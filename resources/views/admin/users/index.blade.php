@extends('admin.layouts.master')

@section('title', __('User Management'))

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ __('User Management') }}</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="input-group">
                        <input id="search" type="text" class="form-control" placeholder="{{ __('Search by Name, Email...') }}" value="">
                        <select id="filter-role" class="form-select" style="max-width: 200px;">
                            <option value="">{{ __('All Roles') }}</option>
                            <option value="customer">{{ __('Customer') }}</option>
                            <option value="sale">{{ __('Seller') }}</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="button" id="reset-filter">{{ __('Reset') }}</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="users-table">
                            @foreach($users as $user)
                                @if($user->role != 'admin')
                                    <tr data-role="{{ $user->role }}" data-status="{{ $user->is_active ? 'active' : 'inactive' }}">
                                        <td>{{ $user->id }}</td>
                                        <td data-name="{{ $user->first_name }} {{ $user->last_name }}">{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td data-email="{{ $user->email }}">{{ $user->email }}</td>
                                        <td>
                                            @switch($user->role)
                                                @case('sale')
                                                    <span class="badge bg-primary">Người bán hàng</span>
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
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Hiển thị thông tin người dùng
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
                        <option value="sale" ${user.role === 'sale' ? 'selected' : ''}>Người bán hàng</option>
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
            // User info display functionality
            $('button[data-id]').click(function () {
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
            
            // Client-side filtering - same pattern as products page
            const rows = document.querySelectorAll("#users-table tr");
            
            function applyFilters() {
                const roleFilter = document.getElementById("filter-role").value.toLowerCase();
                const searchFilter = document.getElementById("search").value.toLowerCase();
                
                rows.forEach(row => {
                    let roleMatch = true;
                    let searchMatch = true;
                    
                    // Role filtering
                    if (roleFilter) {
                        const rowRole = row.getAttribute("data-role");
                        roleMatch = rowRole === roleFilter;
                    }
                    
                    // Search filtering - look in name and email
                    if (searchFilter) {
                        const name = row.querySelector("td[data-name]").getAttribute("data-name").toLowerCase();
                        const email = row.querySelector("td[data-email]").getAttribute("data-email").toLowerCase();
                        searchMatch = name.includes(searchFilter) || email.includes(searchFilter);
                    }
                    
                    // Show/hide row based on combined filters
                    if (roleMatch && searchMatch) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }
            
            // Apply filters when search input changes
            document.getElementById("search").addEventListener("keyup", applyFilters);
            
            // Apply filters when role changes (immediate apply like product page)
            document.getElementById("filter-role").addEventListener("change", applyFilters);
            
            // Reset filters
            document.getElementById("reset-filter").addEventListener("click", function() {
                document.getElementById("filter-role").value = "";
                document.getElementById("search").value = "";
                rows.forEach(row => row.style.display = "");
            });
        });
    </script>
@endsection