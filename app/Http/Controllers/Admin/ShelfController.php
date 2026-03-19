<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renter;
use App\Models\Shelf;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $shelves = Shelf::query()
            ->with('renter:renter_id,renter_company_name')
            ->when($q, function ($query) use ($q) {
                $query->where('shelf_number', 'like', "%{$q}%")
                      ->orWhere('shelf_status', 'like', "%{$q}%")
                      ->orWhereHas('renter', function ($renterQ) use ($q) {
                          $renterQ->where('renter_company_name', 'like', "%{$q}%");
                      });
            })
            ->orderBy('shelf_number')
            ->paginate(10)
            ->withQueryString();

        return view('admin.shelves.index', compact('shelves', 'q'));
    }

    public function create()
    {
        $renters = Renter::query()
            ->where('status', 'active')
            ->orderBy('renter_company_name')
            ->get(['renter_id', 'renter_company_name']);

        return view('admin.shelves.create', compact('renters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shelf_number' => ['required', 'string', 'max:20', 'unique:shelves,shelf_number'],
            'monthly_rent' => ['required', 'numeric', 'min:0'],
        ]);

        $shelf = Shelf::create([
            'shelf_number' => $validated['shelf_number'],
            'monthly_rent' => $validated['monthly_rent'],
            'renter_id' => null,
            'start_date' => null,
            'end_date' => null,
            'shelf_status' => 'Available',
        ]);

        AuditLogService::log(
            'Create',
            'Shelves',
            "Created Shelf {$shelf->shelf_number}.",
            $shelf->shelf_id,
            'SHF-' . $shelf->shelf_id,
            [
                'shelf_id' => $shelf->shelf_id,
                'shelf_number' => $shelf->shelf_number,
                'monthly_rent' => $shelf->monthly_rent,
                'renter_id' => $shelf->renter_id,
                'renter_name' => null,
                'start_date' => $shelf->start_date,
                'end_date' => $shelf->end_date,
                'shelf_status' => $shelf->shelf_status,
            ]
        );

        return redirect()->route('admin.shelves.index')->with('success', 'Shelf created successfully.');
    }

    public function show(Shelf $shelf)
    {
        $shelf->load('renter:renter_id,renter_company_name,email,contact_number');
        return view('admin.shelves.show', compact('shelf'));
    }

    public function edit(Shelf $shelf)
    {
        $renters = Renter::query()
            ->where('status', 'active')
            ->orderBy('renter_company_name')
            ->get(['renter_id', 'renter_company_name']);

        return view('admin.shelves.edit', compact('shelf', 'renters'));
    }

    public function update(Request $request, Shelf $shelf)
    {
        $validated = $request->validate([
            'shelf_number' => [
                'required', 'string', 'max:20',
                'unique:shelves,shelf_number,' . $shelf->shelf_id . ',shelf_id'
            ],
            'renter_id' => ['nullable', 'exists:renters,renter_id'],
            'monthly_rent' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'shelf_status' => ['required', 'in:Available,Occupied'],
        ]);

        $shelf->load('renter');

        $before = [
            'shelf_id' => $shelf->shelf_id,
            'shelf_number' => $shelf->shelf_number,
            'monthly_rent' => $shelf->monthly_rent,
            'renter_id' => $shelf->renter_id,
            'renter_name' => optional($shelf->renter)->renter_company_name,
            'start_date' => $shelf->start_date,
            'end_date' => $shelf->end_date,
            'shelf_status' => $shelf->shelf_status,
        ];

        if (!empty($validated['renter_id'])) {
            $validated['shelf_status'] = 'Occupied';
        } else {
            $validated['shelf_status'] = 'Available';
        }

        $shelf->update($validated);
        $shelf->load('renter');

        $after = [
            'shelf_id' => $shelf->shelf_id,
            'shelf_number' => $shelf->shelf_number,
            'monthly_rent' => $shelf->monthly_rent,
            'renter_id' => $shelf->renter_id,
            'renter_name' => optional($shelf->renter)->renter_company_name,
            'start_date' => $shelf->start_date,
            'end_date' => $shelf->end_date,
            'shelf_status' => $shelf->shelf_status,
        ];

        AuditLogService::log(
            'Update',
            'Shelves',
            "Updated Shelf {$shelf->shelf_number}.",
            $shelf->shelf_id,
            'SHF-' . $shelf->shelf_id,
            [
                'before' => $before,
                'after' => $after,
            ]
        );

        return redirect()->route('admin.shelves.index')->with('success', 'Shelf updated successfully.');
    }

    public function destroy(Shelf $shelf)
    {
        $shelf->load('renter');

        $details = [
            'shelf_id' => $shelf->shelf_id,
            'shelf_number' => $shelf->shelf_number,
            'monthly_rent' => $shelf->monthly_rent,
            'renter_id' => $shelf->renter_id,
            'renter_name' => optional($shelf->renter)->renter_company_name,
            'start_date' => $shelf->start_date,
            'end_date' => $shelf->end_date,
            'shelf_status' => $shelf->shelf_status,
        ];

        $shelfNumber = $shelf->shelf_number;
        $shelfId = $shelf->shelf_id;

        $shelf->delete();

        AuditLogService::log(
            'Delete',
            'Shelves',
            "Deleted Shelf {$shelfNumber}.",
            $shelfId,
            'SHF-' . $shelfId,
            $details
        );

        return redirect()->route('admin.shelves.index')->with('success', 'Shelf deleted successfully.');
    }
}