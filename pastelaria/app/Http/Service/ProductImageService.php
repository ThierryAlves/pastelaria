<?php

namespace App\Http\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    public function storeProductImage(UploadedFile $file) : void
    {
        $file->storeAs(
            'produtos',
            $file->getFilename() . ".{$file->extension()}"
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
