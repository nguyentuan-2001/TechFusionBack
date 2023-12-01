<?php

namespace App\Http\Controllers;

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
        'products.*.product_id' => 'required|numeric',
        'products.*.product_quantity' => 'required|numeric',
    ]);

    $customer_id = $request->input('customer_id');
    $cartItems = $request->input('products');

    $createdCartItems = [];

    try {
        foreach ($cartItems as $cart) {
            $createdCartItem = Cart::create([
                'customer_id' => $customer_id,
                'product_id' => $cart['product_id'],
                'product_quantity' => $cart['product_quantity'],
            ]);

            $createdCartItems[] = $createdCartItem;
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error creating cart items', 'message' => $e->getMessage()], 500);
    }

    return response()->json(['message' => 'Cart created successfully', 'data' => $createdCartItems]);
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
    public function update(Request $request, Cart $cart)
    {
        //
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
}
