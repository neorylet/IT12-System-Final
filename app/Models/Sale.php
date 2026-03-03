<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'sale_id';

    const CREATED_AT = 'sale_date';
    const UPDATED_AT = null;

    protected $fillable = [
        'total_amount',
        'processed_by',
        'payment_method',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id', 'sale_id');
    }
}