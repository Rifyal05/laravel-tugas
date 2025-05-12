<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories; 
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Categories::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%')
                      ->orWhere('description', 'like', '%' . $request->q . '%');
            })
            ->paginate(10);

        return view('dashboard.categories.index', [
            'categories' => $categories,
            'q' => $request->q
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * cek validasi input
         */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required'
        ]);

        /**
         * jika validasi gagal,
         * maka redirect kembali dengan pesan error
         */
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with( 
                [
                    'errors' => $validator->errors(),
                    'errorMessage' => 'Validasi Error, Silahkan lengkapi data terlebih dahulu'
                ]
            );
        }

        $category = new Categories;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/categories', $imageName, 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return redirect()->route('categories.index') 
            ->with(
                [
                    'successMessage' => 'Data Berhasil Disimpan'
                ]
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $category)
    {
        $category->load('products');

        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Categories::find($id);
        if (!$category) {
            return redirect()->route('categories.index')->with('errorMessage', 'Kategori tidak ditemukan');
        }
        return view('dashboard.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /**
         * cek validasi input
         */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255', 
            'description' => 'required'
        ]);

        /**
         * jika validasi gagal,
         * maka redirect kembali dengan pesan error
         */
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with( 
                [
                    'errors' => $validator->errors(),
                    'errorMessage' => 'Validasi Error, Silahkan lengkapi data terlebih dahulu'
                ]
            );
        }

        $category = Categories::find($id);
        if (!$category) {
            return redirect()->route('categories.index')->with('errorMessage', 'Kategori tidak ditemukan');
        }

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            // Opsional: Hapus gambar lama jika ada
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/categories', $imageName, 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return redirect()->route('categories.index') 
            ->with(
                [
                    'successMessage' => 'Data Berhasil Disimpan'
                ]
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categories::find($id);
        if (!$category) {
            return redirect()->route('categories.index')->with('errorMessage', 'Kategori tidak ditemukan');
        }

        // Opsional: Hapus gambar terkait jika ada
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with(
                [
                    'successMessage' => 'Data Berhasil Dihapus'
                ]
            );
    }
}