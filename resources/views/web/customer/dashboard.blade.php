<x-layout>
    <h3>Ini adalah halaman Homepage</h3>
    <x-alert></x-alert>
    <div class="row">
        <h3>Categories</h3>
        @foreach($categories as $category)
            <div class="col-md-2 col-sm-4 col-6 mb-4"> 
                <div class="card h-100">
                    @if($category->image)
                        <img src="{{ Storage::url($category->image) }}"
                             class="card-img-top"
                             alt="{{ $category->name }}"
                             style="height: 280px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                            <span class="text-muted small">No Image</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text small text-muted mb-auto">
                            {{ Str::limit($category->description, 50) }}
                        </p>
                        <a href="{{ route('homepage.category.detail', $category->slug) }}" class="btn btn-primary btn-sm mt-2">Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>