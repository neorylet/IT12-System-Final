<?php

namespace App\Http\Controllers\Staff\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Shelf;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use App\Models\ProductBatch;
use Carbon\Carbon;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $expiryStatus = trim((string) $request->get('expiry_status', ''));
        $expiryShelf = trim((string) $request->get('expiry_shelf', ''));

        $today = Carbon::today();

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
            ])
            ->latest('transaction_date')
            ->take(20)
            ->get();

        $allProducts = collect();
        foreach (($shelves ?? []) as $sh) {
            $allProducts = $allProducts->merge($sh->products ?? collect());
        }

        $totalProducts = $allProducts->count();
        $totalQty = $allProducts->sum(fn($p) => $p->inventory?->quantity_on_hand ?? 0);

        $lowStockCount = $allProducts->filter(function ($p) {
            $onHand = $p->inventory?->quantity_on_hand ?? 0;
            $reorder = $p->inventory?->reorder_level ?? 0;
            return $reorder > 0 && $onHand <= $reorder;
        })->count();

        $pendingRequests = InventoryTransaction::where('status', 'Pending')->count();

        $expiryBatches = ProductBatch::with(['product.shelf', 'product.renter'])
            ->where('quantity_remaining', '>', 0)
            ->when($expiryShelf, function ($query) use ($expiryShelf) {
                $query->whereHas('product', function ($q) use ($expiryShelf) {
                    $q->where('shelf_id', $expiryShelf);
                });
            })
            ->orderBy('expiration_date')
            ->get()
            ->map(function ($batch) use ($today) {
                $expiryDate = $batch->expiration_date
                    ? Carbon::parse($batch->expiration_date)->startOfDay()
                    : null;

                $daysLeft = $expiryDate
                    ? $today->diffInDays($expiryDate, false)
                    : null;

                if (!$expiryDate) {
                    $computedExpiryStatus = 'No Expiry';
                } elseif ($daysLeft < 0) {
                    $computedExpiryStatus = 'Expired';
                } elseif ($daysLeft === 0) {
                    $computedExpiryStatus = 'Expires Today';
                } elseif ($daysLeft <= 7) {
                    $computedExpiryStatus = 'Expiring Soon';
                } else {
                    $computedExpiryStatus = 'Fresh';
                }

                return [
                    'batch_id'            => $batch->batch_id,
                    'product_name'        => $batch->product->product_name ?? 'Unknown Product',
                    'category'            => $batch->product->category ?? '—',
                    'shelf_id'            => $batch->product->shelf_id ?? null,
                    'shelf_number'        => $batch->product->shelf->shelf_number ?? '—',
                    'renter_name'         => $batch->product->renter->renter_company_name ?? '—',
                    'lot_number'          => $batch->lot_number ?? '—',
                    'expiration_date'     => $batch->expiration_date,
                    'quantity_remaining'  => (int) $batch->quantity_remaining,
                    'days_left'           => $daysLeft,
                    'expiry_status'       => $computedExpiryStatus,
                ];
            })
            ->when($expiryStatus, function ($collection) use ($expiryStatus) {
                return $collection->where('expiry_status', $expiryStatus)->values();
            })
            ->values();

        $expiringSoon = $expiryBatches->where('expiry_status', 'Expiring Soon')->count()
            + $expiryBatches->where('expiry_status', 'Expires Today')->count();

        $expiryShelves = Shelf::orderBy('shelf_number')->get(['shelf_id', 'shelf_number']);

        return view('staff.inventory.index', compact(
            'shelves',
            'transactions',
            'q',
            'totalProducts',
            'totalQty',
            'lowStockCount',
            'pendingRequests',
            'expiryBatches',
            'expiringSoon',
            'expiryStatus',
            'expiryShelf',
            'expiryShelves'
        ));
    }
}