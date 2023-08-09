<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Services\CartService;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    //
    public function destroy(OrderDetail $orderDetail){
        $orderDetail->delete();
        $cartService = new CartService();
        $cartService->deductOrderInfo($orderDetail);
        return back()->with(['msg' => 'Product sucessfully removed']);
    }
}
