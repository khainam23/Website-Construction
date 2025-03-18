@extends('admin.layouts.master')

@section('title', __('Order Details'))

@section('content')
<div class="container">
    <h1>{{ __('Order Details') }}</h1>

    <div class="card">
        <div class="card-header">
            {{ __('Order Information') }}
        </div>
        <div class="card-body">
            <p><strong>{{ __('ID') }}:</strong> {{ $order->id }}</p>
            <p><strong>{{ __('User') }}:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
            <p><strong>{{ __('Total') }}:</strong> {{ $order->total }}</p>
            <p><strong>{{ __('Status') }}:</strong> {{ $order->status }}</p>
            <p><strong>{{ __('Address') }}:</strong> {{ $order->address }}</p>
            <p><strong>{{ __('Phone') }}:</strong> {{ $order->phone }}</p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            {{ __('Order Items') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Cost') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                        <tr>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ $detail->cost }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{ __('Back to Orders') }}</a>
</div>
@endsection
