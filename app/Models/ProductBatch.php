<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBatch extends Model
{
    protected $table = 'product_batch';
    protected $primaryKey = 'batch_id';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'lot_number',
        'manufacturing_date',
        'expiration_date',
        'quantity_received',
        'quantity_remaining',
        'date_received',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function transactionItems()
    {
        return $this->hasMany(InventoryTransactionItem::class, 'batch_id', 'batch_id');
    }

    public function expirationAlerts()
    {
        return $this->hasMany(ExpirationAlert::class, 'batch_id', 'batch_id');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'batch_id', 'batch_id');
    }
}