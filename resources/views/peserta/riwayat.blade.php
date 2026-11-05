<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-5 sm:p-6 md:p-8 shadow-sm"
             style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#0e1e17]">Riwayat Pendaftaran</h1>
                    <p class="text-sm text-gray-600 mt-1">Daftar lomba yang sudah Anda ikuti.</p>
                </div>
                <a href="{{ route('peserta.daftar') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-[#527b5d] shadow-md transition hover:bg-gray-50 active:scale-[0.98] w-full sm:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Daftar Lagi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="w-full mx-auto">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                {{-- Flash Message --}}
                @if(session('success'))
                    <div class="mx-4 mt-4 p-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-100">
                        {!! session('success') !!}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mx-4 mt-4 p-4 rounded-xl bg-red-50 text-red-700 text-sm border border-red-100 flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($riwayats->isEmpty())
                    <div class="p-10 sm:p-14 text-center">
                        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-gray-50">
                            <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Belum ada riwayat</h3>
                        <p class="mt-1.5 text-sm text-gray-500 max-w-xs mx-auto">Anda belum mendaftar lomba apapun. Yuk daftar sekarang!</p>
                        <a href="{{ route('peserta.daftar') }}"
                           class="inline-flex mt-6 items-center gap-2 rounded-xl bg-[#527b5d] px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[#42684d] active:scale-[0.98]">
                            Daftar Lomba Sekarang
                        </a>
                    </div>
                
                    @else
                        <div class="space-y-4 p-4 sm:p-6">
                            @foreach($riwayats as $acaraId => $items)
                                @php
                                    $first      = $items->first();
                                    $total      = $items->sum('harga');
                                    $totalFmt   = number_format($total, 0, ',', '.');
                                    $namaAcara  = $first->acara?->nama ?? '-';
                                    $pembayaran = $items->pluck('pembayaran')->filter()->first();
                                    $bisaUpload = !$pembayaran && $first->status === 'menunggu_pembayaran';

                                    $statusColor = match($first->status) {
                                        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                        'menunggu_verifikasi' => 'bg-blue-100 text-blue-800',
                                        'lunas'               => 'bg-emerald-100 text-emerald-800',
                                        'ditolak'             => 'bg-red-100 text-red-800',
                                        default               => 'bg-gray-100 text-gray-700',
                                    };
                                    $statusLabel = match($first->status) {
                                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                        'lunas'               => 'Lunas',
                                        'ditolak'             => 'Ditolak',
                                        default               => ucfirst(str_replace('_', ' ', $first->status)),
                                    };
                                @endphp

                                <div class="overflow-hidden rounded-2xl border border-gray-100 shadow-sm">
                                    <div class="flex flex-col gap-2 border-b border-gray-100 bg-gray-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="min-w-0">
                                            <h3 class="truncate font-bold text-gray-800">{{ $namaAcara }}</h3>
                                            <p class="mt-0.5 text-xs text-gray-500">
                                                Didaftar {{ $first->created_at->format('d M Y, H:i') }} • {{ $items->count() }} kelas lomba
                                            </p>
                                        </div>
                                        <span class="inline-flex w-fit whitespace-nowrap rounded-full px-3 py-1 text-xs font-semibold {{ $statusColor }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </div>

                                    <div class="divide-y divide-gray-100">
                                        @foreach($items as $item)
                                            <div class="flex items-center justify-between gap-3 px-5 py-3.5">
                                                <div class="flex min-w-0 items-center gap-3">
                                                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#527b5d] text-sm font-bold text-white">
                                                        {{ $item->nomor_gantangan ?? '-' }}
                                                    </span>
                                                    <div class="min-w-0">
                                                        <p class="truncate text-sm font-semibold text-gray-800">{{ $item->kelasLomba?->nama ?? '-' }}</p>
                                                        <p class="truncate text-xs text-gray-500">{{ $item->nama_burung }}</p>
                                                    </div>
                                                </div>
                                                <span class="whitespace-nowrap text-sm font-medium text-gray-700">
                                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="flex items-center justify-between border-t border-gray-100 bg-[#f8faf9] px-5 py-4">
                                        <span class="text-sm font-bold text-gray-800">Total Pembayaran</span>
                                        <span class="text-base font-bold text-[#527b5d]">Rp {{ $totalFmt }}</span>
                                    </div>

                                    @if($pembayaran || $bisaUpload)
                                        <div class="border-t border-gray-100 px-5 py-4">
                                            @if($pembayaran)
                                                <div class="flex items-center gap-3">
                                                    <img src="{{ asset('storage/' . $pembayaran->foto) }}" alt="Bukti"
                                                        class="h-14 w-14 cursor-pointer rounded-lg border border-gray-200 object-cover"
                                                        onclick="window.open(this.src, '_blank')">
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-medium capitalize text-gray-700">
                                                            Status: <span class="font-semibold">{{ $pembayaran->status }}</span>
                                                        </p>
                                                        @if($pembayaran->catatan_admin)
                                                            <p class="mt-0.5 text-xs text-gray-500">Catatan admin: {{ $pembayaran->catatan_admin }}</p>
                                                        @endif
                                                    </div>
                                                    <a href="{{ asset('storage/' . $pembayaran->foto) }}" target="_blank"
                                                    class="whitespace-nowrap text-xs font-semibold text-[#527b5d]">Lihat</a>
                                                </div>
                                            @else
                                                <button type="button"
                                                        onclick="openUploadModal({{ $first->id }}, @js($namaAcara), @js($totalFmt))"
                                                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#527b5d] py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#42684d] active:scale-[0.98]">
                                                    Upload Bukti Pembayaran
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
            </div>
        </div>
    </div>

    {{-- ==================== MODAL UPLOAD BUKTI ==================== --}}
    <div id="uploadModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all"
             onclick="event.stopPropagation()">
            
            {{-- Modal Header --}}
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Upload Bukti Pembayaran</h3>
                    <p class="text-xs text-gray-500 mt-0.5" id="modalSubtitle">-</p>
                    <p class="mt-1 text-sm font-bold text-[#527b5d]" id="modalTotal"></p>
                </div>
                <button type="button" onclick="closeUploadModal()"
                        class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <form id="uploadForm" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                
                {{-- Preview Area --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Bukti Transfer</label>
                    <div id="dropZone"
                         class="relative border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer transition hover:border-[#527b5d] hover:bg-[#527b5d]/5"
                         onclick="document.getElementById('fotoInput').click()">
                        
                        <div id="previewEmpty" class="space-y-2">
                            <div class="mx-auto w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600 font-medium">Klik atau ambil foto</p>
                            <p class="text-xs text-gray-400">JPG, PNG (maks. 2MB)</p>
                        </div>

                        <img id="previewImage" src="" alt="Preview"
                             class="hidden mx-auto max-h-48 rounded-lg object-contain">
                    </div>
                    <input type="file" name="foto" id="fotoInput" accept="image/*" capture="environment"
                           class="hidden" required onchange="previewFoto(this)">
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="keterangan" placeholder="Contoh: Transfer via BCA"
                           class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] transition">
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeUploadModal()"
                            class="flex-1 rounded-xl border border-gray-200 bg-white py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 rounded-xl bg-[#527b5d] py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-[#42684d] active:scale-[0.98]">
                        Kirim Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('uploadModal');
        const form  = document.getElementById('uploadForm');

        function openUploadModal(pesertaId, namaAcara, total) {
            form.action = `/peserta/${pesertaId}/upload-bukti`;
            document.getElementById('modalSubtitle').textContent = namaAcara;
            document.getElementById('modalTotal').textContent = 'Total: Rp ' + total;

            // Reset preview
            document.getElementById('previewImage').classList.add('hidden');
            document.getElementById('previewEmpty').classList.remove('hidden');
            document.getElementById('fotoInput').value = '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeUploadModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Klik di luar modal = tutup
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeUploadModal();
        });

        // Preview foto
        function previewFoto(input) {
            const preview = document.getElementById('previewImage');
            const empty   = document.getElementById('previewEmpty');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    empty.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // ESC untuk tutup modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeUploadModal();
        });
    </script>
</x-app-layout>