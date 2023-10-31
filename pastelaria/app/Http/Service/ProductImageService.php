<?php

namespace App\Http\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    public function storeProductImage(UploadedFile $file) : void
    {
        $fileName = $file->getFilename() . ".{$file->extension()}";
        Storage::disk('produtos')->put(
            $fileName,
            $file->getContent()
        );
    }

    public function deleteProductImage($fileName) : void
    {
        Storage::disk('produtos')->delete($fileName);
    }

    public function updateProductImage(UploadedFile $file, string $oldFileName) : void
    {
        $this->storeProductImage($file);
        $this->deleteProductImage($oldFileName);
    }
}
