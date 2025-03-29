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
                        {{ number_format($totalRevenue, 0, ',', '.') }} đ
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Total Orders') }}
                    </div>
                    <div class="card-body">
                        {{ number_format($totalOrders) }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Average Order Value') }}
                    </div>
                    <div class="card-body">
                        {{ number_format($averageOrderValue, 0, ',', '.') }} đ
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
                            <th>{{ __('Products') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Created At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    @if($order->details->count() > 0)
                                        <ul class="list-unstyled mb-0">
                                            @foreach($order->details as $detail)
                                                <li>{{ $detail->product->name }} (x{{ $detail->quantity }})</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <em>{{ __('No products') }}</em>
                                    @endif
                                </td>
                                <td>{{ number_format($order->calculated_total, 0, ',', '.') }} đ</td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'badge bg-secondary',
                                            'confirm' => 'badge bg-primary',
                                            'ship' => 'badge bg-warning text-dark',
                                            'delivery' => 'badge bg-success',
                                            'return' => 'badge bg-info text-dark',
                                            'cancel' => 'badge bg-danger',
                                        ];
                                        $statusClass = $statusClasses[$order->status] ?? 'badge bg-dark';
                                    @endphp
                                    <span class="{{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
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
                                <td>{{ number_format($category->total_sales, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
