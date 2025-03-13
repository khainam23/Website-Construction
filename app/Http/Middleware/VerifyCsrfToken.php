protected $except = [
    '/api/login', // Bỏ qua kiểm tra CSRF cho AJAX login
    '/api/orders/*', // Bỏ qua kiểm tra CSRF cho AJAX cập nhật order
];
