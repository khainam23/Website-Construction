<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Trang chủ | INGOUDINGOUDE-Shopper</title>
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
	<style>
    body {
        visibility: hidden; /* Initially hide the body until data is loaded */
    }
    
    .loading {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 6px solid #f3f3f3;
        border-top: 6px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    .loading-text {
        position: absolute;
        margin-top: 80px;
        font-weight: bold;
        color: #3498db;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* ...existing styles... */
</style>
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
											<div class="statistic-box bg-primary text-white">
												<h4><i class="fa fa-money"></i> Doanh Thu Bán Hàng</h4>
												<h2>{{ number_format($latestReport->sales_revenue ?? 0, 1) }} Tỷ VNĐ
												</h2>
											</div>
										</div>

										<div class="col-md-6">
											<div class="statistic-box bg-success text-white">
												<h4><i class="fa fa-refresh"></i> Doanh Thu Cho Thuê</h4>
												<h2>{{ number_format($latestReport->rental_revenue ?? 0, 1) }} Tỷ VNĐ
												</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			 <!-- Revenue Statistics -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Thống Kê Doanh Thu</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Tháng</th>
                                                <th>Doanh Thu Bán Hàng</th>
                                                <th>Doanh Thu Cho Thuê</th>
                                                <th>Tổng Doanh Thu</th>
                                            </tr>
                                        </thead>
                                        <tbody id="revenueTableBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Device Statistics -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Thống Kê Thiết Bị</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Danh Mục</th>
                                                <th>Số Lượng Thiết Bị</th>
                                                <th>Giá Trị Tồn Kho</th>
                                                <th>Tỷ Lệ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="deviceStatsTableBody">
                                        </tbody>
                                    </table>
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
							<div class="row">
								<div class="col-md-4">
									<!-- Add Device Form -->
									<div class="device-form-container">
										<h4 class="section-subtitle"><i class="fa fa-plus-circle"></i> Thêm Thiết Bị Mới</h4>
										<form id="deviceForm" class="form-horizontal" enctype="multipart/form-data">
											@csrf
											<div class="form-group">
												<label>Tên Thiết Bị</label>
												<input type="text" class="form-control" name="name" required placeholder="Nhập tên thiết bị">
											</div>
											<div class="form-group">
												<label>Danh Mục</label>
												<select class="form-control" name="category_id" required>
													<option value="">-- Chọn Danh Mục --</option>
													@foreach($categories as $category)
														<option value="{{ $category->id }}">{{ $category->name }}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<label>Giá (VNĐ)</label>
												<input type="number" class="form-control" name="price" required min="0" placeholder="Nhập giá thiết bị">
											</div>
											<div class="form-group">
												<label>Số Lượng</label>
												<input type="number" class="form-control" name="stock" required min="0" placeholder="Nhập số lượng">
											</div>
											<div class="form-group">
												<label>Mô Tả</label>
												<textarea class="form-control" name="description" rows="4" placeholder="Mô tả chi tiết về thiết bị"></textarea>
											</div>
											<div class="form-group">
												<label>Hình Ảnh</label>
												<input type="file" class="form-control" name="image" accept="image/*">
												<p class="help-block">Chọn hình ảnh thiết bị (JPG, PNG)</p>
											</div>
											<div class="form-group">
												<button type="submit" class="btn btn-primary btn-block">
													<i class="fa fa-plus"></i> Thêm Thiết Bị
												</button>
											</div>
										</form>
									</div>
								</div>
								
								<div class="col-md-8">
									<!-- Devices Table -->
									<div class="device-table-container">
										<h4 class="section-subtitle"><i class="fa fa-list"></i> Danh Sách Thiết Bị</h4>
										<div class="table-responsive">
											<table class="table table-striped table-hover" id="devicesTable">
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
					</div>
				</div>
			</div>

			<!-- Edit Device Modal -->
			<div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title"><i class="fa fa-edit"></i> Chỉnh Sửa Thiết Bị</h4>
						</div>
						<div class="modal-body">
							<form id="editDeviceForm" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="device_id" id="edit_device_id">
								<div class="form-group">
									<label>Tên Thiết Bị</label>
									<input type="text" class="form-control" id="edit_name" name="name" required>
								</div>
								<div class="form-group">
									<label>Danh Mục</label>
									<select class="form-control" id="edit_category_id" name="category_id" required>
										@foreach($categories as $category)
											<option value="{{ $category->id }}">{{ $category->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Giá (VNĐ)</label>
									<input type="number" class="form-control" id="edit_price" name="price" required>
								</div>
								<div class="form-group">
									<label>Số Lượng</label>
									<input type="number" class="form-control" id="edit_stock" name="stock" required>
								</div>
								<div class="form-group">
									<label>Mô Tả</label>
									<textarea class="form-control" id="edit_description" name="description" rows="4"></textarea>
								</div>
								<div class="form-group">
									<label>Hình Ảnh</label>
									<input type="file" class="form-control" name="image">
									<p class="help-block">Để trống nếu không muốn thay đổi hình ảnh</p>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">
								<i class="fa fa-times"></i> Đóng
							</button>
							<button type="button" class="btn btn-primary" id="saveDeviceChanges">
								<i class="fa fa-save"></i> Lưu Thay Đổi
							</button>
						</div>
					</div>
				</div>
			</div>

		</div>
		</div>
	</section>

	<!-- Add loading indicator -->
	<div class="loading" style="display: none;">
		<div class="loading-spinner"></div>
		<div class="loading-text">Đang tải dữ liệu thống kê...</div>
	</div>

	<!-- BODY SECTION END -->

	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>INGOUDE</span>-shopper</h2>
							<p>INGOUDINGOUDE-Shopper là nền tảng cung cấp máy móc, thiết bị công trình chất lượng cao,
								giúp
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
								<div class="video-gallery text-center">
									<a href="#">
										<div class="iframe-img">
											<img src="/images/home/i3.png" alt="" />
										</div>
										<div class="overlay-icon">
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
						<p class="pull-right">Designed by <span><a target="_blank" href="#">PND</a></span></p>
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
    $(document).ready(function () {
        // Format currency functions
        function formatCurrencyBillions(amount) {
            return amount.toFixed(1) + ' Tỷ VNĐ';
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }

        // Loading indicator
        $(document).ajaxStart(function () {
            $('.loading').show();
        });

        $(document).ajaxComplete(function () {
            $('.loading').hide();
        });

        // Initially show the loading indicator until all data is loaded
        $('.loading').show();
        
        // AJAX setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Session check
        function checkSession(response) {
            if (response === 'Unauthorized' || response.status === 401) {
                window.location.href = '/login';
                return false;
            }
            return true;
        }

        // Load Statistics Tables
        function loadRevenueTable(year = new Date().getFullYear()) {
            return $.ajax({
                url: '/api/statistics/monthly-revenue',
                type: 'GET',
                data: { year: year },
                success: function(data) {
                    let tbody = $('#revenueTableBody');
                    tbody.empty();
                    
                    if (data && data.length > 0) {
                        data.forEach(function(row) {
                            tbody.append(`
                                <tr>
                                    <td>Tháng ${row.month}</td>
                                    <td>${formatCurrencyBillions(row.sales_revenue)}</td>
                                    <td>${formatCurrencyBillions(row.rental_revenue)}</td>
                                    <td>${formatCurrencyBillions(row.total_revenue)}</td>
                                </tr>
                            `);
                        });
                    } else {
                        tbody.append(`<tr><td colspan="4" class="text-center">Chưa có dữ liệu báo cáo</td></tr>`);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading revenue data:', xhr);
                    $('#revenueTableBody').html(`
                        <tr><td colspan="4" class="text-center text-danger">
                            Không thể tải dữ liệu. Vui lòng thử lại sau.
                        </td></tr>
                    `);
                }
            });
        }

        function loadDeviceStatsTable() {
            return $.ajax({
                url: '/api/statistics/device-stats',
                type: 'GET',
                success: function(data) {
                    let tbody = $('#deviceStatsTableBody');
                    tbody.empty();
                    
                    if (data && data.length > 0) {
                        data.forEach(function(row) {
                            tbody.append(`
                                <tr>
                                    <td>${row.category}</td>
                                    <td>${row.device_count}</td>
                                    <td>${formatCurrency(row.inventory_value)}</td>
                                    <td>${row.percentage}%</td>
                                </tr>
                            `);
                        });
                    } else {
                        tbody.append(`<tr><td colspan="4" class="text-center">Chưa có dữ liệu thống kê</td></tr>`);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading device stats:', xhr);
                    $('#deviceStatsTableBody').html(`
                        <tr><td colspan="4" class="text-center text-danger">Không thể tải dữ liệu. Vui lòng thử lại sau.</td></tr>
                    `);
                }
            });
        }

        // Load Devices Table
        function loadDevicesTable() {
            return $.ajax({
                url: '/api/devices',
                type: 'GET',
                success: function(data) {
                    if (!checkSession(data)) return;
                    let tbody = $('#devicesTable tbody');
                    tbody.empty();
                    
                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="6" class="text-center">Không có thiết bị nào</td></tr>');
                        return;
                    }
                    
                    data.forEach(function(device) {
                        tbody.append(`
                            <tr>
                                <td>${device.id}</td>
                                <td>${device.name}</td>
                                <td>${device.category ? device.category.name : 'N/A'}</td>
                                <td>${formatCurrency(device.price)}</td>
                                <td>${device.stock}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-device btn-action" data-id="${device.id}" title="Chỉnh sửa">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-device btn-action" data-id="${device.id}" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </button>
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

        // Add year selector
        let currentYear = new Date().getFullYear();
        let yearSelector = $(`
            <div class="form-group">
                <label>Chọn Năm:</label>
                <select id="yearSelector" class="form-control" style="width:auto; display:inline-block; margin-left:10px;">
                    <option value="2023">2023</option>
                    <option value="2024" selected>2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
        `);
        
        $('.panel-heading:contains("Thống Kê Doanh Thu")').append(yearSelector);
        
        // Year change event
        $('#yearSelector').change(function() {
            let year = $(this).val();
            $('.loading').show(); // Show loading when changing year
            loadRevenueTable(year).always(function() {
                $('.loading').hide(); // Hide loading after data is loaded
            });
        });

        // Initialize everything when page loads
        function initializeAll() {
            // Show the main loading indicator for the page
            $('body').css('visibility', 'hidden');
            $('.loading').show();
            
            // Use Promise.all to load all data concurrently
            Promise.all([
                loadRevenueTable(currentYear),
                loadDeviceStatsTable(),
                loadDevicesTable()
            ]).then(() => {
                // Hide loading indicator when all data is loaded and show the page
                $('.loading').hide();
                $('body').css('visibility', 'visible');
            }).catch(error => {
                console.error("Error loading data:", error);
                $('.loading').hide();
                $('body').css('visibility', 'visible');
                alert("Có lỗi xảy ra khi tải dữ liệu. Vui lòng tải lại trang.");
            });
        }

        // Call initializeAll right away
        initializeAll();

        // Set up auto-refresh every 60 seconds (optional)
        setInterval(initializeAll, 60000);

        // Event handlers
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
                    
                    // Refresh all tables after adding a device
                    initializeAll();
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

        // Delete device
        $(document).on('click', '.delete-device', function() {
            if (confirm('Bạn có chắc muốn xóa thiết bị này?')) {
                let id = $(this).data('id');
                $.ajax({
                    url: '/api/devices/' + id,
                    type: 'DELETE',
                    success: function() {
                        alert('Thiết bị đã được xóa');
                        
                        // Refresh all tables after deleting a device
                        initializeAll();
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

        // Edit device - open modal and populate data
        $(document).on('click', '.edit-device', function() {
            let deviceId = $(this).data('id');
            
            // Get device details
            $.ajax({
                url: '/api/devices/' + deviceId,
                type: 'GET',
                success: function(device) {
                    $('#edit_device_id').val(device.id);
                    $('#edit_name').val(device.name);
                    $('#edit_category_id').val(device.category_id);
                    $('#edit_price').val(device.price);
                    $('#edit_stock').val(device.stock);
                    $('#edit_description').val(device.description);
                    
                    $('#editDeviceModal').modal('show');
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Không thể tải thông tin thiết bị: ' + xhr.responseJSON?.error || 'Lỗi không xác định');
                    }
                }
            });
        });

        // Save edited device
        $('#saveDeviceChanges').click(function() {
            let formData = new FormData($('#editDeviceForm')[0]);
            let deviceId = $('#edit_device_id').val();
            
            $.ajax({
                url: '/api/devices/' + deviceId,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editDeviceModal').modal('hide');
                    alert('Thiết bị đã được cập nhật thành công');
                    
                    // Refresh all tables after updating a device
                    initializeAll();
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Không thể cập nhật thiết bị: ' + xhr.responseJSON?.error || 'Lỗi không xác định');
                    }
                }
            });
        });
    });
</script>

<style>
	.section-subtitle {
		margin-bottom: 20px;
		padding-bottom: 10px;
		border-bottom: 1px solid #eee;
		color: #555;
		font-weight: 600;
	}
	.device-form-container {
		background-color: #f9f9f9;
		padding: 15px;
		border-radius: 5px;
		border: 1px solid #eee;
		height: 100%;
	}
	.device-table-container {
		background-color: #ffffff;
		padding: 15px;
		border-radius: 5px;
		border: 1px solid #eee;
		box-shadow: 0 1px 3px rgba(0,0,0,0.1);
	}
	#devicesTable thead {
		background-color: #f5f5f5;
	}
	#devicesTable th {
		font-weight: 600;
	}
	.btn-action {
		margin: 2px;
	}
	.modal-header {
		background-color: #f8f8f8;
		border-bottom: 1px solid #e5e5e5;
	}
	.modal-footer {
		background-color: #f8f8f8;
		border-top: 1px solid #e5e5e5;
	}
	.help-block {
		font-size: 12px;
		color: #777;
		margin-top: 5px;
	}
</style>
</body>

</html>