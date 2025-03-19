@extends('frontend.layouts.master')
@section('title', 'Giới thiệu')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/profile.css') }}" />
@endsection

@section('content')
<div class="profile-container">
    <div class="sidebar">
        <h3>Danh Mục</h3>
        <div class="nav-item active" data-target="profile">Hồ sơ</div>
        <div class="nav-item" data-target="cart">Giỏ hàng</div>
        <div class="nav-item" data-target="orders">Đơn hàng</div>
        <div class="nav-item" data-target="password">Mật khẩu</div>
    </div>
    <div class="content">
        <div id="profile" class="content-section active">
            <h2>Hồ sơ của bạn</h2>
            <form id="profile-form" enctype="multipart/form-data">
                <div class="form-group text-center">
                    <label>Ảnh đại diện:</label>
                    <br>
                    <img id="avatar-preview" src="{{ asset($infoUser->avatar) }}" alt="Avatar" class="img-thumbnail"
                        width="150">
                    <br>
                    <input id="avatar" type="file" class="form-control mt-2" name="avatar" accept="image/*"
                        onchange="previewAvatar(event)">
                </div>
                <div class="form-group">
                    <label>Họ:</label>
                    <input type="text" class="form-control" name="first_name" value="{{ $infoUser->first_name }}">
                </div>
                <div class="form-group">
                    <label>Tên:</label>
                    <input type="text" class="form-control" name="last_name" value="{{ $infoUser->last_name }}">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" value="{{ $infoUser->email }}" disabled>
                </div>
                <div class="form-group">
                    <label>Số điện thoại:</label>
                    <input type="text" class="form-control" name="phone" value="{{ $infoUser->phone }}">
                </div>
                <div class="form-group">
                    <label>Địa chỉ:</label>
                    <input type="text" class="form-control" name="address" value="{{ $infoUser->address }}">
                </div>
                <div class="form-group">
                    <label>Ngày sinh:</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{ $infoUser->date_of_birth }}">
                </div>
                <div class="form-group">
                    <label>Giới tính:</label>
                    <select class="form-control" name="gender">
                        <option value="male" {{ $infoUser->gender == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ $infoUser->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ $infoUser->gender == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </form>
        </div>
        <div id="cart" class="content-section">
            <h2>Giỏ hàng</h2>
            @if($cartItems)
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Ngày thuê</th>
                            <th>Ngày trả</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ number_format($item->cost, 0, ',', '.') }} đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->rental_start_date }}</td>
                                <td>{{ $item->rental_end_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
            <span>Hiện giỏ hàng đang trống</span>
            @endIf
        </div>
        <div id="orders" class="content-section">
            <h2>Đơn hàng</h2>
            @if($orders->count() != 0)
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ number_format($order->total, 0, ',', '.') }} đ</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>
                                    <ul>
                                        @foreach($order->orderDetails as $detail)
                                            <li>{{ $detail->product->name }} - {{ $detail->quantity }} x
                                                {{ number_format($detail->cost, 0, ',', '.') }} đ
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <span>Hiện chưa có đơn hàng thành công</span>
            @endif
        </div>
        <div id="password" class="content-section">
            <h2 class="mb-4">Mật khẩu</h2>
            <form id="password-form">
                <div class="form-group">
                    <label for="current-password">Mật khẩu cũ</label>
                    <input id="current-password" name="current-password" type="password" class="form-control"
                        placeholder="Nhập mật khẩu cũ" required>
                </div>
                <div class="form-group">
                    <label for="new-password">Mật khẩu mới</label>
                    <input id="new-password" name="new-password" type="password" class="form-control"
                        placeholder="Nhập mật khẩu mới" required>
                </div>
                <div class="form-group">
                    <label for="confrim-password">Nhập lại mật khẩu mới</label>
                    <input id="confrim-password" name="confrim-password" type="password" class="form-control"
                        placeholder="Nhập lại mật khẩu mới" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
    <!-- Nav chuyển tab -->
    <script>
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function () {
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');

                let target = this.getAttribute('data-target');
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(target).classList.add('active');
            });
        });
    </script>

    <!-- Cập nhật thông tin cá nhân -->
    <script>
        function previewAvatar(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('avatar-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        $(document).ready(function () {
            let initialData = {};
            let initialAvatar = null;

            function getFormData() {
                $('#profile-form').find('input, select').each(function () {
                    if ($(this).attr('type') !== 'file') {
                        initialData[$(this).attr('name')] = $(this).val();
                    }
                });

                let avatarInput = $('#avatar')[0];
                if (avatarInput.files.length > 0) {
                    initialAvatar = avatarInput.files[0];
                }
            }

            getFormData(); // Lưu dữ liệu ban đầu

            $('#profile-form').on('submit', function (event) {
                event.preventDefault();

                let formData = new FormData(this);
                let hasChanged = false;

                // Kiểm tra thay đổi dữ liệu text, select
                $(this).find('input, select').each(function () {
                    if ($(this).attr('type') !== 'file') {
                        let name = $(this).attr('name');
                        let value = $(this).val();

                        if (initialData[name] !== value) {
                            hasChanged = true;
                        }
                    }
                });

                // Kiểm tra xem có ảnh mới không
                let avatarInput = $('#avatar')[0];
                if (avatarInput.files.length > 0 && avatarInput.files[0] !== initialAvatar) {
                    hasChanged = true;
                }

                if (!hasChanged) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Không có thay đổi nào!',
                        text: 'Bạn chưa thay đổi thông tin nào.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Đang xử lý...',
                    html: 'Vui lòng chờ trong giây lát.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('api.update.info') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    success: function (response) {
                        Swal.close();
                        Swal.fire({
                            icon: 'success',
                            title: 'Cập nhật thành công!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            getFormData(); // Cập nhật lại dữ liệu sau khi lưu thành công

                            // Cập nhật avatar preview nếu có ảnh mới
                            if (avatarInput.files.length > 0) {
                                let reader = new FileReader();
                                reader.onload = function (e) {
                                    $('#avatar-preview').attr('src', e.target.result);
                                };
                                reader.readAsDataURL(avatarInput.files[0]);
                            }
                        });
                    },
                    error: function (xhr) {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON?.message || 'Có lỗi xảy ra, vui lòng thử lại.',
                        });
                    }
                });
            });

            // Hiển thị ảnh preview ngay khi chọn file
            $('#avatar').on('change', function () {
                let file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $('#avatar-preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>


    <!-- Cập nhật mật khẩu -->
    <script>
        $(document).ready(function () {
            $('#password-form').on('submit', function (event) {
                event.preventDefault();

                let currentPassword = $('#current-password').val();
                let newPassword = $('#new-password').val();
                let confirmPassword = $('#confrim-password').val();

                if (newPassword !== confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Mật khẩu mới không khớp, vui lòng nhập lại.',
                    });
                    return;
                }

                // Hiển thị loading
                Swal.fire({
                    title: 'Đang xử lý...',
                    html: 'Vui lòng chờ trong giây lát.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('api.update.password') }}",
                    type: "POST",
                    data: {
                        current_password: currentPassword,
                        new_password: newPassword,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        Swal.close();
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                        }).then(() => {
                            $('#password-form')[0].reset();
                        });
                    },
                    error: function (xhr) {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON.message || 'Có lỗi xảy ra, vui lòng thử lại.',
                        });
                    }
                });
            });
        });
    </script>
@endsection