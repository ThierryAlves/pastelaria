<?php

namespace Tests\Feature;

use Database\Seeders\CustomerSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_get_success(): void
    {
        $this->seed(OrderSeeder::class);
        $response = $this->get('/api/order/get/1');

        $response->assertJsonStructure([
            'id',
            'cliente_id',
            'created_at',
            'updated_at',
            'total_cost',
            'customer' => [
                'id',
                'nome',
                'email',
                'telefone',
                'data_nascimento',
                'endereco',
                'bairro',
                'cep',
                'created_at',
                'updated_at'
            ],
            'items' => [
                '*' => [
                    'id',
                    'pedido_id',
                    'produto_id',
                    'created_at',
                    'updated_at',
                    'product' => [
                        'id',
                        'nome',
                        'preco',
                        'foto_produto',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_order_get_not_found(): void
    {
        $response = $this->get('/api/order/get/1');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'Unable to locate the order you requested.')
                ->etc()
            );
        $response->assertStatus(404);
    }

    public function test_order_create_success(): void
    {

        $this->seed([CustomerSeeder::class, ProductSeeder::class]);

        $newOrder = [
            'cliente_id' => 1,
            'produtos' => [
                4,5,2
            ]
        ];

        $response = $this->post('/api/order/create', $newOrder);

        $response->assertJsonStructure([
            'id',
            'cliente_id',
            'created_at',
            'updated_at',
            'total_cost',
            'customer' => [
                'id',
                'nome',
                'email',
                'telefone',
                'data_nascimento',
                'endereco',
                'bairro',
                'cep',
                'created_at',
                'updated_at'
            ],
            'items' => [
                '*' => [
                    'id',
                    'pedido_id',
                    'produto_id',
                    'created_at',
                    'updated_at',
                    'product' => [
                        'id',
                        'nome',
                        'preco',
                        'foto_produto',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]
        ])->assertJson(fn (AssertableJson $json) =>
            $json->where('items.0.product.id', 4)
            ->where('items.1.product.id', 5)
            ->where('items.2.product.id', 2)
            ->where('customer.id', 1)
                ->etc()
        );

        $response->assertStatus(200);
    }

    public function test_order_create_product_dont_exists_error(): void
    {
        $newOrder = [
            'cliente_id' => 1,
            'produtos' => [
                6
            ]
        ];

        $response = $this->post('/api/order/create', $newOrder);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The product 6 don\'t exists.')
                ->etc()
            );

        $response->assertStatus(422);
    }

    public function test_order_delete_success(): void
    {
        $this->seed(OrderSeeder::class);

        $response = $this->delete('/api/order/delete/1');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'pedido excluido')
                ->etc()
            );

        $this->assertSoftDeleted('pedidos', ['id' => 1]);
        $response->assertStatus(200);
    }

    public function test_order_list_success(): void
    {
        $this->seed(OrderSeeder::class);

        $response = $this->get('/api/order/list/');

        $response
            ->assertJsonStructure(
                [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'cliente_id',
                            'created_at',
                            'updated_at',
                            'total_cost',
                            'customer' => [
                                'id',
                                'nome',
                                'email',
                                'telefone',
                                'data_nascimento',
                                'endereco',
                                'bairro',
                                'cep',
                                'created_at',
                                'updated_at'
                            ],
                            'items' => [
                                '*' => [
                                    'id',
                                    'pedido_id',
                                    'produto_id',
                                    'created_at',
                                    'updated_at',
                                    'product' => [
                                        'id',
                                        'nome',
                                        'preco',
                                        'foto_produto',
                                        'created_at',
                                        'updated_at'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            )
            ->assertJson(fn (AssertableJson $json) =>
            $json->whereType('data', 'array')
                ->where('current_page', 1)
                ->where('per_page', 10)
                ->etc()
            );

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_order_list_empty(): void
    {
        $this->seed(OrderSeeder::class);

        $response = $this->get('/api/order/list/?page=4');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->whereType('data', 'array')
                ->missing('data.0')
                ->where('current_page', 4)
                ->where('per_page', 10)
                ->etc()
            );

        $response->assertStatus(200);
    }

    public function test_order_put_products_success(): void
    {
        $this->seed(OrderSeeder::class);

        $newProducts = [
            'cliente_id' => 1,
            'produtos' => [2,3]
        ];

        $response = $this->put('/api/order/changeProducts/1', $newProducts);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('items.0.product.id', 2)
                ->where('items.1.product.id', 3)
                ->etc()
            );

        $this->assertSoftDeleted('itens_pedido', ['id' => 1]);
        $this->assertSoftDeleted('itens_pedido', ['id' => 2]);
        $response->assertStatus(200);
    }

    public function test_order_put_empty_error(): void
    {
        $this->seed(OrderSeeder::class);

        $newProducts = [

        ];

        $response = $this->put('/api/order/changeProducts/1', $newProducts);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The produtos field is required. (and 1 more error)')
                ->where('errors.produtos.0', 'The produtos field is required.')
                ->where('errors.cliente_id.0', 'The cliente id field is required.')
                ->etc()
            );

        $response->assertStatus(422);
    }

    public function test_order_put_products_empty_error(): void
    {
        $this->seed(OrderSeeder::class);

        $newProducts = [
            'cliente_id' => 1,
            'produtos' => []
        ];

        $response = $this->put('/api/order/changeProducts/1', $newProducts);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The produtos field is required.')
                ->etc()
            );

        $response->assertStatus(422);
    }

    public function test_order_put_products_dont_exists_error(): void
    {
        $this->seed(OrderSeeder::class);

        $newProducts = [
            'cliente_id' => 1,
            'produtos' => [7]
        ];

        $response = $this->put('/api/order/changeProducts/1', $newProducts);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The product 7 don\'t exists.')
                ->etc()
            );

        $response->assertStatus(422);
    }


}
