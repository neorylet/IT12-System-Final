<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; // dictionary only shows created_at for products

    protected $fillable = [
        'product_name',
        'description',
        'category',
        'price',
        'shelf_id',
        'renter_id',
        'status',
        'created_by',
        'approved_by',
    ];

    public function shelf()
    {
        return $this->belongsTo(Shelf::class, 'shelf_id', 'shelf_id');
    }

    public function renter()
    {
        return $this->belongsTo(Renter::class, 'renter_id', 'renter_id');
    }

    public function batches()
    {
        return $this->hasMany(ProductBatch::class, 'product_id', 'product_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id', 'product_id');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'product_id', 'product_id');
    }

    public function stockAlerts()
    {
        return $this->hasMany(StockAlert::class, 'product_id', 'product_id');
    }
}