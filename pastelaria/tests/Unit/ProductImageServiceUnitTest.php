<?php

namespace Tests\Unit;

use App\Http\Service\ProductImageService;
use App\Http\Service\ProductService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageServiceUnitTest extends TestCase
{

    public function test_store_product_image_success(): void
    {
        Storage::fake('produtos');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $productService = resolve(ProductImageService::class);
        $productService->storeProductImage($file);

        Storage::disk('produtos')->assertExists($file->getFilename() . ".{$file->extension()}");
    }


    public function test_update_product_image_success(): void
    {
        Storage::fake('produtos');

        $firstFile = UploadedFile::fake()->image('pastel.jpg');
        $newFile = UploadedFile::fake()->image('pastel_new.jpg');

        $firstFileName = $firstFile->getFilename() . ".{$firstFile->extension()}";
        $newFileName = $newFile->getFilename() . ".{$newFile->extension()}";

        $productService = resolve(ProductImageService::class);
        $productService->storeProductImage($firstFile);
        $productService->updateProductImage($newFile, $firstFileName);

        Storage::disk('produtos')->assertExists($newFileName);
        Storage::disk('produtos')->assertMissing($firstFileName);
    }


}
