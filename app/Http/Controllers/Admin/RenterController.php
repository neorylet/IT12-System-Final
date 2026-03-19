<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renter;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class RenterController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $renters = Renter::query()
            ->when($q, function ($query) use ($q) {
                $query->where('renter_first_name', 'like', "%{$q}%")
                      ->orWhere('renter_last_name', 'like', "%{$q}%")
                      ->orWhere('renter_company_name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('contact_number', 'like', "%{$q}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.renters.index', compact('renters', 'q'));
    }

    public function create()
    {
        return view('admin.renters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'renter_first_name' => ['required', 'string', 'max:255'],
            'renter_last_name' => ['required', 'string', 'max:255'],
            'renter_company_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:renters,email'],
            'contract_start' => ['required', 'date'],
            'contract_end' => ['required', 'date', 'after_or_equal:contract_start'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $renter = Renter::create($validated);

        AuditLogService::log(
            'Create',
            'Renters',
            "Created renter '{$renter->renter_company_name}'.",
            $renter->renter_id,
            'RNT-' . $renter->renter_id,
            [
                'renter_id' => $renter->renter_id,
                'renter_first_name' => $renter->renter_first_name,
                'renter_last_name' => $renter->renter_last_name,
                'renter_company_name' => $renter->renter_company_name,
                'contact_person' => $renter->contact_person,
                'contact_number' => $renter->contact_number,
                'email' => $renter->email,
                'contract_start' => $renter->contract_start,
                'contract_end' => $renter->contract_end,
                'status' => $renter->status,
            ]
        );

        return redirect()->route('admin.renters.index')->with('success', 'Renter created successfully.');
    }

    public function show(Renter $renter)
    {
        return view('admin.renters.show', compact('renter'));
    }

    public function edit(Renter $renter)
    {
        return view('admin.renters.edit', compact('renter'));
    }

    public function update(Request $request, Renter $renter)
    {
        $validated = $request->validate([
            'renter_first_name' => ['required', 'string', 'max:255'],
            'renter_last_name' => ['required', 'string', 'max:255'],
            'renter_company_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:renters,email,' . $renter->renter_id . ',renter_id'],
            'contract_start' => ['required', 'date'],
            'contract_end' => ['required', 'date', 'after_or_equal:contract_start'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $before = [
            'renter_id' => $renter->renter_id,
            'renter_first_name' => $renter->renter_first_name,
            'renter_last_name' => $renter->renter_last_name,
            'renter_company_name' => $renter->renter_company_name,
            'contact_person' => $renter->contact_person,
            'contact_number' => $renter->contact_number,
            'email' => $renter->email,
            'contract_start' => $renter->contract_start,
            'contract_end' => $renter->contract_end,
            'status' => $renter->status,
        ];

        $renter->update($validated);

        $after = [
            'renter_id' => $renter->renter_id,
            'renter_first_name' => $renter->renter_first_name,
            'renter_last_name' => $renter->renter_last_name,
            'renter_company_name' => $renter->renter_company_name,
            'contact_person' => $renter->contact_person,
            'contact_number' => $renter->contact_number,
            'email' => $renter->email,
            'contract_start' => $renter->contract_start,
            'contract_end' => $renter->contract_end,
            'status' => $renter->status,
        ];

        AuditLogService::log(
            'Update',
            'Renters',
            "Updated renter '{$renter->renter_company_name}'.",
            $renter->renter_id,
            'RNT-' . $renter->renter_id,
            [
                'before' => $before,
                'after' => $after,
            ]
        );

        return redirect()->route('admin.renters.index')->with('success', 'Renter updated successfully.');
    }

    public function destroy(Renter $renter)
    {
        $details = [
            'renter_id' => $renter->renter_id,
            'renter_first_name' => $renter->renter_first_name,
            'renter_last_name' => $renter->renter_last_name,
            'renter_company_name' => $renter->renter_company_name,
            'contact_person' => $renter->contact_person,
            'contact_number' => $renter->contact_number,
            'email' => $renter->email,
            'contract_start' => $renter->contract_start,
            'contract_end' => $renter->contract_end,
            'status' => $renter->status,
        ];

        $renterName = $renter->renter_company_name;
        $renterId = $renter->renter_id;

        $renter->delete();

        AuditLogService::log(
            'Delete',
            'Renters',
            "Deleted renter '{$renterName}'.",
            $renterId,
            'RNT-' . $renterId,
            $details
        );

        return redirect()->route('admin.renters.index')->with('success', 'Renter deleted successfully.');
    }
}