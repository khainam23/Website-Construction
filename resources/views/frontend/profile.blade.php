@extends('frontend.layouts.master')
@section('title', 'Profile')

@section('style')
<link rel="stylesheet" href="{{ asset('frontendcss/css/profile.css') }}" />
@endsection

@section('content')
<div class="profile-container">
    <div class="sidebar">
        <h3>{{ __('Category') }}</h3>
        <div class="nav-item active" data-target="profile">{{ __('Profile') }}</div>
        <div class="nav-item" data-target="cart">{{ __('Cart') }}</div>
        <div class="nav-item" data-target="orders">{{ __('Orders') }}</div>
        <div class="nav-item" data-target="password">{{ __('Password') }}</div>
    </div>
    <div class="content">
        <div id="profile" class="content-section active">
            <h2>{{ __('Profile') }}</h2>
            <form id="profile-form" enctype="multipart/form-data">
                <div class="form-group text-center">
                    <label>{{ __('Avatar') }}:</label>
                    <br>
                    <img id="avatar-preview" src="{{ asset($infoUser->avatar) }}" alt="Avatar" class="img-thumbnail"
                        width="150">
                    <br>
                    <input id="avatar" type="file" class="form-control mt-2" name="avatar" accept="image/*"
                        onchange="previewAvatar(event)">
                </div>
                <div class="form-group">
                    <label>{{ __('First Name') }}:</label>
                    <input type="text" class="form-control" name="first_name" value="{{ $infoUser->first_name }}">
                </div>
                <div class="form-group">
                    <label>{{ __('Last Name') }}:</label>
                    <input type="text" class="form-control" name="last_name" value="{{ $infoUser->last_name }}">
                </div>
                <div class="form-group">
                    <label>{{ __('Email') }}:</label>
                    <input type="email" class="form-control" name="email" value="{{ $infoUser->email }}" disabled>
                </div>
                <div class="form-group">
                    <label>{{ __('Phone Number') }}:</label>
                    <input type="text" class="form-control" name="phone" value="{{ $infoUser->phone }}">
                </div>
                <div class="form-group">
                    <label>{{ __('Address') }}:</label>
                    <input type="text" class="form-control" name="address" value="{{ $infoUser->address }}">
                </div>
                <div class="form-group">
                    <label>{{ __('Date of Birth') }}:</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{ $infoUser->date_of_birth }}" max="2007-06-06">
                </div>
                <div class="form-group">
                    <label>{{ __('Gender') }}:</label>
                    <select class="form-control" name="gender">
                        <option value="male" {{ $infoUser->gender == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                        <option value="female" {{ $infoUser->gender == 'female' ? 'selected' : '' }}>{{ __('Female') }}
                        </option>
                        <option value="other" {{ $infoUser->gender == 'other' ? 'selected' : '' }}>{{ __('Other') }}
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
            </form>
        </div>
        <div id="cart" class="content-section">
            <h2>{{ __('Cart') }}</h2>
            @if($cartItems)
            <div class="cart-actions mb-3">
                <button id="deleteSelectedBtn" class="btn btn-danger" disabled>
                    <i class="bi bi-trash"></i> {{ __('Delete Selected') }}
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Product ID') }}</th>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Rental Date') }}</th>
                        <th>{{ __('Return Date') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>
                            <input type="checkbox" class="selectItem" data-max-quantity="{{ $item->max_quantity }}" value="{{ $item->id }}">
                        </td>
                        <td>
                            <span class="badge {{ $item->rental_end_date ? 'badge-primary' : 'badge-success' }}">
                                {{ $item->rental_end_date ? __('Rent') : __('Buy') }}
                            </span>
                        </td>
                        <td>{{ $item->product->id }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ number_format($item->cost, 0, ',', '.') }} đ</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->rental_start_date ? \Carbon\Carbon::parse($item->rental_start_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td>{{ $item->rental_end_date ? \Carbon\Carbon::parse($item->rental_end_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-success payment-btn">
                                    <i class="bi bi-credit-card"></i> {{ __('Payment') }}
                                </button>
                                <button class="btn btn-danger delete-btn" data-id="{{ $item->id }}">
                                    <i class="bi bi-trash"></i> {{ __('Delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-actions mt-3">
                <button id="bulkPaymentBtn" class="btn btn-primary">
                    <i class="bi bi-cash"></i> {{ __('Pay for selected products') }}
                </button>
            </div>
            @else
            <span>{{ __('The cart is empty') }}</span>
            @endIf
        </div>
        <div id="orders" class="content-section">
            <h2>{{ __('Orders') }}</h2>
            @if(count($orders) != 0)
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Order ID') }}</th>
                        <th>{{ __('Total Price') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Phone Number') }}</th>
                        <th>{{ __('Details') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order['id'] }}</td>
                        <td>{{ number_format($order['total'], 0, ',', '.') }} đ</td>
                        <td>
                            @php
                            $statusClasses = [
                            'pending' => 'badge bg-secondary', // Chờ xử lý (màu xám)
                            'confirm' => 'badge bg-primary', // Đã xác nhận (xanh dương)
                            'ship' => 'badge bg-warning text-dark', // Đang giao hàng (vàng cam)
                            'delivery' => 'badge bg-success', // Đã giao hàng (xanh lá)
                            'return' => 'badge bg-info text-dark', // Trả hàng (xanh nhạt)
                            'cancel' => 'badge bg-danger', // Đã hủy (đỏ)
                            ];
                            $statusClass = $statusClasses[$order['status']] ?? 'badge bg-dark'; // Mặc định nếu trạng thái không hợp lệ
                            @endphp

                            <span class="{{ $statusClass }}">
                                {{ ucfirst($order['status']) }}
                            </span>
                        </td>

                        <td>{{ $order['address'] }}</td>
                        <td>{{ $order['phone'] }}</td>
                        <td>
                            <ul>
                                @foreach($order['details'] as $detail)
                                <li>
                                    {{ $detail['product']['name'] }} - {{ $detail['quantity'] }} x
                                    {{ number_format($detail['product']['price'], 0, ',', '.') }} đ
                                    @if(!empty($detail['rental_end_date']))
                                    - {{ __('Rental Date') }}: {{ $detail['rental_start_date'] }}
                                    {{ __('and Return Date') }}:
                                    {{ $detail['rental_end_date'] }}
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <button id="cancel" class="btn {{ $order['status']=='confirm' ? 'btn-danger' : 'btn-secondary' }}"
                                {{ $order['status']=='confirm' ? '' : 'disabled' }}>
                                {{ __('Cancel') }}
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <span>{{ __('No successful orders yet') }}</span>
            @endif
        </div>
        <div id="password" class="content-section">
            <h2 class="mb-4">{{ __('Password') }}</h2>
            <form id="password-form">
                <div class="form-group">
                    <label for="current-password">{{ __('Current Password') }}</label>
                    <input id="current-password" name="current-password" type="password" class="form-control"
                        placeholder="{{ __('Enter old password') }}" required>
                </div>
                <div class="form-group">
                    <label for="new-password">{{ __('New Password') }}</label>
                    <input id="new-password" name="new-password" type="password" class="form-control"
                        placeholder="{{ __('Enter new password') }}" required>
                </div>
                <div class="form-group">
                    <label for="confrim-password">{{ __('Confirm Password') }}</label>
                    <input id="confrim-password" name="confrim-password" type="password" class="form-control"
                        placeholder="{{ __('Re-enter new password') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Update password') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Nav chuyển tab -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function showTabFromHash() {
            let hash = window.location.hash.substring(1); // Lấy phần sau dấu #
            if (hash) {
                let targetTab = document.querySelector(`.nav-item[data-target="${hash}"]`);
                if (targetTab) {
                    document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                    targetTab.classList.add('active');

                    document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
                    document.getElementById(hash).classList.add('active');
                }
            }
        }

        // Khi trang tải, kiểm tra URL hash
        showTabFromHash();

        // Lắng nghe sự kiện click để thay đổi hash
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');

                let target = this.getAttribute('data-target');
                window.location.hash = target; // Cập nhật hash trên URL

                document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
                document.getElementById(target).classList.add('active');
            });
        });

        // Khi hash thay đổi (ví dụ: người dùng nhấn nút quay lại trên trình duyệt)
        window.addEventListener("hashchange", showTabFromHash);
    });
</script>

<!-- Cập nhật thông tin cá nhân -->
<script>
    function previewAvatar(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('avatar-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    $(document).ready(function() {
        let initialData = {};
        let initialAvatar = null;

        function getFormData() {
            $('#profile-form').find('input, select').each(function() {
                if ($(this).attr('type') !== 'file') {
                    initialData[$(this).attr('name')] = $(this).val();
                }
            });

            let avatarInput = $('#avatar')[0];
            if (avatarInput.files.length > 0) {
                initialAvatar = avatarInput.files[0];
            }
        }

        getFormData(); // Lưu dữ liệu ban đầu

        $('#profile-form').on('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);
            let hasChanged = false;

            // Kiểm tra thay đổi dữ liệu text, select
            $(this).find('input, select').each(function() {
                if ($(this).attr('type') !== 'file') {
                    let name = $(this).attr('name');
                    let value = $(this).val();

                    if (initialData[name] !== value) {
                        hasChanged = true;
                    }
                }
            });

            // Kiểm tra xem có ảnh mới không
            let avatarInput = $('#avatar')[0];
            if (avatarInput.files.length > 0 && avatarInput.files[0] !== initialAvatar) {
                hasChanged = true;
            }

            if (!hasChanged) {
                Swal.fire({
                    icon: 'info',
                    title: "{{ __('No changes') }}",
                    text: "{{ __('Not Found') }}",
                });
                return;
            }

            $.ajax({
                url: "{{ route('api.update.info') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                beforeSend: function() {
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
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Update successful!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        getFormData(); // Cập nhật lại dữ liệu sau khi lưu thành công

                        // Cập nhật avatar preview nếu có ảnh mới
                        if (avatarInput.files.length > 0) {
                            let reader = new FileReader();
                            reader.onload = function(e) {
                                $('#avatar-preview').attr('src', e.target.result);
                            };
                            reader.readAsDataURL(avatarInput.files[0]);
                        }
                    });
                },
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred, please try again.',
                    });
                }
            });
        });

        // Hiển thị ảnh preview ngay khi chọn file
        $('#avatar').on('change', function() {
            let file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<!-- Cập nhật mật khẩu -->
<script>
    $(document).ready(function() {
        $('#password-form').on('submit', function(event) {
            event.preventDefault();

            let currentPassword = $('#current-password').val();
            let newPassword = $('#new-password').val();
            let confirmPassword = $('#confrim-password').val();

            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'New password does not match, please re-enter.',
                });
                return;
            }

            $.ajax({
                url: "{{ route('api.update.password') }}",
                type: "POST",
                data: {
                    current_password: currentPassword,
                    new_password: newPassword,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
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
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                    }).then(() => {
                        $('#password-form')[0].reset();
                    });
                },
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON.message || 'An error occurred, please try again.',
                    });
                }
            });
        });
    });
</script>

<!-- Lựa chọn loại thanh toán -->
<script>
    // Chọn loại thanh toán 
    function handlePayment(items) {
        Swal.fire({
            title: "{{ __('Choose payment method') }}",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "{{ __('VNPAY') }}",
            denyButtonText: "{{ __('Direct') }}",
            cancelButtonText: "{{ __('Cancel') }}",
            icon: "question"
        }).then((result) => {
            if (result.isConfirmed) {
                processPayment(items, "vnpay");
            } else if (result.isDenied) {
                processPayment(items, "direct");
            }
        });
    }

    function enterPaymentInfo() {
        let paymentInfo = {
            name: "{{ $infoUser->last_name }}",
            email: "{{ $infoUser->email }}",
            phone: "{{ $infoUser->phone }}",
            address: "{{ $infoUser->address }}"
        };

        return Swal.fire({
            title: "{{ __('Enter purchase information') }}",
            html: `
                    <input id="swal-phone" class="swal2-input" placeholder="{{ __('Phone number') }}" type="phone" value="${paymentInfo.phone}">
                    <input id="swal-address" class="swal2-input" placeholder="{{ __('Address') }}" value="${paymentInfo.address}">
                `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: "{{ __('Confirm') }}",
            cancelButtonText: "{{ __('Cancel') }}",
            preConfirm: () => {
                return {
                    phone: document.getElementById("swal-phone").value,
                    address: document.getElementById("swal-address").value
                };
            }
        });
    }

    // Tiến hành thanh toán
    function processPayment(items, method) {
        enterPaymentInfo().then((result) => {
            paymentInfo = result.value;

            if (!paymentInfo) return;

            $.ajax({
                url: "{{ route('api.payment') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                contentType: "application/json",
                data: JSON.stringify({
                    items: items,
                    method: method,
                    paymentInfo: paymentInfo
                }),
                beforeSend: function() {
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
                success: function(data) {
                    if (data.success) {
                        if (method === "vnpay") {
                            window.location.href = data.vnpay_url; // Chuyển hướng đến VNPAY
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: "{{ __('Payment successful!') }}",
                                text: "{{ __('The products have been paid.') }}",
                                confirmButtonText: "OK"
                            }).then(() => {
                                window.location.href = "{{ route('web.profile') }}#orders"; // Chuyển hướng về trang đơn hàng
                                setTimeout(() => {
                                    window.location.reload(); // Làm mới trang sau khi chuyển hướng
                                }, 500);
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "{{ __('Payment error!') }}",
                            text: data.message || "{{ __('An error occurred during payment.') }}",
                            confirmButtonText: "OK"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "{{ __('Payment error!') }}",
                        text: xhr.responseJSON || "{{ __('An error occurred during payment.') }}",
                        confirmButtonText: "OK"
                    });
                    console.error("Error:", xhr.responseText);
                }
            });
        });
    }
</script>

<!-- Thanh toán hàng loạt -->
<script>
    $(document).ready(function() {
        const selectAllCheckbox = $("#selectAll");
        const itemCheckboxes = $(".selectItem");
        const bulkPaymentBtn = $("#bulkPaymentBtn");

        function updateButtonState() {
            let selectedCount = $(".selectItem:checked").length;
            bulkPaymentBtn.prop("disabled", selectedCount < 2);
            selectAllCheckbox.prop("checked", selectedCount === itemCheckboxes.length);
        }

        // Khi nhấn chọn tất cả
        selectAllCheckbox.on("change", function() {
            itemCheckboxes.prop("checked", this.checked);
            updateButtonState();
        });

        // Khi chọn từng sản phẩm
        itemCheckboxes.on("change", updateButtonState);

        // Mặc định vô hiệu hóa nút thanh toán hàng loạt
        bulkPaymentBtn.prop("disabled", true);

        // Khi nhấn nút thanh toán hàng loạt
        bulkPaymentBtn.on("click", function() {
            let selectedItems = $(".selectItem:checked").map((key, val) => {
                let row = $(val).closest("tr");
                let productId = row.find("td:nth-child(3)").text().trim();
                let cost = row.find("td:nth-child(5)").text().trim();
                let quantity = row.find("td:nth-child(6)").text().trim();
                return {
                    'id': val.value,
                    'productId': productId,
                    'quantity': quantity,
                    'cost': cost.substring(0, cost.length - 2).replace(/\./g, '').trim()
                };
            }).get();


            if (selectedItems.length < 2) {
                Swal.fire({
                    icon: "warning",
                    title: "{{ __('Select at least 2 products') }}",
                    text: "{{ __('You need to select at least 2 products to pay!') }}",
                    confirmButtonText: "OK"
                });
                return;
            }

            Swal.fire({
                title: "{{ __('Confirm payment?') }}",
                text: `{{ __('You are paying for') }} ${selectedItems.length} {{ __('products.') }}`,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ __('Pay') }}",
                cancelButtonText: "{{ __('Cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    handlePayment(selectedItems);
                }
            });
        });
    });
</script>

<!-- Thanh toán từng sản phẩm -->
<script>
    $(document).ready(function() {
        function formatDateForInput(dateStr) {
            if (!dateStr || dateStr === "-") return ""; // Trả về chuỗi rỗng nếu không có ngày
            let parts = dateStr.split("/"); // Tách chuỗi theo dấu "/"
            if (parts.length === 3) {
                return `${parts[2]}-${parts[1]}-${parts[0]}`; // Chuyển sang YYYY-MM-DD
            }
            return ""; // Trả về chuỗi rỗng nếu không đúng định dạng
        }

        function showEditForm(items) {
            let formHtml = `<form id="editPaymentForm">`;
            items.forEach(item => {
                formHtml += `
                    <div class="payment-item d-flex flex-column">
                        <h5>${item.name}</h5>
                        <label>{{ __('Quantity') }}:</label>
                        <input type="number" class="swal2-input" name="quantity_${item.id}" value="${item.quantity}" min="1" max="${item.maxQuantity}">
                        ${item.end !== '-' ? `
                            <label>{{ __('Rental Date') }}:</label>
                            <input id="rental_start" type="date" class="swal2-input" name="start_${item.id}" value="${formatDateForInput(item.start)}">
                            <label>{{ __('Return Date') }}:</label>
                            <input id="rental_end" type="date" class="swal2-input" name="end_${item.id}" value="${formatDateForInput(item.end)}">
                        ` : ""}
                        <input type="hidden" name="id_${item.id}" value="${item.id}">
                        <input type="hidden" name="old_quantity_${item.id}" value="${item.quantity}">
                        ${item.end !== '-' ? `
                            <input type="hidden" name="old_start_${item.id}" value="${formatDateForInput(item.start)}">
                            <input type="hidden" name="old_end_${item.id}" value="${formatDateForInput(item.end)}">
                        ` : ""}
                    </div>
                    <hr>`;
            });
            formHtml += `</form>`;

            Swal.fire({
                title: "{{ __('Edit information before payment') }}",
                html: formHtml,
                didOpen: () => {
                    let tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    let tomorrowDate = tomorrow.toISOString().split('T')[0];

                    let startInput = document.getElementById("rental_start");
                    let endInput = document.getElementById("rental_end");

                    if (startInput && endInput) {
                        startInput.min = tomorrowDate;
                        startInput.value = tomorrowDate;
                        endInput.min = tomorrowDate;
                        endInput.value = tomorrowDate;
                    }
                },
                showCancelButton: true,
                confirmButtonText: "{{ __('Confirm') }}",
                cancelButtonText: "{{ __('Cancel') }}",
                preConfirm: () => {
                    let updatedItems = [];
                    items.forEach(item => {
                        let newQuantity = $(`[name=quantity_${item.id}]`).val();
                        let newStart = item.isRental ? formatDateForInput($(`[name=start_${item.id}]`).val()) : null;
                        let newEnd = item.isRental ? formatDateForInput($(`[name=end_${item.id}]`).val()) : null;

                        let oldQuantity = $(`[name=old_quantity_${item.id}]`).val();
                        let oldStart = item.isRental ? formatDateForInput($(`[name=old_start_${item.id}]`).val()) : null;
                        let oldEnd = item.isRental ? formatDateForInput($(`[name=old_end_${item.id}]`).val()) : null;

                        let changes = {};
                        // Bắt buộc có
                        changes.id = item.id;
                        changes.productId = item.productId;
                        changes.quantity = item.quantity;
                        changes.cost = item.cost.substring(0, item.cost.length - 2).replace(/\./g, '').trim(); // Bỏ dấu "." và "đ" rồi chuyển sang số
                        if (newQuantity !== oldQuantity) changes.quantity = newQuantity;
                        if (item.isRental) {
                            if (newStart !== oldStart) changes.start = newStart;
                            if (newEnd !== oldEnd) changes.end = newEnd;

                            let price = changes.cost;

                            let startDate = new Date(newStart);
                            let endDate = new Date(newEnd);

                            let timeDiff = endDate - startDate; // Độ chênh lệch tính bằng milliseconds
                            let daysDiff = timeDiff / (1000 * 60 * 60 * 24); // Chuyển đổi sang ngày

                            if (daysDiff > 4 && daysDiff < 7) {
                                price *= 0.9; // Giảm 10% => nhân 0.9
                            } else if (daysDiff > 8 && daysDiff < 14) {
                                price *= 0.85; // Giảm 15% => nhân 0.85
                            } else if (daysDiff > 14) {
                                price *= 0.8; // Giảm 20% => nhân 0.8
                            }

                            changes.cost = price;
                        }

                        if (Object.keys(changes).length > 0) {
                            updatedItems.push(changes);
                        }
                    });
                    return updatedItems;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    handlePayment(result.value);
                }
            });
        }

        $(".payment-btn").on("click", function() {
            let row = $(this).closest("tr");
            let itemCheckbox = row.find(".selectItem");
            let itemId = itemCheckbox.val();
            let maxQuantity = itemCheckbox.data('max-quantity');
            let productId = row.find("td:nth-child(3)").text().trim();
            let productName = row.find("td:nth-child(4)").text().trim();
            let cost = row.find("td:nth-child(5)").text().trim();
            let quantity = row.find("td:nth-child(6)").text().trim();
            let rentalStart = row.find("td:nth-child(7)").text().trim();
            let rentalEnd = row.find("td:nth-child(8)").text().trim();
            let isRental = rentalEnd !== "-"; // Kiểm tra có phải là thuê không

            showEditForm([{
                id: itemId,
                productId: productId,
                name: productName,
                cost: cost,
                quantity: quantity,
                start: rentalStart,
                end: rentalEnd,
                isRental: isRental,
                maxQuantity: maxQuantity
            }]);
        });
    });
</script>

<!-- Xóa giỏ hàng -->
<script>
    $(document).ready(function() {
        const selectAllCheckbox = $("#selectAll");
        const itemCheckboxes = $(".selectItem");
        const bulkPaymentBtn = $("#bulkPaymentBtn");
        const deleteSelectedBtn = $("#deleteSelectedBtn");

        function updateButtonState() {
            let selectedCount = $(".selectItem:checked").length;
            bulkPaymentBtn.prop("disabled", selectedCount < 2);
            deleteSelectedBtn.prop("disabled", selectedCount === 0);
            selectAllCheckbox.prop("checked", selectedCount === itemCheckboxes.length && selectedCount > 0);
        }

        // Khi nhấn chọn tất cả
        selectAllCheckbox.on("change", function() {
            itemCheckboxes.prop("checked", this.checked);
            updateButtonState();
        });

        // Khi chọn từng sản phẩm
        itemCheckboxes.on("change", updateButtonState);

        // Xử lý xóa từng sản phẩm
        $(".delete-btn").on("click", function() {
            const itemId = $(this).data("id");
            deleteCartItems([itemId]);
        });

        // Xử lý xóa nhiều sản phẩm
        $("#deleteSelectedBtn").on("click", function() {
            let selectedItems = $(".selectItem:checked").map(function() {
                return $(this).val();
            }).get();

            if (selectedItems.length === 0) {
                Swal.fire({
                    icon: "warning",
                    title: "{{ __('No items selected') }}",
                    text: "{{ __('Please select at least one item to delete.') }}",
                    confirmButtonText: "OK"
                });
                return;
            }

            deleteCartItems(selectedItems);
        });

        // Hàm xóa giỏ hàng
        function deleteCartItems(itemIds) {
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                text: itemIds.length > 1 
                    ? "{{ __('You are about to delete') }} " + itemIds.length + " {{ __('items from your cart.') }}"
                    : "{{ __('You are about to delete this item from your cart.') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "{{ __('Yes, delete it!') }}",
                cancelButtonText: "{{ __('Cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('api.cart.delete') }}",
                        type: "POST",
                        data: {
                            ids: itemIds,
                            _token: "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
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
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "{{ __('Deleted!') }}",
                                text: response.message || "{{ __('Cart items have been deleted.') }}",
                                confirmButtonText: "OK"
                            }).then(() => {
                                // Reload the page to refresh cart
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "{{ __('Error!') }}",
                                text: xhr.responseJSON?.message || "{{ __('An error occurred while deleting items.') }}",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                }
            });
        }

        // Update button states on page load
        updateButtonState();
    });
</script>

<!-- Hủy đơn hàng -->
<script>
    $(document).ready(function() {
        $("#cancel.btn-danger").on("click", function() {
            let row = $(this).closest("tr");
            let orderId = row.find("td:nth-child(1)").text().trim();

            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You will not be able to recover this order!') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "{{ __('Yes, cancel it!') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('api.order.cancel') }}",
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        contentType: "application/json",
                        data: JSON.stringify({
                            orderId: orderId
                        }),
                        success: function(data) {
                            Swal.fire({
                                icon: "success",
                                title: "{{ __('Order canceled!') }}",
                                text: "{{ __('The order has been canceled.') }}",
                                confirmButtonText: "OK"
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: "error",
                                title: "{{ __('Error!') }}",
                                text: "{{ __('An error occurred while canceling the order.') }}",
                                confirmButtonText: "OK"
                            });
                            console.error("Error:", xhr.responseText);
                        }
                    })
                }
            })
        })
    })
</script>
@endsection