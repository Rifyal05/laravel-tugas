{{-- resources/views/dashboard/products/edit.blade.php --}}
<x-layouts.app :title="__('Edit Product') . ' - ' . $product->name">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Edit Product: {{ $product->name }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">Update the details for this product</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Menampilkan pesan error validasi jika ada --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-md bg-red-50 dark:bg-red-800 dark:bg-opacity-30 border border-red-300 dark:border-red-600">
            <div class="font-medium text-red-700 dark:text-red-200 mb-1">
                Oops! Something went wrong.
            </div>
            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-300">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data"
          class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 space-y-6">
        @csrf
        @method('PATCH') {{-- atau PUT --}}

        {{-- Product Name --}}
        <div>
            <label for="name_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name <span class="text-red-500">*</span></label>
            <flux:input id="name_edit" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter product name"
                        class="{{ $errors->has('name') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            @error('name')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Product Slug --}}
        <div>
            <label for="slug_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug <span class="text-red-500">*</span></label>
            <flux:input id="slug_edit" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="e.g., unique-product-name"
                        class="{{ $errors->has('slug') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            @error('slug')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- SKU --}}
        <div>
            <label for="sku_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SKU <span class="text-red-500">*</span></label>
            <flux:input id="sku_edit" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Stock Keeping Unit"
                        class="{{ $errors->has('sku') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            @error('sku')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Product Category --}}
        <div>
            <label for="category_id_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
            <flux:select id="category_id_edit" name="category_id"
                         class="{{ $errors->has('category_id') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </flux:select>
            @error('category_id')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Price & Stock (in a grid) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="price_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price (Rp) <span class="text-red-500">*</span></label>
                <flux:input type="number" id="price_edit" name="price" value="{{ old('price', $product->price) }}" placeholder="0.00" min="0" step="0.01"
                            class="{{ $errors->has('price') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                @error('price')
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="stock_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock <span class="text-red-500">*</span></label>
                <flux:input type="number" id="stock_edit" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="0" min="0"
                            class="{{ $errors->has('stock') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                @error('stock')
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Description --}}
        <div>
            <label for="description_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <flux:textarea id="description_edit" name="description" rows="5" placeholder="Enter product description"
                           class="{{ $errors->has('description') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description', $product->description) }}</flux:textarea>
            @error('description')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Current Image Preview --}}
        @if($product->image)
            <div class="mb-2">
                <p class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Image:</p>
                <img src="{{ $product->image_url }}" alt="Current {{ $product->name }} image"
                     class="w-32 h-32 object-cover rounded-md shadow-sm border border-gray-200 dark:border-gray-700">
            </div>
        @else
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">No current image available for this product.</p>
        @endif

        {{-- Change Product Image Input --}}
        <div>
            <label for="image_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Change Image (Optional)</label>
            <flux:input type="file" id="image_edit" name="image"
                        class="border-gray-300 dark:border-gray-600" />
            @error('image')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Is Active Checkbox (menggunakan HTML standar) --}}
        <div class="flex items-center">
            <input type="checkbox"
                   id="is_active_edit"
                   name="is_active"
                   value="1"
                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-offset-0 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
            <label for="is_active_edit" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                Product is Active
            </label>
        </div>

        <flux:separator />

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end space-x-3">
            <flux:link href="{{ route('products.index') }}" variant="outline" class="px-4 py-2">Cancel</flux:link>
            <flux:button type="submit" variant="primary" class="px-4 py-2">Update Product</flux:button>
        </div>
    </form>
</x-layouts.app>