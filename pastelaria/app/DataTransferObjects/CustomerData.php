<?php

namespace App\DataTransferObjects;

class CustomerData
{
    public $nome;
    public $endereco;
    public $complemento;
    public $bairro;
    public $cep;
    public $email;
    public $telefone;
    public $data_nascimento;

    public function __construct(
        ?string $nome,
        ?string $endereco,
        ?string $complemento,
        ?string $bairro,
        ?string $cep,
        ?string $email,
        ?string $telefone,
        ?string $data_nascimento
    )
    {
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cep = $cep;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->data_nascimento = \DateTime::createFromFormat('d/m/Y',$data_nascimento)->format('Y-m-d');
    }

    public function toArray() : array
    {
        return (array) $this;
    }
}
