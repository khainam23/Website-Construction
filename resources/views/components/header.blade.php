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
                                                href="{{route('admin.language', ['vi'])}}">Vietnamese</a>
                                            <a class="dropdown-item"
                                                href="{{route('admin.language', ['en'])}}">English</a>
                                            <a class="dropdown-item" href="{{route('admin.language', ['lo'])}}">Lao</a>
                                            <a class="dropdown-item"
                                                href="{{route('admin.language', ['my'])}}">Myanmar</a>
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
                                <a class="nav-link" href="{{ route('web.index') }}">TRANG CHỦ<span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item 
                            {{(\Request::route()->getName() == 'web.about') ? 'active' : ''}}
                            ">
                                <a class="nav-link" href="{{ route('web.about') }}">GIỚI THIỆU<span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item 
                                {{ (\Request::route()->getName() == 'web.product' && \Request::route('type') == 'sale')
                                    || (\Request::route()->getName() == 'web.product-detail') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('web.product', ['type' => 'sale']) }}">
                                    SẢN PHẨM BÁN <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li
                                class="nav-item 
                                {{ (\Request::route()->getName() == 'web.product' && \Request::route('type') == 'rental') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('web.product', ['type' => 'rental']) }}">
                                    SẢN PHẨM CHO THUÊ <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item 
                            {{(\Request::route()->getName() == 'web.contact') ? 'active' : ''}}
                            ">
                                <a class="nav-link" href="{{ route('web.contact') }}">LIÊN HỆ <span
                                        class="sr-only">(current)</span></a>
                            </li>
                            @if(session()->has('user'))
                                <!-- Nếu đã đăng nhập -->
                                <li class="nav-item {{ \Request::route()->getName() == 'web.profile' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('web.profile') }}">
                                        Xin chào, {{ session('user')['name'] }}
                                        <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('api.logout') }}">
                                        Đăng xuất
                                    </a>
                                </li>
                            @else
                                <!-- Nếu chưa đăng nhập -->
                                <li class="nav-item {{ \Request::route()->getName() == 'web.login' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('web.login') }}">Đăng nhập<span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item {{ \Request::route()->getName() == 'web.register' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('web.register') }}">Đăng ký<span
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