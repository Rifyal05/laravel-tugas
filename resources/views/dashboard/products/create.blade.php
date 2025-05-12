{{-- resources/views/dashboard/products/create.blade.php --}}
<x-layouts.app :title="__('Add New Product')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Create New Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Fill in the details for the new product</flux:subheading>
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

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data"
          class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 space-y-6">
        @csrf

        {{-- Product Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name <span class="text-red-500">*</span></label>
            <flux:input id="name" name="name" value="{{ old('name') }}" placeholder="Enter product name"
                        class="{{ $errors->has('name') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            @error('name')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Product Slug --}}
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug <span class="text-red-500">*</span></label>
            <flux:input id="slug" name="slug" value="{{ old('slug') }}" placeholder="e.g., unique-product-name"
                        class="{{ $errors->has('slug') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            @error('slug')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- SKU --}}
        <div>
            <label for="sku" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SKU <span class="text-red-500">*</span></label>
            <flux:input id="sku" name="sku" value="{{ old('sku') }}" placeholder="Stock Keeping Unit"
                        class="{{ $errors->has('sku') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            @error('sku')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Product Category --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
            <flux:select id="category_id" name="category_id"
                         class="{{ $errors->has('category_id') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price (Rp) <span class="text-red-500">*</span></label>
                <flux:input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="0.00" min="0" step="0.01"
                            class="{{ $errors->has('price') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                @error('price')
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock <span class="text-red-500">*</span></label>
                <flux:input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" placeholder="0" min="0"
                            class="{{ $errors->has('stock') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                @error('stock')
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <flux:textarea id="description" name="description" rows="5" placeholder="Enter product description"
                           class="{{ $errors->has('description') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description') }}</flux:textarea>
            @error('description')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Product Image --}}
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Image</label>
            <flux:input type="file" id="image" name="image"
                        class="border-gray-300 dark:border-gray-600" />
            @error('image')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Is Active Checkbox (HTML Standar) --}}
        <div class="flex items-center">
            <input type="checkbox" id="is_active_html" name="is_active" value="1"
                   {{ old('is_active', true) ? 'checked' : '' }}
                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="is_active_html" class="ml-2 block text-sm text-gray-900 dark:text-gray-200">
                Product is Active
            </label>
        </div>

        <flux:separator />

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end space-x-3">
            <flux:link href="{{ route('products.index') }}" variant="outline" class="px-4 py-2">Cancel</flux:link>
            <flux:button type="submit" variant="primary" class="px-4 py-2">Create Product</flux:button>
        </div>
    </form>
</x-layouts.app>