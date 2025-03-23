<style>
    .footers-logo {
        position: fixed;
        right: 20px;
        bottom: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        z-index: 1100;
    }


    .footer-logo-container,
    .back-to-top-container {
        width: 70px;
        height: 70px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .footer-logo-container:hover,
    .back-to-top-container:hover {
        transform: scale(1.1);
    }

    .footer-logo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .back-to-top {
        width: 50px;
        height: 50px;
        background-color: #333;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        text-decoration: none !important;
    }
</style>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-left col-md-7">
                <img src="ảnh logo " alt="">
                <h1>{{ __('BMQ PRODUCTION AND TRADING JOINT STOCK COMPANY') }}</h1>
                <h2>{{ __('Headquarters') }}</h2>
                {{-- <p>
                    @if($lang === 'vi')
                    {{ $contacts['address'] }}
                    @else
                    {{ $contacts['address_en'] }}
                    @endif
                </p>

                <h2>{{ __('Representative office') }}</h2>
                <p>
                    @if($lang === 'vi')
                    {{ $contacts['representative_office'] }}
                    @else
                    {{ $contacts['representative_office_en'] }}
                    @endif
                </p>     --}}

                <h2>{{ __('CONTACT') }}</h2>
                {{-- <p>
                    @if($lang === 'vi')
                    {{ preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1.$2.$3', $contacts['phone']) }} -
                    {{ preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1.$2.$3', $contacts['phone_2']) }}
                    @else
                    {{ preg_replace('/(\+84)(\d{2})(\d{3})(\d{4})/', '$1 $2.$3.$4', $contacts['phone_en']) }} -
                    {{ preg_replace('/(\+84)(\d{2})(\d{3})(\d{4})/', '$1 $2.$3.$4', $contacts['phone_2en']) }}
                    @endif
                </p> --}}

                <h2>WeChat</h2>
                {{-- <p>
                    @if($lang === 'vi')
                    {{ preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1.$2.$3', $contacts['WeChat']) }}
                    @else
                    {{ preg_replace('/(\+84)(\d{2})(\d{3})(\d{4})/', '$1 $2.$3.$4', $contacts['WeChat_en']) }}
                    @endif
                </p> --}}

                <h2>WhatsApp</h2>
                {{-- <p>
                    @if($lang === 'vi')
                    {{ preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1.$2.$3', $contacts['WhatsApp']) }}
                    @else
                    {{ preg_replace('/(\+84)(\d{2})(\d{3})(\d{4})/', '$1 $2.$3.$4', $contacts['WhatsApp_en']) }}
                    @endif
                </p> --}}

                <h2>EMAIL</h2>
                {{-- <p>{{$contacts['email']}}</p> --}}
                <div>
                    <p>Copyright ©2025 - BMQ TRADING., JSC</p>
                </div>
            </div>
            <div class="footer-right col-md-5">
                <!-- <div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14891.425055477474!2d105.76262771799524!3d21.078402294596174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31345546f60b20a5%3A0xe5a46f5a2bfaa542!2zQ8O0bmcgVHkgQ-G7lSBQaOG6p24gVGjGsMahbmcgTeG6oWkgQk1R!5e0!3m2!1svi!2s!4v1740709355136!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div> -->
                <a href="LINK GG MAP " target="_blank">
                    <div class ="img-map">
                        <img src="ANH GG MAP" alt="">
                    </div> 
                </a>              
            </div>
        
            <div class="footers-logo">
                <a href="LINK DẪN ĐẾN THẰNG NÀO">
                    <div class="footer-logo-container">
                        <img src="ẢNH LOGO " alt="Logo ISO" class="footer-logo">
                    </div>
                </a>
                
                <div class="back-to-top-container">
                    <a href="#" id="back-to-top" class="back-to-top">
                        <i class="fa-solid fa-arrow-up"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>