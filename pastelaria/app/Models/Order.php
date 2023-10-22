<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'pedidos';

    protected $fillable = ['cliente_id'];

    protected $appends = ['total_cost'];

    public function totalCost(): Attribute
    {
        return new Attribute(
            get: fn () => number_format($this->items->sum('product.preco'), 2)
        );
    }

    public function items() : HasMany
    {
        return $this->hasMany(ItensOrder::class, 'pedido_id');
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class, 'cliente_id');
    }
}
