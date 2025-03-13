<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Thống Kê Doanh Thu | INGOUDINGOUDE-Shopper</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<link href="css/statistics.css" rel="stylesheet">
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
							<a href="index.html"><img src="/images/home/logo.png" style="height: 80px; width: 80px;" alt="" /></a>
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
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="/" class="active">Trang chủ</a></li>
								<li class="dropdown"><a href="#">Cửa hàng<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="shop">Products</a></li>
										@if (session()->has('user'))
											<li><a href="checkout">Hóa đơn</a></li>
											<li><a href="cart">Giỏ hàng</a></li>
										@endif
										<li><a href="login">Truy cập</a></li>
									</ul>
								</li>
								<li><a href="contact-us">Liên hệ</a></li>
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
						<h2 class="title text-center">Báo Cáo Thống Kê Doanh Thu</h2>
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
												<h2>{{ number_format($latestReport->sales_revenue ?? 0, 1) }} Tỷ VNĐ</h2>
											</div>
										</div>

										<div class="col-md-6">
											<div class="statistic-box bg-success text-white">
												<h4><i class="fa fa-refresh"></i> Doanh Thu Cho Thuê</h4>
												<h2>{{ number_format($latestReport->rental_revenue ?? 0, 1) }} Tỷ VNĐ</h2>
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
	<script src="/js/main.js"></script>
	<script>
	$(document).ready(function () {
		// Format currency functions
		function formatCurrencyBillions(amount) {
			return amount.toFixed(1) + ' Tỷ VNĐ';
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

		// Load Revenue Table
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
			$('.loading').show(); 
			loadRevenueTable(year);
		});

		// Initialize everything when page loads
		function initializeAll() {
			// Show the main loading indicator for the page
			$('body').css('visibility', 'hidden');
			$('.loading').show();
			
			// Load revenue data
			loadRevenueTable(currentYear);
			
			// Set a small timeout to ensure all AJAX requests have completed
			setTimeout(function() {
				$('.loading').hide();
				$('body').css('visibility', 'visible');
			}, 1000);
		}

		// Call initializeAll right away
		initializeAll();

		// Set up auto-refresh every 60 seconds (optional)
		setInterval(function() {
			loadRevenueTable(currentYear);
		}, 60000);
	});
	</script>

	<style>
		.statistic-box {
			padding: 20px;
			border-radius: 5px;
			margin-bottom: 20px;
			color: white;
		}
		.bg-primary {
			background-color: #337ab7;
		}
		.bg-success {
			background-color: #5cb85c;
		}
		.text-white {
			color: white;
		}
		.statistic-box h2 {
			margin-top: 10px;
			font-weight: bold;
		}
		.table-bordered {
			border: 1px solid #ddd;
		}
		.table-bordered th {
			background-color: #f5f5f5;
			font-weight: bold;
		}
	</style>
</body>
</html>