<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renter;
use App\Models\Shelf;
use App\Services\AuditLogService;
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

        $before = [
            'shelf_id' => $shelf->shelf_id,
            'shelf_number' => $shelf->shelf_number,
            'renter_id' => $shelf->renter_id,
            'renter_name' => optional($shelf->renter)->renter_company_name,
            'shelf_status' => $shelf->shelf_status,
            'start_date' => $shelf->start_date,
            'end_date' => $shelf->end_date,
        ];

        $shelf->update([
            'renter_id' => $renter->renter_id,
            'shelf_status' => 'Occupied',
            'start_date' => $renter->contract_start,
            'end_date' => $renter->contract_end,
        ]);

        $after = [
            'shelf_id' => $shelf->shelf_id,
            'shelf_number' => $shelf->shelf_number,
            'renter_id' => $renter->renter_id,
            'renter_name' => $renter->renter_company_name,
            'shelf_status' => 'Occupied',
            'start_date' => $renter->contract_start,
            'end_date' => $renter->contract_end,
        ];

        AuditLogService::log(
            'Assign',
            'Shelves',
            "Assigned Shelf {$shelf->shelf_number} to '{$renter->renter_company_name}'.",
            $shelf->shelf_id,
            'SHF-' . $shelf->shelf_id,
            [
                'action_type' => 'assignment',
                'before' => $before,
                'after' => $after,
            ]
        );

        return redirect()->route('admin.shelves.index')->with('success', 'Renter assigned successfully.');
    }

    public function unassign(Shelf $shelf)
    {
        $shelf->load('renter');

        $before = [
            'shelf_id' => $shelf->shelf_id,
            'shelf_number' => $shelf->shelf_number,
            'renter_id' => $shelf->renter_id,
            'renter_name' => optional($shelf->renter)->renter_company_name,
            'shelf_status' => $shelf->shelf_status,
            'start_date' => $shelf->start_date,
            'end_date' => $shelf->end_date,
        ];

        $oldRenterName = optional($shelf->renter)->renter_company_name ?? 'Unknown Renter';
        $shelfNumber = $shelf->shelf_number;
        $shelfId = $shelf->shelf_id;

        $shelf->update([
            'renter_id' => null,
            'shelf_status' => 'Available',
            'start_date' => null,
            'end_date' => null,
        ]);

        $after = [
            'shelf_id' => $shelfId,
            'shelf_number' => $shelfNumber,
            'renter_id' => null,
            'renter_name' => null,
            'shelf_status' => 'Available',
            'start_date' => null,
            'end_date' => null,
        ];

        AuditLogService::log(
            'Unassign',
            'Shelves',
            "Unassigned Shelf {$shelfNumber} from '{$oldRenterName}'.",
            $shelfId,
            'SHF-' . $shelfId,
            [
                'action_type' => 'unassignment',
                'before' => $before,
                'after' => $after,
            ]
        );

        return redirect()->route('admin.shelves.index')->with('success', 'Shelf unassigned successfully.');
    }
}