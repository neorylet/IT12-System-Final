<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shelf;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $products = Product::with(['shelf', 'renter', 'inventory'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('product_name', 'like', "%{$q}%")
                       ->orWhere('category', 'like', "%{$q}%");
                });
            })
            ->orderBy('product_name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'q'));
    }

    public function create()
    {
        $shelves = Shelf::with('renter')
            ->orderBy('shelf_number')
            ->get();

        return view('admin.products.create', compact('shelves'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:500'],
            'category'     => ['required', 'string', 'max:120'],
            'price'        => ['required', 'numeric', 'min:0'],
            'shelf_id'     => ['required', 'exists:shelves,shelf_id'],
        ]);

        $shelf = Shelf::with('renter')
            ->where('shelf_id', $validated['shelf_id'])
            ->firstOrFail();

        // ✅ Business rule: shelf must be assigned to a renter
        if (!$shelf->renter_id) {
            return back()
                ->withErrors(['shelf_id' => 'This shelf has no assigned renter. Assign a renter first.'])
                ->withInput();
        }

        Product::create([
            'product_name' => $validated['product_name'],
            'description'  => $validated['description'] ?? null,
            'category'     => $validated['category'],
            'price'        => $validated['price'],

            'shelf_id'     => $shelf->shelf_id,
            'renter_id'    => $shelf->renter_id,

            // ✅ Admin auto-approves
            'status'       => 'Approved',
            'created_by'   => auth()->id(),
            'approved_by'  => auth()->id(),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created and auto-approved.');
    }

    public function edit(Product $product)
    {
        $product->load(['shelf', 'renter', 'inventory']);

        $shelves = Shelf::with('renter')
            ->orderBy('shelf_number')
            ->get();

        return view('admin.products.edit', compact('product', 'shelves'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:500'],
            'category'     => ['required', 'string', 'max:120'],
            'price'        => ['required', 'numeric', 'min:0'],
            'shelf_id'     => ['required', 'exists:shelves,shelf_id'],
        ]);

        $shelf = Shelf::with('renter')
            ->where('shelf_id', $validated['shelf_id'])
            ->firstOrFail();

        if (!$shelf->renter_id) {
            return back()
                ->withErrors(['shelf_id' => 'This shelf has no assigned renter. Assign a renter first.'])
                ->withInput();
        }

        $product->update([
            'product_name' => $validated['product_name'],
            'description'  => $validated['description'] ?? null,
            'category'     => $validated['category'],
            'price'        => $validated['price'],

            'shelf_id'     => $shelf->shelf_id,
            'renter_id'    => $shelf->renter_id,

            // ✅ keep approved always
            'status'       => 'Approved',
            'approved_by'  => auth()->id(),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        // ✅ safer: don’t delete if there’s stock history/batches
        if ($product->batches()->exists()) {
            return back()->withErrors([
                'delete' => 'Cannot delete: product already has batches/stock history. (Set it inactive / archived later instead.)'
            ]);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }
}