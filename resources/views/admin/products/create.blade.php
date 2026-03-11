@extends('layouts.app_a')
@section('title', 'Add Product')

@section('content')

<div class="header-section product-form-header">
    <div>
        <h1>Add Product</h1>
        <p>Create a product before doing stock operations.</p>
    </div>

    <a href="{{ route('admin.products.index') }}" class="btn-outline">
        ← Back to Products
    </a>
</div>

@if ($errors->any())
    <div class="form-page-wrap" style="padding-top:0;">
        <div class="form-alert form-alert-danger">
            <div class="form-alert-title">Please fix the errors:</div>
            <ul class="form-error-list">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="form-page-wrap">
    <div class="form-shell">
        <div class="form-card">
            <div class="form-card-header">
                <h2 class="form-card-title">Product Details</h2>
                <p class="form-card-subtitle">Enter product information and assign it to a shelf.</p>
            </div>

            <form method="POST" action="{{ route('admin.products.store') }}" class="transaction-form">
                @csrf

                <div class="product-form-grid">
                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input type="text"
                               name="product_name"
                               class="form-input"
                               value="{{ old('product_name') }}"
                               placeholder="e.g., Lavender Soap"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <input type="text"
                               name="category"
                               class="form-input"
                               value="{{ old('category') }}"
                               placeholder="e.g., Skincare"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Price</label>
                        <input type="number"
                               name="price"
                               step="0.01"
                               min="0"
                               class="form-input"
                               value="{{ old('price') }}"
                               placeholder="0.00"
                               required>
                    </div>

                    <div class="form-group product-status-note-wrap">
                        <label class="form-label">Status</label>
                        <div class="product-status-note">
                            <strong>Approved</strong> (automatic)
                        </div>
                    </div>

                    <div class="form-group form-group-full">
                        <label class="form-label">Description (optional)</label>
                        <textarea name="description"
                                  class="form-input form-textarea"
                                  placeholder="Short description...">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group form-group-full">
                        <label class="form-label">Shelf</label>
                        <select name="shelf_id" class="form-input form-select" required>
                            <option value="">— Select shelf —</option>
                            @foreach($shelves as $s)
                                <option value="{{ $s->shelf_id }}"
                                    {{ (string)old('shelf_id') === (string)$s->shelf_id ? 'selected' : '' }}>
                                    {{ $s->shelf_number }} — {{ $s->renter?->renter_company_name ?? 'Unassigned' }}
                                </option>
                            @endforeach
                        </select>

                        <div class="form-help-text">
                            Product will automatically be linked to the shelf’s assigned renter.
                        </div>
                    </div>
                </div>

                <div class="form-actions form-actions-right">
                    <a href="{{ route('admin.products.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection