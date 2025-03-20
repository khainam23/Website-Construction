@extends('sale.layouts.master')

@section('title', 'Thống kê doanh thu')

@section('content')
    <div class="container-fluid">
        <h1>Thống kê doanh thu</h1>

        <div class="card">
            <div class="card-header">
                {{ __('Doanh thu hàng tháng') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Tháng') }}</th>
                            <th>{{ __('Doanh thu') }}</th>
                            <th>{{ __('Loại') }}</th>
                            <th>{{ __('Ngày bắt đầu thuê') }}</th>
                            <th>{{ __('Ngày kết thúc thuê') }}</th>
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
                {{ __('Doanh thu hàng năm') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Năm') }}</th>
                            <th>{{ __('Doanh thu') }}</th>
                             <th>{{ __('Loại') }}</th>
                            <th>{{ __('Ngày bắt đầu thuê') }}</th>
                            <th>{{ __('Ngày kết thúc thuê') }}</th>
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
