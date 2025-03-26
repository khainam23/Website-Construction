@extends('sale.layouts.master')

@section('title', __('Sale Dashboard'))

@section('content')
    <div class="container-fluid">
        <h1>{{ __('Sale Dashboard') }}</h1>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        {{ __('Today\'s Revenue') }}
                    </div>
                    <div class="card-body">
                        <h3>{{ isset($todayRevenue) ? number_format($todayRevenue, 2) : __('N/A') }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        {{ __('This Week\'s Revenue') }}
                    </div>
                    <div class="card-body">
                        <h3>{{ isset($weeklyRevenue) ? number_format($weeklyRevenue, 2) : __('N/A') }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        {{ __('This Month\'s Revenue') }}
                    </div>
                    <div class="card-body">
                        <h3>{{ isset($monthlyRevenue) ? number_format($monthlyRevenue, 2) : __('N/A') }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        {{ __('This Year\'s Revenue') }}
                    </div>
                    <div class="card-body">
                        <h3>{{ isset($yearlyRevenue) ? number_format($yearlyRevenue, 2) : __('N/A') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Revenue Statistics') }}
                    </div>
                    <div class="card-body">
                        <p>{{ __('For detailed revenue statistics, visit the') }} 
                           <a href="{{ route('sale.sales.revenue') }}">{{ __('Revenue Statistics') }}</a> 
                           {{ __('page.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
