<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renter;
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

        Renter::create($validated);

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

        $renter->update($validated);

        return redirect()->route('admin.renters.index')->with('success', 'Renter updated successfully.');
    }

    public function destroy(Renter $renter)
    {
        $renter->delete();

        return redirect()->route('admin.renters.index')->with('success', 'Renter deleted successfully.');
    }
}