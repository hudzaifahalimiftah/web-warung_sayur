<div class="space-y-5">

    {{-- Category --}}
    <div>
        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">
            Kategori <span class="text-red-500 normal-case tracking-normal font-normal">*</span>
        </label>
        <select name="category_id" required
                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition @error('category_id') border-red-400 ring-2 ring-red-100 @enderror">
            <option value="">— Pilih Kategori —</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->category_name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Product Name --}}
    <div>
        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">
            Nama Produk <span class="text-red-500 normal-case tracking-normal font-normal">*</span>
        </label>
        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name ?? '') }}" required
               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition @error('product_name') border-red-400 ring-2 ring-red-100 @enderror"
               placeholder="Contoh: Bayam Segar">
        @error('product_name')
            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">
            Deskripsi <span class="text-red-500 normal-case tracking-normal font-normal">*</span>
        </label>
        <textarea name="description" rows="3" required
                  class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition resize-none @error('description') border-red-400 ring-2 ring-red-100 @enderror"
                  placeholder="Deskripsi singkat produk...">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Price & Unit --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">
                Harga (Rp) <span class="text-red-500 normal-case tracking-normal font-normal">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium pointer-events-none">Rp</span>
                {{-- Input display (formatted) --}}
                <input type="text" id="price_display"
                       value="{{ old('price', isset($product) && $product->price ? number_format($product->price, 0, ',', '.') : '') }}"
                       class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition @error('price') border-red-400 ring-2 ring-red-100 @enderror"
                       placeholder="0"
                       inputmode="numeric"
                       onwheel="this.blur()"
                       oninput="formatPrice(this)">
                {{-- Hidden input untuk submit --}}
                <input type="hidden" name="price" id="price_raw"
                       value="{{ old('price', $product->price ?? '') }}">
            </div>
            @error('price')
                <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">
                Satuan <span class="text-red-500 normal-case tracking-normal font-normal">*</span>
            </label>
            <select name="unit" required
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition">
                @foreach(['kg', 'ikat', 'buah', 'gram', 'liter', 'pcs'] as $unit)
                    <option value="{{ $unit }}" {{ old('unit', $product->unit ?? 'kg') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Stock --}}
    <div>
        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">
            Stok <span class="text-red-500 normal-case tracking-normal font-normal">*</span>
        </label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required min="0"
               onwheel="this.blur()"
               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition @error('stock') border-red-400 ring-2 ring-red-100 @enderror">
        @error('stock')
            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Image --}}
    <div>
        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">Foto Produk</label>

        @if(isset($product) && $product->image)
            <div class="flex items-center gap-3 mb-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                <img id="currentImg" src="{{ $product->image_url }}" class="w-16 h-16 object-cover rounded-lg border border-slate-200">
                <div>
                    <p class="text-xs font-medium text-slate-600">Foto saat ini</p>
                    <p class="text-xs text-slate-400 mt-0.5">Upload atau ambil foto baru untuk mengganti</p>
                </div>
            </div>
        @endif

        {{-- Preview --}}
        <div id="imgPreviewWrap" class="hidden mb-3">
            <img id="imgPreview" src="" class="w-24 h-24 object-cover rounded-xl border border-slate-200">
        </div>

        {{-- 2 Opsi: Choose File & Kamera --}}
        <div class="grid grid-cols-2 gap-3">
            {{-- Choose File --}}
            <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-200 hover:border-green-400 rounded-xl p-4 cursor-pointer transition-colors group">
                <svg class="w-6 h-6 text-slate-300 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs font-medium text-slate-500 group-hover:text-green-600">Pilih dari Galeri</span>
                <input type="file" name="image" accept="image/*" id="imageInput" class="hidden" onchange="previewImage(this)">
            </label>

            {{-- Kamera (mobile only) --}}
            <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-200 hover:border-green-400 rounded-xl p-4 cursor-pointer transition-colors group">
                <svg class="w-6 h-6 text-slate-300 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-xs font-medium text-slate-500 group-hover:text-green-600">Ambil Foto</span>
                <span class="text-[10px] text-slate-400">(kamera HP)</span>
                <input type="file" name="image" accept="image/*" capture="environment" id="cameraInput" class="hidden" onchange="previewImage(this)">
            </label>
        </div>
        <p class="text-xs text-slate-400 mt-2">
            Format: JPG, PNG, WebP · Maks 2MB ·
            <span class="text-slate-300">Tombol "Ambil Foto" hanya berfungsi di perangkat mobile</span>
        </p>
        @error('image')
            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

</div>

@push('scripts')
<script>
function formatPrice(input) {
    // Ambil hanya angka
    let raw = input.value.replace(/\D/g, '');
    // Update hidden input (nilai asli tanpa titik)
    document.getElementById('price_raw').value = raw;
    // Format dengan titik setiap 3 angka
    if (raw === '') {
        input.value = '';
        return;
    }
    input.value = parseInt(raw, 10).toLocaleString('id-ID');
}

// Inisialisasi saat halaman load (untuk mode edit)
window.addEventListener('DOMContentLoaded', function() {
    const display = document.getElementById('price_display');
    const raw     = document.getElementById('price_raw');
    if (raw && raw.value && display) {
        display.value = parseInt(raw.value, 10).toLocaleString('id-ID');
    }
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('imgPreviewWrap').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);

        if (input.id === 'imageInput') {
            document.getElementById('cameraInput').value = '';
        } else {
            document.getElementById('imageInput').value = '';
        }
        input.name = 'image';
        const other = input.id === 'imageInput'
            ? document.getElementById('cameraInput')
            : document.getElementById('imageInput');
        other.name = '';
    }
}
</script>
@endpush
