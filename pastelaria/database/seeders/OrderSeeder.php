<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\ItemsOrder;
use App\Models\Order;
use App\Models\Product;
use Database\Factories\ItemsOrderFactory;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()
            ->count(6)
            ->create();

        Order::factory()
            ->count(13)
            ->for(Customer::factory())
            ->hasItems(3, [
                'produto_id' => 1,
            ])
            ->create();
    }
}
