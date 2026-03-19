<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shelf;
use App\Services\AuditLogService;
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

        if (!$shelf->renter_id) {
            return back()
                ->withErrors(['shelf_id' => 'This shelf has no assigned renter. Assign a renter first.'])
                ->withInput();
        }

        $product = Product::create([
            'product_name' => $validated['product_name'],
            'description'  => $validated['description'] ?? null,
            'category'     => $validated['category'],
            'price'        => $validated['price'],
            'shelf_id'     => $shelf->shelf_id,
            'renter_id'    => $shelf->renter_id,
            'status'       => 'Approved',
            'created_by'   => auth()->id(),
            'approved_by'  => auth()->id(),
        ]);

        AuditLogService::log(
            'Create',
            'Products',
            "Created product '{$product->product_name}' on Shelf {$shelf->shelf_number}" .
            ($shelf->renter?->renter_company_name ? " ({$shelf->renter->renter_company_name})" : '') . ".",
            $product->product_id,
            'PRD-' . $product->product_id,
            [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'category' => $product->category,
                'price' => $product->price,
                'status' => $product->status,
                'shelf_id' => $shelf->shelf_id,
                'shelf_number' => $shelf->shelf_number,
                'renter_id' => $shelf->renter_id,
                'renter_name' => $shelf->renter->renter_company_name ?? null,
            ]
        );

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

        $before = [
            'product_name' => $product->product_name,
            'description' => $product->description,
            'category' => $product->category,
            'price' => $product->price,
            'shelf_id' => $product->shelf_id,
            'renter_id' => $product->renter_id,
            'status' => $product->status,
        ];

        $oldShelf = $product->shelf()->with('renter')->first();

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
            'status'       => 'Approved',
            'approved_by'  => auth()->id(),
        ]);

        $after = [
            'product_name' => $product->product_name,
            'description' => $product->description,
            'category' => $product->category,
            'price' => $product->price,
            'shelf_id' => $product->shelf_id,
            'shelf_number' => $shelf->shelf_number,
            'renter_id' => $product->renter_id,
            'renter_name' => $shelf->renter->renter_company_name ?? null,
            'status' => $product->status,
        ];

        AuditLogService::log(
            'Update',
            'Products',
            "Updated product '{$product->product_name}'" .
            ($shelf->shelf_number ? " on Shelf {$shelf->shelf_number}" : '') . ".",
            $product->product_id,
            'PRD-' . $product->product_id,
            [
                'product_id' => $product->product_id,
                'before' => [
                    'product_name' => $before['product_name'],
                    'description' => $before['description'],
                    'category' => $before['category'],
                    'price' => $before['price'],
                    'shelf_id' => $before['shelf_id'],
                    'shelf_number' => $oldShelf->shelf_number ?? null,
                    'renter_id' => $before['renter_id'],
                    'renter_name' => $oldShelf->renter->renter_company_name ?? null,
                    'status' => $before['status'],
                ],
                'after' => $after,
            ]
        );

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->batches()->exists()) {
            return back()->withErrors([
                'delete' => 'Cannot delete: product already has batches/stock history. (Set it inactive / archived later instead.)'
            ]);
        }

        $product->load(['shelf.renter']);

        $details = [
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'description' => $product->description,
            'category' => $product->category,
            'price' => $product->price,
            'status' => $product->status,
            'shelf_id' => $product->shelf_id,
            'shelf_number' => $product->shelf->shelf_number ?? null,
            'renter_id' => $product->renter_id,
            'renter_name' => $product->shelf->renter->renter_company_name ?? null,
        ];

        $productName = $product->product_name;
        $productId = $product->product_id;

        $product->delete();

        AuditLogService::log(
            'Delete',
            'Products',
            "Deleted product '{$productName}'.",
            $productId,
            'PRD-' . $productId,
            $details
        );

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }
}