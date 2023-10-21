<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProductData
{
    public readonly ?string $nome;
    public readonly ?float $preco;
    public readonly ?UploadedFile $foto_produto;
    public readonly ?int $id;

    public function fromRequest(Request $request) : self
    {
        $this->nome = $request->input('nome');
        $this->preco = $request->input('preco');
        $this->foto_produto = $request->file('foto_produto');
        $this->id = $request->route('id');
        return $this;
    }

    public function toArray() : array
    {
        $data = (array) $this;
        $data['foto_produto'] = $this->foto_produto->getFilename() . ".{$this->foto_produto->extension()}";
        return array_filter($data);
    }
}
