@extends('admin.layouts.master')

@section('title', __('Revenue Statistics'))

@section('styles')
@endsection

@section('content')
    <div class="container-fluid">
        <h1>{{ __('Revenue Statistics') }}</h1>
        
        <!-- Date range filter -->
        <div class="card mb-4">
            <div class="card-header">
                {{ __('Filter by Date Range') }}
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('sale.sales.revenue') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate ?? '' }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">{{ __('Apply Filter') }}</button>
                        <a href="{{ route('sale.sales.revenue') }}" class="btn btn-secondary ms-2">{{ __('Reset') }}</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daily Revenue -->
        <div class="card mb-4">
            <div class="card-header">
                {{ __('Daily Revenue') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Revenue') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($dailyRevenue) && count($dailyRevenue) > 0)
                                @foreach($dailyRevenue as $date => $data)
                                    <tr>
                                        <td>{{ $date }}</td>
                                        <td>{{ number_format($data['revenue'], 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="text-center">{{ __('No data available') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Weekly Revenue -->
        <div class="card mb-4">
            <div class="card-header">
                {{ __('Weekly Revenue') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Week') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Revenue') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($weeklyRevenue) && count($weeklyRevenue) > 0)
                                @foreach($weeklyRevenue as $data)
                                    <tr>
                                        <td>{{ $data['week'] }}</td>
                                        <td>{{ $data['start_date'] }}</td>
                                        <td>{{ $data['end_date'] }}</td>
                                        <td>{{ number_format($data['revenue'], 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('No data available') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="card mb-4">
            <div class="card-header">
                {{ __('Monthly Revenue') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Month') }}</th>
                                <th>{{ __('Revenue') }}</th>
                                <th>{{ __('Type') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monthlyRevenue as $month => $revenues)
                                @foreach ($revenues as $revenue)
                                    <tr>
                                        <td>{{ $revenue['month'] }}</td>
                                        <td>{{ number_format($revenue['revenue'], 2) }}</td>
                                        <td>{{ __($revenue['type']) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Annual Revenue -->
        <div class="card mb-4">
            <div class="card-header">
                {{ __('Annual Revenue') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Year') }}</th>
                                <th>{{ __('Revenue') }}</th>
                                <th>{{ __('Type') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($yearlyRevenue as $year => $revenues)
                                @foreach ($revenues as $revenue)
                                    <tr>
                                        <td>{{ $revenue['year'] }}</td>
                                        <td>{{ number_format($revenue['revenue'], 2) }}</td>
                                        <td>{{ __($revenue['type']) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
