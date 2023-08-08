<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->createDefaultUsers();
    }

    public function createDefaultUsers(){
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'is_admin' => 1,
        ]);
        
        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'normal@gmail.com',
            'password' => 'password',
            'is_admin' => 0,
        ]);
    }
}
