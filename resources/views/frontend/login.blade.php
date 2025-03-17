@extends('frontend.layouts.master')
@section('title', 'Đăng nhập')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/login.css') }}" />
@endsection

@section('content')
    <div class="container login-container">
        <div class="login-form">
            <h2 class="text-center mb-4">Đăng Nhập</h2>
            <form>
                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập</label>
                    <input type="text" class="form-control" placeholder="Nhập tên đăng nhập" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault();
            alert('Đăng nhập thành công! (Chưa có backend)');
        });
    </script>
@endsection