<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_telepon' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $pesertaRole = Role::where('name', 'peserta')->firstOrFail();

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $this->normalizePhone($request->no_telepon),
            'password' => Hash::make($request->password),
            'role_id'  => $pesertaRole->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }

    /**
     * Normalisasi nomor telepon: hanya digit, diawali 0
     * Contoh: 081234567890
     */
    private function normalizePhone(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $phone);

        if ($digits === '' || strlen($digits) < 8) {
            return null;
        }

        // 62... → 0...
        if (str_starts_with($digits, '62')) {
            $digits = '0' . substr($digits, 2);
        }

        // Belum ada 0 di depan → tambahkan
        if (! str_starts_with($digits, '0')) {
            $digits = '0' . $digits;
        }

        return $digits;
    }
}