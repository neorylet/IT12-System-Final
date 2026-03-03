<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenterPayout extends Model
{
    protected $table = 'renter_payouts';
    protected $primaryKey = 'payout_id';

    public $timestamps = false;

    protected $fillable = [
        'renter_id',
        'week_start',
        'week_end',
        'total_sales',
        'commission_rate',
        'commission_amount',
        'net_amount',
        'payout_date',
        'status',
        'processed_by',
    ];

    public function renter()
    {
        return $this->belongsTo(Renter::class, 'renter_id', 'renter_id');
    }
}