@extends('layouts.app_a')
@section('title', 'Transaction Receipt')

@section('content')
<div class="header-section" style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap;">
    <div>
        <h1>Transaction Receipt</h1>
        <p>Detailed view of the selected inventory transaction.</p>
    </div>

    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('admin.inventory.index') }}" class="btn-outline">Back to Inventory</a>
        <button type="button" class="btn-action-chip" onclick="window.print()">Print Receipt</button>
    </div>
</div>

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Transaction Details</div>

    <div style="padding:16px;">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:14px;">
            <div class="stat-card">
                <div class="stat-label">Reference No.</div>
                <div class="stat-value" style="font-size:20px;">{{ $transaction->reference_no ?? '—' }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Transaction Type</div>
                <div class="stat-value" style="font-size:20px;">{{ $transaction->transaction_type ?? '—' }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Transaction Date</div>
                <div class="stat-value" style="font-size:20px;">
                    {{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d h:i A') : '—' }}
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Status</div>
                <div class="stat-value" style="font-size:20px;">{{ $transaction->status ?? 'Approved' }}</div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:14px; margin-top:14px;">
            <div class="stat-card">
                <div class="stat-label">Shelf</div>
                <div class="stat-value" style="font-size:20px;">{{ $transaction->shelf?->shelf_number ?? '—' }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Renter</div>
                <div class="stat-value" style="font-size:20px;">{{ $transaction->renter?->renter_company_name ?? '—' }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Actioned By</div>
                <div class="stat-value" style="font-size:20px;">{{ $transaction->actionedBy?->name ?? '—' }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Remarks</div>
                <div class="stat-value" style="font-size:18px;">{{ $transaction->remarks ?: '—' }}</div>
            </div>
        </div>
    </div>
</div>

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Items Included</div>

    <div class="activity-table-scrollable" style="padding:0;">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Lot Number</th>
                    <th>MFG Date</th>
                    <th>EXP Date</th>
                    <th style="text-align:right;">Quantity</th>
                    <th style="text-align:right;">Unit Cost</th>
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp

                @forelse($transaction->items as $item)
                    @php
                        $productName = $item->batch?->product?->product_name
                            ?? $item->product?->product_name
                            ?? 'Unknown Product';

                        $lotNumber = $item->batch?->lot_number
                            ?? $item->lot_number
                            ?? '—';

                        $mfgDate = $item->batch?->manufacturing_date
                            ?? $item->manufacturing_date;

                        $expDate = $item->batch?->expiration_date
                            ?? $item->expiration_date;

                        $qty = (int) ($item->quantity ?? 0);
                        $unitCost = is_null($item->unit_cost) ? null : (float) $item->unit_cost;
                        $amount = is_null($unitCost) ? null : $qty * $unitCost;

                        if (!is_null($amount)) {
                            $grandTotal += $amount;
                        }
                    @endphp

                    <tr>
                        <td>{{ $productName }}</td>
                        <td>{{ $lotNumber }}</td>
                        <td>{{ $mfgDate ? \Carbon\Carbon::parse($mfgDate)->format('Y-m-d') : '—' }}</td>
                        <td>{{ $expDate ? \Carbon\Carbon::parse($expDate)->format('Y-m-d') : '—' }}</td>
                        <td style="text-align:right;">{{ $qty }}</td>
                        <td style="text-align:right;">
                            {{ is_null($unitCost) ? '—' : '₱' . number_format($unitCost, 2) }}
                        </td>
                        <td style="text-align:right;">
                            {{ is_null($amount) ? '—' : '₱' . number_format($amount, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No items found for this transaction.</td>
                    </tr>
                @endforelse
            </tbody>

            @if($transaction->items->count() > 0)
            <tfoot>
                <tr>
                    <th colspan="6" style="text-align:right;">Grand Total</th>
                    <th style="text-align:right;">₱{{ number_format($grandTotal, 2) }}</th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection