<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insert = [
            [
                'nome' => 'Pastel de carne',
                'preco' => 5,
                'foto_produto' => 'phpQy6vue.jpg',
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->addDays(rand(1, 30)),
            ],
            [
                'nome' => 'Pastel de frango',
                'preco' => 5,
                'foto_produto' => 'phpdACMwc.jpg',
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->addDays(rand(1, 30)),
            ],
            [
                'nome' => 'Pastel de bauru',
                'preco' => 6.50,
                'foto_produto' => 'phpVPJEQb.jpg',
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->addDays(rand(1, 30)),
            ],
            [
                'nome' => 'Pastel de pizza',
                'preco' => 6.50,
                'foto_produto' => 'phpnsK2Pd.jpg',
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->addDays(rand(1, 30)),
            ],
            [
                'nome' => 'Pastel de carne seca',
                'preco' => 8.50,
                'foto_produto' => 'phpj8T5oj.jpg',
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->addDays(rand(1, 30)),
            ],
        ];

        DB::table('produtos')->insert($insert);
    }
}
