@extends('sale.layouts.master')

@section('title', __('Revenue Statistics'))

@section('content')
    <div class="container-fluid">
        <h1>{{ __('Revenue Statistics') }}</h1>

        <div class="card">
            <div class="card-header">
                {{ __('Monthly Revenue') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Month') }}</th>
                            <th>{{ __('Revenue') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Rental Start Date') }}</th>
                            <th>{{ __('Rental End Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyRevenue as $month => $revenues)
                            @foreach ($revenues as $revenue)
                                <tr>
                                    <td>{{ $revenue['month'] }}</td>
                                    <td>{{ $revenue['revenue'] }}</td>
                                    <td>{{ $revenue['type'] }}</td>
                                    <td>{{ $revenue['rental_start_date'] ?? 'N/A' }}</td>
                                    <td>{{ $revenue['rental_end_date'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                {{ __('Annual Revenue') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Year') }}</th>
                            <th>{{ __('Revenue') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Rental Start Date') }}</th>
                            <th>{{ __('Rental End Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($yearlyRevenue as $year => $revenues)
                            @foreach ($revenues as $revenue)
                                <tr>
                                    <td>{{ $revenue['year'] }}</td>
                                    <td>{{ $revenue['revenue'] }}</td>
                                    <td>{{ $revenue['type'] }}</td>
                                    <td>{{ $revenue['rental_start_date'] ?? 'N/A' }}</td>
                                    <td>{{ $revenue['rental_end_date'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
