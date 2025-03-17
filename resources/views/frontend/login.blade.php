@extends('frontend.layouts.master')
@section('title', 'Đăng nhập')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/login.css') }}" />
@endsection

@section('content')
    <div class="container login-container">
        <div class="login-form">
            <h2 class="text-center mb-4">Đăng Nhập</h2>
            <form id="login">
                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập</label>
                    <input name="email" type="text" class="form-control" placeholder="Nhập tên đăng nhập" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input name="password" type="password" class="form-control" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#login').on('submit', function (event) {
                event.preventDefault();

                let formData = new FormData(this);

                // Hiển thị hộp thoại loading
                Swal.fire({
                    title: 'Đang xử lý...',
                    html: 'Vui lòng chờ trong giây lát.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('api.login') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    success: function (response) {
                        // Đóng hộp thoại loading
                        Swal.close();

                        Swal.fire({
                            icon: 'success',
                            title: 'Đăng nhập thành công!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ route('web.index') }}";
                        });
                    },
                    error: function (xhr) {
                        // Đóng hộp thoại loading
                        Swal.close();

                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON || 'Có lỗi xảy ra, vui lòng thử lại.',
                        });
                    }
                });
            });
        });
    </script>
@endsection