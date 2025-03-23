@extends('frontend.layouts.master')
@section('title', __('Forgot Password'))

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/forget.css') }}" />
@endsection

@section('content')
    <div class="container forgot-password-container">
        <div class="forgot-password-form">
            <h2 class="text-center mb-4">{{ __('Forgot Password') }}</h2>
            <form id="forgot">
                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="{{ __('Enter your email') }}"
                        required>
                </div>
                <button type="submit" class="btn btn-primary w-100">{{ __('Send Request') }}</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('forgot').addEventListener('submit', function (event) {
            event.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('api.forget') }}",
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
                        title: "{{ __('Please check your email!') }}",
                        text: response.message,
                        confirmButtonText: "{{ __('OK') }}"
                    }).then(() => {
                        window.location.href = "{{ route('web.login') }}";
                    });
                },
                error: function (xhr) {
                    // Close loading dialog
                    Swal.close();

                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('Error!') }}",
                        text: xhr.responseJSON || "{{ __('An error occurred, please try again.') }}",
                    });
                }
            });
        });
    </script>
@endsection