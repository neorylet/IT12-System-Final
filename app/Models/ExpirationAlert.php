<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpirationAlert extends Model
{
    protected $table = 'expiration_alerts';
    protected $primaryKey = 'exp_alert_id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'batch_id',
        'expiration_date',
        'days_before_alert',
        'alert_status',
    ];

    public function batch()
    {
        return $this->belongsTo(ProductBatch::class, 'batch_id', 'batch_id');
    }
}