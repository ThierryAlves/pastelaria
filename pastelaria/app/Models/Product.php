<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'produtos';

    protected $fillable = ['nome', 'preco', 'foto_produto'];

    protected function fotoProduto(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset("produtos/$value")
        );
    }

    protected function preco(): Attribute
    {
        return Attribute::make(
            get: fn (float $value) => number_format($value, 2)
        );
    }
}
