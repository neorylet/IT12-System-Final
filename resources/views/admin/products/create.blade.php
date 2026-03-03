@extends('layouts.app_a')
@section('title', 'Add Product')

@section('content')

<div class="header-section" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div>
        <h1>Add Product</h1>
        <p>Create a product before doing stock operations.</p>
    </div>

    <a href="{{ route('admin.products.index') }}" class="btn-outline">
        ← Back to Products
    </a>
</div>

@if ($errors->any())
    <div class="success-box" style="border-color:#f3c4c4; background:#fff7f7;">
        <strong style="color:#9b2c2c;">Please fix the errors:</strong>
        <ul style="margin:8px 0 0 18px;">
            @foreach($errors->all() as $e)
                <li style="color:#9b2c2c;">{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="activity-section" style="margin-top:16px;">
    <div class="activity-header">Product Details</div>

    <form method="POST" action="{{ route('admin.products.store') }}" style="padding:12px;">
        @csrf

        <div style="display:grid; grid-template-columns: 1.2fr 1fr; gap:12px;">
            <div>
                <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Product Name</label>
                <input type="text"
                       name="product_name"
                       class="input-field"
                       style="width:100%;"
                       value="{{ old('product_name') }}"
                       placeholder="e.g., Lavender Soap"
                       required>
            </div>

            <div>
                <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Category</label>
                <input type="text"
                       name="category"
                       class="input-field"
                       style="width:100%;"
                       value="{{ old('category') }}"
                       placeholder="e.g., Skincare"
                       required>
            </div>

            <div>
                <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Price</label>
                <input type="number"
                       name="price"
                       step="0.01"
                       min="0"
                       class="input-field"
                       style="width:100%;"
                       value="{{ old('price') }}"
                       placeholder="0.00"
                       required>
            </div>

            <div style="display:flex; align-items:flex-end;">
                <div style="font-size:12px; color:#9a8575;">
                    <strong>Status:</strong> Approved (auto)
                </div>
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Description (optional)</label>
                <textarea name="description"
                          class="input-field"
                          style="width:100%; min-height:90px; resize:vertical;"
                          placeholder="Short description...">{{ old('description') }}</textarea>
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display:block; font-size:12px; color:#7b6151; margin-bottom:6px;">Shelf</label>
                <select name="shelf_id" class="input-field" style="width:100%;" required>
                    <option value="">— Select shelf —</option>
                    @foreach($shelves as $s)
                        <option value="{{ $s->shelf_id }}"
                            {{ (string)old('shelf_id') === (string)$s->shelf_id ? 'selected' : '' }}>
                            {{ $s->shelf_number }} — {{ $s->renter?->renter_company_name ?? 'Unassigned' }}
                        </option>
                    @endforeach
                </select>

                <div style="font-size:12px; color:#9a8575; margin-top:6px;">
                    Product will automatically be linked to the shelf’s assigned renter.
                </div>
            </div>
        </div>

        <div style="margin-top:14px; display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap;">
            <a href="{{ route('admin.products.index') }}" class="btn-outline" style="text-decoration:none;">Cancel</a>
            <button type="submit" class="btn-primary">Save Product</button>
        </div>
    </form>
</div>

@endsection