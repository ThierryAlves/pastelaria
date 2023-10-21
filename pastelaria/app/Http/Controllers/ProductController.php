<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Service\ProductService;
use App\Models\Product;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(CreateProductRequest $request)
    {
        $createdProduct = $this->productService->add($request->validated());
        return response($createdProduct);
    }

    public function get(Product $product)
    {
        return response($product);
    }

    public function list()
    {
        $products =  $this->productService->list();
        return response($products);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $updatedProduct =  $this->productService->update($product, $request->validated());
        return response($updatedProduct);
    }

    public function delete(Product $product)
    {
        $this->productService->delete($product);
        return response(['message' => 'produto excluido']);
    }
}
