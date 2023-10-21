<?php

namespace App\DataTransferObjects;
use Illuminate\Http\Request;

class CustomerData
{
    public readonly ?string $nome;
    public readonly ?string $endereco;
    public readonly ?string $complemento;
    public readonly ?string $bairro;
    public readonly ?string $cep;
    public readonly ?string $email;
    public readonly ?string $telefone;
    public readonly ?string $data_nascimento;
    public readonly ?int $id;

    public function fromRequest(Request $request) : Customerdata
    {
        $this->nome = $request->input('nome');
        $this->endereco = $request->input('endereco');
        $this->complemento = $request->input('complemento');
        $this->bairro = $request->input('bairro');
        $this->cep = $request->input('cep');
        $this->email = $request->input('email');
        $this->telefone = $request->input('telefone');
        if ($request->input('data_nascimento')) {
            $this->data_nascimento = \DateTime::createFromFormat('d/m/Y',$request->input('data_nascimento'))->format('Y-m-d');
        }
        $this->id = $request->route('id');

        return $this;
    }

    public function toArray() : array
    {
        $data = (array) $this;
        return array_filter($data);
    }
}
