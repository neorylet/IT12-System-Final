<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPayment extends Model
{
    protected $table = 'rental_payments';
    protected $primaryKey = 'payment_id';

    public $timestamps = false;

    protected $fillable = [
        'renter_id',
        'shelf_id',
        'amount_paid',
        'payment_method',
        'payment_date',
        'reference_no',
        'status',
    ];

    public function renter()
    {
        return $this->belongsTo(Renter::class, 'renter_id', 'renter_id');
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class, 'shelf_id', 'shelf_id');
    }
}