<?php

namespace App\Http\Controllers;

use App\Models\CanteenProduct;
use Illuminate\Http\Request;

class CanteenProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->get('category');
        if ($category) {
            $canteenProducts = CanteenProduct::where('category', $category)->get();
        } else {
            $canteenProducts = CanteenProduct::all();
        }

        $totalProducts = $canteenProducts->count();

        return view('index', compact('canteenProducts', 'category', 'totalProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,beverage',
            'image' => '',
        ]);

        // Upload file (jika ada)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('canteen_images', 'public');
        }

        // Simpan data ke database
        $product = \App\Models\CanteenProduct::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'image' => $imagePath,
        ]);

        // Tampilkan langsung view dengan gambar saja
        // Setelah berhasil tambah produk
        return redirect()->route('index')->with('status', 'Produk berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(CanteenProduct $canteenProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CanteenProduct $canteenProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CanteenProduct $canteenProduct)
    {
        $canteenProduct = CanteenProduct::find($request->id);
        if ($request->hasFile('image')) {
            // Hapus gambar lama (opsional)
            if ($canteenProduct->image && file_exists(storage_path('app/public/'.$canteenProduct->image))) {
                unlink(storage_path('app/public/'.$canteenProduct->image));
            }

            // Simpan gambar baru ke storage/app/public/images
            $path = $request->file('image')->store('images', 'public');
            $canteenProduct->image = $path;
        }

        // Update data lainnya
        $canteenProduct->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'image' => $canteenProduct->image, // simpan path baru
        ]);

        return redirect()->back()->with('status', "$canteenProduct->name updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $canteenProduct = CanteenProduct::find($id);
        $canteenProduct->delete();

        return redirect()->back()->with('status', "$canteenProduct->name deleted successfully");
    }
}
