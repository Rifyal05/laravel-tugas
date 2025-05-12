{{-- resources/views/dashboard/products/index.blade.php --}}
<x-layouts.app :title="__('Products')">
    {{-- Header Halaman --}}
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Product Management</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage all products in your application</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Tombol Tambah & Search --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-3 sm:space-y-0 sm:space-x-4">
        <div>
            <flux:button icon="plus">
                <flux:link href="{{ route('products.create') }}" variant="subtle">Add New Product</flux:link>
            </flux:button>
        </div>
        <div class="w-full sm:w-auto">
            <form action="{{ route('products.index') }}" method="get" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="search" name="q" value="{{ $q ?? '' }}" placeholder="Search products..."
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow">
            </form>
        </div>
    </div>

    {{-- Badge Notifikasi Sukses --}}
    @if(session()->has('successMessage'))
    <div x-data="{ showBadge: true }" x-show="showBadge" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"
        class="relative mb-3 w-full">
        <flux:badge color="lime" class="w-full pr-10">
            <div class="flex items-center">
                <span class="flex-grow">{{ session()->get('successMessage') }}</span>
            </div>
            <button @click="showBadge = false" type="button"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2
                           bg-transparent text-lime-700 dark:text-lime-300 hover:text-lime-900 dark:hover:text-lime-100
                           rounded-lg focus:ring-2 focus:ring-lime-400
                           p-1.5 inline-flex items-center justify-center h-8 w-8"
                    aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </flux:badge>
    </div>
    @endif

    {{-- Badge Notifikasi Error --}}
    @if(session()->has('errorMessage'))
    <div x-data="{ showBadge: true }" x-show="showBadge" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"
        class="relative mb-3 w-full">
        <flux:badge color="red" class="w-full pr-10">
            <div class="flex items-center">
                <span class="flex-grow">{{ session()->get('errorMessage') }}</span>
            </div>
            <button @click="showBadge = false" type="button"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2
                           bg-transparent text-red-700 dark:text-red-300 hover:text-red-900 dark:hover:text-red-100
                           rounded-lg focus:ring-2 focus:ring-red-400
                           p-1.5 inline-flex items-center justify-center h-8 w-8"
                    aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </flux:badge>
    </div>
    @endif

    {{-- Kontainer utama tabel dan modal delete --}}
    <div class="w-full overflow-x-auto shadow-md rounded-lg mt-6"
         x-data="{
             deleteModalOpen: false,
             productIdToDelete: null,
             productNameToDelete: '',
             submitDeleteForm() {
                 if (this.productIdToDelete) {
                     const form = document.getElementById('delete-form-product-' + this.productIdToDelete);
                     if (form) {
                         form.submit();
                     }
                 }
                 this.deleteModalOpen = false;
             }
         }"
         @open-delete-modal.window="
             deleteModalOpen = true;
             productIdToDelete = $event.detail.id;
             productNameToDelete = $event.detail.name;
             $nextTick(() => $refs.deleteConfirmButtonModal.focus());
         ">

        <table class="min-w-full leading-normal border border-gray-200 dark:border-gray-700">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">#</th>
                    <th class="px-4 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Image</th>
                    <th class="px-4 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">SKU</th>
                    <th class="px-4 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Category</th>
                    <th class="px-4 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Price</th>
                    <th class="px-4 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                    <th class="px-4 py-3 border-b-2 border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $key => $product)
                    <tr class="text-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150 ease-in-out">
                        <td class="px-4 py-3 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">
                                {{ $products->firstItem() + $key }}
                            </p>
                        </td>
                        <td class="px-4 py-3 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            @if($product->image)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-14 w-14 object-cover rounded">
                            @else
                                <div class="h-14 w-14 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded text-xs text-gray-500 dark:text-gray-400">N/A</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <a href="{{ route('products.show', $product->id) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium hover:underline">
                                {{ $product->name }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400 whitespace-no-wrap">{{ Str::limit($product->description, 40) }}</p>
                        </td>
                        <td class="px-4 py-3 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">{{ $product->sku }}</p>
                        </td>
                        <td class="px-4 py-3 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </td>
                        <td class="px-4 py-3 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800 text-right">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-4 py-3 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800 text-center">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">{{ $product->stock }}</p>
                        </td>
                        <td class="px-4 py-3 border-b border-r border-gray-200 dark:border-gray-600 dark:border-r-gray-600 bg-white dark:bg-gray-800 text-center">
                            @if($product->is_active)
                                <flux:badge color="lime" size="sm">Active</flux:badge>
                            @else
                                <flux:badge color="rose" size="sm">Inactive</flux:badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-center">
                            <flux:dropdown>
                                <flux:button variant="outline" size="sm" icon:trailing="chevron-down">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="eye" href="{{ route('products.show', $product->id) }}">View</flux:menu.item>
                                    <flux:menu.item icon="pencil" href="{{ route('products.edit', $product->id) }}">Edit</flux:menu.item>
                                    <flux:menu.item icon="trash" variant="danger"
                                        @click="$dispatch('open-delete-modal', { id: {{ $product->id }}, name: '{{ addslashes(htmlspecialchars($product->name)) }}' })">
                                        Delete
                                    </flux:menu.item>
                                    <form id="delete-form-product-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @empty
                    <tr class="text-sm">
                        <td colspan="9" class="px-4 py-10 border-b border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-center">
                            <p class="text-gray-500 dark:text-gray-400 whitespace-no-wrap">No products found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($products->hasPages())
        <div class="mt-0 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-3">
            {{ $products->links() }}
        </div>
        @endif

        <div x-show="deleteModalOpen"
             style="display: none;"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] overflow-y-auto flex items-center justify-center p-4"
             aria-labelledby="modal-title-delete" role="dialog" aria-modal="true">

            <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/30 dark:bg-black/50 backdrop-blur-sm" aria-hidden="true"></div>

            <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @click.away="deleteModalOpen = false"
                 class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl transform transition-all w-full sm:max-w-md p-0">

                <div class="flex items-start justify-between p-5 border-b border-solid border-gray-200 dark:border-gray-700 rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modal-title-delete">
                        Confirm Deletion
                    </h3>
                    <button @click="deleteModalOpen = false" type="button"
                            class="p-1 ml-auto bg-transparent border-0 text-gray-700 dark:text-gray-300 opacity-50 hover:opacity-100 float-right text-3xl leading-none font-semibold outline-none focus:outline-none">
                        <span class="bg-transparent text-gray-700 dark:text-gray-300 opacity-50 hover:opacity-100 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            x
                        </span>
                    </button>
                </div>

                <div class="relative p-6 flex-auto">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Are you sure you want to delete the product:
                                <strong class="font-medium text-gray-900 dark:text-gray-100" x-text="productNameToDelete"></strong>?
                            </p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end p-4 space-x-2 border-t border-solid border-gray-200 dark:border-gray-700 rounded-b">
                    <button @click="deleteModalOpen = false" type="button"
                            class="text-gray-700 dark:text-gray-300 bg-transparent hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-600 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium px-5 py-2.5 hover:text-gray-900 dark:hover:text-white focus:z-10 transition-colors">
                        Cancel
                    </button>
                    <button @click="submitDeleteForm()" type="button" x-ref="deleteConfirmButtonModal"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center transition-colors">
                        Yes, I'm sure
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>