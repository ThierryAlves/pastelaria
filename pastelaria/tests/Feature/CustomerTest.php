<?php

namespace Tests\Feature;

use App\Models\Customer;
use Database\Seeders\CustomerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Str;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_get_success(): void
    {
        $this->seed(CustomerSeeder::class);
        $response = $this->get('/api/customer/get/1');
        $response
            ->assertJsonStructure([
                'nome',
                'email',
                'telefone',
                'data_nascimento',
                'endereco',
                'complemento',
                'bairro',
                'cep',
                'updated_at',
                'created_at'
            ]);

        $response->assertStatus(200);
    }

    public function test_customer_get_not_found(): void
    {
        $response = $this->get('/api/customer/get/1');
        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'Unable to locate the customer you requested.')
                ->etc()
            );
        $response->assertStatus(404);
    }

    public function test_customer_create_without_complemento_success(): void
    {

        $newCustomer = [
            'nome' => Str::random(10),
            'email' => fake()->unique()->safeEmail(),
            'telefone' => fake()->cellphone(false),
            'data_nascimento' => fake()->date('d/m/Y'),
            'endereco' => Str::random(10),
            'cep' => fake()->postcode,
            'bairro' => Str::random(10)
        ];

        $response = $this->post('/api/customer/create', $newCustomer);
        $response
            ->assertJsonStructure([
                'nome',
                'email',
                'telefone',
                'data_nascimento',
                'endereco',
                'bairro',
                'cep',
                'updated_at',
                'created_at'
            ]) ->assertJson(fn (AssertableJson $json) =>
                $json->missing('complemento')
                ->etc()
            );

        $response->assertStatus(200);
    }

    public function test_customer_create_with_complemento_success(): void
    {

        $newCustomer = [
            'nome' => Str::random(10),
            'email' => fake()->unique()->safeEmail(),
            'telefone' => fake()->cellphone(false),
            'data_nascimento' => fake()->date('d/m/Y'),
            'endereco' => Str::random(10),
            'complemento' => Str::random(10),
            'cep' => fake()->postcode,
            'bairro' => Str::random(10)
        ];

        $response = $this->post('/api/customer/create', $newCustomer);
        $response
            ->assertJsonStructure([
                'nome',
                'email',
                'telefone',
                'data_nascimento',
                'complemento',
                'endereco',
                'bairro',
                'cep',
                'updated_at',
                'created_at'
            ]);

        $response->assertStatus(200);
    }

    public function test_customer_create_name_required_error(): void
    {

        $newCustomer = [
            'email' => fake()->unique()->safeEmail(),
            'telefone' => fake()->cellphone(false),
            'data_nascimento' => fake()->date('d/m/Y'),
            'endereco' => Str::random(10),
            'cep' => fake()->postcode,
            'bairro' => Str::random(10)
        ];

        $response = $this->post('/api/customer/create', $newCustomer);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The nome field is required.')
                ->etc()
            );

        $response->assertStatus(422);
    }

    public function test_customer_delete_success(): void
    {
        $this->seed(CustomerSeeder::class);

        $response = $this->delete('/api/customer/delete/1');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'cliente excluido')
                ->etc()
            );

        $this->assertSoftDeleted('clientes', ['id' => 1]);
        $response->assertStatus(200);
    }

    public function test_customer_delete_not_found(): void
    {
        $response = $this->delete('/api/customer/delete/1');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'Unable to locate the customer you requested.')
                ->etc()
            );

        $response->assertStatus(404);
    }

    /**
     * @return void
     */
    public function test_customers_list_success(): void
    {
        $this->seed(CustomerSeeder::class);

        $response = $this->get('/api/customer/list/');

        $response
            ->assertJsonStructure(
                [
                    'current_page',
                    'data' => [
                        [
                            'nome',
                            'email',
                            'telefone',
                            'data_nascimento',
                            'complemento',
                            'endereco',
                            'bairro',
                            'cep',
                            'updated_at',
                            'created_at'

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
    public function test_customers_list_empty(): void
    {
        $this->seed(CustomerSeeder::class);

        $response = $this->get('/api/customer/list/?page=2');

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

    public function test_customer_patch_name_success(): void
    {
        $this->seed(CustomerSeeder::class);

        $newName = 'Nome Atualizado';
        $newCustomer = [
            'nome' => $newName
        ];

        $response = $this->patch('/api/customer/update/1', $newCustomer);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('nome', $newName)
                ->etc()
            );

        $response->assertStatus(200);
    }

    public function test_customer_patch_no_data_error(): void
    {
        $this->seed(CustomerSeeder::class);

        $newCustomer = [

        ];

        $response = $this->patch('/api/customer/update/1', $newCustomer);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'nome,email,telefone,data_nascimento,endereco,complemento,bairro or cep must be present.')
                ->etc()
            );
        $response->assertStatus(422);
    }

    public function test_customer_patch_name_lenght_error(): void
    {
        $this->seed(CustomerSeeder::class);

        $newCustomer = [
            'nome' => 'Nom'
        ];

        $response = $this->patch('/api/customer/update/1', $newCustomer);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'The nome field must be at least 8 characters.')
                ->etc()
            );
        $response->assertStatus(422);
    }
}
