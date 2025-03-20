@extends('frontend.layouts.master')
@section('title', 'Quên Mật Khẩu')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/forget.css') }}" />
@endsection

@section('content')
    <div class="container forgot-password-container">
        <div class="forgot-password-form">
            <h2 class="text-center mb-4">Quên Mật Khẩu</h2>
            <form id="forgot">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Nhập email của bạn"
                        required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Gửi Yêu Cầu</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('forgot').addEventListener('submit', function (event) {
            event.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('api.forget') }}",
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
                        title: 'Vui lòng kiểm tra mail!',
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
                        text: xhr.responseJSON || 'Có lỗi xảy ra, vui lòng thử lại.',
                    });
                }
            });
        });
    </script>
@endsection