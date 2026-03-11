<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransactionItem extends Model
{
    protected $table = 'inventory_transaction_items';
    protected $primaryKey = 'transaction_item_id';

    public $timestamps = false;

protected $fillable = [
    'transaction_id',
    'product_id',
    'batch_id',
    'lot_number',
    'manufacturing_date',
    'expiration_date',
    'quantity',
    'unit_cost',
];

    public function transaction()
    {
        return $this->belongsTo(InventoryTransaction::class, 'transaction_id', 'transaction_id');
    }

    public function batch()
    {
        return $this->belongsTo(ProductBatch::class, 'batch_id', 'batch_id');
    }
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id', 'product_id');
}
}