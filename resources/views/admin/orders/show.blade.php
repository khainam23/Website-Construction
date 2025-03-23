@extends('admin.layouts.master')

@section('title', __('Order Details'))

@section('content')
    <div class="container">
        <h1>{{ __('Order Details') }}</h1>

        <div class="card">
            <div class="card-header">
                {{ __('Order Information') }}
            </div>
            <div class="card-body">
                <p><strong>{{ __('ID') }}:</strong> {{ $order->id }}</p>
                <p><strong>{{ __('User') }}:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
                <p><strong>{{ __('Total') }}:</strong> {{ $order->total }}</p>
                <div class="mb-3">
                    <label for="status-select" class="form-label">{{ __('Status') }}: </label>
                    <input type="hidden" value="{{ $order->status }}" id="order-status">
                    <select id="status-select" class="form-select">
                        @php
                            $statuses = ['confirm', 'ship', 'delivery', 'return', 'cancel']; // Loại bỏ 'pending'
                        @endphp
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <p><strong>{{ __('Address') }}:</strong> {{ $order->address }}</p>
                <p><strong>{{ __('Phone') }}:</strong> {{ $order->phone }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                {{ __('Order Items') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Product') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Cost') }}</th>
                                <th>{{ __('Rental Start') }}</th>
                                <th>{{ __('Rental End') }}</th>
                                <th>{{ __('Rental Duration') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $detail)
                                <tr>
                                    <td>{{ $detail->product->name }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ $detail->cost }}</td>
                                    <td>{{ $detail->rental_start_date }}</td>
                                    <td>{{ $detail->rental_end_date }}</td>
                                    <td>{{ $detail->duration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{ __('Back to Orders') }}</a>
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
                                document.getElementById('order-status').textContent = newStatus;
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