<?php

namespace Tests\Feature;

use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as FakerFactory;

class OrderControllerTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    

    public function test_order_quantity_and_price(){
        $faker = FakerFactory::create();
        $cartService = (new CartService());

        $price = 500;
        $maxIteration = 5;

        for($i = 1; $i<=$maxIteration; $i++){
            $data = [
                'name' => $faker->word(),
                'description' => $faker->paragraph(),
                'price' => $price,
            ];
    
            $product = Product::create($data);
    
            $order = (new OrderController($cartService))->store($product);
        }

        $order = Order::find($cartService->order_id);

        $this->assertEquals($price*$maxIteration, $order->total_amount);
        $this->assertEquals($maxIteration, $order->total_quantity);

    }
}
