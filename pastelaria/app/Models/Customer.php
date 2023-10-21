<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Costumer extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'clientes';

    protected $fillable = ['nome', 'endereco', 'complemento', 'bairro', 'cep', 'email', 'telefone', 'data_nascimento'];
}
