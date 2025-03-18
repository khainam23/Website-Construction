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
                        <p class="card-text">Manage your products efficiently.</p>
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
                        <p class="card-text">Organize your products into categories.</p>
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
                        <p class="card-text">Manage user accounts and roles.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
