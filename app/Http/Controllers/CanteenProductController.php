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
        if ($category) 
        {
        $canteenProducts = CanteenProduct::where('category', $category)->get();
        }
         else 
        {
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
        CanteenProduct::create($request->all());
        return redirect()->back()->with('status', "$request->name create successfully");
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
        $canteenProduct->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category
        ]);
        return redirect()->back()->with('status', "$canteenProduct->name update successfully");

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
