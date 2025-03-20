@extends('admin.layouts.master')

@section('title', __('Create Category'))

@section('content')
<div class="container">
    <h1>{{ __('Create Category') }}</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="parent_id">{{ __('Parent Category') }}</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">{{ __('None') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
</div>
@endsection
