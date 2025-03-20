@extends('admin.layouts.master')

@section('title', __('Order Management'))

@section('content')
<div class="container">
    <h1>{{ __('Order Management') }}</h1>

    <div class="mb-3">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="{{ __('Search') }}" name="search" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">{{ __('Search') }}</button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Address') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Items') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>
                        <ul>
                            @foreach($order->details as $detail)
                            <li>
                                {{ $detail->product->name }} ({{ $detail->quantity }}) - {{ $detail->cost }}
                                @if($detail->rental_start && $detail->rental_end && $detail->duration)
                                    <br>
                                    {{ __('Rental Start') }}: {{ $detail->rental_start }}
                                    {{ __('Rental End') }}: {{ $detail->rental_end }}
                                    {{ __('Duration') }}: {{ $detail->duration }}
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
