@extends('sale.layouts.master')

@section('title', __('Sales Management'))

@section('content')
    <div class="container-fluid">
        <h1>{{ __('Sales Management') }}</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Total Revenue') }}
                    </div>
                    <div class="card-body">
                        {{ $totalRevenue }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Total Orders') }}
                    </div>
                    <div class="card-body">
                        {{ $totalOrders }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Average Order Value') }}
                    </div>
                    <div class="card-body">
                        {{ $averageOrderValue }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                {{ __('Recent Orders') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Order ID') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Created At') }}</th>
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
                {{ __('Sales By Category') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Category Name') }}</th>
                            <th>{{ __('Total Sales') }}</th>
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
