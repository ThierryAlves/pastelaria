<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItensOrder extends Model
{
    use HasFactory;
//    use softDeletes;

    protected $table = 'itens_pedido';

    protected $fillable = ['pedido_id', 'produto_id'];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'produto_id');
    }
}
