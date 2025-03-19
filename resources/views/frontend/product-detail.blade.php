@extends('frontend.layouts.master')
@section('title', 'chi tiết sản phẩm')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/product-detail.css') }}">
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
                    <h5 class="name-product">{{$product->name}}</h5>
                    <div class="content-product">
                        <p class="text-content"> {{ $product->type == 'sale' ? 'Bán' : 'Thuê' }}</p>
                    </div>
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
                                    @foreach ($product->images as $image)
                                        <img src="{{$image->path}}" class="thumb-img " width="70" onclick="changeImage(this)">
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <h2>Số lượng tồn kho: <span>{{ $product->productInventories->quantity }}</span></h2>
                                <h4>Giá {{ $product->type == 'sale' ? 'Bán' : 'Thuê' }}:
                                    {{ number_format($product->price, 0, ',', '.') }} đ</h4>
                            </div>
                        </div>
                        <div class="row">
                            @if ($product->productInventories->quantity)
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" onclick="addCart()">Thêm vào giỏ hàng</button>
                                </div>
                            @else
                                <span class="text-danger">Sản phẩm đã hết hàng</span>
                            @endif
                        </div>
                    </div>
                    <!-- supheading-1 -->
                    @if($product->info != '')
                        <div class="supheading">
                            <div class="polygon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                    <path
                                        d="M12.299 2.75C12.0311 2.2859 11.5359 2 11 2C10.4641 2 9.96891 2.2859 9.70096 2.75L1.90673 16.25C1.63878 16.7141 1.63878 17.2859 1.90673 17.75C2.17468 18.2141 2.66987 18.5 3.20577 18.5H18.7942C19.3301 18.5 19.8253 18.2141 20.0933 17.75C20.3612 17.2859 20.3612 16.7141 20.0933 16.25L12.299 2.75Z"
                                        fill="#295BAE" stroke="#295BAE" stroke-width="3" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <p class="text-information">{{ __('Product information') }}</p>
                        </div>
                        <div class="content-information">
                            <div>
                                {!! $product->info !!}
                            </div>
                        </div>
                    @endif
                    <!-- supheading-2 -->
                    @if($product->features != '')
                        <div class="supheading">
                            <div class="polygon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                    <path
                                        d="M12.299 2.75C12.0311 2.2859 11.5359 2 11 2C10.4641 2 9.96891 2.2859 9.70096 2.75L1.90673 16.25C1.63878 16.7141 1.63878 17.2859 1.90673 17.75C2.17468 18.2141 2.66987 18.5 3.20577 18.5H18.7942C19.3301 18.5 19.8253 18.2141 20.0933 17.75C20.3612 17.2859 20.3612 16.7141 20.0933 16.25L12.299 2.75Z"
                                        fill="#295BAE" stroke="#295BAE" stroke-width="3" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <p class="text-information">{{ __('Description and advantages') }}</p>
                        </div>
                        <div class="content-information">
                            <div>
                                {!! $product->features !!}
                            </div>
                        </div>
                    @endif
                    <!-- supheading-3 -->
                    @if($product->applications != '')
                        <div class="supheading">
                            <div class="polygon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                    <path
                                        d="M12.299 2.75C12.0311 2.2859 11.5359 2 11 2C10.4641 2 9.96891 2.2859 9.70096 2.75L1.90673 16.25C1.63878 16.7141 1.63878 17.2859 1.90673 17.75C2.17468 18.2141 2.66987 18.5 3.20577 18.5H18.7942C19.3301 18.5 19.8253 18.2141 20.0933 17.75C20.3612 17.2859 20.3612 16.7141 20.0933 16.25L12.299 2.75Z"
                                        fill="#295BAE" stroke="#295BAE" stroke-width="3" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <p class="text-information">{{ __('Applications') }}</p>
                        </div>
                        <div class="content-information">
                            <div>
                                {!! $product->applications !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="group-slide product-list">
                <div class="text-slide">
                    <h4 class="in-text-slide"> {{ __('Related products') }}</h4>
                </div>
                <div class="swiper mySwiper1">
                    <div class="swiper-wrapper">
                        <!-- Xin lỗi -->
                        @foreach($relatedProducts as $relateProduct)
                            <div class="swiper-slide">
                                <a class="link" href="{{ route('web.product.detail', ['id' => $relateProduct->id]) }}">
                                    <div>
                                        <img class="img-slide" src="{{asset($relateProduct->avatar)}}"
                                            alt="Phụ gia bê tông BMQ - Plas 02">
                                    </div>
                                    <h4 class="name-product-1">{{$relateProduct->name}}</h4>
                                    <p class="content-product-1">{!!$relateProduct->description!!}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Nút điều hướng -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                    <!-- Thanh phân trang -->
                </div>
            </div>
        </div>

    </div>

@endsection
@section('js')
    <!-- Thay đổi hình ảnh -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
                img.addEventListener("click", function () {
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

    <!-- Thêm sản phẩm vào giỏ hàng -->
    <script>
        function addCart() {
            Swal.fire({
                title: 'Xác nhận thêm vào giỏ hàng',
                html: `
                        <div class="text-start">
                            <label class="fw-bold">Tên sản phẩm:</label>
                            <input type="text" id="product_name" class="form-control mb-2" value="{{ $product->name }}" readonly>

                            <label class="fw-bold">Giá sản phẩm:</label>
                            <input type="text" id="product_price" class="form-control mb-2" value="{{ number_format($product->price, 0, ',', '.') }} đ" readonly>

                            <label class="fw-bold">Số lượng:</label>
                            <input type="number" id="quantity" class="form-control mb-2" value="1" 
                                min="1" max="{{ $product->productInventories->quantity }}"
                                oninput="updateTotalPrice()" 
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                            @if($product->type == 'rental')
                                <label class="fw-bold">Ngày bắt đầu:</label>
                                <input type="date" id="rental_start" class="form-control mb-2">

                                <label class="fw-bold">Ngày kết thúc:</label>
                                <input type="date" id="rental_end" class="form-control mb-2" onchange="updateTotalPrice()">
                            @endif

                            <label class="fw-bold">Tổng giá:</label>
                            <input type="text" id="total_price" class="form-control mb-2" value="{{ number_format($product->price, 0, ',', '.') }} đ" readonly>
                        </div>
                    `,
                showCancelButton: true,
                confirmButtonText: 'Thêm vào giỏ hàng',
                cancelButtonText: 'Hủy',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                preConfirm: () => {
                    let data = {
                        product_id: {{ $product->id }},
                        quantity: document.getElementById('quantity').value,
                        totalPrice: document.getElementById('total_price').value.replace(/[^\d]/g, '').trim(),
                        type: '{{ $product->type }}',
                    };

                    if ('{{ $product->type }}' === 'rental') {
                        data.rentalStart = document.getElementById('rental_start').value;
                        data.rentalEnd = document.getElementById('rental_end').value;
                    }

                    return data;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let data = result.value;
                    let formData = new FormData();
                    formData.append('product_id', data.product_id);
                    formData.append('quantity', data.quantity);
                    formData.append('total_price', parseFloat(data.totalPrice));
                    formData.append('type', data.type);

                    if (data.type === 'rental') {
                        formData.append('rental_start', data.rentalStart);
                        formData.append('rental_end', data.rentalEnd);
                    }

                    $.ajax({
                        url: "{{ route('api.cart.add') }}",
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thêm vào giỏ hàng thành công',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi khi thêm vào giỏ hàng',
                                text: xhr.responseJSON ? xhr.responseJSON.message : 'Lỗi không xác định'
                            });
                        }
                    });
                }
            });
        }

        // Hàm cập nhật tổng giá dựa trên số lượng
        function updateTotalPrice() {
            let quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value, 10);
            let maxQuantity = {{ $product->productInventories->quantity }};
            let price = {{ $product->price }}; // Lấy giá sản phẩm từ PHP

            // Đảm bảo số lượng nằm trong khoảng hợp lệ
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
            } else if (quantity > maxQuantity) {
                quantity = maxQuantity;
            }

            quantityInput.value = quantity; // Cập nhật lại giá trị hợp lệ

            @if($product->type == 'rental')
                let rentalStart = document.getElementById('rental_start').value;
                let rentalEnd = document.getElementById('rental_end').value;


                let startDate = new Date(rentalStart);
                let endDate = new Date(rentalEnd);

                let timeDiff = endDate - startDate; // Độ chênh lệch tính bằng milliseconds
                let daysDiff = timeDiff / (1000 * 60 * 60 * 24); // Chuyển đổi sang ngày

                if (daysDiff > 4 && daysDiff < 7) {
                    price *= 0.9; // Giảm 10% => nhân 0.9
                } else if (daysDiff > 8 && daysDiff < 14) {
                    price *= 0.85; // Giảm 15% => nhân 0.85
                } else if (daysDiff > 14) {
                    price *= 0.8; // Giảm 20% => nhân 0.8
                }
            @endif

            let totalPrice = quantity * price;

            // Cập nhật tổng giá với định dạng tiền tệ
            document.getElementById('total_price').value = totalPrice.toLocaleString('vi-VN') + " đ";
        }
    </script>
@endsection