<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($customer_id)
    {
        return Cart::where('customer_id', $customer_id)
            ->select('cart_id', 'customer_id', 'product_id', 'product_quantity')
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'products' => 'required|array',
        ]);
    
        $customerId = $request->input('customer_id');
        $products = $request->input('products');
    
        foreach ($products as $product) {
            $productId = $product['product_id'];
            $quantity = $product['product_quantity'];
    
            // Nếu sản phẩm đã tồn tại trong giỏ hàng của khách hàng, cập nhật quantity
            Cart::updateOrCreate(
                ['customer_id' => $customerId, 'product_id' => $productId],
                ['product_quantity' => \DB::raw("product_quantity + $quantity")]
            );
        }
    
        return response()->json(['message' => 'Cart updated successfully'], 200);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customer_id, $product_id)
    {
        // Validate the request data
        $request->validate([
            'product_quantity' => 'required|numeric',
        ]);
    
        // Find the cart item associated with the customer and product
        $cart = Cart::where('customer_id', $customer_id)
                    ->where('product_id', $product_id)
                    ->first();
    
        // Check if the cart item exists
        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }
    
        // Update the cart item with the new product quantity
        $cart->update([
            'product_quantity' => $request->input('product_quantity'),
        ]);
    
        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'Cart item updated successfully', 'data' => $cart]);
    }    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function getCartProducts($customerId)
    {
        // Lấy thông tin giỏ hàng của khách hàng theo customer_id
        $cartItems = Cart::with(['productDetail' => function ($query) {
            $query->select('product_id', 'product_name', 'product_price', 'product_image','product_inventory_quantity');
        }])->where('customer_id', $customerId)->get(['customer_id', 'product_id', 'product_quantity']);

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart not found'], 404);
        }
        return response()->json(['data' => $cartItems]);
    }

    public function deleteProductFromCart($customerId, $productId)
    {
        $cartItem = Cart::where('customer_id', $customerId)
                        ->where('product_id', $productId)
                        ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Product not found in the cart'], 404);
        }

        // Delete the cart item
        $cartItem->delete();

        return response()->json(['message' => 'Product deleted from the cart']);
    }
    public function deleteAllProductsFromCart($customerId)
    {
        $cartItems = Cart::where('customer_id', $customerId)->get();
    
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is already empty']);
        }
    
        $cartItems->each(function ($cartItem) {
            $cartItem->delete();
        });
    
        return response()->json(['message' => 'All products deleted from the cart']);
    }
}
