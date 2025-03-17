@extends('frontend.layouts.master')
@section('title', 'Trang chủ')


@section('style')

<link rel="stylesheet" href="{{ asset('frontendcss/css/home.css') }}" />

<style>
    :root {
        --commit-bg-image-certifications: url('{{ asset('frontendcss/images/backgrout.jpeg') }}');
    }
</style>

@endsection

@section('content')

<div class="banner">
    <img src="{{ asset('frontendcss/images/banner.png')}}" alt="">
</div>

<div class="container">
    <div class="about">
        <div class="row">
            <div class="about-left col-md-7">
                <h2> {{ __('ABOUT US') }}</h2>
                <h1> {{ __('JOINT STOCK COMPANY') }}</br> {{ __('NAME COMPANY') }}</h1>
                <p> {{ __('Content ct') }}</p>
                <div class="about-left-statistical">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="number"><h1>15</h1></div>
                            <p class="number-text">{{ __('year') }} <br> {{ __('experience') }}</p>
                        </div>
                        <div class="col-md-6">
                            <div class="number"><h1>22</h1></div>
                            <p class="number-text">{{ __('head') }}<br> {{ __('product') }}</p>
                        </div>
                    </div>
                </div>


            </div>
            <div class="about-right col-md-5">
                <img src="{{ asset('frontendcss/images/right.png')}}" alt="">
            </div>
        </div>
    </div>

    <div class="product">
        <div class="row">
            <div class="about-left product-title-left col-md-7">
                <h2>{{ __('PRODUCTS') }}</h2>
                <h1>{{ __('FEATURED PRODUCTS') }}</h1>
            </div>
            <div class="product-title-right col-md-5">
                <a href="{{ route('web.product', ['type' => 'all'])}}">
                    <div>{{ __('View all products') }}</div>
                </a>
            </div>
        </div>
        <div class="product-list row">
            @foreach($products as $product)
            <a class="col-md-4" href="{{ route('web.product-detail', ['id' => $product->id]) }}">
                <div class="product-card">
                    <img src="{{$product->avatar}}" alt="">
                    <h1>{{$product->name}}</h1>
                    <p>{!!$product->description!!}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<div class="certifications"id="certifications-section">
    <div class="container">
        <div class="about-left">
            <h2>{{ __('CERTIFICATIONS') }}</h2>
            <h1>{{ __('QUALITY CERTIFICATION') }}</h1>
        </div>

        <div class="swiper mySwiper1">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('frontendcss/images/certifications-1.png')}}" alt="" />

                    <div class="swiper mySwiper1">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset('frontendcss/images/certifications-1.png')}}" alt="" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('frontendcss/images/certifications-2.png')}}" alt="" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('frontendcss/images/certifications-3.png')}}" alt="" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('frontendcss/images/certifications-2.png')}}" alt="" />
                            </div>
                        </div>

                        <!-- Nút điều hướng -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>

                        <!-- Thanh phân trang -->
                        {{-- <div class="swiper-pagination"></div> --}}
                    </div>
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('frontendcss/images/certifications-2.png')}}" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('frontendcss/images/certifications-3.png')}}" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('frontendcss/images/certifications-2.png')}}" alt="" />
                </div>
            </div>

            <!-- Nút điều hướng -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Thanh phân trang -->
            {{-- <div class="swiper-pagination"></div> --}}
        </div>
    </div>
</div>

<div class="container">
    <div class="projects">
        <div class="row">
            <div class="about-left product-title-left col-md-7">
                <h2>{{ __('PROJECT') }}</h2>
                <h1>{{ __('PROJECT LIST') }}</h1>
            </div>
            <div class="product-title-right col-md-5">
                <a href="">
                    <div> {{ __('See the entire project') }}</div>
                </a>
            </div>
        </div>

        <div class="swiper mySwiper2">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('frontendcss/images/du-an-1.png')}}" alt="" />
                    <P>{{ __('Hatinh') }}</P>
                    <h1>{{ __('home_content_1') }}</h1>
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('frontendcss/images/du-an-2.png')}}" alt="" />
                    <P>{{ __('Hatinh') }}</P>
                    <h1>{{ __('home_content_2') }}</h1>
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('frontendcss/images/du-an-1.png')}}" alt="" />
                    <P>{{ __('Hatinh') }}</P>
                    <h1>{{ __('home_content_3') }}</h1>
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('frontendcss/images/du-an-2.png')}}" alt="" />
                    <P>{{ __('Hatinh') }}</P>
                    <h1>{{ __('home_content_4') }}</h1>
                </div>
            </div>

            <!-- Nút điều hướng -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Thanh phân trang -->
            {{-- <div class="swiper-pagination"></div> --}}
        </div>
    </div>

    <div class="market">
        <div class="about-left ">
            <h2>{{ __('MARKET') }}</h2>
            <h1>{{ __('EXPORT MARKET') }}</h1>
        </div>
        <div class="market-img">
            <img src="{{ asset('frontendcss/images/co-1.png')}}" alt="">
            <img src="{{ asset('frontendcss/images/co-2.png')}}" alt="">
            <img src="{{ asset('frontendcss/images/co-3.png')}}" alt="">
            <img src="{{ asset('frontendcss/images/co-4.png')}}" alt="">
            <img src="{{ asset('frontendcss/images/co-5.png')}}" alt="">
        </div>

    </div>

    <div class="news">
        <div class="row">
            <div class="about-left product-title-left col-md-7">
                <h2>{{ __('NEWS') }}</h2>
                <h1>{{ __('NEWS_EVENTS') }}</h1>
            </div>
        </div>
        <div class="news-list">
            <div class="row">
            </div>
        </div>

    </div>
</div>

@endsection


@section('js')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Swiper cho slider 1
        var swiper1 = new Swiper(".mySwiper1", {
            slidesPerView: 3, // Hiển thị 3 ảnh mặc định
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".mySwiper1 .swiper-button-next",
                prevEl: ".mySwiper1 .swiper-button-prev",
            },
            breakpoints: {
                1200: {
                    slidesPerView: 3
                },
                992: {
                    slidesPerView: 3
                },
                576: {
                    slidesPerView: 2
                },
                0: {
                    slidesPerView: 1
                },
            },
        });

        var swiper2 = new Swiper(".mySwiper2", {
            slidesPerView: 3, // Hiển thị 3 ảnh mặc định
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".mySwiper2 .swiper-button-next",
                prevEl: ".mySwiper2 .swiper-button-prev",
            },
            breakpoints: {
                1200: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 2
                },
                576: {
                    slidesPerView: 2
                },
                0: {
                    slidesPerView: 1
                },
            },
        });
    });
</script>
@endsection