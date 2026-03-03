<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renter;
use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfAssignmentController extends Controller
{
    public function create(Shelf $shelf)
    {
        abort_if($shelf->shelf_status !== 'Available', 403, 'Shelf is not available.');

        $renters = Renter::where('status', 'active')
            ->orderBy('renter_company_name')
            ->get(['renter_id', 'renter_company_name', 'contract_start', 'contract_end']);

        return view('admin.shelves.assign', compact('shelf', 'renters'));
    }

    public function store(Request $request, Shelf $shelf)
    {
        abort_if($shelf->shelf_status !== 'Available', 403, 'Shelf is not available.');

        $validated = $request->validate([
            'renter_id' => ['required', 'exists:renters,renter_id'],
        ]);

        $renter = Renter::findOrFail($validated['renter_id']);

        // override shelf dates using renter contract dates
        $shelf->update([
            'renter_id' => $renter->renter_id,
            'shelf_status' => 'Occupied',
            'start_date' => $renter->contract_start,
            'end_date' => $renter->contract_end,
        ]);

        return redirect()->route('admin.shelves.index')->with('success', 'Renter assigned successfully.');
    }
}