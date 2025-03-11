<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <title>Nhà | INGOUDINGOUDE-Shopper</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/images/ico/apple-touch-icon-57-precomposed.png">
    <title>Quản Lý Thiết Bị | INGOUDINGOUDE-Shopper</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .equipment-card {
            transition: transform 0.3s;
            height: 100%;
        }

        .equipment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .filter-section {
            background-color: #f8f9fa;
            border-radius: 10px;
        }

        .status-available {
            color: #28a745;
        }

        .status-rented {
            color: #dc3545;
        }

        .status-maintenance {
            color: #ffc107;
        }

        .dashboard-card {
            border-left: 4px solid;
            transition: transform 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .bg-gradient-primary {
            background: linear-gradient(to right, #4e73df, #224abe);
        }

        .bg-gradient-success {
            background: linear-gradient(to right, #1cc88a, #13855c);
        }

        .bg-gradient-info {
            background: linear-gradient(to right, #36b9cc, #258391);
        }

        .bg-gradient-warning {
            background: linear-gradient(to right, #f6c23e, #dda20a);
        }
    </style>
</head>

<body>
    <!-- Header would go here -->

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <!-- Dashboard Overview -->
        <section class="mb-4">
            <h2 class="mb-3">Tổng Quan Thiết Bị</h2>
            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100 py-2 dashboard-card" style="border-left-color: #4e73df;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Tổng Thiết Bị</div>
                                    <div id="overview-devices" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tools fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100 py-2 dashboard-card" style="border-left-color: #1cc88a;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Đang Cho Thuê</div>
                                    <div id="rental-devices" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow h-100 py-2 dashboard-card" style="border-left-color: #36b9cc;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Sẵn Sàng</div>
                                    <div id="sale-devices" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="mb-4">
            <div class="d-flex flex-column">
                <div class="col-md-8">
                    <h2 class="mb-3">Quản Lý Thiết Bị</h2>
                </div>
                <div class="col-md-4 mx-auto text-center">
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
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Thêm Thiết Bị</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Search and Filter -->
        <section class="mb-4">
            <div class="card shadow">
                <div class="card-body filter-section">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Tìm kiếm thiết bị...">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <select class="form-control" name="category_id" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <select class="form-select">
                                        <option>Sẵn sàng</option>
                                        <option>Đang cho thuê</option>
                                        <option>Đang bán</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Equipment List -->
        <section id="list-devices" class="mb-5">
        </section>

        <!-- Recent Transactions -->
        <section class="mb-4">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary fw-bold">Giao Dịch Gần Đây</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Mã GD</th>
                                    <th scope="col">Khách Hàng</th>
                                    <th scope="col">Thiết Bị</th>
                                    <th scope="col">Loại</th>
                                    <th scope="col">Ngày Bắt Đầu</th>
                                    <th scope="col">Ngày Kết Thúc</th>
                                    <th scope="col">Giá Trị</th>
                                    <th scope="col">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>GD-2023-001</td>
                                    <td>Công ty TNHH Xây dựng Phú Thành</td>
                                    <td>Máy Ủi Komatsu D65EX</td>
                                    <td><span class="badge bg-info">Cho thuê</span></td>
                                    <td>15/05/2023</td>
                                    <td>30/06/2023</td>
                                    <td>285.200.000đ</td>
                                    <td><span class="badge bg-success">Đang thực hiện</span></td>
                                </tr>
                                <tr>
                                    <td>GD-2023-002</td>
                                    <td>Công ty CP Đầu tư Xây dựng Minh Anh</td>
                                    <td>Máy Trộn Bê Tông Hino</td>
                                    <td><span class="badge bg-info">Cho thuê</span></td>
                                    <td>20/05/2023</td>
                                    <td>20/07/2023</td>
                                    <td>210.000.000đ</td>
                                    <td><span class="badge bg-success">Đang thực hiện</span></td>
                                </tr>
                                <tr>
                                    <td>GD-2023-003</td>
                                    <td>Công ty TNHH Xây dựng Thành Công</td>
                                    <td>Xe Tải Howo 25 Tấn</td>
                                    <td><span class="badge bg-danger">Bán</span></td>
                                    <td>22/05/2023</td>
                                    <td>-</td>
                                    <td>950.000.000đ</td>
                                    <td><span class="badge bg-primary">Hoàn thành</span></td>
                                </tr>
                                <tr>
                                    <td>GD-2023-004</td>
                                    <td>Công ty CP Xây dựng và Phát triển Hạ tầng</td>
                                    <td>Máy Xúc Caterpillar 320D</td>
                                    <td><span class="badge bg-info">Cho thuê</span></td>
                                    <td>01/06/2023</td>
                                    <td>15/06/2023</td>
                                    <td>82.500.000đ</td>
                                    <td><span class="badge bg-warning">Đã đặt cọc</span></td>
                                </tr>
                                <tr>
                                    <td>GD-2023-005</td>
                                    <td>Công ty TNHH MTV Xây dựng Tân Phát</td>
                                    <td>Máy Đào Hitachi ZX200</td>
                                    <td><span class="badge bg-info">Cho thuê</span></td>
                                    <td>05/06/2023</td>
                                    <td>20/06/2023</td>
                                    <td>87.000.000đ</td>
                                    <td><span class="badge bg-secondary">Chờ xác nhận</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="#" class="btn btn-sm btn-outline-primary">Xem tất cả giao dịch</a>
                </div>
            </div>
        </section>

        <!-- Maintenance Schedule -->
        <section class="mb-4">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary fw-bold">Lịch Bảo Trì Thiết Bị</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Mã Thiết Bị</th>
                                    <th scope="col">Tên Thiết Bị</th>
                                    <th scope="col">Loại Bảo Trì</th>
                                    <th scope="col">Ngày Bắt Đầu</th>
                                    <th scope="col">Dự Kiến Hoàn Thành</th>
                                    <th scope="col">Kỹ Thuật Viên</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CR-LIE-LTM</td>
                                    <td>Cần Cẩu Liebherr LTM</td>
                                    <td>Bảo dưỡng định kỳ</td>
                                    <td>01/06/2023</td>
                                    <td>10/06/2023</td>
                                    <td>Nguyễn Văn A</td>
                                    <td><span class="badge bg-warning">Đang thực hiện</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-success"><i
                                                class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>GN-CUM-500KVA</td>
                                    <td>Máy Phát Điện Cummins</td>
                                    <td>Sửa chữa</td>
                                    <td>03/06/2023</td>
                                    <td>15/06/2023</td>
                                    <td>Trần Văn B</td>
                                    <td><span class="badge bg-warning">Đang thực hiện</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-success"><i
                                                class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>EX-CAT-320D</td>
                                    <td>Máy Xúc Caterpillar 320D</td>
                                    <td>Bảo dưỡng định kỳ</td>
                                    <td>15/06/2023</td>
                                    <td>20/06/2023</td>
                                    <td>Lê Văn C</td>
                                    <td><span class="badge bg-secondary">Chờ thực hiện</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-primary"><i
                                                class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>BL-KOM-D65EX</td>
                                    <td>Máy Ủi Komatsu D65EX</td>
                                    <td>Bảo dưỡng định kỳ</td>
                                    <td>01/07/2023</td>
                                    <td>05/07/2023</td>
                                    <td>Phạm Văn D</td>
                                    <td><span class="badge bg-secondary">Chờ thực hiện</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-primary"><i
                                                class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="#" class="btn btn-sm btn-outline-primary">Xem tất cả lịch bảo trì</a>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer would go here -->


    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.scrollUp.min.js"></script>
    <script src="/js/price-range.js"></script>
    <script src="/js/jquery.prettyPhoto.js"></script>
    <script src="/js/main.js"></script>

    <script>

        function deleteProduct(id) {
            $.ajax({
                url: '/api/device/delete/' + id,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                success: function (response) {
                    alert('Thiết bị đã được xóa thành công');
                    location.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        // alert('Không thể xóa thiết bị: '|| 'Lỗi không xác định');
                        console.log(xhr.responseText);
                    }
                }
            });
        }

        function editProduct() {
        }

        window.onload = function () {

            function loadDevices() {
                $.ajax({
                    url: '/api/devices',
                    type: 'GET',
                    success: function (data) {
                        let container = $('#list-devices'); // Phần tử chứa danh sách thiết bị
                        container.empty(); // Xóa nội dung cũ trước khi thêm mới

                        data.forEach(device => {
                            console.log(device);
                            let statusBadge =
                                `<span class="position-absolute top-0 end-0 badge bg-success m-2">${device.category.name}</span>`

                            let deviceCard = `
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card shadow equipment-card">
                            <div class="position-relative">
                                <img src="${device.image}" class="card-img-top" alt="${device.name}">
                                ${statusBadge}
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">${device.name}</h5>
                                <p class="card-text">${device.description}</p>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-primary">Mã: ${device.id}</span>
                                    <span class="badge bg-light text-dark">${(new Date(device.created_at)).toISOString().split('T')[0]}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-tag me-1"></i> Thuê: ${device.price * 0.4}đ / 3ngày</span>
                                    <span><i class="fas fa-shopping-cart me-1"></i> Bán: ${device.price}</span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editProduct()"><i class="fas fa-edit"></i> Sửa</button>
                                    <button class="btn btn-sm btn-outline-success" onclick="deleteProduct(${device.id})"><i class="fas fa-clipboard-list"></i> Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                            container.append(deviceCard);
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 401) {
                            window.location.href = '/login';
                        } else {
                            alert('Không thể tải danh sách thiết bị: ' + (xhr.responseJSON?.error || 'Lỗi không xác định'));
                        }
                    }
                });
            }

            loadDevices();


            // Example: Update dashboard overview
            const overviceDevices = document.getElementById('overview-devices');
            const rentalDevices = document.getElementById('rental-devices');
            const saleDevices = document.getElementById('sale-devices');

            $.ajax({
                url: '/api/devices/count',
                type: 'GET',
                success: function (response) {
                    overviceDevices.innerText = response.totalDevices;
                },
                error: function (error) {
                    console.error(error);
                }
            });

            $.ajax({
                url: '/api/rentals/count',
                type: 'GET',
                success: function (response) {
                    rentalDevices.innerText = response.totalDevices;
                },
                error: function (error) {
                    console.error(error);
                }
            });

            $.ajax({
                url: '/api/sales/count',
                type: 'GET',
                success: function (response) {
                    saleDevices.innerText = response.totalDevices;
                },
                error: function (error) {
                    console.error(error);
                }
            });
        };

        // Device form submission with authentication
        $('#deviceForm').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: '/api/devices',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Thiết bị đã được thêm thành công');
                    $('#deviceForm')[0].reset();
                    loadDevices();
                },
                error: function (xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Không thể thêm thiết bị: ' + xhr.responseJSON?.error || 'Lỗi không xác định');
                    }
                }
            });
        });

    </script>
</body>

</html>