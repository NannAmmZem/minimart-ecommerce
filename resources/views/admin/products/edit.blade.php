@extends('layouts.admin')

@section('title', 'Edit Product')
@section('header', 'Edit Product')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-grid-2">
            <div class="form-group">
                <label for="name">Product Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-input" required>
                @error('name')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="category_id">Category *</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="3" class="form-input">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <span class="text-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-grid-3">
            <div class="form-group">
                <label for="price">Price ($) *</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="form-input" required>
                @error('price')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="unit">Unit *</label>
                <input type="text" name="unit" id="unit" value="{{ old('unit', $product->unit) }}" class="form-input" required>
                @error('unit')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity *</label>
                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" class="form-input" required>
                @error('stock_quantity')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-grid-2">
            <div class="form-group">
                <label for="low_stock_alert">Low Stock Alert</label>
                <input type="number" name="low_stock_alert" id="low_stock_alert" value="{{ old('low_stock_alert', $product->low_stock_alert) }}" min="0" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="image">Product Image</label>
                @if($product->image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 150px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <p style="font-size: 12px; color: #6b7280; margin-top: 4px;">Current image</p>
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*" class="form-input">
                @if($product->image)
                    <small class="text-muted">Upload new image to replace current one</small>
                @endif
                @error('image')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-grid-2">
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    Featured Product
                </label>
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="in_stock" value="1" {{ old('in_stock', $product->in_stock) ? 'checked' : '' }}>
                    In Stock
                </label>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
