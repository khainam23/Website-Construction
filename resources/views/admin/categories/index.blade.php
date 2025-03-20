@extends('admin.layouts.master')

@section('title', __('Category Management'))

@section('content')
<div class="container">
    <h1>{{ __('Category Management') }}</h1>

    <div class="mb-3">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">{{ __('Create Category') }}</a>
    </div>

    <div class="mb-3">
        <form action="{{ route('admin.categories.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="{{ __('Search category...') }}" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Parent Category') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent ? $category->parent->name : __('None') }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                        <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}')">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
