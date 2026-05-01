<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
        <select name="category_id" required
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 @error('category_id') border-red-400 @enderror">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->category_name }}
                </option>
            @endforeach
        </select>
        @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name ?? '') }}" required
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 @error('product_name') border-red-400 @enderror"
               placeholder="Nama produk">
        @error('product_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
        <textarea name="description" rows="3"
                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 resize-none"
                  placeholder="Deskripsi produk...">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required min="0" step="500"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 @error('price') border-red-400 @enderror"
                   placeholder="0">
            @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Satuan <span class="text-red-500">*</span></label>
            <select name="unit" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400">
                @foreach(['kg', 'ikat', 'buah', 'gram', 'liter', 'pcs'] as $unit)
                    <option value="{{ $unit }}" {{ old('unit', $product->unit ?? 'kg') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stok <span class="text-red-500">*</span></label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required min="0"
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 @error('stock') border-red-400 @enderror">
        @error('stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Produk</label>
        @if(isset($product) && $product->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $product->image) }}" class="w-24 h-24 object-cover rounded-xl border border-gray-200">
                <p class="text-xs text-gray-400 mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
            </div>
        @endif
        <input type="file" name="image" accept="image/*"
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400">
        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WebP. Maks 2MB.</p>
        @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
</div>
