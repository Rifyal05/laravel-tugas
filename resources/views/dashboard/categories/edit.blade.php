@php
@endphp

<x-layouts.app :title="__('Categories') . ' - Edit ' . $category->name">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Update Product Category</flux:heading>
        <flux:subheading size="lg" class="mb-6">You are editing: <strong>{{ $category->name }}</strong></flux:subheading>
        <flux:separator variant="subtle" />
    </div>

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

    @if(session()->has('successMessage'))
        <div class="mb-4 p-3 rounded-md bg-green-50 dark:bg-green-800 dark:bg-opacity-30 border border-green-300 dark:border-green-600">
            <p class="text-sm text-green-700 dark:text-green-300">{{ session()->get('successMessage') }}</p>
        </div>
    @endif
    @if(session()->has('errorMessage'))
         <div class="mb-4 p-3 rounded-md bg-red-50 dark:bg-red-800 dark:bg-opacity-30 border border-red-300 dark:border-red-600">
            <p class="text-sm text-red-700 dark:text-red-300">{{ session()->get('errorMessage') }}</p>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data"
          class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        @csrf
        @method('PATCH')

        {{-- Name --}}
        <div class="mb-4">
            <label for="name_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
            <flux:input id="name_edit" name="name" value="{{ old('name', $category->name) }}"
                        placeholder="Enter category name"
                        class="{{ $errors->has('name') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            @error('name')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Slug --}}
        <div class="mb-4">
            <label for="slug_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug</label>
            <flux:input id="slug_edit" name="slug" value="{{ old('slug', $category->slug) }}"
                        placeholder="Enter category slug (e.g., pakaian-anak)"
                        class="{{ $errors->has('slug') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            @error('slug')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label for="description_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <flux:textarea id="description_edit" name="description" rows="4"
                           placeholder="Enter category description"
                           class="{{ $errors->has('description') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }} focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description', $category->description) }}</flux:textarea>
            @error('description')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Current Image Preview --}}
        @if($category->image)
            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Image:</p>
                <img src="{{ Storage::url($category->image) }}" alt="Current {{ $category->name }} image"
                     class="w-24 h-24 object-cover rounded-md shadow-sm border border-gray-200 dark:border-gray-700">
            </div>
        @else
            <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">No current image available.</p>
        @endif

        {{-- Change Image Input --}}
        <div class="mb-6">
            <label for="image_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Change Image (Optional)</label>
            <flux:input type="file" id="image_edit" name="image"
                        class="border-gray-300 dark:border-gray-600" />
            @error('image')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <flux:separator />

        {{-- Action Buttons --}}
        <div class="mt-6 flex items-center justify-end space-x-3">
            <flux:link href="{{ route('categories.index') }}" variant="outline" class="px-4 py-2">Kembali</flux:link>
            <flux:button type="submit" variant="primary" class="px-4 py-2">Update Category</flux:button>
        </div>
    </form>
</x-layouts.app>