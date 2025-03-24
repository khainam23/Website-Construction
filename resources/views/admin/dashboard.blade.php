@extends('admin.layouts.master')

@section('title', __('Admin Dashboard'))

@section('content')
    <div class="container">
        <h1>{{ __('Admin Dashboard') }}</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Total Products') }}
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">{{ $totalProducts }}</h2>
                        <p class="card-text">{{ __('Manage Products') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Total Categories') }}
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">{{ $totalCategories }}</h2>
                        <p class="card-text">{{ __('Manage Categories') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Total Users') }}
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">{{ $totalUsers }}</h2>
                        <p class="card-text">{{ __('Manage Users') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">  
                <div class="card">
                    <div class="card-header">
                        {{ __('Total Orders') }}
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">{{ $totalOrders }}</h2>
                        <p class="card-text">{{ __('Manage Orders') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">  
                <div class="card">
                    <div class="card-header">
                        {{ __('Total Revenue') }}
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">{{ number_format($totalRevenue) }} VNĐ</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly revenue chart section removed -->
    </div>
@endsection

@section('js')
@endsection
