@extends('admin.layouts.master')

@section('title', __('Order Details'))

@section('css')
<style>
    .order-card {
        border-radius: 10px;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }
    
    .order-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #ebedf2;
        font-weight: 600;
    }
    
    .order-info-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 1rem 0;
    }
    
    .order-info-item {
        padding: 0.5rem 1rem;
        background-color: #f8f9fa;
        border-radius: 6px;
        display: flex;
        align-items: center;
        min-width: 200px;
        flex-wrap: nowrap; /* Prevent wrapping */
    }
    
    .order-info-label {
        font-weight: 600;
        color: #495057;
        margin-right: 0.5rem;
        white-space: nowrap;
        flex-shrink: 0; /* Prevent label from shrinking */
    }
    
    .order-info-value {
        flex-grow: 0; /* Don't grow */
        white-space: nowrap; /* Prevent wrapping */
    }
    
    .status-item {
        display: flex;
        align-items: center;
        flex-basis: 300px; /* Fixed width for status item */
        flex-wrap: nowrap;
        overflow: visible;
    }
    
    .status-select-container {
        position: relative;
        display: flex;
        align-items: center;
        vertical-align: middle;
        width: 140px; /* Fixed width */
        margin-left: 0.5rem;
        flex-shrink: 0;
    }
    
    .status-badge-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
    }
    
    .status-select {
        padding-left: 30px;
        width: 100%;
        height: 30px;
        font-size: 0.875rem;
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }
    
    .product-table {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
    }
    
    .product-table thead {
        background-color: #f8f9fa;
    }
    
    .product-table th {
        font-weight: 600;
        color: #495057;
    }
    
    .action-btn {
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Order Details') }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Orders') }}
            </a>
        </div>

        <div class="card order-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>{{ __('Order Information') }}</span>
                <span class="badge bg-primary">#{{ $order->id }}</span>
            </div>
            <div class="card-body">
                <div class="order-info-container">
                    <div class="order-info-item">
                        <span class="order-info-label">{{ __('Customer') }}:</span>
                        <span class="order-info-value">{{ $order->user->first_name }} {{ $order->user->last_name }}</span>
                    </div>
                    
                    <div class="order-info-item">
                        <span class="order-info-label">{{ __('Total') }}:</span>
                        <span class="order-info-value fw-bold">{{ $order->total }}</span>
                    </div>
                    
                    <div class="order-info-item">
                        <span class="order-info-label">{{ __('Address') }}:</span>
                        <span class="order-info-value">
                            <i class="fas fa-map-marker-alt text-muted"></i> {{ $order->address }}
                        </span>
                    </div>
                    
                    <div class="order-info-item">
                        <span class="order-info-label">{{ __('Phone') }}:</span>
                        <span class="order-info-value">
                            <i class="fas fa-phone text-muted"></i> {{ $order->phone }}
                        </span>
                    </div>
                    
                    <div class="order-info-item status-item" style="display: flex;">
                        <span class="order-info-label">{{ __('Status') }}:</span>
                        <input type="hidden" value="{{ $order->status }}" id="order-status">
                        @php
                            $statusIcons = [
                                'pending' => 'fas fa-clock',
                                'confirm' => 'fas fa-check',
                                'ship' => 'fas fa-shipping-fast',
                                'delivery' => 'fas fa-box-open',
                                'return' => 'fas fa-undo',
                                'cancel' => 'fas fa-times'
                            ];
                            $currentIcon = $statusIcons[$order->status] ?? 'fas fa-question';
                        @endphp
                        <div class="status-select-container">
                            <span class="status-badge-icon"><i class="{{ $currentIcon }}"></i></span>
                            <select id="status-select" class="form-select form-select-sm status-select">
                                @php
                                    $statuses = ['confirm', 'ship', 'delivery', 'return', 'cancel'];
                                @endphp
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card order-card mt-3">
            <div class="card-header">
                {{ __('Order Items') }}
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover product-table mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Product') }}</th>
                                <th class="text-center">{{ __('Quantity') }}</th>
                                <th class="text-center">{{ __('Cost') }}</th>
                                <th>{{ __('Order Information') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-2">
                                                <div class="fw-bold">{{ $detail->product->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-center fw-bold">{{ $detail->cost }}</td>
                                    <td>
                                        @if($detail->rental_start_date && $detail->rental_end_date && $detail->duration)
                                            <div>
                                                <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                                <span class="fw-medium">{{ __('Start Date') }}: </span>{{ $detail->rental_start_date }}
                                            </div>
                                            <div>
                                                <i class="fas fa-calendar-check me-1 text-success"></i>
                                                <span class="fw-medium">{{ __('End Date') }}: </span>{{ $detail->rental_end_date }}
                                            </div>
                                            <div>
                                                <i class="fas fa-clock me-1 text-info"></i>
                                                <span class="fw-medium">{{ __('Rental Duration') }}: </span>{{ $detail->duration }}
                                            </div>
                                        @else
                                            <span class="text-muted">{{ __('Product_sale') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('status-select').addEventListener('change', function () {
            let newStatus = this.value;
            let currentStatus = document.getElementById('order-status').value;

            // Danh sách ràng buộc
            const invalidTransitions = {
                'cancel': ['return'],
                'delivery': ['cancel'],
                'ship': ['return'],
                'confirm': ['delivery', 'return']
            };

            // Kiểm tra nếu trạng thái mới bị chặn
            if (invalidTransitions[currentStatus] && invalidTransitions[currentStatus].includes(newStatus)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: `Không thể chuyển từ "${currentStatus}" sang "${newStatus}".`,
                });
                this.value = currentStatus; // Reset lại dropdown
                return;
            }

            // Update the icon when status changes
            const statusIcons = {
                'pending': 'fas fa-clock',
                'confirm': 'fas fa-check',
                'ship': 'fas fa-shipping-fast',
                'delivery': 'fas fa-box-open',
                'return': 'fas fa-undo',
                'cancel': 'fas fa-times'
            };

            // Thay confirm bằng SweetAlert
            Swal.fire({
                title: 'Xác nhận',
                text: `Bạn có chắc chắn muốn thay đổi trạng thái thành "${newStatus}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Không'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.api.order.update.status') }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: 'application/json',
                        data: JSON.stringify({ order_id: {{ $order->id }}, status: newStatus }),
                        success: function (data) {
                            if (data.success) {
                                document.getElementById('order-status').value = newStatus;
                                
                                // Update the status icon
                                const iconElement = document.querySelector('.status-badge-icon i');
                                iconElement.className = statusIcons[newStatus] || 'fas fa-question';
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: 'Trạng thái đã được cập nhật thành công!',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Thất bại',
                                    text: data.message || 'Cập nhật thất bại. Vui lòng thử lại.'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi hệ thống',
                                text: 'Đã xảy ra lỗi. Vui lòng thử lại sau.'
                            });
                            console.error('Error:', error);
                        }
                    });
                } else {
                    this.value = currentStatus; // Reset lại dropdown nếu không xác nhận
                }
            });
        });
    </script>
@endsection