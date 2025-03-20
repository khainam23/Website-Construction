@extends('admin.layouts.master')

@section('title', __('Edit User Role'))

@section('content')
<div class="container">
    <h1>{{ __('Edit User Role') }}</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="role">{{ __('Role') }}</label>
            <select name="role" id="role" class="form-control">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>{{ __('Customer') }}</option>
                <option value="sale" {{ $user->role == 'sale' ? 'selected' : '' }}>{{ __('Sale') }}</option>
                <option value="rental" {{ $user->role == 'rental' ? 'selected' : '' }}>{{ __('Rental') }}</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
</div>
@endsection
