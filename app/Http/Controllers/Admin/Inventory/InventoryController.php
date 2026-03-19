<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Shelf;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $shelves = Shelf::with(['renter', 'products.inventory'])
            ->when($q, function ($query) use ($q) {
                $query->where('shelf_number', 'like', "%{$q}%")
                    ->orWhereHas('renter', fn($r) => $r->where('renter_company_name', 'like', "%{$q}%"))
                    ->orWhereHas('products', fn($p) => $p->where('product_name', 'like', "%{$q}%"));
            })
            ->orderBy('shelf_number')
            ->get();

        $transactions = InventoryTransaction::with([
                'shelf',
                'renter',
                'actionedBy',
                'items.batch.product',
                'items.product',
            ])
            ->latest('transaction_date')
            ->take(20)
            ->get();

        $pendingCount = InventoryTransaction::where('status', 'pending')->count();

        return view('admin.inventory.index', compact(
            'shelves',
            'transactions',
            'q',
            'pendingCount'
        ));
    }
}