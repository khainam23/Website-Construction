@extends('frontend.layouts.master')
@section('title', 'Sản phẩm')

@section('style')
<link rel="stylesheet" href="{{ asset('frontend/css/product.css') }}">

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

</div>
<div class="section">
    <div class="container">
        <div class="items">
            @foreach($categories as $category)
            <div class="supgroup">
                <div>
                    <div class="heading-category">
                        <p class="text-cantegory-2">{{$category->name}}</p>
                    </div>
                </div>
                <div class="product-list">
                    <div class="item-1">
                        <div class="row"> 
                            @foreach($products as $product)
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                                <a class="link" href="{{ route('web.product-detail', ['id' => $product->id]) }}">
                                    <div class="card">
                                        <img src="{{asset($product->avatar)}}" class="card-img-top" alt="{{$product->name}}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$product->name}}</h5>
                                            <p class="card-text">{!!$product->description!!}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>



@endsection