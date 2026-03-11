@extends('layouts.app_a')
@section('title', 'Edit Product')

@section('content')

<div class="header-section product-form-header">
    <div>
        <h1>Edit Product</h1>
        <p>Update product details and shelf assignment.</p>
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
                <p class="form-card-subtitle">Update product information and shelf assignment.</p>
            </div>

            <form method="POST" action="{{ route('admin.products.update', $product) }}" class="transaction-form">
                @csrf
                @method('PUT')

                <div class="product-form-grid">
                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input type="text"
                               name="product_name"
                               class="form-input"
                               value="{{ old('product_name', $product->product_name) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <input type="text"
                               name="category"
                               class="form-input"
                               value="{{ old('category', $product->category) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Price</label>
                        <input type="number"
                               name="price"
                               step="0.01"
                               min="0"
                               class="form-input"
                               value="{{ old('price', $product->price) }}"
                               required>
                    </div>

                    <div class="form-group product-status-note-wrap">
                        <label class="form-label">Status</label>
                        <div class="product-status-note">
                            <strong>{{ $product->status ?? 'Approved' }}</strong> (admin)
                        </div>
                    </div>

                    <div class="form-group form-group-full">
                        <label class="form-label">Description (optional)</label>
                        <textarea name="description"
                                  class="form-input form-textarea">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="form-group form-group-full">
                        <label class="form-label">Shelf</label>
                        <select name="shelf_id" class="form-input form-select" required>
                            <option value="">— Select shelf —</option>
                            @foreach($shelves as $s)
                                <option value="{{ $s->shelf_id }}"
                                    {{ (string)old('shelf_id', $product->shelf_id) === (string)$s->shelf_id ? 'selected' : '' }}>
                                    {{ $s->shelf_number }} — {{ $s->renter?->renter_company_name ?? 'Unassigned' }}
                                </option>
                            @endforeach
                        </select>

                        <div class="form-help-text">
                            Product will automatically be linked to the shelf’s assigned renter.
                        </div>
                    </div>

                    <div class="form-group form-group-full">
                        <div class="product-meta-box">
                            <div class="product-meta-row">
                                <span class="product-meta-label">Current linked renter:</span>
                                <span class="product-meta-value">{{ $product->renter?->renter_company_name ?? '—' }}</span>
                            </div>
                            <div class="product-meta-row">
                                <span class="product-meta-label">On-hand stock:</span>
                                <span class="product-meta-value">{{ $product->inventory?->quantity_on_hand ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions form-actions-right">
                    <a href="{{ route('admin.products.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection