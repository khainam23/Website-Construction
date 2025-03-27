@extends('admin.layouts.master')

@section('title', __('User Management'))

@section('content')
    <div class="container">
        <h1>{{ __('User Management') }}</h1>

        <div class="mb-3">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="{{ __('Search') }}" name="search"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">{{ __('Search') }}</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>Trạng thái</th>
                        <th class="text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @if($user->role != 'admin')
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @switch($user->role)
                                        @case('staff')
                                            <span class="badge bg-primary">Người bán hàng</span>
                                            @break
                                        @case('warehouse')
                                            <span class="badge bg-warning text-dark">Quản lý kho</span>
                                            @break
                                        @case('customer')
                                            <span class="badge bg-success">Khách hàng</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Không xác định</span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $user->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button data-id="{{ $user->id }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <!-- Hiển thị thông tin người dùng -->
    <script>
        function showUserInfo(user) {
            const avatarUrl = user.avatar ? user.avatar : 'https://via.placeholder.com/100?text=Avatar';

            Swal.fire({
                title: 'Thông tin người dùng',
                html: `
                    <img src="${avatarUrl}" alt="Avatar" style="width:100px; height:100px; border-radius:50%; margin-bottom:10px;">
                    <p><strong>Họ & Tên:</strong> ${user.first_name} ${user.last_name}</p>
                    <p><strong>Email:</strong> ${user.email}</p>
                    <p><strong>Giới tính:</strong> ${user.gender === 'male' ? 'Nam' : 'Nữ'}</p>
                    <p><strong>Ngày sinh:</strong> ${user.date_of_birth}</p>
                    <p><strong>Địa chỉ:</strong> ${user.address}</p>
                    <p><strong>Số điện thoại:</strong> ${user.phone}</p>
                    <p><strong>Đăng nhập lần cuối:</strong> ${user.last_login}</p>

                    <label for="roleSelect"><strong>Chọn vai trò:</strong></label>
                    <select id="roleSelect" class="swal2-select">
                        <option value="staff" ${user.role === 'staff' ? 'selected' : ''}>Người bán hàng</option>
                        <option value="warehouse" ${user.role === 'warehouse' ? 'selected' : ''}>Quản lý kho</option>
                        <option value="customer" ${user.role === 'customer' ? 'selected' : ''}>Khách hàng</option>
                    </select>

                    <br><br>

                    <label for="statusSelect"><strong>Trạng thái:</strong></label>
                    <select id="statusSelect" class="swal2-select">
                        <option value="true" ${user.is_active ? 'selected' : ''}>Hoạt động</option>
                        <option value="false" ${!user.is_active ? 'selected' : ''}>Không hoạt động</option>
                    </select>
                `,
                showCancelButton: true,
                confirmButtonText: 'Lưu thay đổi',
                cancelButtonText: 'Hủy',
                didOpen: () => {
                    const confirmButton = Swal.getConfirmButton();
                    const roleSelect = document.getElementById('roleSelect');
                    const statusSelect = document.getElementById('statusSelect');

                    function checkChanges() {
                        const selectedRole = roleSelect.value;
                        const selectedStatus = statusSelect.value === 'true';

                        if (selectedRole !== user.role || selectedStatus !== user.is_active) {
                            confirmButton.removeAttribute('disabled');
                        } else {
                            confirmButton.setAttribute('disabled', true);
                        }
                    }

                    roleSelect.addEventListener('change', checkChanges);
                    statusSelect.addEventListener('change', checkChanges);

                    confirmButton.setAttribute('disabled', true); // Mặc định vô hiệu hóa nút khi mở dialog
                },
                preConfirm: () => {
                    return {
                        ...user,
                        role: document.getElementById('roleSelect').value,
                        is_active: document.getElementById('statusSelect').value === 'true'
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Hiển thị loading khi bắt đầu gửi request
                    Swal.fire({
                        title: 'Đang xử lý...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.api.user.update') }}",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        type: 'POST',
                        data: {
                            userId: user.id,
                            role: result.value.role,
                            is_active: result.value.is_active
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: 'Cập nhật thông tin người dùng thành công',
                                timer: 1500, // Tự động đóng sau 1.5 giây
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Reload lại trang sau khi cập nhật
                            });
                        },
                        error: function (error) {
                            Swal.fire('Lỗi', 'Có lỗi xảy ra khi cập nhật', 'error');
                        }
                    });
                }
            });
        }

        $(document).ready(function () {
            $('button').click(function () {
                $.ajax({
                    url: "{{ route('admin.api.user.show') }}",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    type: 'POST',
                    data: {
                        userId: $(this).data('id')
                    },
                    success: function (response) {
                        showUserInfo(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection