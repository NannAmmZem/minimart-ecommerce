@extends('layouts.admin')

@section('title', 'Create Category')
@section('header', 'Create New Category')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Category Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" required>
            @error('name')
                <span class="text-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="3" class="form-input">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-grid-2">
            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" class="form-input">
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    Active
                </label>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
