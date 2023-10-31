<?php

namespace Tests\Unit;

use App\Http\Service\ProductService;
use Database\Seeders\ProdutosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_service_add_success()
    {
        Storage::fake('produtos');

        $newProduct = [
            'nome' => 'teste',
            'preco' => 12.55,
            'foto_produto' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $productService = resolve(ProductService::class);
        $createdProduct = $productService->add($newProduct);
        $this->assertDatabaseCount('produtos', 1);
        $this->assertEquals($createdProduct['nome'], $newProduct['nome']);
        $this->assertEquals($createdProduct['preco'], $newProduct['preco']);
        $this->assertEquals($createdProduct['preco'], $newProduct['preco']);
        Storage::disk('produtos')->assertExists($createdProduct->getRawOriginal('foto_produto'));
    }


    /**
     * @return void
     */
    public function test_products_service_list_has_five_items_listed(): void
    {
        $this->seed(ProdutosSeeder::class);
        $productService = resolve(ProductService::class);
        $response = $productService->list();
        $response = $response->toArray();
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey(4, $response['data']);
        $this->assertArrayNotHasKey(5, $response['data']);
    }


    /**
     * @return void
     */
    public function test_products_service_list_has_no_items(): void
    {
        $customerService = resolve(ProductService::class);
        $response = $customerService->list();
        $this->assertInstanceOf(Paginator::class, $response);
        $response = $response->toArray();
        $this->assertArrayHasKey('data', $response);

        $assertion = [
            'current_page' => 1,
            'data' => [],
            'first_page_url' => 'http://localhost?page=1',
            'from' => null,
            'next_page_url' => null,
            'path' => 'http://localhost',
            'per_page' => 15,
            'prev_page_url' => null,
            'to' => null
        ];

        $this->assertEquals($response, $assertion);
    }
}
