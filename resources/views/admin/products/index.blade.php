@extends('layouts.app_a')
@section('title', 'Products')

@section('content')

<div class="header-section" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div>
        <h1>Products</h1>
        <p>Manage product catalog before stock operations.</p>
    </div>

    <a href="{{ route('admin.inventory.index') }}" class="btn-outline">
        ← Back to Inventory
    </a>
</div>

@if(session('success'))
    <div class="success-box">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="success-box" style="border-color:#f3c4c4; background:#fff7f7;">
        <strong style="color:#9b2c2c;">Error:</strong>
        <ul style="margin:8px 0 0 18px;">
            @foreach($errors->all() as $e)
                <li style="color:#9b2c2c;">{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- TOP TOOLBAR --}}
<div class="toolbar">
    <form method="GET" action="{{ route('admin.products.index') }}" class="search-form">
        <input class="input-field"
               name="q"
               value="{{ $q ?? '' }}"
               placeholder="Search product or category...">
        <button class="btn-outline" type="submit">Search</button>
    </form>

    <a href="{{ route('admin.products.create') }}" class="btn-primary">
        + Add Product
    </a>
</div>

{{-- PRODUCTS TABLE --}}
<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Product List</div>

    <div class="activity-table-scrollable">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th style="text-align:right;">Price</th>
                    <th>Shelf</th>
                    <th>Renter</th>
                    <th style="text-align:right;">On Hand</th>
                    <th>Status</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->product_name }}</strong>
                            <div style="font-size:12px; color:#9a8575;">
                                {{ $product->description ?? '—' }}
                            </div>
                        </td>

                        <td>{{ $product->category }}</td>

                        <td style="text-align:right;">
                            ₱{{ number_format($product->price, 2) }}
                        </td>

                        <td>
                            {{ $product->shelf?->shelf_number ?? '—' }}
                        </td>

                        <td>
                            {{ $product->renter?->renter_company_name ?? '—' }}
                        </td>

                        <td style="text-align:right;">
                            {{ $product->inventory?->quantity_on_hand ?? 0 }}
                        </td>

                        <td>
                            <span class="badge
                                {{ $product->status === 'Active' ? 'badge-available' : 'badge-occupied' }}">
                                {{ strtoupper($product->status) }}
                            </span>
                        </td>

                        <td style="text-align:center;">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="btn-mini-outline">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.products.destroy', $product) }}"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn-mini-outline"
                                        onclick="return confirm('Delete this product?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top:14px;">
        {{ $products->links() }}
    </div>
</div>

@endsection