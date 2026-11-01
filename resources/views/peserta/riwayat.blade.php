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
                    <div class="mx-4 mt-4 p-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-100 flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('success') }}</span>
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

                    {{-- ==================== MOBILE CARD ==================== --}}
                    <div class="block md:hidden divide-y divide-gray-100">
                        @foreach($riwayats as $item)
                            <div class="p-4">
                                {{-- Header Card --}}
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-[#527b5d] text-white text-sm font-bold flex-shrink-0 shadow-sm">
                                            {{ $item->nomor_gantangan ?? '-' }}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-800 truncate">{{ $item->nama_burung }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5 truncate">
                                                {{ $item->kelasLomba?->burung?->nama ?? $item->burung?->nama ?? '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    @php
                                        $statusColor = match($item->status) {
                                            'menunggu_pembayaran'   => 'bg-yellow-100 text-yellow-800',
                                            'menunggu_verifikasi'   => 'bg-blue-100 text-blue-800',
                                            'lunas'                 => 'bg-emerald-100 text-emerald-800',
                                            'ditolak'               => 'bg-red-100 text-red-800',
                                            default                 => 'bg-gray-100 text-gray-700',
                                        };
                                        $statusLabel = match($item->status) {
                                            'menunggu_pembayaran'   => 'Menunggu Bayar',
                                            'menunggu_verifikasi'   => 'Menunggu Verifikasi',
                                            'lunas'                 => 'Lunas',
                                            'ditolak'               => 'Ditolak',
                                            default                 => ucfirst(str_replace('_', ' ', $item->status)),
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $statusColor }} whitespace-nowrap">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                {{-- Detail --}}
                                <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <p class="text-[11px] text-gray-400 mb-0.5">Kelas Lomba</p>
                                        <p class="font-medium text-gray-700 text-sm">{{ $item->kelasLomba?->nama ?? '-' }}</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <p class="text-[11px] text-gray-400 mb-0.5">Harga</p>
                                        <p class="font-medium text-gray-700 text-sm">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-span-2 bg-gray-50 rounded-xl p-3">
                                        <p class="text-[11px] text-gray-400 mb-0.5">Acara</p>
                                        <p class="font-medium text-gray-700 text-sm">{{ $item->acara?->nama ?? '-' }}</p>
                                    </div>
                                </div>

                                <p class="mt-3 text-xs text-gray-400">
                                    Didaftar {{ $item->created_at->format('d M Y') }} • {{ $item->created_at->format('H:i') }}
                                </p>

                                {{-- Action --}}
                                <div class="mt-4">
                                    @if($item->status === 'menunggu_pembayaran' && !$item->pembayaran)
                                        <button type="button"
                                                onclick="openUploadModal({{ $item->id }}, '{{ $item->nama_burung }}')"
                                                class="w-full flex items-center justify-center gap-2 rounded-xl bg-[#527b5d] py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#42684d] active:scale-[0.98]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                            </svg>
                                            Upload Bukti Pembayaran
                                        </button>
                                    @elseif($item->pembayaran)
                                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                                            <img src="{{ asset('storage/' . $item->pembayaran->foto) }}"
                                                 alt="Bukti"
                                                 class="w-14 h-14 rounded-lg object-cover border border-gray-200"
                                                 onclick="window.open(this.src, '_blank')">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-700 capitalize">
                                                    Status: <span class="font-semibold">{{ $item->pembayaran->status }}</span>
                                                </p>
                                                @if($item->pembayaran->keterangan)
                                                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $item->pembayaran->keterangan }}</p>
                                                @endif
                                            </div>
                                            <a href="{{ asset('storage/' . $item->pembayaran->foto) }}" target="_blank"
                                               class="text-[#527b5d] text-xs font-semibold whitespace-nowrap">
                                                Lihat
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- ==================== DESKTOP TABLE ==================== --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 font-semibold border-b border-gray-100">
                                <tr>
                                    <th class="px-5 py-4">No</th>
                                    <th class="px-5 py-4">No. Gantangan</th>
                                    <th class="px-5 py-4">Nama Burung</th>
                                    <th class="px-5 py-4">Kelas Lomba</th>
                                    <th class="px-5 py-4">Harga</th>
                                    <th class="px-5 py-4">Status</th>
                                    <th class="px-5 py-4">Bukti Bayar</th>
                                    <th class="px-5 py-4">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($riwayats as $index => $item)
                                    <tr class="hover:bg-gray-50/70 transition">
                                        <td class="px-5 py-4 text-gray-500">{{ $riwayats->firstItem() + $index }}</td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-[#527b5d] text-white text-sm font-bold">
                                                {{ $item->nomor_gantangan ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 font-medium text-gray-800">{{ $item->nama_burung }}</td>
                                        <td class="px-5 py-4">{{ $item->kelasLomba?->nama ?? '-' }}</td>
                                        <td class="px-5 py-4 font-medium">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td class="px-5 py-4">
                                            @php
                                                $statusColor = match($item->status) {
                                                    'menunggu_pembayaran'   => 'bg-yellow-100 text-yellow-800',
                                                    'menunggu_verifikasi'   => 'bg-blue-100 text-blue-800',
                                                    'lunas'                 => 'bg-emerald-100 text-emerald-800',
                                                    'ditolak'               => 'bg-red-100 text-red-800',
                                                    default                 => 'bg-gray-100 text-gray-700',
                                                };
                                                $statusLabel = match($item->status) {
                                                    'menunggu_pembayaran'   => 'Menunggu Pembayaran',
                                                    'menunggu_verifikasi'   => 'Menunggu Verifikasi',
                                                    'lunas'                 => 'Lunas',
                                                    'ditolak'               => 'Ditolak',
                                                    default                 => ucfirst(str_replace('_', ' ', $item->status)),
                                                };
                                            @endphp
                                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($item->status === 'menunggu_pembayaran' && !$item->pembayaran)
                                                <button type="button"
                                                        onclick="openUploadModal({{ $item->id }}, '{{ $item->nama_burung }}')"
                                                        class="inline-flex items-center gap-1.5 text-[#527b5d] hover:text-[#42684d] text-sm font-semibold transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                    </svg>
                                                    Upload
                                                </button>
                                            @elseif($item->pembayaran)
                                                <a href="{{ asset('storage/' . $item->pembayaran->foto) }}" target="_blank"
                                                   class="inline-flex items-center gap-1.5 text-[#527b5d] hover:underline text-sm font-medium">
                                                    Lihat Bukti
                                                </a>
                                                <span class="block text-xs text-gray-500 capitalize mt-0.5">
                                                    {{ $item->pembayaran->status }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-gray-500">
                                            {{ $item->created_at->format('d M Y') }}
                                            <span class="block text-xs text-gray-400">{{ $item->created_at->format('H:i') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($riwayats->hasPages())
                        <div class="px-4 sm:px-6 py-4 border-t border-gray-100">
                            {{ $riwayats->links() }}
                        </div>
                    @endif
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

        function openUploadModal(pesertaId, namaBurung) {
            form.action = `/peserta/${pesertaId}/upload-bukti`;
            document.getElementById('modalSubtitle').textContent = namaBurung;
            
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