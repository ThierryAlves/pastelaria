<?php

namespace App\Http\Service;

use App\DataTransferObjects\productData;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    private $productModel;
    private $productImageService;

    public function __construct(Product $product, ProductImageService $productImageService)
    {
        $this->productModel = $product;
        $this->productImageService = $productImageService;
    }

    public function add(ProductData $productData) : Product
    {
        $productCreated = $this->productModel->create(
            $productData->toArray()
        );

        $this->productImageService->storeProductImage($productData->foto_produto);

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

    public function update(ProductData $product) : Product
    {
        $productFound = $this->getById($product->id);

        if ($product->foto_produto) {
            $oldFileName = $productFound->getRawOriginal('foto_produto');
            $this->productImageService->updateProductImage($product->foto_produto, $oldFileName);
        }

        $productFound->update($product->toArray());

        return $productFound;
    }

    public function delete(int $id) : void
    {
        $product = $this->getById($id);
        $product->delete();
    }
}
