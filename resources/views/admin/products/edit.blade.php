@extends('admin.layouts.master')

@section('title', __('Edit Product'))

@section('content')
<div class="container">
    <h1>{{ __('Edit Product') }}</h1>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
        </div>

        <div class="form-group">
            <label for="category_id">{{ __('Category') }}</label>
            <input type="number" name="category_id" id="category_id" class="form-control" value="{{ $product->category_id }}">
        </div>

         <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">{{ __('Price') }}</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}">
        </div>

        <div class="form-group">
            <label for="stock">{{ __('Stock') }}</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}">
        </div>

        <div class="form-group">
            <label for="images">{{ __('Images') }}</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            @if($product->images)
                <div>
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}" style="max-height: 100px;">
                    @endforeach
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
</div>
@endsection
