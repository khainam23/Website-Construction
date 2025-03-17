@extends('frontend.layouts.master')
@section('title', 'Quên Mật Khẩu')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/forget.css') }}" />
@endsection

@section('content')
    <div class="container forgot-password-container">
        <div class="forgot-password-form">
            <h2 class="text-center mb-4">Quên Mật Khẩu</h2>
            <form id="forgot-password-form">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Gửi Yêu Cầu</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('forgot-password-form').addEventListener('submit', function (event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            if (email) {
                alert('Liên kết đặt lại mật khẩu đã được gửi đến email của bạn! (Chưa có backend)');
            } else {
                alert('Vui lòng nhập email hợp lệ!');
            }
        });
    </script>
@endsection