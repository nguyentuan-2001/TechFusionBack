<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'category_id' => 'required|exists:categories,category_id',
            'product_sale' => 'numeric',
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'product_content' => 'string',
            'product_image' => 'required|string',
            'product_inventory_quantity'=>'numeric',
            'product_status' => 'required|in:1,0', 
        ];

        $request->validate($rules);

        // Create the product if validation passes
        $product = Product::create([
            'category_id' => $request->input('category_id'),
            'product_sale' => $request->input('product_sale'),
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'product_content' => $request->input('product_content'),
            'product_image' => $request->input('product_image'),
            'product_inventory_quantity'=> $request->input('product_inventory_quantity'),
            'product_status' => $request->input('product_status'),
        ]);

        return response()->json(['message' => 'Product created successfully', 'data' => $product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($slider);
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
        // Kiểm tra xem sản phẩm tồn tại không
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Validate dữ liệu từ request
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'product_sale' => 'numeric',
            'product_name' => 'required|string',
            'product_price' => 'required|numeric',
            'product_content' => 'string',
            'product_image' => 'required|string',
            'product_inventory_quantity'=> 'numeric',
            'product_status' => ['required', Rule::in(['1', '0'])],
        ]);

        // Cập nhật thông tin sản phẩm
        $product->update([
            'category_id' => $request->input('category_id'),
            'product_sale' => $request->input('product_sale'),
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'product_content' => $request->input('product_content'),
            'product_image' => $request->input('product_image'),
            'product_inventory_quantity'=>$request->input('product_inventory_quantity'),
            'product_status' => $request->input('product_status'),
        ]);

        // Trả về phản hồi với thông báo
        return response()->json(['message' => 'Product updated successfully', 'data' => $product]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Lấy product_id của sản phẩm
        $productId = $product->product_id;

        // Xóa tất cả các bản ghi liên quan trong các bảng
        $product->productDetail()->delete();
        //Thêm các bảng liên quan khác nếu có

        // Xóa sản phẩm chính
        $product->delete();

        // Trả về phản hồi với thông báo
        return response()->json(['message' => 'Product and related records deleted successfully'], 200);
    }
    
    public function searchByName(Request $request)
    {
        try {
            // Validate the search query
            $request->validate([
                'product_name' => 'required|string|max:255',
            ]);
    
            $products = Product::where('product_name', 'like', '%' . $request->input('product_name') . '%')->get();
    
            if ($products->isEmpty()) {
                return response()->json(['message' => 'No products found for the given search query', 'data' => []]);
            }
    
            return response()->json(['data' => $products]);
        } catch (\Exception $e) {
            // Handle exceptions if any
            return response()->json(['message' => 'Error searching products', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function getProductsByCategory($category_id)
    {
        try {
            // Validate the category ID
            $category = Category::find($category_id);

            if (!$category) {
                return response()->json(['message' => 'Category not found'], 404);
            }

            // Get products associated with the category
            $products = $category->products ?? collect();

            if ($products->isEmpty()) {
                return response()->json(['message' => 'No products found for the given category', 'data' => []]);
            }

            return response()->json(['data' => $products]);
        } catch (\Exception $e) {
            // Handle exceptions if any
            return response()->json(['message' => 'Error retrieving products by category', 'error' => $e->getMessage()], 500);
        }
    }

    public function getProductDetail($product_id)
    {
        try {
            $product = Product::with('productDetail')->findOrFail($product_id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }
    
            return response()->json(['data' => $product]);
        } catch (\Exception $e) {
            return response()->json(['data' => []]);
        }
    }
    
}
