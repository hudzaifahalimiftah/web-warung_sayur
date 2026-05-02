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
        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">Deskripsi</label>
        <textarea name="description" rows="3"
                  class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition resize-none"
                  placeholder="Deskripsi singkat produk...">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    {{-- Price & Unit --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1.5">
                Harga (Rp) <span class="text-red-500 normal-case tracking-normal font-normal">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">Rp</span>
                <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required min="0" step="500"
                       class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition @error('price') border-red-400 ring-2 ring-red-100 @enderror"
                       placeholder="0">
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
                <img src="{{ asset('storage/' . $product->image) }}" class="w-14 h-14 object-cover rounded-lg border border-slate-200">
                <div>
                    <p class="text-xs font-medium text-slate-600">Foto saat ini</p>
                    <p class="text-xs text-slate-400 mt-0.5">Upload foto baru untuk mengganti</p>
                </div>
            </div>
        @endif
        <div class="relative">
            <input type="file" name="image" accept="image/*" id="imageInput"
                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 focus:outline-none focus:ring-2 focus:ring-primary-400 transition">
        </div>
        <p class="text-xs text-slate-400 mt-1.5">Format: JPG, PNG, WebP · Maks 2MB</p>
        @error('image')
            <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

</div>
