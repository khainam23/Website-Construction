@extends('frontend.layouts.master')
@section('title', 'Liên hệ')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontend/css/styleGuide.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/aboutUsStyle.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/contactUsStyle.css') }}" />
@endsection

@section('content')
    <div class="container flex-column d-flex contact-us">
        <div class="section-container">
            <div class="contact-us-container d-flex flex-column">
                <div class="news-title">
                    <div>
                        <h1>
                        {{ __('CONTACT') }} 
                        </h1>
                    </div>
                    <div class="news-title-right">
                        <a href=""><h2> {{ __('Home') }}</h2></a>
                        <p>></p>
                        <p> {{ __('Contact') }}</p>
                    </div>
                </div>
                <div class="content-container d-flex flex-column">
                    <div class="banner-contact-us d-flex flex-col">
                        <img src="{{ asset('frontend/images/banner-contact-us.png') }}" class="w-100" alt="">
                    </div>
                    <div class="frame-content row">
                        <div class="section-title-left col-md-6 mb-3">
                            <div class="text-wrapper">
                                <span>{{ __('BMQ PRODUCTION AND TRADING JOINT STOCK COMPANY') }}</span>
                            </div>
                            <div class="infor-wrapper">
                                <div class="info">
                                    <span class="label-info">{{ __('Headquarters') }}: <br /></span>
                                    <span class="value-info">
                                        @if(app()->getLocale() === 'vi')
                                            {{ $contacts['address'] }}
                                        @else
                                            {{ $contacts['address_en'] }}
                                        @endif
                                    </span>

                                </div>
                            </div>

                            <div class="infor-wrapper">
                                <div class="info">
                                    <span class="label-info">{{ __('Representative office') }} <br /></span>
                                    <span class="value-info">
                                        @if(app()->getLocale() === 'vi')
                                            {{ $contacts['representative_office'] }}
                                        @else
                                            {{ $contacts['representative_office_en'] }}
                                        @endif
                                    </span>

                                </div>
                            </div>

                            <div class="infor-wrapper">
                            <div class="info">
                                <span class="label-info">{{ __('Hotline') }}: <br /></span>
                                <span class="value-info">
                                    @if(in_array(app()->getLocale(), ['en', 'lo', 'my']))
                                        @php
                                            $phone1 = isset($contacts['phone']) 
                                                ? preg_replace('/(\d{2})(\d{3})(\d{4})/', '$1.$2.$3', ltrim($contacts['phone'], '0')) 
                                                : '';
                                            $phone2 = isset($contacts['phone_2']) 
                                                ? preg_replace('/(\d{2})(\d{3})(\d{4})/', '$1.$2.$3', ltrim($contacts['phone_2'], '0')) 
                                                : '';
                                        @endphp
                                        +84 {{ $phone1 }} - +84 {{ $phone2 }}
                                    @else
                                        @php
                                            $phone1 = isset($contacts['phone']) 
                                                ? preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1.$2.$3', $contacts['phone']) 
                                                : '';
                                            $phone2 = isset($contacts['phone_2']) 
                                                ? preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1.$2.$3', $contacts['phone_2']) 
                                                : '';
                                        @endphp
                                        {{ $phone1 }} - {{ $phone2 }}
                                    @endif
                                </span>


                            </div>
                        </div>

                        <div class="infor-wrapper">
                            <div class="info">
                                <span class="label-info">WeChat <br /></span>
                                <span class="value-info">
                                    @if(in_array(app()->getLocale(), ['en', 'lo', 'my']))
                                        +84 {{ preg_replace('/(\d{2})(\d{3})(\d{4})/', '$1.$2.$3', ltrim($contacts['WeChat'], '0')) }}
                                    @else
                                        {{ preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1.$2.$3', $contacts['WeChat']) }}
                                    @endif
                                </span>

                            </div>
                        </div>

                        <div class="infor-wrapper">
                            <div class="info">
                                <span class="label-info">WhatsApp <br /></span>
                                <span class="value-info">
                                    @if(in_array(app()->getLocale(), ['en', 'lo', 'my']))
                                        +84 {{ preg_replace('/(\d{2})(\d{3})(\d{4})/', '$1.$2.$3', ltrim($contacts['WhatsApp'], '0')) }}
                                    @else
                                        {{ preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1.$2.$3', $contacts['WhatsApp']) }}
                                    @endif
                                </span>

                            </div>
                        </div>

                            <div class="infor-wrapper">
                                <div class="info">
                                    <span class="label-info">{{ __('Email') }} <br /></span>
                                    <span class="value-info">{{ $contacts['email'] }}</span>
                                </div>
                            </div>
                            <div class="infor-wrapper-bottom"></div>
                        </div>
                        <div class="section-title-right col-md-6 ">
                            <form action="{{ route('web.addContact') }}" method="post" enctype="multipart/form-data"
                                class="d-flex flex-column submit-form-contact-us">
                                @csrf
                                @if(session('message'))
                                    <div class="toast-contact-us-{{ session('type') }} p-2">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                <div class="text-wrapper">
                                    <span class="label-help">{{ __('Do you need advice?') }}<br /></span>
                                    <span class="value-help">{{ __('Please leave us your information') }}</span>
                                </div>
                                <input class="fullName" placeholder="{{ __('Full_name') }}"
                                    name="lastname"value="{{ old('lastname') }}" />
                                @error('lastname')
                                    <div class="parsley-required">{{ $message }}</div>
                                @enderror
                                <input type="text" class="contact_number" placeholder="{{ __('Phone') }}"
                                    name="contact_number"value="{{ old('contact_number') }}" />
                                @error('contact_number')
                                    <div class="parsley-required">{{ $message }}</div>
                                @enderror
                                <textarea name="description" id="" class="description" placeholder="{{ __('Message') }}">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="parsley-required">{{ $message }}</div>
                                @enderror
                                <!-- captcha  -->
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                <div id="recaptcha-error" style="color: red; margin-top: 5px;"></div>

                                <div class="row">
                                    <div class="col-md-12 col-12">
                                    <button type="submit" class="button-click" onclick="return checkRecaptcha();">
                                        {{ __('Send_information') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
function checkRecaptcha() {
    var response = grecaptcha.getResponse();
    if (response.length === 0) {
        document.getElementById("recaptcha-error").innerHTML = "Vui lòng xác nhận bạn không phải là robot!";
        return false; 
    } else {
        document.getElementById("recaptcha-error").innerHTML = ""; 
        return true; 
}
}
</script>


@endsection
