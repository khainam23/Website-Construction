@extends('frontend.layouts.master')
@section('title', 'Đăng ký')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/register.css') }}" />
@endsection

@section('content')
    <div class="container register-container">
        <div class="register-form">
            <h2 class="text-center mb-4">Đăng Ký</h2>
            <form>
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" placeholder="Nhập họ và tên">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Nhập email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Nhập mật khẩu">
                </div>
                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Nhập lại mật khẩu">
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
            </form>
        </div>
    </div>
@endsection