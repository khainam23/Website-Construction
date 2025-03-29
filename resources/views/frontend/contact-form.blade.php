<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #295bae;
            color: white;
            padding: 15px 20px;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #295bae;
        }
        .value {
            margin-top: 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Thông báo cần hỗ trợ</h2>
    </div>
    <div class="content">
        <div class="field">
            <div class="label">Tên:</div>
            <div class="value">{{ $name }}</div>
        </div>
        <div class="field">
            <div class="label">Số điện thoại:</div>
            <div class="value">{{ $phone }}</div>
        </div>
        <div class="field">
            <div class="label">Tình huống:</div>
            <div class="value">{{ $description }}</div>
        </div>
    </div>
    <div class="footer">
        <p>Email này được gửi tự động từ hệ thống website BMQ Production.</p>
    </div>
</body>
</html>
