@extends('layouts.admin')

@section('title', 'Create Product')
@section('header', 'Create New Product')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-grid-2">
            <div class="form-group">
                <label for="name">Product Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" required>
                @error('name')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="category_id">Category *</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
            <textarea name="description" id="description" rows="3" class="form-input">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-grid-3">
            <div class="form-group">
                <label for="price">Price ($) *</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" class="form-input" required>
                @error('price')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="unit">Unit *</label>
                <input type="text" name="unit" id="unit" value="{{ old('unit', 'pc') }}" placeholder="e.g., kg, pc, l" class="form-input" required>
                @error('unit')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity *</label>
                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" class="form-input" required>
                @error('stock_quantity')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-grid-2">
            <div class="form-group">
                <label for="low_stock_alert">Low Stock Alert</label>
                <input type="number" name="low_stock_alert" id="low_stock_alert" value="{{ old('low_stock_alert', 10) }}" min="0" class="form-input">
                @error('low_stock_alert')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" id="image" accept="image/*" class="form-input">
                @error('image')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-grid-2">
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    Featured Product
                </label>
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="in_stock" value="1" {{ old('in_stock', true) ? 'checked' : '' }}>
                    In Stock
                </label>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
