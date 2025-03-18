@extends('frontend.layouts.master')
@section('title', 'Người dùng')

@section('style')
<style>
    body {
        background-color: #f8f9fa;
    }
    .profile-container {
        display: flex;
        max-width: 900px;
        margin: 50px auto;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .sidebar {
        width: 30%;
        background: #007bff;
        padding: 20px;
        color: white;
    }
    .sidebar .nav-item {
        padding: 10px;
        cursor: pointer;
        border-radius: 5px;
        transition: background 0.3s;
    }
    .sidebar .nav-item:hover, .sidebar .nav-item.active {
        background: rgba(255,255,255,0.2);
    }
    .content {
        width: 70%;
        padding: 20px;
    }
    .content-section {
        display: none;
    }
    .content-section.active {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="sidebar">
        <h3>Danh Mục</h3>
        <div class="nav-item active" data-target="profile">Hồ sơ</div>
        <div class="nav-item" data-target="cart">Giỏ hàng</div>
        <div class="nav-item" data-target="orders">Đơn hàng</div>
    </div>
    <div class="content">
        <div id="profile" class="content-section active">
            <h2>Hồ sơ của bạn</h2>
            <p>Thông tin cá nhân và chi tiết tài khoản của bạn.</p>
        </div>
        <div id="cart" class="content-section">
            <h2>Giỏ hàng</h2>
            <p>Danh sách sản phẩm trong giỏ hàng của bạn.</p>
        </div>
        <div id="orders" class="content-section">
            <h2>Đơn hàng</h2>
            <p>Danh sách đơn hàng đã đặt.</p>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function() {
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
@endsection
