<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ProductData;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Service\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    private $productData;

    public function __construct(ProductService $productService, ProductData $productData)
    {
        $this->productService = $productService;
        $this->productData = $productData;
    }

    public function create(CreateProductRequest $request)
    {
        $product = $this->productData->fromRequest($request);
        $createdProduct = $this->productService->add($product);
        return response($createdProduct);
    }

    public function get(int $id)
    {
        $product = $this->productService->getById($id);
        return response($product);
    }

    public function list()
    {
        $products =  $this->productService->list();
        return response($products);
    }

    public function update(UpdateProductRequest $request)
    {
        $product = $this->productData->fromRequest($request);
        $updatedProduct =  $this->productService->update($product);
        return response($updatedProduct);
    }

    public function delete(int $id)
    {
        $this->productService->delete($id);
        return response(['message' => 'produto excluido']);
    }
}
