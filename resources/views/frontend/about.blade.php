@extends('frontend.layouts.master')
@section('title', 'Giới thiệu')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontend/css/styleGuide.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/aboutUsStyle.css') }}" />
@endsection

@section('content')
    <div class="container flex-column d-flex about-us">
        <div class="about-us-container">
            <div class="sub-about-us d-flex flex-column">
                <div class="news-title">
                    <div>
                        <h1>
                        {{-- {{ __('INTRODUCE') }} --}}  GIỚI THIỆU
                        </h1>
                    </div>
                    <div class="news-title-right">
                        <a href=""><h2>{{ __('Home') }} trang chủ</h2></a>
                        <p>></p>
                        {{-- <p>{{ __('Introduce') }}</p> --}} GIỚI THIỆU
                    </div>
                </div>
                <div class="content-about-us row">
                    <div class="left-content col-md-6">
                        <div class="frame-left-content">
                           
                            <div class="content">
                                <div class="sub-content mb-4">
                                    {{-- <span class="text-content-top">{{ __('About_content1') }}<br /><br />{{ __('About_content2') }}<br /><br />{{ __('About_content3') }}<br /><br />{{ __('About_content4') }}<br /><br />{{ __('About_content5') }}<br /><br />{{ __('About_content6') }}<br /><br /></span>
                                    <span class="text-content-bottom">{{ __('Thank_you_est') }}</span> --}} nội dung
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-content col-md-6 d-flex flex-column align-items-center">
                        <div>
                            <img alt="" src="ảnh lo go" class="logo-bmq123" />
                        </div>
                        <div class="ceo-infomation w-100 d-flex flex-column justify-content-between">
                            <div class="mb-3 d-flex justify-content-center">
                                <img alt="" src="ảnh giám đốc"
                                    class="avatar-ceo w-100" />
                            </div>
                            <p class="infomation d-flex justify-content-center align-items-end">
                                <span class="text-name">Ông Nguyễn Văn Hùng -
                                    <span class="text-permission">giám đốc</span></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="achievement-about-us">
                    <div class="list-achievement row">
                        <div class="acvm-no-1 col-md-3 col-6 d-flex align-items-center">
                            <div class="text-wrapper">15</div>
                            {{-- <div class="achievement">{{ __('year') }}<br />{{ __('experience') }}</div> --}}
                            <div class="rectangle"></div>
                        </div>
                        <div class="acvm-no-1 col-md-3 col-6 d-flex align-items-center">
                            <div class="text-wrapper">22</div>
                            {{-- <div class="achievement">{{ __('head') }}<br />{{ __('product') }}</div> --}}
                            <div class="rectangle"></div>
                        </div>
                        <div class="acvm-no-1 col-md-3 col-6 d-flex align-items-center">
                            <div class="text-wrapper">85</div>
                            {{-- <div class="achievement">{{ __('personnel') }}<br />{{ __('high_level') }}</div> --}}
                            <div class="rectangle"></div>
                        </div>
                        <div class="acvm-no-1 col-md-3 col-6 d-flex align-items-center">
                            <div class="text-wrapper">39</div>
                            {{-- <div class="achievement">{{ __('project') }}<br />{{ __('completed') }}</div> --}}
                            <div class="rectangle"></div>
                        </div>
                    </div>
                </div>
                <div class="mission-about-us row">
                    <div class="left-mission col-lg-6 d-flex flex-column justify-content-between w-100 mb-4">
                        <div class="item">
                            <div class="title-item">
                                <span class="text-wrapper">{{ __('Vision') }}</span>
                            </div>
                            <div class="content-item">
                                <ul class="content-wrapper">
                                    {{-- <li>
                                    {{ __('Vision_content1') }}
                                    </li>
                                    <li>
                                    {{ __('Vision_content2') }}
                                    </li> --}}
                                </ul>
                            </div>
                            <img src="{{ asset('frontend/images/polygon.svg') }}" class="polygon" alt="" />
                        </div>
                        <div class="item">
                            <div class="title-item">
                                <span class="text-wrapper">{{ __('Mission') }}</span>
                            </div>
                            <div class="content-item">
                                <ul class="content-wrapper">
                                    {{-- <li>
                                    {{ __('Mission_content1') }}
                                    </li>
                                    <li>
                                    {{ __('Mission_content2') }}                                    </li>
                                    <li>
                                    {{ __('Mission_content3') }}
                                    </li> --}}
                                </ul>
                            </div>
                            <img src="{{ asset('frontend/images/polygon.svg') }}" class="polygon" alt="" />
                        </div>
                    </div>
                    <div class="right-mission col-lg-6">
                        <div class="item">
                            <div class="title-item">
                                <span class="text-wrapper">{{ __('Core_value') }}</span>
                            </div>
                            <div class="content-item">
                                <ul class="content-wrapper">
                                    {{-- <li>
                                    {{ __('Core_Value_content1') }}
                                    </li>
                                    <li>
                                    {{ __('Core_Value_content2') }}                                    </li>
                                    <li>
                                    {{ __('Core_Value_content3') }}
                                    </li> --}}
                                </ul>
                            </div>
                            <img src="ảnh logo tam giác" class="polygon" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="process-about-us w-100">
            <div class="container-process">
                <div class="section-header">
                    <div class="section-heading d-flex flex-column">
                        <div class="warehouse-chemical">{{ __('Warehouse, Chemical Process') }}</div>
                        <p class="text-wrapper mb-3">
                        {{ __('PHOTOS_OF_WAREHOUSE_AND_CHEMICAL_PROCESSES') }}
                        </p>
                    </div>
                </div>
                <div class="swiper mySwiper1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/images/img-process1.png') }}" alt="" />
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/images/item (1).png') }}" alt="" />
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/images/item (2).png') }}" alt="" />
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/images/item.png') }}" alt="" />
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/images/item (1).png') }}" alt="" />
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
        <div class="laboratory-about-us w-100">
            <div class="container-laboratory">
                <div class="section-header">
                    <div class="section-heading d-flex flex-column">
                        <div class="laboratory">{{ __('Laboratory') }}</div>
                        <p class="text-wrapper mb-3">{{ __('LABORATORY_PHOTOS') }}</p>
                    </div>
                </div>
                <div class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/images/img-labo1.png') }}" alt=""
                                class="w-100 h-100" />
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/images/item (3).png') }}" alt=""
                                class="w-100 h-100" />
                        </div>
                    </div>

                    <!-- Nút điều hướng -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
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

            // Swiper cho slider 2
            var swiper2 = new Swiper(".mySwiper2", {
                slidesPerView: 2, // Hiển thị 2 ảnh mặc định
                spaceBetween: 10,
                loop: true,
                navigation: {
                    nextEl: ".mySwiper2 .swiper-button-next",
                    prevEl: ".mySwiper2 .swiper-button-prev",
                },
                breakpoints: {
                    992: {
                        slidesPerView: 2
                    },
                    576: {
                        slidesPerView: 1
                    },
                    0: {
                        slidesPerView: 1
                    },
                },
            });
        });
    </script>
@endsection
