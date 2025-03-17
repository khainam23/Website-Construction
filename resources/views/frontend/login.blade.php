@extends('frontend.layouts.master')
@section('title', 'Đăng nhập')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/login.css') }}" />
@endsection

@section('content')
    <div class="container custom-background">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="login-container">
                    <h2>Đăng nhập</h2>
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Tên đăng nhập" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Mật khẩu" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                </div>
            </div>
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