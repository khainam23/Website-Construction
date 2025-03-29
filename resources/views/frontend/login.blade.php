@extends('frontend.layouts.master')
@section('title', __('Login'))

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/login.css') }}" />
@endsection

@section('content')
    <div class="container login-container">
        <div class="login-form">
            <h2 class="text-center mb-4">{{ __('Login') }}</h2>
            <form id="login" class="mb-4">
                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input name="email" type="text" class="form-control" placeholder="{{ __('Email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Password') }}</label>
                    <input name="password" type="password" class="form-control" placeholder="{{ __('Password') }}" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route("web.forget") }}">{{ __('Forgot your password?') }}</a>
            </div>
            <div class="text-center mt-2">
                <span>{{ __("Don't have an account?") }}</span> <a href="{{ route('web.register') }}">{{ __('Create an account') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#login').on('submit', function (event) {
                event.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('api.login') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "{{ __('Processing...') }}",
                            text: "{{ __('Please wait a moment!') }}",
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = response.url;
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr)
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: xhr.responseJSON || '{{ __("Message_error") }}',
                        });
                    }
                });
            });
        });
    </script>
@endsection