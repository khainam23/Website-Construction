@extends('frontend.layouts.master')
@section('title', __('Sản phẩm'))

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/product.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="news-title">
            <div>
                <h1>
                    {{ __('PRODUCT CATALOG') }}
                </h1>
            </div>
            <div class="news-title-right">
                <a href="{{ route('web.index') }}">
                    <h2>{{ __('Home') }}</h2>
                </a>
                <p>></p>
                <p>{{ __('Product catalog') }}</p>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-filter-container">
            <form action="{{ url()->current() }}" method="GET" class="search-filter-form">
                <div class="search-category-row">
                    <div class="search-container">
                        <input type="text" name="search" placeholder="{{ __('Search products...') }}" value="{{ request('search') }}" class="search-input">
                        <button type="submit" class="search-button">
                            <i class="fa fa-search"></i> {{ __('Search') }}
                        </button>
                    </div>
                    <div class="category-filter">
                        <select name="category" class="filter-select" onchange="this.form.submit()">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="price-range-filter">
                    <label>{{ __('Price Range') }}:</label>
                    <div class="price-inputs">
                        <input type="number" name="min_price" placeholder="{{ __('Min') }}" value="{{ request('min_price') }}" class="price-input">
                        <span>-</span>
                        <input type="number" name="max_price" placeholder="{{ __('Max') }}" value="{{ request('max_price') }}" class="price-input">
                        <button type="submit" class="filter-price-button">{{ __('Filter') }}</button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Result count -->
        <div class="result-count">
            <p>{{ __('Found') }} {{ count($products) }} {{ __('products') }}</p>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="items">
                @if($products->isEmpty())
                    <div class="no-results">
                        <p>{{ __('No products found matching your criteria.') }}</p>
                    </div>
                @else
                    @foreach($categories as $category)
                        @php
                            $categoryProducts = $products->where('category_id', $category->id);
                        @endphp
                        
                        @if($categoryProducts->count() > 0)
                            <div class="supgroup">
                                <div>
                                    <div class="heading-category">
                                        <p class="text-cantegory-2">{{$category->name}}</p>
                                    </div>
                                </div>
                                <div class="product-list">
                                    <div class="item-1">
                                        <div class="row">
                                            @foreach($categoryProducts as $product)
                                                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                                                    <a class="link" href="{{ route('web.product.detail', ['id' => $product->id]) }}">
                                                        <div class="card">
                                                            <img src="{{asset($product->avatar)}}" class="card-img-top"
                                                                alt="{{$product->name}}">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{$product->name}}</h5>
                                                                <p class="card-text">
                                                                    {{ Str::limit(strip_tags($product->description), 50, '...') }}
                                                                </p>
                                                                <span class="product-price">
                                                                    <i class="fas fa-tag" style="font-size: 14px; margin-right: 5px; opacity: 0.7;"></i>
                                                                    {{ $product->price }}<span class="product-price-currency">{{ __('Type pice') }}</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection