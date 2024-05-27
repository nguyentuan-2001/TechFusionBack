<?php

namespace App\Http\Controllers;

use App\Models\ProductCapacity;
use Illuminate\Http\Request;

class ProductCapacityController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCapacity  $productCapacity
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCapacity $productCapacity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCapacity  $productCapacity
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCapacity $productCapacity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCapacity  $productCapacity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCapacity $productCapacity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCapacity  $productCapacity
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCapacity $productCapacity)
    {
        if ($productCapacity) {
            $productCapacity->delete();

            // Trả về phản hồi với thông báo
            return response()->json(['message' => 'product capacity deleted successfully'], 200);
        } else {
            // Trả về phản hồi nếu slider không tồn tại
            return response()->json(['message' => 'product capacity not found'], 404);
        }
    }
}
