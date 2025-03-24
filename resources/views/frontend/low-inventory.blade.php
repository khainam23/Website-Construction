<!DOCTYPE html>
<html>
<head>
    <title>Cảnh báo hàng tồn kho thấp</title>
</head>
<body>
    <h2>Cảnh báo: Hàng tồn kho thấp</h2>
    <p>Sản phẩm có ID: {{ $product_id }} đang có số lượng tồn kho thấp.</p>
    <ul>
        <li>Loại: {{ $type }}</li>
        <li>Số lượng còn lại: {{ $quantity }}</li>
    </ul>
    <p>Vui lòng kiểm tra và bổ sung hàng tồn kho.</p>
</body>
</html>