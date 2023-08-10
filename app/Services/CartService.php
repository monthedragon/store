<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class CartService
{
    private $productInfo;
    private $_cancel_status = 4;
    private $_ship_status = 3;
    private $_checkout_status = 2;
    private $_cart_status = 1;
    public $order_id;

    public function createOrder(Product $product, $userId = null)
    {
        // $this->getProductInfo($productId);

        $userId = $userId ?? auth()->user()->id ?? 1;
        if (!$orderId = $this->getExistingOrder($userId)) {
            $order = Order::create(['user_id' => $userId]);
            $orderId = $order->id;
        }
        $this->order_id = $orderId;

        $this->createOrderDetails($orderId, $product->id);
        $this->updateOrderInfo($orderId, $product);
    }

    public function getProductInfo(int $productId)
    {
        $this->productInfo = Product::find($productId);
    }

    public function getExistingOrder($userId)
    {
        $orderID = Order::where('user_id', $userId)->where('status', 1)->value('id');
        return $orderID;
    }

    /**
     * create order_details record
     */
    public function createOrderDetails(int $orderId, int $productId)
    {

        $orderDetailId = OrderDetail::where('order_id', $orderId)->where('product_id', $productId)->value('id');

        if ($orderDetailId) {

            //update existing order_details
            OrderDetail::where('id', $orderDetailId)
                ->update(['quantity' => \DB::raw('quantity + 1')]);

        } else {

            //create new order_details
            $data = [
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' =>  1, //TODO make it dynamic
            ];
            //insert
            OrderDetail::create($data);
        }

        // $data = [
        //     'order_id' => $orderId,
        //     'product_id' => $productId,
        //     'quantity' =>  \DB::raw('quantity + 1') //TODO make it dynamic,
        // ];

        // OrderDetail::updateOrInsert(
        //     ['order_id' => $orderId, 'product_id' => $productId],
        //     $data
        // );
    }

    public function updateOrderInfo(int $orderId, Product $product, OrderDetail $orderDetail = null)
    {
        if($orderDetail){ //when passed, reduction will be done
            $qty = $orderDetail->quantity;
            $amount = $product->price*$qty;
            $operation = '-';
        }else{
            $qty = 1; //todo make it dynamic
            $amount = $product->price * $qty;
            $operation = '+';
        }

        Order::where('id', $orderId)->update([
            'total_quantity' => \DB::raw("total_quantity  {$operation} ". $qty),
            'total_amount' => \DB::raw("total_amount {$operation} ". $amount)
        ]);
    }

    public function deductOrderInfo(OrderDetail $orderDetail){
        $this->updateOrderInfo($orderDetail->order_id, $orderDetail->product, $orderDetail);
    }

    public function cancelOrder(int $orderId){
        Order::where('id', $orderId)->update(['status'=>$this->_cancel_status]);
    }

    public function shipOrder(int $orderId){
        Order::where('id', $orderId)->update(['status'=>$this->_ship_status]);
    }

    public function checkOutOrder(Order $order){
        if($order->orderDetail()->count() == 0) return false;

        $order->update(['status'=>$this->_checkout_status]);
        return true;
    }

    public function getUserActiveOrderList($userId){
        $order = Order::with(['orderDetail','user','orderDetail.product'])
                ->where('status', $this->_cart_status)
                ->where('user_id', $userId)
                ->first();

        return $order;
    }
}
