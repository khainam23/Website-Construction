@extends('frontend.layouts.master')
@section('title', 'chi tiết sản phẩm')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="{{ asset('frontend/css/product-detail.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="news-title">
        <div>
            <h1 style="color:#B4B4B4;">
                {{ __('PRODUCT CATALOG') }}
            </h1>
        </div>
        <div class="news-title-right">
            <a href="{{ route('web.index') }}">
                <h2>{{ __('Home') }}</h2>
            </a>
            <p>></p>
            <p style="color:#333;">{{ __('Product catalog') }}</p>
        </div>
    </div>

</div>
<div class="section">
    <div class="container">
        <!-- mailay -->

        <div class="section-header">
            <div class="section-heading">
                <h5 class="name-product">{{$product->productTranslations->first()->name}}</h5>
                <div class="content-product">
                    <p class="text-content"> {!! $product->productTranslations->first()->short_description !!}</p>
                </div>
            </div>
            <div class="logo">
                <img class="logo-in" src="{{ asset('frontend/images/logo-product-detail1.png') }}" alt="logo">
            </div>
        </div>
        <div class="content">
            <div class="left">
                <div class="gallery">
                    <div class="row">
                        <div class="col-12">
                            <img id="mainImage" src="{{asset($product->avatar)}}" class="img-fluid" alt="Main Image">
                        </div>
                        <div class="col-12 mt-3">
                            <div class="d-flex justify-content">
                                <img src="{{asset($product->avatar)}}" class="thumb-img " width="70" onclick="changeImage(this)">
                                <!-- <img src="{{ asset('frontend/images/product-detail6.png') }}" class="thumb-img " width="70" onclick="changeImage(this)">
                                <img src="{{ asset('frontend/images/product-detail3.png') }}" class="thumb-img " width="70" onclick="changeImage(this)"> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- supheading-1 -->
                @if( $product->productTranslations->first()->product_information != '')
                <div class="supheading">
                    <div class="polygon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                            <path d="M12.299 2.75C12.0311 2.2859 11.5359 2 11 2C10.4641 2 9.96891 2.2859 9.70096 2.75L1.90673 16.25C1.63878 16.7141 1.63878 17.2859 1.90673 17.75C2.17468 18.2141 2.66987 18.5 3.20577 18.5H18.7942C19.3301 18.5 19.8253 18.2141 20.0933 17.75C20.3612 17.2859 20.3612 16.7141 20.0933 16.25L12.299 2.75Z" fill="#295BAE" stroke="#295BAE" stroke-width="3" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <p class="text-information">{{ __('Product information') }}</p>
                </div>
                <div class="content-information">
                    <div>
                        {!! $product->productTranslations->first()->product_information !!}
                    </div>
                </div>
                @endif
                <!-- supheading-2 -->
                @if( $product->productTranslations->first()->description_benefits != '')
                <div class="supheading">
                    <div class="polygon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                            <path d="M12.299 2.75C12.0311 2.2859 11.5359 2 11 2C10.4641 2 9.96891 2.2859 9.70096 2.75L1.90673 16.25C1.63878 16.7141 1.63878 17.2859 1.90673 17.75C2.17468 18.2141 2.66987 18.5 3.20577 18.5H18.7942C19.3301 18.5 19.8253 18.2141 20.0933 17.75C20.3612 17.2859 20.3612 16.7141 20.0933 16.25L12.299 2.75Z" fill="#295BAE" stroke="#295BAE" stroke-width="3" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <p class="text-information">{{ __('Description and advantages') }}</p>
                </div>
                <div class="content-information">
                    <div>
                        {!! $product->productTranslations->first()->description_benefits !!}
                    </div>
                </div>
                @endif
                <!-- supheading-3 -->
                @if( $product->productTranslations->first()->applications != '')
                <div class="supheading">
                    <div class="polygon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                            <path d="M12.299 2.75C12.0311 2.2859 11.5359 2 11 2C10.4641 2 9.96891 2.2859 9.70096 2.75L1.90673 16.25C1.63878 16.7141 1.63878 17.2859 1.90673 17.75C2.17468 18.2141 2.66987 18.5 3.20577 18.5H18.7942C19.3301 18.5 19.8253 18.2141 20.0933 17.75C20.3612 17.2859 20.3612 16.7141 20.0933 16.25L12.299 2.75Z" fill="#295BAE" stroke="#295BAE" stroke-width="3" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <p class="text-information">{{ __('Applications') }}</p>
                </div>
                <div class="content-information">
                    <div>
                        {!! $product->productTranslations->first()->applications !!}
                    </div>
                </div>
                @endif
                <div class="tabs">
                    <!-- Tabs -->
                    <div class="container mt-4">
                        <!-- Tabs Header -->
                        <ul class="nav custom-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="thi-cong-tab" data-toggle="tab" href="#thi-cong" role="tab" aria-controls="thi-cong" aria-selected="true">
                                    <strong>{{ __('Construction') }}</strong>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="trach-nhiem-tab" data-toggle="tab" href="#trach-nhiem" role="tab" aria-controls="trach-nhiem" aria-selected="false">
                                    {{ __('Responsibility') }}
                                </a>
                            </li>
                        </ul>

                        <!-- Tabs Content -->
                        <div class="tab-content mt-0" id="myTabContent">
                            <!-- Nội dung Tab Thi Công -->
                            <div class="tab-pane fade show active" id="thi-cong" role="tabpanel" aria-labelledby="thi-cong-tab">
                                <div>
                                    {!! $product->productTranslations->first()->construction !!}
                                </div>
                            </div>

                            <!-- Nội dung Tab Trách Nhiệm -->
                            <div class="tab-pane fade" id="trach-nhiem" role="tabpanel" aria-labelledby="trach-nhiem-tab">
                                <div>
                                    {!! $product->productTranslations->first()->responsibilities !!}
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="group-slide product-list">
            <div class="text-slide">
                <h4 class="in-text-slide"> {{ __('Related products') }}</h4>
            </div>
            <div class="swiper mySwiper1">
                <div class="swiper-wrapper">
                    @foreach($products as $product)
                    <div class="swiper-slide">
                        <a class="link" href="{{ route('web.product-detail', ['id' => $product->id]) }}">
                            <div>
                                <img class="img-slide" src="{{asset($product->avatar)}}" alt="Phụ gia bê tông BMQ - Plas 02">
                            </div>
                            <h4 class="name-product-1">{{$product->productTranslations->first()->name}}</h4>
                            <p class="content-product-1">{!!$product->productTranslations->first()->short_description!!}</p>
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Nút điều hướng -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Thanh phân trang -->
            </div>

            <!-- <div class="swiper-pagination"></div> -->

        </div>



    </div>

</div>

@endsection
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // === Thay đổi ảnh chính khi click vào thumbnail ===
        function changeImage(element) {
            let mainImage = document.getElementById("mainImage");

            // Hiệu ứng mờ trước khi đổi ảnh
            mainImage.style.opacity = 0;
            setTimeout(() => {
                mainImage.src = element.src;
                mainImage.style.opacity = 1;
            }, 200);

            // Xóa trạng thái active khỏi tất cả ảnh thumbnail
            document.querySelectorAll(".thumb-img").forEach(img => img.classList.remove("active"));
            element.classList.add("active");
        }

        // Gán sự kiện cho tất cả ảnh thumbnail
        document.querySelectorAll(".thumb-img").forEach(img => {
            img.addEventListener("click", function() {
                changeImage(this);
            });
        });



        // === Khởi tạo Swiper cho slider 1 ===
        var swiper1 = new Swiper(".mySwiper1", {
            slidesPerView: 3, // Hiển thị 3 ảnh mặc định
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".mySwiper1 .swiper-button-next",
                prevEl: ".mySwiper1 .swiper-button-prev",
            },
            pagination: {
                el: ".mySwiper1 .swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4
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
    });
</script>
@endsection