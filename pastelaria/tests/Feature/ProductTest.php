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
            ->assertJsonStructure([
                'id',
                'nome',
                'preco',
                'foto_produto',
                'created_at',
                'updated_at'
            ])
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
            'foto_produto' => UploadedFile::fake()->image('pastel.jpg')
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response->assertJsonStructure([
            'id',
            'nome',
            'preco',
            'foto_produto',
            'created_at',
            'updated_at'
        ])->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->etc()
        );;

        $response->assertStatus(200);
    }

    public function test_product_create_name_required_error(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'preco' => 12.55,
            'foto_produto' => UploadedFile::fake()->image('pastel.jpg')
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The nome field is required.')
                ->etc()
            );
        $response->assertStatus(422);
    }

    public function test_product_create_name_min_size_8_error(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'Nom',
            'preco' => 12.55,
            'foto_produto' => UploadedFile::fake()->image('pastel.jpg')
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
            'foto_produto' => UploadedFile::fake()->image('pastel.jpg')
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The nome field must be at least 8 characters.')
                ->etc()
            );
        $response->assertStatus(422);
    }

    public function test_product_create_foto_produto_must_be_file_error(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'Nome Tamanho Aceito',
            'preco' => 12.55,
            'foto_produto' => 'UploadedFile::fake()->image()'
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The foto produto field must be a file. (and 1 more error)')
                ->where('errors.foto_produto.0', 'The foto produto field must be a file.')
                ->where('errors.foto_produto.1', "The foto produto field must be a file of type: image/jpeg, image/png.")
                ->etc()
            );
        $response->assertStatus(422);
    }

    public function test_product_create_file_size_error(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'Nome Tamanho Aceito',
            'preco' => 12.55,
            'foto_produto' => UploadedFile::fake()->image('pastel.jpg')->size(10000)
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The foto produto field must not be greater than 2000 kilobytes.')
                ->etc()
            );
        $response->assertStatus(422);
    }

    public function test_product_create_file_type_error(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'Nome Tamanho Aceito',
            'preco' => 12.55,
            'foto_produto' => UploadedFile::fake()->image('pastel.pdf')
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The foto produto field must be a file of type: image/jpeg, image/png.')
                ->etc()
            );
        $response->assertStatus(422);
    }

    public function test_product_create_preco_required_error(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'Nome Tamanho Aceito',
            'foto_produto' => UploadedFile::fake()->image('pastel.jpg')
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The preco field is required.')
                ->etc()
            );
        $response->assertStatus(422);
    }

    public function test_product_create_preco_must_be_float_error(): void
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'Nome Tamanho Aceito',
            'preco' => 12.555678,
            'foto_produto' => UploadedFile::fake()->image('pastel.jpg')
        ];

        $response = $this->post('/api/product/create', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The preco field must have 0-2 decimal places.')
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

    public function test_product_patch_no_data_error(): void
    {
        $this->seed(ProductSeeder::class);

        $newProduct = [

        ];

        $response = $this->patch('/api/product/update/1', $newProduct);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'nome, preco or foto_produto must be present.')
                ->etc()
            );
        $response->assertStatus(422);
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
