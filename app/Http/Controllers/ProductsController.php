<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-products', [
            'only' => ['index', 'show']
        ]);
        $this->middleware('permission:add-products', [
            'only' => ['create','store']
        ]);
        $this->middleware('permission:edit-products', [
            'only' => ['edit', 'update']
        ]);
        $this->middleware('permission:delete-products', [
            'only' => ['destroy']
        ]);
    }

    public function index()
    {
        $sections = sections::pluck('section_name', 'id');
        $products = products::orderBy('created_at', 'desc')->get();

        return view('products.products', compact('sections', 'products'));
    }

    public function create()
    {
        return redirect('/products');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => [
                'required',
                'regex:/(^[A-Za-z0-9 ]+$)+/',
                'max:255',
            ],
            'section_name' => [
                'required',
            ],
        ]);

        products::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('type', __('success'));
        session()->flash('title', __('Created Successful'));
        session()->flash('message', __('The Product Has Been Successfully Created.'));

        return redirect('/products');
    }

    public function show(products $products)
    {
        return redirect('/products');
    }

    public function edit(products $products)
    {
        return redirect('/products');
    }

    public function update(Request $request)
    {
        $id = $request->product_id;

        $product = products::find($id, ['product_name']);

        $request->validate([
            'product_name' => [
                'required',
                'regex:/(^[A-Za-z0-9 ]+$)+/',
                'max:255',
            ],
            'section_name' => [
                'required',
            ],
        ]);

        products::find($id)->update([
            'product_name' => $request->product_name,
            'section_id' => $request->section_name,
            'description' => $request->description,
        ]);

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Updated Successful'));
        $request->session()->flash('message', __('The Product Has Been Successfully Updated.'));

        return redirect('/products');
    }

    public function destroy(Request $request)
    {
        $id = $request->product_id;
        products::find($id)->delete();

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Deleted Successful'));
        $request->session()->flash('message', __('The Product Has Been Successfully Deleted.'));

        return redirect('/products');
    }
}
