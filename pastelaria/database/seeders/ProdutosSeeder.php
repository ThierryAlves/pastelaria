<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProdutosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insert = [
            [
                'nome' => 'Pastel de carne',
                'preco' => 6.50,
                'path_foto' => 'pastel.jpg',
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->addDays(rand(1, 30)),
            ],
        ];

        DB::table('produtos')->insert($insert);
    }
}
