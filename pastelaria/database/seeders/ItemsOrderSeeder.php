<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\ItemsOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ItemsOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order = Order::factory()->create();
        Product::factory()->create();

        ItemsOrder::factory()
            ->count(13)
            ->has(Product::factory(), 'produto_id')
            ->create();
    }
}
