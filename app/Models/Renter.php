<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    protected $primaryKey = 'renter_id';

    protected $fillable = [
        'renter_first_name',
        'renter_last_name',
        'renter_company_name',
        'contact_person',
        'contact_number',
        'email',
        'contract_start',
        'contract_end',
        'status',
    ];

    public function shelves()
    {
        return $this->hasMany(Shelf::class, 'renter_id', 'renter_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'renter_id', 'renter_id');
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'renter_id', 'renter_id');
    }

    public function rentalPayments()
    {
        return $this->hasMany(RentalPayment::class, 'renter_id', 'renter_id');
    }

    public function payouts()
    {
        return $this->hasMany(RenterPayout::class, 'renter_id', 'renter_id');
    }
}