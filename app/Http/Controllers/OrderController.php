<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $rules = [
            'customer_id' => 'required|exists:customers,customer_id',
            'shipping_id' => 'numeric',
            'payment_id' => 'numeric',
            'order_total' => 'numeric',
            'order_status' => 'numeric',
        ];

        $request->validate($rules);

        // Create the product if validation passes
        $order = Order::create([
            'customer_id' => $request->input('customer_id'),
            'shipping_id' => $request->input('shipping_id'),
            'payment_id' => $request->input('payment_id'),
            'order_total' => $request->input('order_total'),
            'order_status' => $request->input('order_status'),
            'created_at'=> now(),
        ]);

        $order_id = $order->order_id;

        $orderDetails = $request->input('order_detail');
        foreach ($orderDetails as $detail) {
            OrderDetail::create([
                'order_id' => $order_id,
                'product_id' => $detail['product_id'],
                'product_name' => $detail['product_name'],
                'product_price' => $detail['product_price'],
                'product_sales_quantity' => $detail['product_sales_quantity'],
            ]);
        }

        return response()->json(['message' => 'Order created successfully', 'data' => $order]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
