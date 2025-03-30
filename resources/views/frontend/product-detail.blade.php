@extends('frontend.layouts.master')
@section('title', __('Product details'))

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
                        <p class="text-content"> {{ $product->type == 'sale' ? __('Sale') : __('Rental') }}</p>
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
                                <div class="image-playlist-container">
                                    <button class="playlist-nav prev-btn" id="prevImage"><i class="fas fa-chevron-left"></i></button>
                                    <div class="image-playlist-wrapper">
                                        <div class="image-playlist">
                                            <!-- Main product image as first thumbnail -->
                                            <img src="{{asset($product->avatar)}}" class="thumb-img active" width="70"
                                                onclick="changeImage(this)" data-index="0">
                                            
                                            <!-- Additional product images -->
                                            @foreach ($product->images as $index => $image)
                                                <img src="{{asset($image->path)}}" class="thumb-img" width="70"
                                                    onclick="changeImage(this)" data-index="{{ $index + 1 }}">
                                            @endforeach
                                        </div>
                                    </div>
                                    <button class="playlist-nav next-btn" id="nextImage"><i class="fas fa-chevron-right"></i></button>
                                </div>
                                <div class="image-counter">
                                    <span id="currentImage">1</span> / <span id="totalImages">{{ count($product->images) + 1 }}</span>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                @if($product->productInventories?->quantity > 0)
                                    <h2>{{ __('Stock quantity') }}: <span>{{ $product->productInventories->quantity }}</span>
                                    </h2>
                                    <h4>{{ __('Price') }} {{ $product->type == 'sale' ? __('Sale') : __('Rental') }}:
                                        {{ number_format($product->price, 0, ',', '.') }} đ
                                    </h4>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            @if ($product->productInventories?->quantity > 0)
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" onclick="addCart()">{{ __('Add to Cart') }}</button>
                                </div>
                            @else
                                <div class="alert alert-danger p-2 m-0 d-inline-block">{{ __('Sold out') }}</div>
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
                        @foreach($relatedProducts as $relateProduct)
                            <div class="swiper-slide">
                                <a class="link" href="{{ route('web.product.detail', ['id' => $relateProduct->id]) }}">
                                    <div class="img-slide">
                                        <img src="{{asset($relateProduct->avatar)}}" alt="{{$relateProduct->name}}">
                                    </div>
                                    <h4 class="name-product-1">{{$relateProduct->name}}</h4>
                                    <p class="content-product-1">
                                        {!! Str::limit(strip_tags($relateProduct->description), 80, '...') !!}
                                    </p>
                                    <div class="related-product-price">
                                        <i class="fas fa-tag"></i>
                                        <span class="price-value">{{ number_format($relateProduct->price, 0, ',', '.') }} đ</span>
                                        <span class="price-type">{{ $relateProduct->type == 'sale' ? __('Sale') : __('Rental') }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
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
    <!-- Thay đổi hình ảnh -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // === Image gallery functionality ===
            const imagePlaylist = document.querySelector('.image-playlist');
            const prevBtn = document.getElementById('prevImage');
            const nextBtn = document.getElementById('nextImage');
            const thumbImages = document.querySelectorAll('.thumb-img');
            const currentImageSpan = document.getElementById('currentImage');
            const totalImagesSpan = document.getElementById('totalImages');
            
            let currentIndex = 0;
            const totalImages = thumbImages.length;
            const visibleThumbs = 5; // Number of visible thumbnails
            const thumbWidth = 86; // Width of each thumbnail including margin
            
            // Initialize totalImages display
            if (totalImagesSpan) {
                totalImagesSpan.textContent = totalImages;
            }
            
            // Function to navigate through thumbnails
            function navigatePlaylist(direction) {
                if (direction === 'next' && currentIndex < totalImages - 1) {
                    currentIndex++;
                } else if (direction === 'prev' && currentIndex > 0) {
                    currentIndex--;
                }
                
                // Update current image counter
                if (currentImageSpan) {
                    currentImageSpan.textContent = currentIndex + 1;
                }
                
                // Update active thumbnail
                thumbImages.forEach((img, index) => {
                    img.classList.toggle('active', index === currentIndex);
                });
                
                // Select the active thumbnail
                const activeThumb = document.querySelector('.thumb-img.active');
                if (activeThumb) {
                    // Update main image
                    let mainImage = document.getElementById("mainImage");
                    mainImage.style.opacity = 0;
                    setTimeout(() => {
                        mainImage.src = activeThumb.src;
                        mainImage.style.opacity = 1;
                    }, 200);
                    
                    // Scroll thumbnail into view
                    const scrollPosition = currentIndex * thumbWidth - 
                        (document.querySelector('.image-playlist-wrapper').offsetWidth - thumbWidth) / 2;
                    
                    imagePlaylist.style.transform = `translateX(${-Math.min(
                        Math.max(0, scrollPosition),
                        thumbWidth * totalImages - document.querySelector('.image-playlist-wrapper').offsetWidth
                    )}px)`;
                }
            }
            
            // Set up event listeners for navigation buttons
            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', () => navigatePlaylist('prev'));
                nextBtn.addEventListener('click', () => navigatePlaylist('next'));
            }
            
            // Function to change the main image when clicking on a thumbnail
            window.changeImage = function(element) {
                let mainImage = document.getElementById("mainImage");
                
                // Fade effect before changing image
                mainImage.style.opacity = 0;
                setTimeout(() => {
                    mainImage.src = element.src;
                    mainImage.style.opacity = 1;
                }, 200);
                
                // Update active state and current index
                thumbImages.forEach((img, index) => {
                    img.classList.remove("active");
                    if (img === element) {
                        currentIndex = index;
                        if (currentImageSpan) {
                            currentImageSpan.textContent = currentIndex + 1;
                        }
                    }
                });
                element.classList.add("active");
                
                // Scroll the thumbnail into view
                const scrollPosition = currentIndex * thumbWidth - 
                    (document.querySelector('.image-playlist-wrapper').offsetWidth - thumbWidth) / 2;
                
                imagePlaylist.style.transform = `translateX(${-Math.min(
                    Math.max(0, scrollPosition),
                    thumbWidth * totalImages - document.querySelector('.image-playlist-wrapper').offsetWidth
                )}px)`;
            }
            
            // Make the first thumbnail active by default
            if (thumbImages.length > 0) {
                thumbImages[0].classList.add('active');
            }
            
            // === Existing Swiper Initialization === 
            var swiper1 = new Swiper(".mySwiper1", {
                slidesPerView: 3,
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

    <!-- Add product to cart -->
    <script>
        function addCart() {
            @if(!Auth::check())
                // Redirect to login page if user is not authenticated
                window.location.href = "{{ route('web.login') }}";
                return;
            @endif

            Swal.fire({
                title: "{{ __('Confirm Payment') }}",
                html: `
                    <div class="text-start">
                        <label class="fw-bold">{{ __('Product Name:') }}</label>
                        <input type="text" id="product_name" class="form-control mb-2" value="{{ $product->name }}" readonly>

                        <label class="fw-bold">{{ __('Product Price:') }}</label>
                        <input type="text" id="product_price" class="form-control mb-2" value="{{ number_format($product->price, 0, ',', '.') }} đ" readonly>

                        <label class="fw-bold">{{ __('Quantity:') }}</label>
                        <input type="number" id="quantity" class="form-control mb-2" value="1" 
                            min="1" max="{{ $product->productInventories->quantity }}"
                            oninput="updateTotalPrice()" 
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                        @if($product->type == 'rental')
                            <label class="fw-bold">{{ __('Start Date:') }}</label>
                            <input type="date" id="rental_start" class="form-control mb-2">

                            <label class="fw-bold">{{ __('End Date:') }}</label>
                            <input type="date" id="rental_end" class="form-control mb-2" onchange="updateTotalPrice()">
                            
                            <!-- Add rental discount information display -->
                            <div id="rental_discount" class="alert alert-info mb-2" style="display: none;">
                                <i class="fas fa-tag"></i> <span id="discount_text"></span>
                            </div>
                        @endif

                        <label class="fw-bold">{{ __('Total Price:') }}</label>
                        <input type="text" id="total_price" class="form-control mb-2" value="{{ number_format($product->price, 0, ',', '.') }} đ" readonly>
                    </div>
                            `,
                showCancelButton: true,
                confirmButtonText: "{{ __('Add to Cart') }}",
                cancelButtonText: "{{ __('Cancel') }}",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                didOpen: () => {
            let tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            let tomorrowDate = tomorrow.toISOString().split('T')[0];

            let startInput = document.getElementById("rental_start");
            let endInput = document.getElementById("rental_end");

            if (startInput && endInput) {
                startInput.min = tomorrowDate;
                startInput.value = tomorrowDate;
                endInput.min = tomorrowDate;
                endInput.value = tomorrowDate;
            }
        },
                preConfirm: () => {
                    let data = {
                        product_id: {{ $product->id }},
                        quantity: document.getElementById('quantity').value,
                        totalPrice: document.getElementById('total_price').value.replace(/[^\d]/g, '').trim(),
                        type: "{{ $product->type }}",
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
                                title: '{{ __('Product added to cart successfully') }}',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = "{{ route('web.profile') }}#cart";
                            });
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('Error adding to cart') }}",
                                text: xhr.responseJSON ? xhr.responseJSON.message : "{{ __('Unknown error') }}"
                            });
                        }
                    });
                }
            });
        }

        // Function to update total price based on quantity
        function updateTotalPrice() {
            let quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value, 10);
            let maxQuantity = {{ $product->productInventories->quantity }};
            let price = {{ $product->price }}; // Get product price from PHP
            let discountPercent = 0;

            // Ensure quantity is within valid range
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
            } else if (quantity > maxQuantity) {
                quantity = maxQuantity;
            }

            quantityInput.value = quantity; // Update with valid value

            @if($product->type == 'rental')
                let rentalStart = document.getElementById('rental_start').value;
                let rentalEnd = document.getElementById('rental_end').value;
                let discountElement = document.getElementById('rental_discount');
                let discountText = document.getElementById('discount_text');

                let startDate = new Date(rentalStart);
                let endDate = new Date(rentalEnd);

                let timeDiff = endDate - startDate; // Difference in milliseconds
                let daysDiff = timeDiff / (1000 * 60 * 60 * 24); // Convert to days

                // Reset discount display
                discountElement.style.display = 'none';

                if (daysDiff > 4 && daysDiff < 7) {
                    price *= 0.9; // 10% discount => multiply by 0.9
                    discountPercent = 10;
                } else if (daysDiff > 8 && daysDiff < 14) {
                    price *= 0.85; // 15% discount => multiply by 0.85
                    discountPercent = 15;
                } else if (daysDiff > 14) {
                    price *= 0.8; // 20% discount => multiply by 0.8
                    discountPercent = 20;
                }

                // Display discount information if there is a discount
                if (discountPercent > 0) {
                    discountText.innerHTML = "{{ __('Discount') }}: " + discountPercent + "% {{ __('for rental duration') }} " + Math.ceil(daysDiff) + " {{ __('days') }}";
                    discountElement.style.display = 'block';
                }
            @endif

            let totalPrice = quantity * price;

            // Update total price with currency format
            document.getElementById('total_price').value = totalPrice.toLocaleString('vi-VN') + " đ";
        }
    </script>
@endsection