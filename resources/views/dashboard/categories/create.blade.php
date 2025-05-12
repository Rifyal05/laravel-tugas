<x-layouts.app :title="__('Categories')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Product Categories</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Product Categories</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if ($errors->any())
        <div class="mb-3">
            <flux:badge color="red" class="w-full">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </flux:badge>
        </div>
    @endif

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">{{ session()->get('successMessage') }}</flux:badge>
    @endif
    @if(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">{{ session()->get('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <flux:input label="Name" name="name" class="mb-3" value="{{ old('name') }}" />
        </div>

        <div class="mb-4">
            <flux:input label="Slug" name="slug" class="mb-3" value="{{ old('slug') }}" />
        </div>

        <div class="mb-4">
            <flux:textarea label="Description" name="description" class="mb-3">{{ old('description') }}</flux:textarea>
        </div>

        <div class="mb-4">
            <flux:input type="file" label="Image" name="image" class="mb-3" />
        </div>

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:link href="{{ route('categories.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>