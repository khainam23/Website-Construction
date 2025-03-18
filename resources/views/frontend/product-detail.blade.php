@extends('frontend.layouts.master')
@section('title', 'Chi tiết sản phẩm')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('frontendcss/product-detail.css') }}">
    <style>
        .product-detail-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            align-items: center;
            justify-content: center;
            padding: 50px 0;
        }

        .product-gallery {
            flex: 1;
            max-width: 500px;
        }

        .product-info {
            flex: 1;
            max-width: 500px;
        }

        .main-image {
            width: 100%;
            border-radius: 10px;
            transition: opacity 0.3s ease-in-out;
        }

        .thumbnail-container {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            justify-content: center;
        }

        .thumbnail {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .thumbnail:hover {
            transform: scale(1.1);
        }

        .product-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .product-description {
            font-size: 16px;
            color: #666;
            margin-top: 10px;
        }

        .btn-order {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-order a {
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }

        .btn-buy {
            background-color: #ff5722;
        }

        .btn-buy:hover {
            background-color: #e64a19;
        }

        .btn-rent {
            background-color: #03a9f4;
        }

        .btn-rent:hover {
            background-color: #0288d1;
        }

        .related-products {
            margin-top: 50px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .related-products h4 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .img-slide {
            max-width: 100px;
            /* Điều chỉnh kích thước phù hợp */
            max-height: 100px;
            object-fit: contain;
            /* Đảm bảo ảnh không bị méo */
        }
    </style>
@endsection

@section('content')
    <div class="container product-detail-container">
        <div class="product-gallery">
            <img id="mainImage" src="{{ asset($product->avatar) }}" class="main-image" alt="Main Image">
            <div class="thumbnail-container">
                @foreach ($product->images as $image)
                    <img src="{{ $image->path }}" class="thumbnail" onclick="changeImage(this)">
                @endforeach
            </div>
        </div>
        <div class="product-info">
            <h1 class="product-title">{{$product->name}}</h1>
            <p class="product-description">Hiện còn: {!! $product->stock !!}</p>
            <p class="product-description">{!! $product->description !!}</p>
            <div class="btn-order">
                <a href="#" class="btn-buy">{{ __('Buy Now') }}</a>
                <a href="#" class="btn-rent">{{ __('Rent Now') }}</a>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="mb-4 text-primary text-center fw-bold">Mô tả</h2>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center fw-semibold">Thông tin</h4>
            </div>
            <div class="card-body bg-light overflow-hidden"
                style="max-height: 150px; transition: max-height 0.3s ease-in-out;" id="infoContent">
                <p class="fs-5 text-muted lh-base text-justify">{{ $product->info }}</p>
            </div>
            <div class="text-center p-2">
                <button class="btn btn-primary btn-sm d-none" id="infoToggle"
                    onclick="toggleContent('infoContent', 'infoToggle')">Xem thêm</button>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0 text-center fw-semibold">Tính năng</h4>
            </div>
            <div class="card-body bg-light overflow-hidden"
                style="max-height: 150px; transition: max-height 0.3s ease-in-out;" id="featuresContent">
                <p class="fs-5 text-muted lh-base text-justify">{{ $product->features }}</p>
            </div>
            <div class="text-center p-2">
                <button class="btn btn-success btn-sm d-none" id="featuresToggle"
                    onclick="toggleContent('featuresContent', 'featuresToggle')">Xem thêm</button>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0 text-center fw-semibold">Ứng dụng</h4>
            </div>
            <div class="card-body bg-light overflow-hidden"
                style="max-height: 150px; transition: max-height 0.3s ease-in-out;" id="applicationsContent">
                <p class="fs-5 text-muted lh-base text-justify">{{ $product->applications }}</p>
            </div>
            <div class="text-center p-2">
                <button class="btn btn-warning btn-sm d-none" id="applicationsToggle"
                    onclick="toggleContent('applicationsContent', 'applicationsToggle')">Xem thêm</button>
            </div>
        </div>
    </div>

    <div class="container related-products">
        <h4>{{ __('Related Products') }}</h4>
        <div class="swiper mySwiper1">
            <div class="swiper-wrapper">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="swiper-slide">
                        <a class="link d-block text-center"
                            href="{{ route('web.product.detail', ['id' => $relatedProduct->id]) }}">
                            <div class="d-flex justify-content-center">
                                <img class="img-slide img-fluid rounded shadow-sm" src="{{ asset($relatedProduct->avatar) }}"
                                    alt="Product Image">
                            </div>
                            <h5 class="mt-2">{{ $relatedProduct->name }}</h5>
                            <p>{{ Str::words(strip_tags($product->description), 20, '...') }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Di chuyển sản phẩm -->
    <script>
        function changeImage(element) {
            let mainImage = document.getElementById("mainImage");
            mainImage.style.opacity = 0;
            setTimeout(() => {
                mainImage.src = element.src;
                mainImage.style.opacity = 1;
            }, 200);
        }

        var swiper1 = new Swiper(".mySwiper1", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                1200: { slidesPerView: 4 },
                992: { slidesPerView: 3 },
                576: { slidesPerView: 2 },
                0: { slidesPerView: 1 },
            },
        });
    </script>

    <!-- Ẩn hiện thông tin -->
    <script>
        function toggleContent(contentId, buttonId) {
            let content = document.getElementById(contentId);
            let button = document.getElementById(buttonId);

            if (content.style.maxHeight === "150px") {
                content.style.maxHeight = "none";
                button.innerText = "Thu gọn";
            } else {
                content.style.maxHeight = "150px";
                button.innerText = "Xem thêm";
            }
        }

        function checkContentOverflow() {
            let sections = [
                { content: "infoContent", button: "infoToggle" },
                { content: "featuresContent", button: "featuresToggle" },
                { content: "applicationsContent", button: "applicationsToggle" }
            ];

            sections.forEach(section => {
                let content = document.getElementById(section.content);
                let button = document.getElementById(section.button);

                if (content.scrollHeight > 150) {
                    button.classList.remove("d-none");
                }
            });
        }

        window.onload = checkContentOverflow;
    </script>
@endsection