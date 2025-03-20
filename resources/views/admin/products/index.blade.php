@extends('admin.layouts.master')

@section('title', __('Product Management'))

@section('content')
<div class="container">
    <h1>{{ __('Product Management') }}</h1>

    <div class="mb-3">
        <form method="GET" action="{{ route('admin.products.index') }}">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="{{ __('Search') }}" name="search" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">{{ __('Search') }}</button>
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
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Stock') }}</th>
                    <th>{{ __('Images') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category_id }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->avatar)
                            <img src="{{ $product->avatar }}" class="card-img-top" alt="{{ $product->name }}" style="max-height: 50px; margin-right: 5px;">
                        @else
                            {{ __('No Images') }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this product?') }}')">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
