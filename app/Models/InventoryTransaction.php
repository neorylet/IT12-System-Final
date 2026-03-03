<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // ✅ add this

class InventoryTransaction extends Model
{
    protected $table = 'inventory_transaction';
    protected $primaryKey = 'transaction_id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'transaction_type',
        'renter_id',
        'shelf_id',
        'transaction_date',
        'reference_no',
        'remarks',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    public function renter()
    {
        return $this->belongsTo(Renter::class, 'renter_id', 'renter_id');
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class, 'shelf_id', 'shelf_id');
    }

    public function items()
    {
        return $this->hasMany(InventoryTransactionItem::class, 'transaction_id', 'transaction_id');
    }

    // ✅ NEW: who performed the action (created_by)
    public function actionedBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}