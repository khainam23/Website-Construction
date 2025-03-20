@extends('admin.layouts.master')

@section('title', __('Edit Category'))

@section('content')
<div class="container">
    <h1>{{ __('Edit Category') }}</h1>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <div class="form-group">
            <label for="parent_id">{{ __('Parent Category') }}</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">{{ __('None') }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
</div>
@endsection
