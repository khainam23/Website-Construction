<!DOCTYPE html>
<html>
<head>
    <title>Cảnh báo: Hàng tồn kho thấp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .warning {
            color: #721c24;
            font-weight: bold;
        }
        .details {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>⚠️ Cảnh báo: Hàng tồn kho thấp</h2>
        </div>
        
        <p>Kính gửi Quản lý,</p>
        
        <p>Hệ thống phát hiện một sản phẩm có lượng tồn kho thấp cần được bổ sung ngay:</p>
        
        <div class="details">
            <p><strong>Sản phẩm:</strong> {{ $product_name }} (ID: {{ $product_id }})</p>
            <p><strong>Loại:</strong> {{ $type_text }} ({{ $type }})</p>
            <p class="warning"><strong>Số lượng tồn kho hiện tại:</strong> {{ $quantity }}</p>
        </div>
        
        <p>Vui lòng kiểm tra và bổ sung hàng tồn kho để đảm bảo đáp ứng nhu cầu khách hàng.</p>
        
        <p>Trân trọng,<br>Hệ thống quản lý kho</p>
        
        <div class="footer">
            <p>Email này được gửi tự động từ hệ thống, vui lòng không phản hồi lại email này.</p>
        </div>
    </div>
</body>
</html>