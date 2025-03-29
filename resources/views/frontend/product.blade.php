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
                <div class="search-container">
                    <input type="text" name="search" placeholder="{{ __('Search products...') }}"
                        value="{{ request('search') }}" class="search-input">
                    <button type="submit" class="search-button">
                        <i class="fa fa-search"></i> {{ __('Search') }}
                    </button>
                </div>
                <div class="filter-container">
                    <select name="category" class="filter-select" onchange="this.form.submit()">
                        <option value="">{{ __('All Categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
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
                    @for($i = $page * 3 - 3; $i < $page * 3 && $i < count($categories); $i++)
                                @php
                                    $category = $categories[$i];
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
                                                                            <i class="fas fa-tag"
                                                                                style="font-size: 14px; margin-right: 5px; opacity: 0.7;"></i>
                                                                            {{ $product->price }}<span
                                                                                class="product-price-currency">{{ __('Type pice') }}</span>
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
                    @endfor
                    <nav>
                        <ul class="pagination">
                            @php
                                $totalPages = ceil(count($categories) / 3);
                            @endphp

                            {{-- Nút Previous --}}
                            <li class="page-item {{ ($page == 1) ? 'disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ route('web.product', ['type' => $type, 'page' => max(1, $page - 1)]) }}"
                                    tabindex="-1">
                                    <</a>
                            </li>

                            {{-- Các số trang --}}
                            @for ($i = 1; $i <= $totalPages; $i++)
                                <li class="page-item {{ ($page == $i) ? 'active' : '' }}">
                                    <a class="page-link"
                                        href="{{ route('web.product', ['type' => $type, 'page' => $i]) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Nút Next --}}
                            <li class="page-item {{ ($page == $totalPages) ? 'disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ route('web.product', ['type' => $type, 'page' => min($totalPages, $page + 1)]) }}">></a>
                            </li>
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
@endsection