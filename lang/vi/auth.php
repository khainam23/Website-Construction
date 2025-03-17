<?php

/*
|--------------------------------------------------------------------------
| Authentication Language Lines
|--------------------------------------------------------------------------
|
| The following language lines are used during authentication for various
| messages that we need to display to the user. You are free to modify
| these language lines according to your application's requirements.
|
*/

return [
    'failed'   => 'Thông tin tài khoản không tìm thấy trong hệ thống.',
    'password' => 'Mật khẩu không đúng.',
    'throttle' => 'Vượt quá số lần đăng nhập cho phép. Vui lòng thử lại sau :seconds giây.',

    // Đăng nhập
    'login_heading'                                         => 'Đăng nhập',
    'login_subheading'                                      => 'Vui lòng đăng nhập bằng email/tên người dùng và mật khẩu của bạn bên dưới.',
    'login_identity_label'                                  => 'Email:',
    'login_identity_placeholder'                            => 'Nhập Email',
    'login_password_label'                                  => 'Mật khẩu:',
    'login_password_placeholder'                            => 'Nhập Mật khẩu',
    'login_remember_label'                                  => 'Ghi nhớ đăng nhập',
    'login_submit_btn'                                      => 'Đăng nhập',
    'login_forgot_password'                                 => 'Quên mật khẩu?',
    'login_sign_in'                                         => 'Đăng nhập',

    // Trang chủ
    'index_users'                                           => 'Người dùng',
    'index_name_th'                                         => 'Tên',
    'index_fname_th'                                        => 'Tên',
    'index_lname_th'                                        => 'Họ',
    'index_email_th'                                        => 'Email',
    'index_groups_th'                                       => 'Nhóm',
    'index_status_th'                                       => 'Trạng thái',
    'index_action_th'                                       => 'Hành động',
    'index_active_link'                                     => 'Hoạt động',
    'index_inactive_link'                                   => 'Không hoạt động',
    'index_create_link'                                     => 'Thêm mới',
    'index_roles'                                           => 'Vai trò',
    'index_acl'                                             => 'Danh sách quyền truy cập',
    'index_column'                                          => 'Cột',
    'index_last_login'                                      => 'Lần đăng nhập cuối',
    'index_created_at'                                      => 'Ngày tạo',
    'index_updated_at'                                      => 'Ngày cập nhật',
    'index_created_by'                                      => 'Người tạo',
    'index_updated_by'                                      => 'Người cập nhật',
    'index_slug_th'                                         => 'Slug',

    // Kích hoạt người dùng
    'activate_heading'                                      => 'Kích hoạt người dùng',
    'activate_subheading'                                   => 'Bạn có chắc chắn muốn kích hoạt người dùng \':name\' không?',
    'activate_this_user'                                    => 'Nhấn để kích hoạt người dùng này',

    // Vô hiệu hóa người dùng
    'deactivate_heading'                                    => 'Vô hiệu hóa người dùng',
    'deactivate_subheading'                                 => 'Bạn có chắc chắn muốn vô hiệu hóa người dùng \':name\' không?',
    'deactivate_this_user'                                  => 'Nhấn để vô hiệu hóa người dùng này',

    // Form
    'form_user_heading'                                     => 'Người dùng',
    'form_user_subheading'                                  => 'Vui lòng nhập thông tin của người dùng bên dưới.',
    'form_user_fname_label'                                 => 'Tên',
    'form_user_lname_label'                                 => 'Họ',
    'form_user_company_label'                               => 'Tên công ty',
    'form_user_identity_label'                              => 'Danh tính',
    'form_user_email_label'                                 => 'Email',
    'form_user_phone_label'                                 => 'Điện thoại',
    'form_user_password_label'                              => 'Mật khẩu',
    'form_user_password_confirm_label'                      => 'Xác nhận mật khẩu',
    'form_user_submit_btn'                                  => 'Tạo tài khoản',
    'form_user_cancel_btn'                                  => 'Hủy',
    'form_user_validation_fname_label'                      => 'Tên',
    'form_user_validation_lname_label'                      => 'Họ',
    'form_user_validation_identity_label'                   => 'Danh tính',
    'form_user_validation_email_label'                      => 'Địa chỉ email',
    'form_user_validation_phone_label'                      => 'Điện thoại',
    'form_user_validation_company_label'                    => 'Tên công ty',
    'form_user_validation_password_label'                   => 'Tạo mật khẩu',
    'form_user_validation_password_confirm_label'           => 'Nhập lại mật khẩu',
    'form_user_role_label'                                  => 'Vai trò',
    'form_user_role_select'                                 => 'Chọn vai trò',
    'form_user_password_long'                               => 'Mật khẩu (ít nhất 8 ký tự)',
    'form_user_password_type_again'                         => 'Nhập lại mật khẩu của bạn',

    // Chỉnh sửa người dùng
    'edit_user_heading'                                     => 'Chỉnh sửa người dùng',
    'edit_user_subheading'                                  => 'Vui lòng nhập thông tin của người dùng bên dưới.',
    'edit_user_fname_label'                                 => 'Tên',
    'edit_user_lname_label'                                 => 'Họ:',
    'edit_user_company_label'                               => 'Tên công ty:',
    'edit_user_email_label'                                 => 'Email:',
    'edit_user_phone_label'                                 => 'Điện thoại:',
    'edit_user_password_label'                              => 'Mật khẩu: (nếu thay đổi mật khẩu)',
    'edit_user_password_confirm_label'                      => 'Xác nhận mật khẩu: (nếu thay đổi mật khẩu)',
    'edit_user_groups_heading'                              => 'Thành viên của các nhóm',
    'edit_user_submit_btn'                                  => 'Lưu người dùng',
    'edit_user_validation_fname_label'                      => 'Tên',
    'edit_user_validation_lname_label'                      => 'Họ',
    'edit_user_validation_email_label'                      => 'Địa chỉ email',
    'edit_user_validation_phone_label'                      => 'Điện thoại',
    'edit_user_validation_company_label'                    => 'Tên công ty',
    'edit_user_validation_groups_label'                     => 'Nhóm',
    'edit_user_validation_password_label'                   => 'Mật khẩu',
    'edit_user_validation_password_confirm_label'           => 'Xác nhận mật khẩu',

    // Tạo nhóm
    'create_role_title'                                    => 'Tạo vai trò',
    'create_role_heading'                                  => 'Tạo vai trò',
    'create_role_subheading'                               => 'Vui lòng nhập thông tin về vai trò bên dưới.',
    'create_role_name_label'                               => 'Tên vai trò:',
    'create_role_desc_label'                               => 'Mô tả:',
    'create_role_submit_btn'                               => 'Tạo vai trò',
    'create_role_validation_name_label'                    => 'Tên vai trò',
    'create_role_validation_desc_label'                    => 'Mô tả',

    // Chỉnh sửa vai trò
    'edit_role_title'                                      => 'Chỉnh sửa vai trò',
    'edit_role_saved'                                      => 'Vai trò đã được lưu',
    'edit_role_heading'                                    => 'Chỉnh sửa vai trò',
    'edit_role_subheading'                                 => 'Vui lòng nhập thông tin vai trò bên dưới.',
    'edit_role_name_label'                                 => 'Tên vai trò:',
    'edit_role_desc_label'                                 => 'Mô tả:',
    'edit_role_submit_btn'                                 => 'Lưu vai trò',
    'edit_role_validation_name_label'                      => 'Tên vai trò',
    'edit_role_validation_desc_label'                      => 'Mô tả',

    // Đổi mật khẩu
    'change_password_heading'                               => 'Đổi mật khẩu',
    'change_password_old_password_label'                    => 'Mật khẩu cũ',
    'change_password_new_password_label'                    => 'Mật khẩu mới',
    'change_password_new_password_confirm_label'            => 'Xác nhận mật khẩu mới',
    'change_password_submit_btn'                            => 'Đổi mật khẩu',
    'change_password_validation_old_password_label'         => 'Mật khẩu cũ',
    'change_password_validation_new_password_label'         => 'Mật khẩu mới',
    'change_password_validation_new_password_confirm_label' => 'Xác nhận mật khẩu mới',

    // Quên mật khẩu
    'forgot_password_heading'                               => 'Quên mật khẩu',
    'forgot_password_subheading'                            => 'Vui lòng nhập <b>Email</b> của bạn và hướng dẫn sẽ được gửi tới bạn!',
    'forgot_password_email_label'                           => '%s:',
    'forgot_password_submit_btn'                            => 'Gửi',
    'forgot_password_validation_email_label'                => 'Địa chỉ Email của bạn',
    'forgot_password_identity_label'                        => 'Danh tính',
    'forgot_password_email_identity_label'                  => 'Email',
    'forgot_password_email_not_found'                       => 'Không tìm thấy địa chỉ email đó.',
    'forgot_password_identity_not_found'                    => 'Không tìm thấy tên người dùng đó.',

    // Đặt lại mật khẩu
    'reset_password_heading'                                => 'Đổi mật khẩu',
    'reset_password_new_password_label'                     => 'Mật khẩu mới (ít nhất %s ký tự):',
    'reset_password_new_password_confirm_label'             => 'Xác nhận mật khẩu mới:',
    'reset_password_submit_btn'                             => 'Đổi',
    'reset_password_validation_new_password_label'          => 'Mật khẩu mới',
    'reset_password_validation_new_password_confirm_label'  => 'Xác nhận mật khẩu mới',
    'reset_password_change_unsuccessful_old'                => 'Mật khẩu cũ không khớp',

    // Tạo tài khoản
    'account_creation_successful'                           => 'Tạo tài khoản thành công',
    'account_creation_unsuccessful'                         => 'Không thể tạo tài khoản',
    'account_creation_duplicate_email'                      => 'Email đã được sử dụng hoặc không hợp lệ',
    'account_creation_duplicate_identity'                   => 'Danh tính đã được sử dụng hoặc không hợp lệ',
    'account_creation_missing_default_group'                => 'Nhóm mặc định chưa được thiết lập',
    'account_creation_invalid_default_group'                => 'Tên nhóm mặc định không hợp lệ',
    'account_creation_register'                             => 'Đăng ký',

    // Mật khẩu
    'password_change_successful'                            => 'Đổi mật khẩu thành công',
    'password_change_unsuccessful'                          => 'Không thể đổi mật khẩu',
    'forgot_password_successful'                            => 'Email đặt lại mật khẩu đã được gửi',
    'forgot_password_unsuccessful'                          => 'Không thể gửi email đặt lại mật khẩu',

    // Kích hoạt tài khoản
    'activate_successful'                                   => 'Kích hoạt tài khoản thành công',
    'activate_unsuccessful'                                 => 'Không thể kích hoạt tài khoản',
    'active_current_user_unsuccessful'                      => 'Bạn không thể tự kích hoạt tài khoản của mình.',
    'deactivate_successful'                                 => 'Vô hiệu hóa tài khoản thành công',
    'deactivate_unsuccessful'                               => 'Không thể vô hiệu hóa tài khoản',
    'activation_email_successful'                           => 'Email kích hoạt đã được gửi. Vui lòng kiểm tra hộp thư đến hoặc thư rác của bạn',
    'activation_email_unsuccessful'                         => 'Không thể gửi email kích hoạt',

    // Đăng nhập / Đăng xuất
    'login_successful'                                      => 'Đăng nhập thành công',
    'login_unsuccessful'                                    => 'Tài khoản hoặc mật khẩu không đúng. vui lòng thử lại !',
    'login_unsuccessful_not_active'                         => 'Tài khoản chưa kích hoạt',
    'login_timeout'                                         => 'Tạm thời bị khóa. Hãy thử lại sau.',
    'logout_successful'                                     => 'Đăng xuất thành công',
    'logout_heading'                                        => 'Đăng xuất',

    // Thay đổi tài khoản
    'update_successful'                                     => 'Thông tin tài khoản đã được cập nhật thành công',
    'update_unsuccessful'                                   => 'Không thể cập nhật thông tin tài khoản',
    'delete_successful'                                     => 'Người dùng đã được xóa',
    'delete_unsuccessful'                                   => 'Không thể xóa người dùng',
    'delete_confirmation'                                   => 'Bạn có chắc chắn muốn xóa người dùng \':name\'?',
    'delete_confirmation_heading'                           => 'Xóa mục này?',

    // Vai trò
    'role_creation_successful'                              => 'Tạo vai trò thành công',
    'role_already_exists'                                   => 'Tên vai trò đã tồn tại',
    'role_update_successful'                                => 'Cập nhật chi tiết vai trò thành công',
    'role_delete_successful'                                => 'Xóa vai trò thành công',
    'role_delete_unsuccessful'                              => 'Không thể xóa vai trò',
    'role_delete_notallowed'                                => 'Không thể xóa vai trò gốc',
    'role_name_required'                                    => 'Tên nhóm là trường bắt buộc',
    'role_name_admin_not_alter'                             => 'Tên nhóm quản trị viên không thể thay đổi',

    // Email kích hoạt
    'email_activation_subject'                              => 'Kích hoạt tài khoản',
    'email_activate_heading'                                => 'Kích hoạt tài khoản cho %s',
    'email_activate_subheading'                             => 'Vui lòng nhấp vào liên kết này để %s.',
    'email_activate_link'                                   => 'Kích hoạt tài khoản của bạn',

    // Email quên mật khẩu
    'email_forgotten_password_subject'                      => 'Xác nhận quên mật khẩu',
    'email_forgot_password_heading'                         => 'Đặt lại mật khẩu cho %s',
    'email_forgot_password_subheading'                      => 'Vui lòng nhấp vào liên kết này để %s.',
    'email_forgot_password_link'                            => 'Đặt lại mật khẩu của bạn',

    // Email mật khẩu mới
    'email_new_password_subject'                            => 'Mật khẩu mới',
    'email_new_password_heading'                            => 'Mật khẩu mới cho %s',
    'email_new_password_subheading'                         => 'Mật khẩu của bạn đã được đặt lại thành: %s',

    // Xóa
    'deactivate_current_user_unsuccessful'                  => 'Bạn không thể vô hiệu hóa chính mình.',
    'delete_account'                                        => 'Xóa tài khoản thành công',

];
