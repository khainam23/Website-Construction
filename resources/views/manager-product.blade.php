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

        .model {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .model-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
        }

        .model-header {
            display: flex;
            justify-content: space-between;
        }

        .image-preview {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <!-- Header would go here -->

    <!-- Main Content -->
    <div class="container-fluid py-4 row">
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

        <div class="mb-4"></div>
    </div>

    <div>
        <!-- Recent Transactions -->
        <div>
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
                                    <th scope="col">Mã sản phẩm</th>
                                    <th scope="col">Mã khách hàng</th>
                                    <th scope="col">Loại</th>
                                    <th scope="col">Ngày Bắt Đầu</th>
                                    <th scope="col">Ngày Kết Thúc</th>
                                    <th scope="col">Giá Trị</th>
                                </tr>
                            </thead>
                            <tbody id="list-transactions">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="model" id="editModel">
        <div class="model-content">
            <div class="model-header">
                <h2>Chỉnh sửa thông tin</h2>
                <button onclick="closeModel()">✖</button>
            </div>
            <form id="editForm">
                @php
                    $role = session('user')['role'];
                @endphp
                <label for="device_name">Tên máy:</label>
                <input type="text" id="device_name" {{$role == 'warehouse' ? 'disabled' : ''}}><br>

                <label for="device_description">Mô tả:</label>
                <textarea id="device_description" {{$role == 'warehouse' ? 'disabled' : ''}}></textarea><br>

                <lable for="old_device_category">Danh mục cũ:</lable>
                <p id="old_device_category"></p>

                @if ($role == 'sales')
                    <label for="device_category">Danh mục:</label>
                    <select id="device_category" class="form-control" name="category_id" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select><br>
                @endif

                <label for="device_id">Mã:</label>
                <p id="device_id"></p>

                <label for="sell">Giá:</label>
                <input type="text" id="sell" {{$role == 'warehouse' ? 'disabled' : ''}}> VND<br>

                <label for="sell">Tồn kho:</label>
                <input type="number" id="device_stock" min="0" max="99" {{$role == 'sales' ? 'disabled' : ''}}><br>

                <label for="device_image">Hình ảnh:</label>
                <img id="image_preview" class="image-preview" src="" alt="Hình ảnh thiết bị"><br>
                <input {{$role == 'warehouse' ? 'disabled' : ''}} type="file" id="device_image" accept="image/*" onchange="updateImagePreview(event)"><br>

                <button type="button" onclick="saveChanges()">Lưu</button>
            </form>
        </div>
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

        function editProduct(id, name, image, description, price, category, stock) {
            openModel(id, name, image, description, price, category, stock);
        }

        function openModel(id, name, image, description, price, category, stock) {
            document.getElementById("editModel").style.display = "flex";
            document.getElementById("device_id").innerText = id;
            document.getElementById("device_name").value = name;
            document.getElementById("device_description").value = description;
            document.getElementById("sell").value = price;
            document.getElementById("old_device_category").innerText = category;
            document.getElementById("device_stock").value = stock;
            document.getElementById("image_preview").src = image;
        }

        function closeModel() {
            document.getElementById("editModel").style.display = "none";
        }

        function updateImagePreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("image_preview").src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        function saveChanges() {
            let formData = new FormData();
            formData.append("id", document.getElementById("device_id").innerText.trim());
            formData.append("name", document.getElementById("device_name").value.trim());
            formData.append("description", document.getElementById("device_description").value.trim());
            formData.append("category", document.getElementById("device_category").value);
            formData.append("price", document.getElementById("sell").value);
            formData.append("stock", document.getElementById("device_stock").value);

            let fileInput = document.getElementById("device_image");
            if (fileInput.files.length > 0) {
                formData.append("image", fileInput.files[0]);
            }

            $.ajax({
                url: '/api/device/' + document.getElementById("device_id").innerText.trim(),
                type: 'POST', // Dùng POST thay vì PUT (PUT không hỗ trợ FormData tốt trong Laravel)
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                success: function (response) {
                    alert('Thiết bị đã được cập nhật thành công');
                    location.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        // alert('Không thể cập nhật thiết bị: ' + JSON.stringify(xhr.responseJSON.errors));
                        console.log(xhr.responseText);
                    }
                }
            });
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
                                    <span class="fw-bold text-primary">Tồn kho: ${device.stock}</span>
                                    <span class="badge bg-light text-dark">${(new Date(device.created_at)).toISOString().split('T')[0]}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-tag me-1"></i> Thuê: ${device.price * 0.4}đ / 3ngày</span>
                                    <span><i class="fas fa-shopping-cart me-1"></i> Bán: ${device.price}</span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editProduct(${device.id}, '${device.name}', '${device.image}', '${device.description}', ${device.price}, '${device.category.name}', ${device.stock})"><i class="fas fa-edit"></i> Sửa</button>
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
                            // alert('Không thể tải danh sách thiết bị: ' + (xhr.responseJSON?.error || 'Lỗi không xác định'));
                            console.log(xhr.responseJSON)
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
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
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

            // Example: Load recent transactions
            const listTransactions = document.getElementById('list-transactions');

            $.ajax({
                url: '/api/sales/all',
                type: 'GET',
                success: function (response) {
                    for (let sale of response) {
                        let html = `<tr>
                                    <td>${sale.id}</td>
                                    <td>${sale.device_id}</td>
                                    <td>${sale.user_id}</td>
                                    <td><span class="badge bg-info">Bán</span></td>
                                    <td>${sale.updated_at}</td>
                                    <td></td>
                                    <td>${sale.total_price}</td>
                                </tr>`;
                        listTransactions.innerHTML += html;
                    }
                },
                error: function (error) {
                    console.error(error);
                }
            });

            $.ajax({
                url: '/api/rentals/all',
                type: 'GET',
                success: function (response) {
                    for (let rental of response) {
                        console.log(rental);
                        let html = `<tr>
                                    <td>${rental.id}</td>
                                    <td>${rental.device_id}</td>
                                    <td>${rental.user_id}</td>
                                    <td><span class="badge bg-danger">Thuê</span></td>
                                    <td>${sale.rental_date}</td>
                                    <td>${sale.return_date}</td>
                                    <td>${sale.total_price}</td>
                                </tr>`;
                        listTransactions.innerHTML += html;
                    }
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