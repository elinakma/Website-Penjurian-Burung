<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login    = trim($this->input('login'));
        $password = $this->input('password');

        $user = $this->findUser($login);

        // Selalu attempt pakai email user yang ditemukan
        // (lebih stabil daripada Auth::attempt dengan kolom phone)
        if (! $user || ! Auth::attempt(
            ['email' => $user->email, 'password' => $password],
            $this->boolean('remember')
        )) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Cari user berdasarkan email / phone / name
     */
    protected function findUser(string $login): ?User
    {
        // 1. Email
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return User::where('email', $login)->first();
        }

        // 2. Nomor telepon (normalisasi ke digit saja)
        $digits = preg_replace('/\D/', '', $login); // buang spasi, +, -, dll

        if (strlen($digits) >= 8 && ctype_digit($digits)) {
            $candidates = array_unique(array_filter([
                $login,          // apa adanya
                $digits,         // hanya digit
                // variasi umum Indonesia
                str_starts_with($digits, '0') ? $digits : null,
                str_starts_with($digits, '0') ? substr($digits, 1) : null,           // tanpa 0
                str_starts_with($digits, '0') ? '62' . substr($digits, 1) : null,    // 62...
                str_starts_with($digits, '62') ? '0' . substr($digits, 2) : null,    // 0...
                str_starts_with($digits, '62') ? substr($digits, 2) : null,
            ]));

            $user = User::whereIn('phone', $candidates)->first();

            if ($user) {
                return $user;
            }
        }

        // 3. Nama (exact match)
        return User::where('name', $login)->first();
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->string('login')) . '|' . $this->ip()
        );
    }
}