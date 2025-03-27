@extends('staff.layouts.master')

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
                {{ __('Recently Sold Products') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('Sold At') }}</th>
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
