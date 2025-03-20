@extends('sale.layouts.master')

@section('title', 'Quản lý bán hàng')

@section('content')
    <div class="container-fluid">
        <h1>Quản lý bán hàng</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Tổng doanh thu
                    </div>
                    <div class="card-body">
                        {{ $totalRevenue }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Tổng số đơn hàng
                    </div>
                    <div class="card-body">
                        {{ $totalOrders }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Giá trị đơn hàng trung bình
                    </div>
                    <div class="card-body">
                        {{ $averageOrderValue }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Đơn hàng gần đây
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID đơn hàng</th>
                            <th>Tổng cộng</th>
                            <th>Đã tạo lúc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Doanh số theo danh mục
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên danh mục</th>
                            <th>Tổng doanh số</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesByCategory as $category)
                            <tr>
                                <td>{{ $category->category_name }}</td>
                                <td>{{ $category->total_sales }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
