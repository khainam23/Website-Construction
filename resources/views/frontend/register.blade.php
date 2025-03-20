@extends('frontend.layouts.master')
@section('title', 'Đăng ký')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/register.css') }}" />
@endsection

@section('content')
    <div class="container register-container mt-5 mb-5  ">
        <div class="register-form">
            <h2 class="text-center mb-4">Đăng Ký</h2>
            <form id="register">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tên đệm</label>
                    <input type="text" class="form-control" name="first_name" placeholder="Tên đệm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tên</label>
                    <input type="text" class="form-control" name="last_name" placeholder="Tên" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" name="phone" placeholder="Số điện thoại" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Nhập email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Nhập lại mật khẩu"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" name="address" placeholder="Nhập địa chỉ" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control" name="date_of_birth" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Giới tính</label>
                    <select class="form-control" name="gender" required>
                        <option value="male">Nam</option>
                        <option value="female">Nữ</option>
                        <option value="other">Khác</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ảnh đại diện</label>
                    <input type="file" class="form-control" name="avatar" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#register').on('submit', function (event) {
                event.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('api.register') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Đang xử lý...",
                            text: "Vui lòng đợi trong giây lát!",
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Đăng ký thành công!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ route('web.login') }}";
                        });
                    },
                    error: function (xhr) {
                        // Đóng hộp thoại loading
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