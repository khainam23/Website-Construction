@extends('sale.layouts.master')

@section('title', __('Product Sales'))

@section('content')
    <div class="container-fluid">
        <h1>{{ __('Product Sales') }}</h1>

        <div class="card">
            <div class="card-header">
                {{ __('Best Selling Products') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('Total Quantity Sold') }}</th>
                            <th>{{ __('Total Revenue') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topSellingProducts as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ number_format($product->total_quantity) }}</td>
                                <td>{{ number_format($product->total_revenue, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                {{ __('Recently Sold Products') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Unit Price') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Sold At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentlySoldProducts as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ number_format($product->cost, 0, ',', '.') }} đ</td>
                                <td>{{ number_format($product->total_cost, 0, ',', '.') }} đ</td>
                                <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
