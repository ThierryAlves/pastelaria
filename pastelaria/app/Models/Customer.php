<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'clientes';

    protected $fillable = ['nome', 'endereco', 'complemento', 'bairro', 'cep', 'email', 'telefone', 'data_nascimento'];

    protected function dataNascimento(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
            get: fn (string $value) => DateTime::createFromFormat('Y-m-d', $value)->format('d/m/Y'),
        );
    }
}
