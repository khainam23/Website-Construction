<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Cửa hàng | INGOUDE-Shopper</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/prettyPhoto.css" rel="stylesheet">
	<link href="css/price-range.css" rel="stylesheet">
	<link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
	<link rel="shortcut icon" href="images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
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
							<a href="/"><img src="images/home/logo.png" style="height: 80px; width: 80px;" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="checkout"><i class="fa fa-crosshairs"></i> Hóa đơn</a></li>
								<li><a href="cart"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>

								@if(session()->has('user'))
									@php $user = session('user'); @endphp
									<li><a href="#"><i class="fa fa-user"></i>
											{{ optional($user)['email'] ?? 'Người dùng' }}</a></li>
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
										<li><a href="checkout">Hóa đơn</a></li>
										<li><a href="cart">Giỏ hàng</a></li>
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

	<section id="advertisement" class="py-4">
		<div class="container">
			<img src="images/shop/banner.png" class="img-fluid rounded shadow"
				style="max-height: 400px; width: 100%; object-fit: cover;" alt="Banner quảng cáo">
		</div>
	</section>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Thể loại</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a href="{{ route('shop.index') }}"
											class="{{ !request('category') ? 'active' : '' }}">
											Tất cả sản phẩm
										</a>
									</h4>
								</div>
							</div>
							@foreach($categories as $category)
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											@if($category->children && $category->children->count() > 0)
												<a data-toggle="collapse" data-parent="#accordian"
													href="#category{{ $category->id }}">
													<span class="badge pull-right"><i class="fa fa-plus"></i></span>
													{{ $category->name }}
												</a>
											@else
												<a href="{{ route('shop.index', ['category' => $category->slug]) }}">
													{{ $category->name }}
												</a>
											@endif
										</h4>
									</div>
									@if($category->children && $category->children->count() > 0)
										<div id="category{{ $category->id }}" class="panel-collapse collapse">
											<div class="panel-body">
												<ul>
													@foreach($category->children as $child)
														<li>
															<a href="{{ route('shop.index', ['category' => $child->slug]) }}">
																{{ $child->name }}
															</a>
														</li>
													@endforeach
												</ul>
											</div>
										</div>
									@endif
								</div>
							@endforeach
						</div><!--/category-products-->
					</div>
				</div>

				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Thiết bị mới nhất</h2>

						@foreach($devices as $device)
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											@if($device->image)
												<img src="{{ asset('storage/' . $device->image) }}" alt="{{ $device->name }}" />
											@else
												<img src="images/shop/no-image.jpg" alt="No image available" />
											@endif
											<h2>{{ number_format($device->price, 0, ',', '.') }} VNĐ</h2>
											<p>{{ $device->name }}</p>
											<a href="#" class="btn btn-default add-to-cart"><i
													class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h2>{{ number_format($device->price, 0, ',', '.') }} VNĐ</h2>
												<p>{{ $device->name }}</p>
												<p class="small">{{ Str::limit($device->description, 100) }}</p>
												<a href="#" p-id="{{ $device->id }}" p-price="{{ $device->price }}" p-type="sales"
													class="btn btn-default add-to-cart"><i
														class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
											</div>
										</div>
									</div>
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="{{ route('devices.show', $device->id) }}"><i
														class="fa fa-info-circle"></i>Chi tiết</a></li>
											<li><a href="#" p-id="{{ $device->id }}" p-price="{{ $device->price }}" p-type="rentals"><i
														class="fa fa-plus-square"></i>Thuê</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach

						<div class="clearfix"></div>
						<ul class="pagination">
							{{ $devices->links() }}
						</ul>
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>

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
										<img src="images/home/i1.png" alt="" />
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
										<img src="images/home/i2.png" alt="" />
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
										<img src="images/home/i3.png" alt="" />
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
										<img src="images/home/i4.png" alt="" />
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
							<img src="images/home/map.png" alt="" />
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

	<script src="js/jquery.js"></script>
	<script src="js/price-range.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.prettyPhoto.js"></script>
	<script src="js/main.js"></script>

	<script>
		@php $user = session('user'); @endphp
		// Add product
		$(document).ready(function () {
			$(".add-to-cart").click(function (e) {
				e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a>

				var categoryData = {
					"user_id": "{{ optional($user)['id'] }}",
					'type': $(this).attr("p-type"),
					"items": [
						{
							"device_id": $(this).attr("p-id"),
							"quantity": 1,
							"unit_price": $(this).attr("p-price")
						}
					]
				};

				$.ajax({
					url: "/api/orders",
					type: "POST",
					contentType: "application/json",
					data: JSON.stringify(categoryData),
					headers: {
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
					},
					xhrFields: {
						withCredentials: true // Bắt buộc để cookie session hoạt động
					},
					success: function (response) {
						alert("Thêm vào giỏ hàng thành công");
					},
					error: function (xhr, status, error) {
						// alert("Cần đăng nhập");
						console.log(xhr.responseText);
						console.log(status);
						console.log(error);
						// window.location.href = "/login";
					}
				});
			});
		});
	</script>
</body>

</html>