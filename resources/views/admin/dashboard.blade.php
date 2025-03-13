<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#productSection">
                                Quản lý sản phẩm
                            </a>
                        </li>
                        <!-- Add more menu items here -->
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div id="productSection">
                    <h2>Quản lý sản phẩm</h2>
                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">
                        Thêm sản phẩm mới
                    </button>

                    <!-- Products Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="productsTableBody">
                            @foreach($devices as $device)
                            <tr>
                                <td>{{ $device->id }}</td>
                                <td>{{ $device->name }}</td>
                                <td>{{ $device->category->name }}</td>
                                <td>{{ number_format($device->price) }} VND</td>
                                <td>{{ $device->stock }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-device" data-id="{{ $device->id }}">Sửa</button>
                                    <button class="btn btn-sm btn-danger delete-device" data-id="{{ $device->id }}">Xóa</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm sản phẩm mới</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Danh mục</label>
                            <select class="form-control" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Giá</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <div class="form-group">
                            <label>Số lượng</label>
                            <input type="number" class="form-control" name="stock" required>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add Product Form Submit
            $('#addProductForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                
                $.ajax({
                    url: '/api/devices',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('Thêm sản phẩm thành công!');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Có lỗi xảy ra: ' + xhr.responseText);
                    }
                });
            });

            // Delete Device
            $('.delete-device').click(function() {
                if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                    let deviceId = $(this).data('id');
                    $.ajax({
                        url: '/api/devices/' + deviceId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            alert('Xóa sản phẩm thành công!');
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Có lỗi xảy ra: ' + xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
