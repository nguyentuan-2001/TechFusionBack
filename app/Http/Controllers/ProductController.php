<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // lấy all
        $products = Product::with('productDetail')->get();
        return response()->json($products);

        // lấy 1 bảng
        // return Product::select('product_name','product_desc', 'product_content', 'product_price','product_sale', 'product_image', 'product_status')->get();
    
        // lấy 1 số trường
        // $products = Product::with(['productDetail' => function ($query) {
        //     $query->select('product_id', 'product_cpu'); 
        // }])->get();
        // return response()->json($products);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create(Request $request)
    // {
    //     // return Product::create($request -> all());
    // }
    public function create(Request $request)
{
    $product = Product::create([
        'category_id' => $request->input('category_id'),
        'product_sale' => $request->input('product_sale'),
        'product_name' => $request->input('product_name'),
        'product_price' => $request->input('product_price'),
        'product_content' => $request->input('product_content'),
        'product_image' => $request->input('product_image'),
        'product_status' => $request->input('product_status'),
    ]);

    return response()->json(['message' => 'Product created successfully', 'data' => $product]);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  $validatedData = $request->validate([
        //     'product_name' => 'required|string|max:255',
        //     'product_content' => 'required|string',
        //     'product_price' => 'required|numeric',
        //     'product_sale' => 'numeric',
        //     'product_image' => 'required|string',
        //     'product_status' => 'required|in:1,0',
        // ]);

        // // Create a new product instance
        // $product = Product::create($validatedData);

        // // If you have a ProductDetail model and a relationship set up in the Product model, you can also create a product detail here
        // // $productDetail = new ProductDetail(['additional_field' => 'value']);
        // // $product->productDetail()->save($productDetail);

        // // Optionally, you can return the created product as a response
        // return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
