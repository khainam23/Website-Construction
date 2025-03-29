<div class="header">
    <div class="header-content ">
        <div class="container">
            <div class="header-top">
                <div class="header-top-phone">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="header-top-lang">
                    <div class="header-top-lang">
                        <!-- Navbar for language selection -->
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <div class="collapse navbar-collapse" id="navbarNav1">
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @if($lang == 'vi')
                                                <img src="{{ asset('frontendcss/images/co-vi.png')}}" alt="">
                                            @endif
                                            @if($lang == 'en')
                                                <img src="{{ asset('frontendcss/images/co-en.png')}}" alt="">
                                            @endif
                                            @if($lang == 'lo')
                                                <img src="{{ asset('frontendcss/images/co-lo.png')}}" alt="">
                                            @endif
                                            @if($lang == 'my')
                                                <img src="{{ asset('frontendcss/images/co-my.png')}}" alt="">
                                            @endif
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item"
                                                href="{{route('web.language', ['lang' => 'vi'])}}" onclick="return switchLanguage('vi')">{{ __('Vietnamese') }}</a>
                                            <a class="dropdown-item"
                                                href="{{route('web.language', ['lang' => 'en'])}}" onclick="return switchLanguage('en')">{{ __('English') }}</a>
                                            <a class="dropdown-item" 
                                                href="{{route('web.language', ['lang' => 'lo'])}}" onclick="return switchLanguage('lo')">{{ __('Laos') }}</a>
                                            <a class="dropdown-item"
                                                href="{{route('web.language', ['lang' => 'my'])}}" onclick="return switchLanguage('my')">{{ __('Myanmarr') }}</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <div>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="logo" href="{{ route('web.index') }}">
                        <img class="img-logo" src="{{ asset('frontendcss/images/logobmq1.png')}}" alt="">
                        <h2 class="text-logo">{{ __('logo-text-bmq') }} <br> {{__('logo-text-bmq1')}}</h2>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item 
                            {{(\Request::route()->getName() == 'web.index') ? 'active' : ''}}
                            ">
                                <a class="nav-link" href="{{ route('web.index') }}">{{ __('Home') }}<span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item 
                            {{(\Request::route()->getName() == 'web.about') ? 'active' : ''}}
                            ">
                                <a class="nav-link" href="{{ route('web.about') }}">{{ __('About') }}<span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <li
                                class="nav-item 
                                {{ (\Request::route()->getName() == 'web.product' && \Request::route('type') == 'sale') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('web.product', ['type' => 'sale']) }}">
                                    {{ __('Product_sale') }} <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li
                                class="nav-item 
                                {{ (\Request::route()->getName() == 'web.product' && \Request::route('type') == 'rental') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('web.product', ['type' => 'rental']) }}">
                                    {{ __('Product_rental') }} <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item 
                            {{(\Request::route()->getName() == 'web.contact') ? 'active' : ''}}
                            ">
                                <a class="nav-link" href="{{ route('web.contact') }}">{{ __('Contact') }} <span
                                        class="sr-only">(current)</span></a>
                            </li>
                            @if(session()->has('user'))
                                <!-- Nếu đã đăng nhập -->
                                <li class="nav-item {{ \Request::route()->getName() == 'web.profile' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('web.profile') }}">
                                        {{ __('Hello') }}, {{ session('user')['name'] }}
                                        <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('api.logout') }}">
                                        {{ __('Log Out') }}
                                    </a>
                                </li>
                            @else
                                <!-- Nếu chưa đăng nhập -->
                                <li class="nav-item {{ \Request::route()->getName() == 'web.login' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('web.login') }}">{{ __('Login') }}<span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item {{ \Request::route()->getName() == 'web.register' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('web.register') }}">{{ __('Register') }}<span
                                            class="sr-only">(current)</span></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>