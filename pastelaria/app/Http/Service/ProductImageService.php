<?php

namespace App\Http\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    public function storeProductImage(UploadedFile $file)
    {
        $file->storeAs(
            'produtos',
            $file->getFilename() . ".{$file->extension()}"
        );
    }

    public function deleteProductImage($fileName)
    {
        Storage::disk('produtos')->delete($fileName);
    }

    public function updateProductImage(UploadedFile $file, string $oldFileName)
    {
        $this->storeProductImage($file);
        $this->deleteProductImage($oldFileName);
    }

    public function getFileName()
    {


        return $filename;
    }
}
