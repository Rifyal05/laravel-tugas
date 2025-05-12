<div>
    {{-- Input Search di-bind ke properti $searchQuery --}}
    <div class="mb-4">
        <input
            wire:model.live.debounce.300ms="searchQuery" {{-- .live untuk update instan, .debounce untuk jeda --}}
            type="text"
            placeholder="Search Product Categories..."
            class="w-full sm:w-1/2 md:w-1/3 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        >
    </div>

    {{-- Tabel (ambil dari index.blade.php yang sudah kamu style) --}}
    <div class="w-full overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full leading-normal border border-gray-200 dark:border-gray-700">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-5 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-5 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Image</th>
                    <th class="px-5 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-5 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Slug</th>
                    <th class="px-5 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Description</th>
                    <th class="px-5 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Created At</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $key => $category)
                    <tr class="text-base hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150 ease-in-out">
                        <td class="px-5 py-5 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">
                                {{-- Penomoran bisa disesuaikan jika paginasi Livewire berbeda --}}
                                {{ $categories->firstItem() + $key }}
                            </p>
                        </td>
                        <td class="px-5 py-5 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">
                                @if($category->image)
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="h-12 w-12 object-cover rounded">
                                @else
                                    <div class="h-12 w-12 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">N/A</span>
                                    </div>
                                @endif
                            </p>
                        </td>
                        <td class="px-5 py-5 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">{{ $category->name }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">{{ $category->slug }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <p class="text-gray-900 dark:text-gray-100">{{ Str::limit($category->description, 50) }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">{{ $category->created_at->format('d M Y H:i') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" href="{{ route('categories.edit', $category->id) }}">Edit</flux:menu.item>
                                    {{-- Untuk delete dengan Livewire, bisa buat method di komponen dan panggil dengan wire:click --}}
                                    <flux:menu.item icon="trash" variant="danger"
                                        onclick="confirm('Are you sure you want to delete this category?') || event.stopImmediatePropagation()"
                                        wire:click="deleteCategory({{ $category->id }})">
                                        Delete
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @empty
                    <tr class="text-base">
                        <td colspan="7" class="px-5 py-5 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-center">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">No categories found matching your search.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($categories->hasPages())
        <div class="mt-0 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-3">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>