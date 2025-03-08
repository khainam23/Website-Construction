<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Trang chủ  | INGOUDINGOUDE-Shopper</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/prettyPhoto.css" rel="stylesheet">
	<link href="css/price-range.css" rel="stylesheet">
	<link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<link href="css/statistics.css" rel="stylesheet">
	<style>
		.loading {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(255, 255, 255, 0.8);
			display: flex;
			justify-content: center;
			align-items: center;
			z-index: 9999;
		}

		.loading-spinner {
			width: 50px;
			height: 50px;
			border: 5px solid #f3f3f3;
			border-top: 5px solid #3498db;
			border-radius: 50%;
			animation: spin 1s linear infinite;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}
	</style>
	<!--[if lt IE 9]>token" content="{{ csrf_token() }}">
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
	<link rel="shortcut icon" href="/images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +84 123456789</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.html"><img src="/images/home/logo.png" style="height: 80px; width: 80px;"
									alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								@if(session()->has('user'))
									@php $user = session('user'); @endphp
									<li><a href="#"><i class="fa fa-user"></i> {{ $user['email'] }}</a></li>
									<li><a href="/api/logout"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
								@else
									<li><a href="login"><i class="fa fa-lock"></i> Truy cập</a></li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse"
								data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="/" class="active">Trang chủ </a></li>
								<li class="dropdown"><a href="#">Cửa hàng<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="shop.html">Products</a></li>
										<li><a href="product-details.html">Product Details</a></li>
										<li><a href="checkout.html">Hóa đơn</a></li>
										<li><a href="cart.html">Giỏ hàng</a></li>
										<li><a href="login.html">Truy cập</a></li>
									</ul>
								</li>
								
								<li><a href="contact-us.html">Liên hệ</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

	<!-- BODY SECTION START -->
	@if(session('error'))
	<div class="alert alert-danger">
		{{ session('error') }}
	</div>
	@endif

	<section id="revenue-report">
    <div class="container">
        <!-- Overall Statistics -->
        <div class="row">
            <div class="col-sm-12">
                <div class="features_items">
                    <h2 class="title text-center">Báo Cáo Thống Kê</h2>
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Tổng Quan</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="statistic-box bg-primary">
                                            <h4><i class="fa fa-money"></i> Doanh Thu Bán Hàng</h4>
                                            <h2>{{ number_format($latestReport->sales_revenue, 1) }} Tỷ VNĐ</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="statistic-box bg-success">
                                            <h4><i class="fa fa-refresh"></i> Doanh Thu Cho Thuê</h4>
                                            <h2>{{ number_format($latestReport->rental_revenue, 1) }} Tỷ VNĐ</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Device Management Section -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Quản Lý Thiết Bị</h3>
                    </div>
                    <div class="panel-body">
                        <!-- Add Device Form -->
                        <form id="deviceForm" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tên Thiết Bị</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Danh Mục</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="category_id" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Giá</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="price" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Số Lượng</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="stock" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Mô Tả</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Hình Ảnh</label>
                                <div class="col-sm-10"></div>
                                    <input type="file" class="form-control" name="image">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Thêm Thiết Bị</button>
                                </div>
                            </div>
                        </form>

                        <!-- Devices Table -->
                        <table class="table table-striped" id="devicesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Danh Mục</th>
                                    <th>Giá</th>
                                    <th>Số Lượng</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add loading indicator -->
<div class="loading" style="display: none;">
    <div class="loading-spinner"></div>
</div>

<!-- BODY SECTION END -->

	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>INGOUDE</span>-shopper</h2>
							<p>INGOUDINGOUDE-Shopper là nền tảng cung cấp máy móc, thiết bị công trình chất lượng cao, giúp
								khách hàng dễ dàng tìm kiếm và lựa chọn sản phẩm phù hợp. Với đa dạng thương hiệu uy
								tín, dịch vụ tư vấn chuyên sâu và chính sách bảo hành minh bạch, chúng tôi cam kết mang
								đến trải nghiệm mua sắm tối ưu cho doanh nghiệp và cá nhân trong ngành xây dựng.</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="/images/home/i1.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Vận tải xe hạng nặng</p>
								<h2>24/12/2024</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="/images/home/i2.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Mẫu xe mới</p>
								<h2>24/12/2024</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center"></div>
								<a href="#">
									<div class="iframe-img">
										<img src="/images/home/i3.png" alt="" />
									</div>
									<div class="overlay-icon"></div></div>
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Đánh giá chất lượng</p>
								<h2>24/12/2024</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="/images/home/i4.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Mẫu máy mạnh</p>
								<h2>24/12/2024</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="/images/home/map.png" alt="" />
							<p>Việt Nam, Thành Phố Hồ Chí Minh, Thành Phố Hà Nội, Đà Nẵng</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Dịch vụ</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Hỗ trợ trực tuyến</a></li>
								<li><a href="#">Liên hệ chúng tôi</a></li>
								<li><a href="#">Tình trạng đơn hàng</a></li>
								<li><a href="#">TKhu vực</a></li>
								<li><a href="#">Câu hỏi thường gặp</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Mặt hàng</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Máy xúc</a></li>
								<li><a href="#">Máy ủi</a></li>
								<li><a href="#">Cần cẩu</a></li>
								<li><a href="#">Phụ tùng & Linh kiện</a></li>
								<li><a href="#">Thiết bị bảo hộ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Chính sách</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Điều khoản sử dụng</a></li>
								<li><a href="#">Chính sách bảo mật</a></li>
								<li><a href="#">Chính sách hoàn tiền</a></li>
								<li><a href="#">Hệ thống thanh toán</a></li>
								<li><a href="#">Hỗ trợ & Bảo hành</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Tổng quan về website</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Thông tin công ty</a></li>
								<li><a href="#">Cơ hội nghề nghiệp</a></li>
								<li><a href="#">Địa điểm kho bãi</a></li>
								<li><a href="#">Chương trình đối tác</a></li>
								<li><a href="#">Bản quyền & Sở hữu trí tuệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>Thông tin</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i
										class="fa fa-arrow-circle-o-right"></i></button>
								<p>Nhận các <br />thông tin và thông báo mới nhất từ chúng tôi...</p>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2025 INGOUDINGOUDE-Shopper Inc. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank"
								href="#">PND</a></span></p>
				</div>
			</div>
		</div>

	</footer><!--/Footer-->

	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/jquery.scrollUp.min.js"></script>
	<script src="/js/price-range.js"></script>
	<script src="/js/jquery.prettyPhoto.js"></script>
	<script src="/js/main.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
	$(document).ready(function() {
    // Show loading indicator
    $(document).ajaxStart(function() {
        $('.loading').show();
    });

    $(document).ajaxComplete(function() {
        $('.loading').hide();
    });

    // Add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Check session status before making AJAX calls
    function checkSession(response) {
        if (response === 'Unauthorized' || response.status === 401) {
            window.location.href = '/login';
            return false;
        }
        return true;
    }

    // Device management functionality
    function loadDevices() {
        $.ajax({
            url: '/api/devices',
            type: 'GET',
            success: function(data) {
                if (!checkSession(data)) return;
                let tbody = $('#devicesTable tbody');
                tbody.empty();
                data.forEach(function(device) {
                    tbody.append(`
                        <tr>
                            <td>${device.id}</td>
                            <td>${device.name}</td>
                            <td>${device.category ? device.category.name : 'N/A'}</td>
                            <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(device.price)}</td>
                            <td>${device.stock}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-device" data-id="${device.id}">Sửa</button>
                                <button class="btn btn-sm btn-danger delete-device" data-id="${device.id}">Xóa</button>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    window.location.href = '/login';
                } else {
                    console.error('Error loading devices:', error);
                    alert('Không thể tải danh sách thiết bị. Vui lòng thử lại sau.');
                }
            }
        });
    }

    // Initial load
    loadDevices();

    // Rest of device management code remains unchanged
    // ...existing device management code...
});

$(document).ready(function() {
    // Add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Device management functionality with error handling
    function loadDevices() {
        $.ajax({
            url: '/api/devices',
            type: 'GET',
            success: function(data) {
                let tbody = $('#devicesTable tbody');
                tbody.empty();
                data.forEach(function(device) {
                    tbody.append(`
                        <tr>
                            <td>${device.id}</td>
                            <td>${device.name}</td>
                            <td>${device.category ? device.category.name : 'N/A'}</td>
                            <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(device.price)}</td>
                            <td>${device.stock}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-device" data-id="${device.id}">Sửa</button>
                                <button class="btn btn-sm btn-danger delete-device" data-id="${device.id}">Xóa</button>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '/login';
                } else {
                    alert('Không thể tải danh sách thiết bị: ' + xhr.responseJSON?.error || 'Lỗi không xác định');
                }
            }
        });
    }

    // Device form submission with authentication
    $('#deviceForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        
        $.ajax({
            url: '/api/devices',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert('Thiết bị đã được thêm thành công');
                $('#deviceForm')[0].reset();
                loadDevices();
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '/login';
                } else {
                    alert('Không thể thêm thiết bị: ' + xhr.responseJSON?.error || 'Lỗi không xác định');
                }
            }
        });
    });

    // Delete device with authentication
    $(document).on('click', '.delete-device', function() {
        if (confirm('Bạn có chắc muốn xóa thiết bị này?')) {
            let id = $(this).data('id');
            $.ajax({
                url: '/api/devices/' + id,
                type: 'DELETE',
                success: function() {
                    alert('Thiết bị đã được xóa');
                    loadDevices();
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Không thể xóa thiết bị: ' + xhr.responseJSON?.error || 'Lỗi không xác định');
                    }
                }
            });
        }
    });

    // Initial load if user is admin
    if (@json(session('user.role') === 'admin')) {
        loadDevices();
    }
});
</script>

<script>
$(document).ready(function() {
    // Device management functionality without auth checks
    function loadDevices() {
        $.ajax({
            url: '/api/devices',
            type: 'GET',
            success: function(data) {
                let tbody = $('#devicesTable tbody');
                tbody.empty();
                data.forEach(function(device) {
                    tbody.append(`
                        <tr>
                            <td>${device.id}</td>
                            <td>${device.name}</td>
                            <td>${device.category ? device.category.name : 'N/A'}</td>
                            <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(device.price)}</td>
                            <td>${device.stock}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-device" data-id="${device.id}">Sửa</button>
                                <button class="btn btn-sm btn-danger delete-device" data-id="${device.id}">Xóa</button>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function(xhr) {
                alert('Không thể tải danh sách thiết bị: ' + (xhr.responseJSON?.message || 'Lỗi không xác định'));
            }
        });
    }

    // Load devices immediately
    loadDevices();
});
</script>
</body>

</html>