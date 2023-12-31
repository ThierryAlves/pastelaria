<?php

namespace App\Http\Service;

use App\Models\Product;
use Illuminate\Pagination\Paginator;

class ProductService
{
    private Product $productModel;
    private ProductImageService $productImageService;

    public function __construct(Product $product, ProductImageService $productImageService)
    {
        $this->productModel = $product;
        $this->productImageService = $productImageService;
    }

    public function add(array $productData) : Product
    {
        $productImage = $productData['foto_produto'];
        $fileName = $productImage->getFilename() . '.' . $productImage->extension();
        $productData['foto_produto'] = $fileName;
        $productCreated = $this->productModel->create($productData);

        $this->productImageService->storeProductImage($productImage);

        return $productCreated;
    }

    public function list() : Paginator
    {
        return $this->productModel->simplePaginate(15);
    }

    public function update(Product $product, array $changedData) : Product
    {
        $fileName = $product->getRawOriginal('foto_produto');

        if (isset($changedData['foto_produto'])) {
            $oldFileName = $product->getRawOriginal('foto_produto');
            $this->productImageService->updateProductImage($changedData['foto_produto'], $oldFileName);
            $fileName = $changedData['foto_produto']->getFilename() . '.' . $changedData['foto_produto']->extension();
        }

        $newProductData = array_merge($product->attributesToArray(), $changedData);
        $newProductData['foto_produto'] = $fileName;

        $product->update($newProductData);

        return $product;
    }

    public function delete(Product $product) : void
    {
        $product->delete();
    }
}
