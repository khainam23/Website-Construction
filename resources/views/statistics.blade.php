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
				<!-- Page Title -->
			<div class="row">
				<div class="col-sm-12">
					<div class="features_items">
						<h2 class="title text-center">Báo Cáo Thống Kê</h2>
					</div>
				</div>
			</div>

            <!-- Daily Revenue Statistics -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-calendar"></i> Thống Kê Doanh Thu Theo Ngày
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-filter"></i> Lọc <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" id="dailyFilter">
                                            <li><a href="#" data-days="7">7 ngày qua</a></li>
                                            <li><a href="#" data-days="14">14 ngày qua</a></li>
                                            <li><a href="#" data-days="30">30 ngày qua</a></li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-xs btn-default" id="refreshDaily">
                                        <i class="fa fa-refresh"></i> Làm mới
                                    </button>
                                </div>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="chart-container" style="height: 250px; margin-bottom: 20px;">
                                        <canvas id="dailyRevenueChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dailyRevenueTable">
                                    <thead>
                                        <tr>
                                            <th>Ngày</th>
                                            <th>Thứ</th>
                                            <th>Doanh Thu Bán</th>
                                            <th>Doanh Thu Thuê</th>
                                            <th>Tổng Doanh Thu</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr class="bg-info">
                                            <th colspan="2">Tổng Cộng</th>
                                            <th id="totalSalesRevenue"></th>
                                            <th id="totalRentalRevenue"></th>
                                            <th id="totalDailyRevenue"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weekly Revenue Statistics -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-calendar-check-o"></i> Thống Kê Doanh Thu Theo Tuần
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-filter"></i> Thời gian <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" id="weeklyTimeFilter">
                                            <li><a href="#" data-period="current">Tháng hiện tại</a></li>
                                            <li><a href="#" data-period="previous">Tháng trước</a></li>
                                            <li><a href="#" data-period="quarter">Quý hiện tại</a></li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-xs btn-default" id="refreshWeekly">
                                        <i class="fa fa-refresh"></i> Làm mới
                                    </button>
                                </div>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="chart-container" style="height: 250px; margin-bottom: 20px;">
                                        <canvas id="weeklyRevenueChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="weeklyRevenueTable">
                                    <thead>
                                        <tr>
                                            <th>Tuần</th>
                                            <th>Từ Ngày</th>
                                            <th>Đến Ngày</th>
                                            <th>Doanh Thu Bán</th>
                                            <th>Doanh Thu Thuê</th>
                                            <th>Tổng Doanh Thu</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr class="bg-success">
                                            <th colspan="3">Tổng Cộng</th>
                                            <th id="totalWeeklySales"></th>
                                            <th id="totalWeeklyRental"></th>
                                            <th id="totalWeeklyRevenue"></th>
                                        </tr>
                                    </tfoot>
                                </table>
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
                            <h3 class="panel-title">Danh Sách Thiết Bị</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Devices Table -->
                                    <div class="device-table-container">
                                        <table class="table table-striped table-hover" id="devicesTable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Tên</th>
                                                    <th>Danh Mục</th>
                                                    <th>Giá</th>
                                                    <th>Số Lượng</th>
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

            <!-- Sales Invoices -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Hóa Đơn Bán Hàng</h3>
                        </div>
                        <div class="panel-body"></div>
                            <div class="row">
                                <div class="col-md-12"></div>
                                    <table class="table table-striped table-hover" id="salesTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Thiết Bị</th>
                                                <th>Số Lượng</th>
                                                <th>Tổng Giá</th>
                                                <th>Ngày Bán</th>
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

            <!-- Rental Invoices -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Hóa Đơn Cho Thuê</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-hover" id="rentalsTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Thiết Bị</th>
                                                <th>Số Lượng</th>
                                                <th>Phí Thuê</th>
                                                <th>Ngày Thuê</th>
                                                <th>Ngày Trả</th>
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
        // Add currentYear declaration at the top
        const currentYear = new Date().getFullYear();
        
        // Format currency functions - Updated to display Đồng instead of ₫
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { 
                style: 'currency', 
                currency: 'VND',
                currencyDisplay: 'code'
            }).format(amount).replace('VND', 'Đồng');
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
        
        // Chart.js color configuration
        const chartColors = {
            sales: 'rgba(54, 162, 235, 0.7)',
            rental: 'rgba(75, 192, 192, 0.7)',
            total: 'rgba(255, 99, 132, 0.7)',
            borderSales: 'rgb(54, 162, 235)',
            borderRental: 'rgb(75, 192, 192)',
            borderTotal: 'rgb(255, 99, 132)'
        };
        
        let dailyRevenueChart, weeklyRevenueChart;
        let dailyFilterDays = 7; // Default: 7 days
        let weeklyPeriod = 'current'; // Default: current month
        
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

        // Functions for loading statistics
        
        // Daily Revenue statistics
        function loadDailyRevenue() {
            // Show a small loading indicator in the panel
            $('#dailyRevenueTable').closest('.panel-body').prepend(
                '<div class="text-center panel-loading"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>'
            );
            
            return $.ajax({
                url: '/api/statistics/daily-revenue',
                type: 'GET',
                data: { days: dailyFilterDays },
                success: function(data) {
                    // Remove loading indicator
                    $('.panel-loading').remove();
                    
                    let tbody = $('#dailyRevenueTable tbody');
                    tbody.empty();
                    
                    if (data && data.length > 0) {
                        let totalSales = 0, totalRental = 0, totalRevenue = 0;
                        
                        // Prepare chart data
                        const labels = [];
                        const salesData = [];
                        const rentalData = [];
                        const totalData = [];
                        
                        // Process data in reverse order to show oldest first
                        data.sort((a, b) => new Date(a.date) - new Date(b.date)).forEach(function(row) {
                            const date = new Date(row.date);
                            const formattedDate = date.toLocaleDateString('vi-VN');
                            
                            // Add to table
                            tbody.append(`
                                <tr>
                                    <td>${formattedDate}</td>
                                    <td>${row.day_name}</td>
                                    <td>${formatCurrency(row.sales_revenue)}</td>
                                    <td>${formatCurrency(row.rental_revenue)}</td>
                                    <td><strong>${formatCurrency(row.total_revenue)}</strong></td>
                                </tr>
                            `);
                            
                            // Add to chart data
                            labels.push(formattedDate);
                            salesData.push(parseFloat(row.sales_revenue));
                            rentalData.push(parseFloat(row.rental_revenue));
                            totalData.push(parseFloat(row.total_revenue));
                            
                            // Calculate totals
                            totalSales += parseFloat(row.sales_revenue);
                            totalRental += parseFloat(row.rental_revenue);
                            totalRevenue += parseFloat(row.total_revenue);
                        });
                        
                        // Update totals in footer
                        $('#totalSalesRevenue').text(formatCurrency(totalSales));
                        $('#totalRentalRevenue').text(formatCurrency(totalRental));
                        $('#totalDailyRevenue').text(formatCurrency(totalRevenue));
                        
                        // Update or create chart
                        updateDailyRevenueChart(labels, salesData, rentalData, totalData);
                        
                        // Update chart title to reflect current filter
                        if (dailyRevenueChart) {
                            dailyRevenueChart.options.plugins.title.text = `Biểu Đồ Doanh Thu ${dailyFilterDays} Ngày Qua`;
                            dailyRevenueChart.update();
                        }
                    } else {
                        tbody.append('<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>');
                        $('#totalSalesRevenue, #totalRentalRevenue, #totalDailyRevenue').text(formatCurrency(0));
                        
                        // Clear chart if no data
                        if (dailyRevenueChart) {
                            dailyRevenueChart.data.labels = [];
                            dailyRevenueChart.data.datasets.forEach(dataset => {
                                dataset.data = [];
                            });
                            dailyRevenueChart.update();
                        }
                    }
                },
                error: function(xhr) {
                    // Remove loading indicator
                    $('.panel-loading').remove();
                    
                    $('#dailyRevenueTable tbody').html(`
                        <tr><td colspan="5" class="text-center text-danger">
                            Không thể tải dữ liệu doanh thu theo ngày
                        </td></tr>
                    `);
                    $('#totalSalesRevenue, #totalRentalRevenue, #totalDailyRevenue').text(formatCurrency(0));
                }
            });
        }
        
        // Weekly Revenue statistics - FIXED FUNCTION
        function loadWeeklyRevenue() {
            // Show a small loading indicator in the panel
            $('#weeklyRevenueTable').closest('.panel-body').prepend(
                '<div class="text-center panel-loading"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>'
            );
            
            return $.ajax({
                url: '/api/statistics/weekly-revenue',
                type: 'GET',
                data: { period: weeklyPeriod },
                success: function(data) {
                    // Remove loading indicator
                    $('.panel-loading').remove();
                    
                    let tbody = $('#weeklyRevenueTable tbody');
                    tbody.empty();
                    
                    if (data && data.length > 0) {
                        let totalSales = 0, totalRental = 0, totalRevenue = 0;
                        
                        // Prepare chart data
                        const labels = [];
                        const salesData = [];
                        const rentalData = [];
                        const totalData = [];
                        
                        data.forEach(function(row) {
                            const weekLabel = `Tuần ${row.week_number}`;
                            const startDate = new Date(row.week_start).toLocaleDateString('vi-VN');
                            const endDate = new Date(row.week_end).toLocaleDateString('vi-VN');
                            
                            // Add to table
                            tbody.append(`
                                <tr>
                                    <td>${weekLabel}</td>
                                    <td>${startDate}</td>
                                    <td>${endDate}</td>
                                    <td>${formatCurrency(row.sales_revenue)}</td>
                                    <td>${formatCurrency(row.rental_revenue)}</td>
                                    <td><strong>${formatCurrency(row.total_revenue)}</strong></td>
                                </tr>
                            `);
                            
                            // Add to chart data
                            labels.push(weekLabel);
                            salesData.push(parseFloat(row.sales_revenue));
                            rentalData.push(parseFloat(row.rental_revenue));
                            totalData.push(parseFloat(row.total_revenue));
                            
                            // Calculate totals
                            totalSales += parseFloat(row.sales_revenue);
                            totalRental += parseFloat(row.rental_revenue);
                            totalRevenue += parseFloat(row.total_revenue);
                        });
                        
                        // Update totals in footer
                        $('#totalWeeklySales').text(formatCurrency(totalSales));
                        $('#totalWeeklyRental').text(formatCurrency(totalRental));
                        $('#totalWeeklyRevenue').text(formatCurrency(totalRevenue));
                        
                        // Update or create chart
                        updateWeeklyRevenueChart(labels, salesData, rentalData, totalData);
                        
                        // Update chart title to reflect current filter
                        if (weeklyRevenueChart) {
                            let periodText = 'Tháng hiện tại';
                            if (weeklyPeriod === 'previous') periodText = 'Tháng trước';
                            if (weeklyPeriod === 'quarter') periodText = 'Quý hiện tại';
                            
                            weeklyRevenueChart.options.plugins.title.text = `Biểu Đồ Doanh Thu Theo Tuần (${periodText})`;
                            weeklyRevenueChart.update();
                        }
                    } else {
                        tbody.append('<tr><td colspan="6" class="text-center">Không có dữ liệu</td></tr>');
                        $('#totalWeeklySales, #totalWeeklyRental, #totalWeeklyRevenue').text(formatCurrency(0));
                        
                        // Clear chart if no data
                        if (weeklyRevenueChart) {
                            weeklyRevenueChart.data.labels = [];
                            weeklyRevenueChart.data.datasets.forEach(dataset => {
                                dataset.data = [];
                            });
                            weeklyRevenueChart.update();
                        }
                    }
                },
                error: function(xhr) {
                    // Remove loading indicator
                    $('.panel-loading').remove();
                    
                    $('#weeklyRevenueTable tbody').html(`
                        <tr><td colspan="6" class="text-center text-danger">
                            Không thể tải dữ liệu doanh thu theo tuần
                        </td></tr>
                    `);
                    $('#totalWeeklySales, #totalWeeklyRental, #totalWeeklyRevenue').text(formatCurrency(0));
                    console.error("Weekly revenue error:", xhr.responseText);
                }
            });
        }
        
        // Create or update the daily revenue chart
        function updateDailyRevenueChart(labels, salesData, rentalData, totalData) {
            const ctx = document.getElementById('dailyRevenueChart').getContext('2d');
            
            if (dailyRevenueChart) {
                dailyRevenueChart.data.labels = labels;
                dailyRevenueChart.data.datasets[0].data = salesData;
                dailyRevenueChart.data.datasets[1].data = rentalData;
                dailyRevenueChart.data.datasets[2].data = totalData;
                dailyRevenueChart.update();
            } else {
                dailyRevenueChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Doanh Thu Bán',
                                data: salesData,
                                backgroundColor: chartColors.sales,
                                borderColor: chartColors.borderSales,
                                borderWidth: 1
                            },
                            {
                                label: 'Doanh Thu Thuê',
                                data: rentalData,
                                backgroundColor: chartColors.rental,
                                borderColor: chartColors.borderRental,
                                borderWidth: 1
                            },
                            {
                                label: 'Tổng Doanh Thu',
                                data: totalData,
                                type: 'line',
                                fill: false,
                                borderColor: chartColors.borderTotal,
                                backgroundColor: chartColors.total,
                                tension: 0.2,
                                pointBackgroundColor: chartColors.borderTotal,
                                pointBorderColor: '#fff',
                                pointRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return formatCurrency(value).replace(/\D00(?=đ)/, 'đ');
                                    }
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: `Biểu Đồ Doanh Thu ${dailyFilterDays} Ngày Qua`,
                                font: { size: 16 }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + formatCurrency(context.parsed.y);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // Weekly Revenue statistics
        function loadWeeklyRevenue() {
            // Show a small loading indicator in the panel
            $('#weeklyRevenueTable').closest('.panel-body').prepend(
                '<div class="text-center panel-loading"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>'
            );
            
            return $.ajax({
                url: '/api/statistics/weekly-revenue',
                type: 'GET',
                data: { period: weeklyPeriod }, // THIS WAS MISSING - Now sending the filter parameter
                success: function(data) {
                    // Remove loading indicator
                    $('.panel-loading').remove();
                    
                    let tbody = $('#weeklyRevenueTable tbody');
                    tbody.empty();
                    
                    if (data && data.length > 0) {
                        let totalSales = 0, totalRental = 0, totalRevenue = 0;
                        
                        // Prepare chart data
                        const labels = [];
                        const salesData = [];
                        const rentalData = [];
                        const totalData = [];
                        
                        data.forEach(function(row) {
                            const weekLabel = `Tuần ${row.week_number}`;
                            const startDate = new Date(row.week_start).toLocaleDateString('vi-VN');
                            const endDate = new Date(row.week_end).toLocaleDateString('vi-VN');
                            
                            // Add to table
                            tbody.append(`
                                <tr>
                                    <td>${weekLabel}</td>
                                    <td>${startDate}</td>
                                    <td>${endDate}</td>
                                    <td>${formatCurrency(row.sales_revenue)}</td>
                                    <td>${formatCurrency(row.rental_revenue)}</td>
                                    <td><strong>${formatCurrency(row.total_revenue)}</strong></td>
                                </tr>
                            `);
                            
                            // Add to chart data
                            labels.push(weekLabel);
                            salesData.push(parseFloat(row.sales_revenue));
                            rentalData.push(parseFloat(row.rental_revenue));
                            totalData.push(parseFloat(row.total_revenue));
                            
                            // Calculate totals
                            totalSales += parseFloat(row.sales_revenue);
                            totalRental += parseFloat(row.rental_revenue);
                            totalRevenue += parseFloat(row.total_revenue);
                        });
                        
                        // Update totals in footer
                        $('#totalWeeklySales').text(formatCurrency(totalSales));
                        $('#totalWeeklyRental').text(formatCurrency(totalRental));
                        $('#totalWeeklyRevenue').text(formatCurrency(totalRevenue));
                        
                        // Update or create chart
                        updateWeeklyRevenueChart(labels, salesData, rentalData, totalData);
                        
                        // Update chart title to reflect current filter
                        if (weeklyRevenueChart) {
                            let periodText = 'Tháng hiện tại';
                            if (weeklyPeriod === 'previous') periodText = 'Tháng trước';
                            if (weeklyPeriod === 'quarter') periodText = 'Quý hiện tại';
                            
                            weeklyRevenueChart.options.plugins.title.text = `Biểu Đồ Doanh Thu Theo Tuần (${periodText})`;
                            weeklyRevenueChart.update();
                        }
                    } else {
                        tbody.append('<tr><td colspan="6" class="text-center">Không có dữ liệu</td></tr>');
                        $('#totalWeeklySales, #totalWeeklyRental, #totalWeeklyRevenue').text(formatCurrency(0));
                        
                        // Clear chart if no data
                        if (weeklyRevenueChart) {
                            weeklyRevenueChart.data.labels = [];
                            weeklyRevenueChart.data.datasets.forEach(dataset => {
                                dataset.data = [];
                            });
                            weeklyRevenueChart.update();
                        }
                    }
                },
                error: function(xhr) {
                    // Remove loading indicator
                    $('.panel-loading').remove();
                    
                    $('#weeklyRevenueTable tbody').html(`
                        <tr><td colspan="6" class="text-center text-danger">
                            Không thể tải dữ liệu doanh thu theo tuần
                        </td></tr>
                    `);
                    $('#totalWeeklySales, #totalWeeklyRental, #totalWeeklyRevenue').text(formatCurrency(0));
                    console.error("Weekly revenue error:", xhr.responseText);
                }
            });
        }
        
        // Create or update the weekly revenue chart
        function updateWeeklyRevenueChart(labels, salesData, rentalData, totalData) {
            const ctx = document.getElementById('weeklyRevenueChart').getContext('2d');
            
            if (weeklyRevenueChart) {
                weeklyRevenueChart.data.labels = labels;
                weeklyRevenueChart.data.datasets[0].data = salesData;
                weeklyRevenueChart.data.datasets[1].data = rentalData;
                weeklyRevenueChart.data.datasets[2].data = totalData;
                weeklyRevenueChart.update();
            } else {
                weeklyRevenueChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Doanh Thu Bán',
                                data: salesData,
                                backgroundColor: chartColors.sales,
                                borderColor: chartColors.borderSales,
                                borderWidth: 1
                            },
                            {
                                label: 'Doanh Thu Thuê',
                                data: rentalData,
                                backgroundColor: chartColors.rental,
                                borderColor: chartColors.borderRental,
                                borderWidth: 1
                            },
                            {
                                label: 'Tổng Doanh Thu',
                                data: totalData,
                                type: 'line',
                                fill: false,
                                borderColor: chartColors.borderTotal,
                                backgroundColor: chartColors.total,
                                tension: 0.2,
                                pointBackgroundColor: chartColors.borderTotal,
                                pointBorderColor: '#fff',
                                pointRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return formatCurrency(value).replace(/\D00(?=đ)/, 'đ');
                                    }
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Biểu Đồ Doanh Thu Theo Tuần',
                                font: { size: 16 }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + formatCurrency(context.parsed.y);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // Device stats
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
                        tbody.append('<tr><td colspan="5" class="text-center">Không có thiết bị nào</td></tr>');
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

        // Initialize everything when page loads
        function initializeAll() {
            $('body').css('visibility', 'hidden');
            $('.loading').show();
            
            // Load all data
            Promise.all([
                loadDeviceStatsTable(),
                loadDevicesTable(),
                loadSalesInvoices(),
                loadRentalInvoices(),
                loadDailyRevenue(),
                loadWeeklyRevenue()
            ]).then(() => {
                setTimeout(function() {
                    $('.loading').hide();
                    $('body').css('visibility', 'visible');
                }, 1000);
            });
        }

        // Call initializeAll right away
        initializeAll();

        // Set up auto-refresh every 60 seconds (optional)
        setInterval(initializeAll, 60000);

        // Load Sales Invoices
        function loadSalesInvoices() {
            return $.ajax({
                url: '/api/sales',
                type: 'GET',
                success: function(data) {
                    if (!checkSession(data)) return;
                    let tbody = $('#salesTable tbody');
                    tbody.empty();
                    
                    if (!data.sales || data.sales.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center">Không có hóa đơn bán hàng</td></tr>');
                        return;
                    }
                    
                    data.sales.forEach(function(sale) {
                        const product = data.products.find(p => p.id === sale.device_id);
                        tbody.append(`
                            <tr>
                                <td>${sale.id}</td>
                                <td>${product ? product.name : 'N/A'}</td>
                                <td>${sale.quantity}</td>
                                <td>${formatCurrency(sale.total_price)}</td>
                                <td>${new Date(sale.created_at).toLocaleDateString('vi-VN')}</td>
                            </tr>
                        `);
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        $('#salesTable tbody').html(`
                            <tr><td colspan="5" class="text-center text-danger">
                                Không thể tải dữ liệu hóa đơn bán hàng
                            </td></tr>
                        `);
                    }
                }
            });
        }

        // Load Rental Invoices
        function loadRentalInvoices() {
            return $.ajax({
                url: '/api/rentals',
                type: 'GET',
                success: function(data) {
                    if (!checkSession(data)) return;
                    let tbody = $('#rentalsTable tbody');
                    tbody.empty();
                    
                    if (!data.rentals || data.rentals.length === 0) {
                        tbody.append('<tr><td colspan="6" class="text-center">Không có hóa đơn cho thuê</td></tr>');
                        return;
                    }
                    
                    data.rentals.forEach(function(rental) {
                        const product = data.products.find(p => p.id === rental.device_id);
                        tbody.append(`
                            <tr>
                                <td>${rental.id}</td>
                                <td>${product ? product.name : 'N/A'}</td>
                                <td>${rental.quantity}</td>
                                <td>${formatCurrency(rental.rental_fee)}</td>
                                <td>${new Date(rental.rental_date).toLocaleDateString('vi-VN')}</td>
                                <td>${new Date(rental.return_date).toLocaleDateString('vi-VN')}</td>
                            </tr>
                        `);
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        $('#rentalsTable tbody').html(`
                            <tr><td colspan="6" class="text-center text-danger">
                                Không thể tải dữ liệu hóa đơn cho thuê
                            </td></tr>
                        `);
                    }
                }
            });
        }

        // Add filters for daily revenue with visual feedback - FIXED EVENT HANDLER
        $('#dailyFilter a').click(function(e) {
            e.preventDefault();
            const newDays = $(this).data('days');
            
            // Only reload if the filter actually changed
            if (dailyFilterDays !== newDays) {
                dailyFilterDays = newDays;
                
                // Update filter button text to show current selection
                const filterText = $(this).text();
                $(this).closest('.btn-group').find('button.dropdown-toggle').html(
                    `<i class="fa fa-filter"></i> ${filterText} <span class="caret"></span>`
                );
                
                // Load data with new filter
                loadDailyRevenue();
            }
        });

        // Add filters for weekly revenue with visual feedback - FIXED EVENT HANDLER
        $('#weeklyTimeFilter a').click(function(e) {
            e.preventDefault();
            const newPeriod = $(this).data('period');
            
            // Only reload if the filter actually changed
            if (weeklyPeriod !== newPeriod) {
                weeklyPeriod = newPeriod;
                
                // Update filter button text to show current selection
                const filterText = $(this).text();
                $(this).closest('.btn-group').find('button.dropdown-toggle').html(
                    `<i class="fa fa-filter"></i> ${filterText} <span class="caret"></span>`
                );
                
                // Load data with new filter
                loadWeeklyRevenue();
            }
        });

        // Add refresh button handlers - FIXED DUPLICATE EVENT HANDLERS
        $('#refreshDaily').click(function() {
            loadDailyRevenue();
        });

        $('#refreshWeekly').click(function() {
            loadWeeklyRevenue();
        });
    });
</script>
</body>

</html>