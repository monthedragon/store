<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }
    public function index(){

        if(auth()->user()->can('isAdmin')){
            //For admin, display all the available orders
            $orders = Order::with(['user'])->paginate(10);
            return view('order.index', ['orders' => $orders]);
        }else{
            //For regular user, display active order
            $userId = auth()->user()->id;
            $order = $this->cartService->getUserActiveOrderList($userId);
            return view('order-details.index', ['order' => $order??null]);
        }

    }

    /**
     * Display single order together the order details
     */
    public function show(Order $order){
        $orderDetails = $order->orderDetail()->paginate(5);
        return view('order-details.index', ['order' => $order, 'orderDetails' => $orderDetails]);
    }

    //
    public function store(Product $product){ 
        try{

            $this->cartService->createOrder($product);
            
            return response()->json([
                'message' => 'AJAX request processed successfully',
                'flash' => 'Product successfully added'
            ]);
            
        }catch(Exception $e){

            return response()->json([
                'flash' => 'Error adding the order'
            ]);

        }
    }

    public function cancel(Order $order){ 
        $this->cartService->cancelOrder($order->id);
        return redirect('order')->with(['msg' => 'Order successfully cancelled']);
    }
    
    public function ship(Order $order){ 
        $this->cartService->shipOrder($order->id);
        return redirect('order')->with(['msg' => 'Order successfully shipped']);
    }
    
    public function checkOut(Order $order){ 
        $this->cartService->checkOutOrder($order);
        return redirect('order')->with(['msg' => 'Order successfully checked out']);
    }
}
	