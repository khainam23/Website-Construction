<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('Invoice') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .banner {
            text-align: center;
            margin-bottom: 30px;
        }
        .banner img {
            max-width: 100%;
            height: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 15px;
        }
        .about h2 {
            color: #28a745;
            font-size: 16px;
            text-transform: uppercase;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }
        .about h1 {
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
            text-transform: uppercase;
            color: #343a40;
        }
        .invoice-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .invoice-info table {
            width: 100%;
        }
        .invoice-info td {
            padding: 8px 0;
        }
        .customer-info {
            margin-bottom: 30px;
            padding: 0 15px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th, .items-table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        .items-table th {
            background-color: #28a745;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }
        .items-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #e9ecef !important;
        }
        .total-row td:last-child {
            color: #28a745;
            font-size: 18px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 0.9em;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .rental-dates {
            font-size: 0.85em;
            color: #6c757d;
            margin-top: 5px;
        }
        .thank-you {
            text-align: center;
            margin: 30px 0;
            font-size: 1.2em;
            color: #28a745;
            padding: 15px;
            border: 1px dashed #28a745;
            border-radius: 8px;
            background-color: #f0fff4;
        }
        .product-card {
            border-left: 3px solid #28a745;
            padding-left: 10px;
        }
        .product-price {
            color: #28a745;
            font-weight: bold;
        }
        .market {
            text-align: center;
            margin-top: 40px;
        }
        .market img {
            height: 30px;
            margin: 0 10px;
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="banner">
            <img src="{{ asset('frontendcss/images/banner.png') }}" alt="BMQ Banner">
        </div>

        <div class="header">
            <div class="logo-container" style="display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('frontendcss/images/logobmq1.png') }}" alt="BMQ Logo" height="80" style="margin-right: 15px;">
                <h2 class="text-logo" style="margin: 0; text-align: left;">{{ __('logo-text-bmq') }} <br> {{__('logo-text-bmq1')}}</h2>
            </div>
            <div class="about">
                <h2>{{ __('INVOICE') }}</h2>
                <h1>{{ __('ORDER DETAILS') }}</h1>
            </div>
        </div>

        <div class="invoice-info">
            <table>
                <tr>
                    <td><strong>{{ __('Order ID') }}:</strong></td>
                    <td>#{{ $order->id }}</td>
                    <td><strong>{{ __('Order Date') }}:</strong></td>
                    <td>{{ $date }}</td>
                </tr>
                <tr>
                    <td><strong>{{ __('Payment Method') }}:</strong></td>
                    <td>{{ $paymentMethod == 'vnpay' ? 'VNPAY' : __('Direct Payment') }}</td>
                    <td><strong>{{ __('Status') }}:</strong></td>
                    <td>{{ __($order->status) }}</td>
                </tr>
            </table>
        </div>

        <div class="about">
            <h2>{{ __('INFORMATION') }}</h2>
            <h1>{{ __('CUSTOMER DETAILS') }}</h1>
        </div>

        <div class="customer-info">
            <p><strong>{{ __('Name') }}:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
            <p><strong>{{ __('Email') }}:</strong> {{ $user->email }}</p>
            <p><strong>{{ __('Phone') }}:</strong> {{ $paymentInfo['phone'] ?? $user->phone ?? 'N/A' }}</p>
            <p><strong>{{ __('Delivery Address') }}:</strong> {{ $paymentInfo['address'] ?? $user->address ?? 'N/A' }}</p>
        </div>

        <div class="about">
            <h2>{{ __('PRODUCTS') }}</h2>
            <h1>{{ __('PRODUCT LIST') }}</h1>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>{{ __('Product') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Quantity') }}</th>
                    <th>{{ __('Unit Price') }}</th>
                    <th>{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $item)
                <tr>
                    <td class="product-card">
                        <strong>{{ $item['product']->name }}</strong>
                        @if($item['is_rental'])
                        <div class="rental-dates">
                            <i class="fas fa-calendar-alt"></i> {{ __('Rental from') }}: {{ date('d/m/Y', strtotime($item['rental_start_date'])) }} 
                            {{ __('to') }}: {{ date('d/m/Y', strtotime($item['rental_end_date'])) }}
                        </div>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $item['is_rental'] ? 'badge-primary' : 'badge-success' }}">
                            {{ $item['is_rental'] ? __('Rental') : __('Sale') }}
                        </span>
                    </td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['product']->price, 0, ',', '.') }}đ</td>
                    <td class="product-price">{{ number_format($item['cost'], 0, ',', '.') }}đ</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4" style="text-align: right; font-size: 16px;">{{ __('Total') }}:</td>
                    <td>{{ number_format($order->total, 0, ',', '.') }}đ</td>
                </tr>
            </tbody>
        </table>

        <div class="thank-you">
            <p>{{ __('Thank you for your purchase at') }} {{ __('logo-text-bmq') }} {{ __('logo-text-bmq1') }}!</p>
            <p>{{ __('We will process your order as soon as possible') }}.</p>
        </div>

        <div class="market">
            <img src="{{ asset('frontendcss/images/co-vi.png') }}" alt="VN">
            <img src="{{ asset('frontendcss/images/co-en.png') }}" alt="EN">
            <img src="{{ asset('frontendcss/images/co-lo.png') }}" alt="LO">
            <img src="{{ asset('frontendcss/images/co-my.png') }}" alt="MY">
        </div>

        <div class="footer">
            <p>{{ __('This is an automated email, please do not reply') }}.</p>
            <p>{{ __('If you have any questions, please contact us via email') }}: support@bmq.com</p>
            <p>&copy; {{ date('Y') }} {{ __('logo-text-bmq') }}. {{ __('All rights reserved') }}.</p>
        </div>
    </div>
</body>
</html>
