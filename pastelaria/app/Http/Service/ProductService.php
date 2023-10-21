<?php

namespace App\Http\Service;

use App\Models\Product;
class ProductService
{
    private $productModel;
    private $productImageService;

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

    public function getById(int $id) : Product
    {
        return $this->productModel->findOrFail($id);
    }

    public function list()
    {
        return $this->productModel->simplePaginate(15);
    }

    public function update(Product $product, array $changedData) : Product
    {

        if ($changedData['foto_produto']) {
            $oldFileName = $product->getRawOriginal('foto_produto');
            $this->productImageService->updateProductImage($changedData['foto_produto'], $oldFileName);
            $changedData['foto_produto'] = $changedData['foto_produto']->getFilename() . '.' . $changedData['foto_produto']->extension();
        }

        $newProductData = array_merge($product->toArray(), $changedData);
        $product->update($newProductData);

        return $product;
    }

    public function delete(Product $product) : void
    {
        $product->delete();
    }
}
