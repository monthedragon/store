<?php

namespace Database\Seeders;

use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(2)->create();
        $this->createDefaultUsers();
        $this->createOrders();
        Product::factory(500)->create();
        
    }

    public function createDefaultUsers(){
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'is_admin' => 1, //admin
        ]);
        
        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'normal@gmail.com',
            'password' => 'password',
            'is_admin' => 0, //non-admin
        ]);
    }

    public function createOrders(){
        $faker = FakerFactory::create();
        $cartService = (new CartService());
        $staffArr = User::all(); //retrieve all the staff records created
        

        $price = 500;
        $maxIteration = 5;

        foreach($staffArr as $staff){
            $data = [
                'name' => $faker->word(),
                'description' => $faker->paragraph(),
                'price' => $price,
            ];
    
            $product = Product::create($data);
            $user = User::factory(1)->create();
            $cartService->createOrder($product,$staff->id);
        }
    }
}
