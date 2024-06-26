<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = 16;
        
        $coupons = Coupon::paginate($perPage);

        return response()->json($coupons);
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
            'coupon_code' => 'required|string',
            'coupon_discount' => 'required|numeric',
            'coupon_expiry_date' => 'required|date',
            'coupon_quantity' => 'required',
        ]);

        $coupon = Coupon::create($request->all());

        return response()->json(['message' => 'coupon created successfully', 'data' => $coupon]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'coupon_discount' => 'required|numeric',
            'coupon_expiry_date' => 'required|date',
            'coupon_quantity' => 'required',
        ]);

        $coupon->update($request->all());

        return response()->json(['message' => 'Coupon updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->json(['message' => 'Coupon deleted successfully']);
    }

    public function getAllCouponInactive()
    {
        $perPage = 16;
        $currentDate = Carbon::now();
        
        $coupons = Coupon::whereDate('coupon_expiry_date', '>', $currentDate)
        ->where('coupon_quantity', '>', 0)->paginate($perPage);

        $responseData = [
            'data' => $coupons,
        ];

        return response()->json($responseData);
    }

    public function getCouponDiscountByCode(Request $request)
    {
        $currentDate = Carbon::now();

        $couponCode = $request->input('coupon_code');

        $coupon = Coupon::where('coupon_code', $couponCode)
                        ->whereDate('coupon_expiry_date', '>', $currentDate)
                        ->where('coupon_quantity', '>', 0)
                        ->first();

        if ($coupon) {
            // Trừ đi 1 ở cột quantity
            $coupon->decrement('coupon_quantity', 1);

            return response()->json($coupon->coupon_discount);
        } else {
            return response()->json(['message' => 'Coupon is invalid or expired'], 404);
        }
    }


    public function getRandomCoupon()
    {
        // Lấy một mã coupon ngẫu nhiên từ cơ sở dữ liệu
        $coupon = Coupon::inRandomOrder()->first();

        // Kiểm tra nếu không có mã coupon nào tồn tại
        if (!$coupon) {
            return response()->json(['message' => 'No coupons available'], 404);
        }

        // Trả về mã coupon ngẫu nhiên
        return response()->json($coupon);
    }
}
