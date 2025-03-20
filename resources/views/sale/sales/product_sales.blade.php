@extends('sale.layouts.master')

@section('title', 'Bán hàng sản phẩm')

@section('content')
    <div class="container-fluid">
        <h1>Bán hàng sản phẩm</h1>

        <div class="card">
            <div class="card-header">
                Sản phẩm bán chạy nhất
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Tổng số lượng đã bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topSellingProducts as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->total_quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Sản phẩm đã bán gần đây
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Đã bán lúc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentlySoldProducts as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
