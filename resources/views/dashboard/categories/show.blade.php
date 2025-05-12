{{-- resources/views/dashboard/categories/show.blade.php --}}
{{-- Ganti 'categories' menjadi 'product_categories' jika nama route & foldermu seperti itu --}}
<x-layouts.app :title="__('Category Details') . ' - ' . $category->name">
    {{-- Header Halaman dengan Navigasi --}}
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Category Details: {{ $category->name }}</flux:heading>
        <div class="mt-1 flex items-center space-x-2 text-sm">
            <flux:link :href="route('categories.index')" variant="soft" class="text-gray-600 dark:text-gray-400 hover:text-primary-500 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
                Back to Categories
            </flux:link>
            <span class="text-gray-400 dark:text-gray-500">/</span>
            <flux:link :href="route('categories.edit', $category->id)" variant="soft" class="text-gray-600 dark:text-gray-400 hover:text-primary-500 inline-flex items-center">
                Edit Category
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 ml-1">
                  <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                </svg>
            </flux:link>
        </div>
        <div class="mt-4">
             <flux:separator variant="subtle" />
        </div>
    </div>

    {{-- Konten Utama Detail Kategori --}}
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        <div class="md:flex">
            {{-- Kolom Gambar Kategori (jika ada) --}}
            <div class="md:w-1/3 p-6 lg:p-8 flex justify-center items-start">
                @if($category->image)
                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                         class="max-w-full h-auto max-h-[300px] md:max-h-[350px] object-contain rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                @else
                    <div class="w-full h-48 md:h-64 bg-gray-100 dark:bg-gray-700 flex items-center justify-center rounded-lg text-gray-400 dark:text-gray-500 text-lg font-medium">
                        No Image Available
                    </div>
                @endif
            </div>

            {{-- Kolom Detail Teks Kategori --}}
            <div class="md:w-2/3 p-6 lg:p-8 space-y-6 border-t md:border-t-0 md:border-l border-gray-200 dark:border-gray-700">
                {{-- Info Dasar Kategori --}}
                <section>
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $category->name }}</h2>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Slug: <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded-sm">{{ $category->slug }}</code>
                    </div>
                </section>

                {{-- Deskripsi Kategori --}}
                @if($category->description)
                <flux:separator variant="dotted" />
                <section>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Description</h3>
                    <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                        {!! nl2br(e($category->description)) !!}
                    </div>
                </section>
                @endif

                <flux:separator variant="dotted" class="my-6"/>

                {{-- Timestamps --}}
                <section class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-xs text-gray-500 dark:text-gray-400">
                    <div>
                        <h3 class="font-medium uppercase tracking-wider">Created At</h3>
                        <p>{{ $category->created_at->format('d M Y, H:i A') }} ({{ $category->created_at->diffForHumans() }})</p>
                    </div>
                    <div>
                        <h3 class="font-medium uppercase tracking-wider">Last Updated</h3>
                        <p>{{ $category->updated_at->format('d M Y, H:i A') }} ({{ $category->updated_at->diffForHumans() }})</p>
                    </div>
                </section>

                @if($category->products && $category->products->count() > 0)
                <flux:separator variant="dotted" class="my-6"/>
                <section>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Products in this Category ({{ $category->products->count() }})
                    </h3>
                    <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-300 space-y-1">
                        @foreach($category->products->take(5) as $product) {{-- Ambil 5 produk pertama sebagai contoh --}}
                            <li>
                                <a href="{{ route('products.show', $product->id) }}" class="hover:underline text-primary-600 dark:text-primary-400">
                                    {{ $product->name }}
                                </a>
                            </li>
                        @endforeach
                        @if($category->products->count() > 5)
                            <li>And {{ $category->products->count() - 5 }} more...</li>
                        @endif
                    </ul>
                </section>
                @endif

            </div>
        </div>
    </div>
</x-layouts.app>