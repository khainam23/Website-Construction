@extends('frontend.layouts.master')
@section('title', __('Register'))

@section('style')
    <link rel="stylesheet" href="{{ asset('frontendcss/css/register.css') }}" />
@endsection

@section('content')
    <div class="container register-container mt-5 mb-5">
        <div class="register-form">
            <h2 class="text-center mb-4">{{ __('Register') }}</h2>
            <form id="register">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ __('First Name') }}</label>
                    <input type="text" class="form-control" name="first_name" maxlength="20"
                        placeholder="{{ __('First Name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Last Name') }}</label>
                    <input type="text" class="form-control" name="last_name" pattern="[A-Za-z\s]+" maxlength="20"
                        placeholder="{{ __('Last Name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Phone Number') }}</label>
                    <input type="tel" class="form-control" name="phone" placeholder="{{ __('Phone Number') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" name="email" placeholder="{{ __('Email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control" name="password" maxlength="20" minlength="6"
                        placeholder="{{ __('Password') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control" name="password_confirmation" maxlength="20" minlength="6"
                        placeholder="{{ __('Confirm Password') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Address') }}</label>
                    <input type="text" class="form-control" name="address" placeholder="{{ __('Address') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Date of Birth') }}</label>
                    <input type="date" class="form-control" name="date_of_birth" required max="2007-06-06">
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Gender') }}</label>
                    <select class="form-control" name="gender" required>
                        <option value="male">{{ __('Male') }}</option>
                        <option value="female">{{ __('Female') }}</option>
                        <option value="other">{{ __('Other') }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Avatar') }}</label>
                    <input type="file" class="form-control" name="avatar">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">
                        {{ __('I agree to the') }} <a href="#">{{ __('Terms of Service') }}</a> {{ __('and') }} <a
                            href="#">{{ __('Privacy Policy') }}</a>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary w-100">{{ __('Register Now') }}</button>
                <div class="text-center mt-3">
                    <span>{{ __('Already have an account?') }}</span> <a
                        href="{{ route('web.login') }}">{{ __('Login to continue') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            function isValidPhoneNumber(phone) {
                return /^(84|0[3|5|7|8|9])+([0-9]{8})\b/.test(phone);
            }

            $('#register').on('submit', function (event) {
                event.preventDefault();

                let formData = new FormData(this);
                let phone = formData.get('phone');

                if (!isValidPhoneNumber(phone)) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("Invalid Phone Number") }}',
                        text: '{{ __("Please enter a valid Vietnamese phone number") }}'
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('api.register') }}",
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
                            title: '{{ __("Success") }}',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ route('web.login') }}";
                        });
                    },
                    error: function (xhr) {
                        // Đóng hộp thoại loading
                        Swal.close();

                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: xhr.responseJSON.message || '{{ __("Message_error") }}',
                        });
                    }
                });
            });
        });
    </script>
@endsection