<?php

namespace Tests\Feature;

use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_get_success(): void
    {
        $this->seed(ProductSeeder::class);
        $response = $this->get('/api/product/get/1');
        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('id', 1)
                ->etc()
            );
        $response->assertStatus(200);
    }

    public function test_product_get_not_found(): void
    {
        $response = $this->get('/api/product/get/1');
        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message', 'Unable to locate the product you requested.')
                ->etc()
            );
        $response->assertStatus(404);
    }

    public function test_product_create_success(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'Nome Do Tamanho Aceito',
            'preco' => 12.55,
            'foto_produto' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response->assertStatus(200);
    }

    public function test_product_create_name_required_error(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'Nom',
            'preco' => 12.55,
            'foto_produto' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The nome field must be at least 8 characters.')
                ->etc()
            );
        $response->assertStatus(422);
    }

    public function test_product_create_name_lenght_error(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'Nom',
            'preco' => 12.55,
            'foto_produto' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The nome field must be at least 8 characters.')
                ->etc()
            );
        $response->assertStatus(422);
    }

    public function test_product_delete_success(): void
    {
        $this->seed(ProductSeeder::class);

        $response = $this->delete('/api/product/delete/1');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'produto excluido')
                ->etc()
            );

        $this->assertSoftDeleted('produtos', ['id' => 1]);
        $response->assertStatus(200);
    }

    public function test_product_delete_not_found(): void
    {
        $response = $this->delete('/api/product/delete/1');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'Unable to locate the product you requested.')
                ->etc()
            );

        $response->assertStatus(404);
    }

    /**
     * @return void
     */
    public function test_products_list_success(): void
    {
        $this->seed(ProductSeeder::class);

        $response = $this->get('/api/product/list/');

        $response
            ->assertJsonStructure(
                [
                    'current_page',
                    'data' => [
                    [
                        'id',
                        'nome',
                        'preco',
                        'foto_produto',
                        'created_at',
                        'updated_at'

                    ]
                ]],
            )
            ->assertJson(fn (AssertableJson $json) =>
            $json->whereType('data', 'array')
                ->where('current_page', 1)
                ->where('per_page', 15)
                ->etc()
            );

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_products_list_empty(): void
    {
        $this->seed(ProductSeeder::class);

        $response = $this->get('/api/product/list/?page=2');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->whereType('data', 'array')
                ->missing('data.0')
                ->where('current_page', 2)
                ->where('per_page', 15)
                ->etc()
            );

        $response->assertStatus(200);
    }

    public function test_product_patch_name_success(): void
    {
        $this->seed(ProductSeeder::class);

        $newName = 'Nome Atualizado';
        $newProduct = [
            'nome' => $newName
        ];

        $response = $this->patch('/api/product/update/1', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('nome', $newName)
                ->etc()
            );

        $response->assertStatus(200);
    }

    public function test_product_patch_name_lenght_error(): void
    {
        $this->seed(ProductSeeder::class);

        $newProduct = [
            'nome' => 'Nom'
        ];

        $response = $this->patch('/api/product/update/1', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The nome field must be at least 8 characters.')
                ->etc()
            );
        $response->assertStatus(422);
    }
}
