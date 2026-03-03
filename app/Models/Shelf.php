<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    protected $primaryKey = 'shelf_id';

    public $timestamps = false; // your dictionary didn't include created_at/updated_at for shelves

    protected $fillable = [
        'shelf_number',
        'renter_id',
        'monthly_rent',
        'start_date',
        'end_date',
        'shelf_status',
    ];

    public function renter()
    {
        return $this->belongsTo(Renter::class, 'renter_id', 'renter_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'shelf_id', 'shelf_id');
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'shelf_id', 'shelf_id');
    }

    public function rentalPayments()
    {
        return $this->hasMany(RentalPayment::class, 'shelf_id', 'shelf_id');
    }
}