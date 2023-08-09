<?php

namespace Tests\Feature;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as FakerFactory;
use Tests\TestCase;

class ProductControllertest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_example()
    {
        $faker = FakerFactory::create();

        $data = [
            'name' => $faker->word(),
            'description' => $faker->paragraph(),
            'price' => $faker->numberBetween(100, 500),
        ];

        $product = Product::create($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($data['name'], $product->name);
        $this->assertEquals($data['price'], $product->price);
        $this->assertEquals($data['description'], $product->description);
    }
}
