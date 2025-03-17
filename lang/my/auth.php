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
    'failed'   => 'အသုံးပြုသူအချက်အလက်ကို စနစ်တွင် မတွေ့ရှိပါ။',
    'password' => 'စကားဝှက် မှားနေသည်။',
    'throttle' => 'ဝင်ရောက်မှု များပြားလွန်းသည်။ ကျေးဇူးပြု၍ :seconds စက္ကန့်အကြာ ထပ်မံကြိုးစားပါ။',

    // ဝင်ရောက်မှု
    'login_heading'                                         => 'ဝင်ရောက်ရန်',
    'login_subheading'                                      => 'ကျေးဇူးပြု၍ သင့် Email/အသုံးပြုသူအမည် နှင့် စကားဝှက်ဖြင့် ဝင်ရောက်ပါ။',
    'login_identity_label'                                  => 'Email:',
    'login_identity_placeholder'                            => 'Email ရိုက်ထည့်ပါ',
    'login_password_label'                                  => 'စကားဝှက်:',
    'login_password_placeholder'                            => 'စကားဝှက် ရိုက်ထည့်ပါ',
    'login_remember_label'                                  => 'မှတ်သားထားမည်',
    'login_submit_btn'                                      => 'ဝင်ရောက်မည်',
    'login_forgot_password'                                 => 'စကားဝှက်မေ့နေပါသလား?',
    'login_sign_in'                                         => 'ဝင်ရောက်မည်',

    // မူလစာမျက်နှာ
    'index_users'                                           => 'အသုံးပြုသူများ',
    'index_name_th'                                         => 'အမည်',
    'index_fname_th'                                        => 'နာမည်',
    'index_lname_th'                                        => 'မျိုးနွယ်အမည်',
    'index_email_th'                                        => 'Email',
    'index_groups_th'                                       => 'အဖွဲ့များ',
    'index_status_th'                                       => 'အခြေအနေ',
    'index_action_th'                                       => 'လုပ်ဆောင်ချက်များ',
    'index_active_link'                                     => 'သုံးနိုင်သည်',
    'index_inactive_link'                                   => 'မသုံးနိုင်ပါ',
    'index_create_link'                                     => 'အသစ်ထည့်ရန်',
    'index_roles'                                           => 'บทบาท',
    'index_acl'                                             => 'အသုံးပြုခွင့်စာရင်း',
    'index_column'                                          => 'ကော်လံ',
    'index_last_login'                                      => 'နောက်ဆုံး ဝင်ရောက်မှု',
    'index_created_at'                                      => 'ဖန်တီးခဲ့သည့်နေ့',
    'index_updated_at'                                      => 'နောက်ဆုံး ပြင်ဆင်ခဲ့သည့်နေ့',
    'index_created_by'                                      => 'ဖန်တီးသူ',
    'index_updated_by'                                      => 'နောက်ဆုံး ပြင်ဆင်သူ',
    'index_slug_th'                                         => 'Slug',

    // အသုံးပြုသူကို အတည်ပြုခြင်း
    'activate_heading'                                      => 'အသုံးပြုသူကို အတည်ပြုရန်',
    'activate_subheading'                                   => 'သင် \':name\' အသုံးပြုသူကို အတည်ပြုလိုပါသလား?',
    'activate_this_user'                                    => 'ဒီအသုံးပြုသူကို အတည်ပြုရန် နှိပ်ပါ',

    'deactivate_heading'                                    => 'အသုံးပြုသူကို ပိတ်ရန်',
    'deactivate_subheading'                                 => 'သင် \':name\' အသုံးပြုသူကို ပိတ်လိုပါသလား?',
    'deactivate_this_user'                                  => 'ဒီအသုံးပြုသူကို ပိတ်ရန် နှိပ်ပါ',

    // ဖောင်
    'form_user_heading'                                     => 'အသုံးပြုသူ',
    'form_user_subheading'                                  => 'ကျေးဇူးပြု၍ အသုံးပြုသူအချက်အလက်ကို ရိုက်ထည့်ပါ။',
    'form_user_fname_label'                                 => 'နာမည်',
    'form_user_lname_label'                                 => 'မျိုးနွယ်အမည်',
    'form_user_company_label'                               => 'ကုမ္ပဏီအမည်',
    'form_user_identity_label'                              => 'အသုံးပြုသူ အထောက်အထား',
    'form_user_email_label'                                 => 'Email',
    'form_user_phone_label'                                 => 'ဖုန်းနံပါတ်',
    'form_user_password_label'                              => 'စကားဝှက်',
    'form_user_password_confirm_label'                      => 'စကားဝှက် အတည်ပြုရန်',
    'form_user_submit_btn'                                  => 'အကောင့်ဖန်တီးရန်',
    'form_user_cancel_btn'                                  => 'မလုပ်တော့ပါ',
    'form_user_validation_fname_label'                      => 'နာမည်',
    'form_user_validation_lname_label'                      => 'မျိုးနွယ်အမည်',
    'form_user_validation_identity_label'                   => 'အသုံးပြုသူ အထောက်အထား',
    'form_user_validation_email_label'                      => 'Email လိပ်စာ',
    'form_user_validation_phone_label'                      => 'ဖုန်းနံပါတ်',
    'form_user_validation_company_label'                    => 'ကုမ္ပဏီအမည်',
    'form_user_validation_password_label'                   => 'စကားဝှက်ဖန်တီးရန်',
    'form_user_validation_password_confirm_label'           => 'စကားဝှက် အတည်ပြုရန်',
    'form_user_role_label'                                  => 'ရာထူး',
    'form_user_role_select'                                 => 'ရာထူးရွေးရန်',
    'form_user_password_long'                               => 'စကားဝှက် (အနည်းဆုံး 8 လုံး)',
    'form_user_password_type_again'                         => 'စကားဝှက်ကို ထပ်မံရိုက်ထည့်ပါ',

    // အသုံးပြုသူကို ပြင်ဆင်ရန်
    'edit_user_heading'                                     => 'အသုံးပြုသူကို ပြင်ဆင်ရန်',
    'edit_user_subheading'                                  => 'ကျေးဇူးပြု၍ အသုံးပြုသူအချက်အလက်ကို ပြင်ဆင်ပါ။',
    'edit_user_fname_label'                                 => 'နာမည်',
    'edit_user_lname_label'                                 => 'မျိုးနွယ်အမည်:',
    'edit_user_company_label'                               => 'ကုမ္ပဏီအမည်:',
    'edit_user_email_label'                                 => 'Email:',
    'edit_user_phone_label'                                 => 'ဖုန်းနံပါတ်:',
    'edit_user_password_label'                              => 'စကားဝှက်: (စကားဝှက်ပြောင်းလိုပါက)',
    'edit_user_password_confirm_label'                      => 'စကားဝှက် အတည်ပြုရန်: (စကားဝှက်ပြောင်းလိုပါက)',
    'edit_user_groups_heading'                              => 'အသုံးပြုသူသည် ပါဝင်သောအဖွဲ့များ',
    'edit_user_submit_btn'                                  => 'အသုံးပြုသူကို သိမ်းဆည်းပါ',
    'edit_user_validation_fname_label'                      => 'နာမည်',
    'edit_user_validation_lname_label'                      => 'မျိုးနွယ်အမည်',
    'edit_user_validation_email_label'                      => 'Email လိပ်စာ',
    'edit_user_validation_phone_label'                      => 'ဖုန်းနံပါတ်',
    'edit_user_validation_company_label'                    => 'ကုမ္ပဏီအမည်',
    'edit_user_validation_groups_label'                     => 'အဖွဲ့များ',
    'edit_user_validation_password_label'                   => 'စကားဝှက်',
    'edit_user_validation_password_confirm_label'           => 'စကားဝှက် အတည်ပြုရန်',

      // အခန်းဖန်တီးရန်
      'create_role_title'                                    => 'အခန်းအသစ်ဖန်တီးရန်',
      'create_role_heading'                                  => 'အခန်းအသစ်ဖန်တီးရန်',
      'create_role_subheading'                               => 'ကျေးဇူးပြု၍ အခန်းအကြောင်းအချက်အလက်ကို ရိုက်ထည့်ပါ။',
      'create_role_name_label'                               => 'အခန်းအမည်:',
      'create_role_desc_label'                               => 'ဖော်ပြချက်:',
      'create_role_submit_btn'                               => 'အခန်းအသစ်ဖန်တီးရန်',
      'create_role_validation_name_label'                    => 'အခန်းအမည်',
      'create_role_validation_desc_label'                    => 'ဖော်ပြချက်',
  
      // အခန်းကို ပြင်ဆင်ရန်
      'edit_role_title'                                      => 'အခန်းကို ပြင်ဆင်ရန်',
      'edit_role_saved'                                      => 'အခန်းကို သိမ်းဆည်းပြီးပါပြီ',
      'edit_role_heading'                                    => 'အခန်းကို ပြင်ဆင်ရန်',
      'edit_role_subheading'                                 => 'ကျေးဇူးပြု၍ အခန်းအကြောင်းအချက်အလက်ကို ပြင်ဆင်ပါ။',
      'edit_role_name_label'                                 => 'အခန်းအမည်:',
      'edit_role_desc_label'                                 => 'ဖော်ပြချက်:',
      'edit_role_submit_btn'                                 => 'အခန်းကို သိမ်းဆည်းရန်',
      'edit_role_validation_name_label'                      => 'အခန်းအမည်',
      'edit_role_validation_desc_label'                      => 'ဖော်ပြချက်',
  
      // စကားဝှက်ပြောင်းရန်
      'change_password_heading'                               => 'စကားဝှက်ပြောင်းရန်',
      'change_password_old_password_label'                    => 'လက်ရှိစကားဝှက်',
      'change_password_new_password_label'                    => 'အသစ်စကားဝှက်',
      'change_password_new_password_confirm_label'            => 'အသစ်စကားဝှက် အတည်ပြုရန်',
      'change_password_submit_btn'                            => 'စကားဝှက်ပြောင်းရန်',
      'change_password_validation_old_password_label'         => 'လက်ရှိစကားဝှက်',
      'change_password_validation_new_password_label'         => 'အသစ်စကားဝှက်',
      'change_password_validation_new_password_confirm_label' => 'အသစ်စကားဝှက် အတည်ပြုရန်',
  
      // စကားဝှက်မေ့သွားပါက
      'forgot_password_heading'                               => 'စကားဝှက်မေ့သွားပါက',
      'forgot_password_subheading'                            => 'ကျေးဇူးပြု၍ <b>Email</b> ထည့်ပါ။ ညွှန်ကြားချက်များကို မကြာမီ ပို့ပေးပါမည်။',
      'forgot_password_email_label'                           => '%s:',
      'forgot_password_submit_btn'                            => 'ပို့ရန်',
      'forgot_password_validation_email_label'                => 'သင့် Email လိပ်စာ',
      'forgot_password_identity_label'                        => 'အသုံးပြုသူအချက်အလက်',
      'forgot_password_email_identity_label'                  => 'Email',
      'forgot_password_email_not_found'                       => 'ထို Email လိပ်စာကို မတွေ့ပါ။',
      'forgot_password_identity_not_found'                    => 'ထို အသုံးပြုသူအမည်ကို မတွေ့ပါ။',
  
      // စကားဝှက်ပြန်သတ်မှတ်ရန်
      'reset_password_heading'                                => 'စကားဝှက်ပြန်သတ်မှတ်ရန်',
      'reset_password_new_password_label'                     => 'အသစ်စကားဝှက် (အနည်းဆုံး %s လုံး):',
      'reset_password_new_password_confirm_label'             => 'အသစ်စကားဝှက် အတည်ပြုရန်:',
      'reset_password_submit_btn'                             => 'ပြောင်းရန်',
      'reset_password_validation_new_password_label'          => 'အသစ်စကားဝှက်',
      'reset_password_validation_new_password_confirm_label'  => 'အသစ်စကားဝှက် အတည်ပြုရန်',
      'reset_password_change_unsuccessful_old'                => 'လက်ရှိစကားဝှက် မတူညီပါ။',
  
      // အကောင့်ဖန်တီးရန်
      'account_creation_successful'                           => 'အကောင့်ဖန်တီးမှု အောင်မြင်ပါသည်။',
      'account_creation_unsuccessful'                         => 'အကောင့်ဖန်တီးမှု မအောင်မြင်ပါ။',
      'account_creation_duplicate_email'                      => 'Email သည် မရှိနိုင်ပါ သို့မဟုတ် မမှန်ပါ။',
      'account_creation_duplicate_identity'                   => 'အသုံးပြုသူအချက်အလက် သည် မရှိနိုင်ပါ သို့မဟုတ် မမှန်ပါ။',
      'account_creation_missing_default_group'                => 'မူလအသုံးပြုသူအဖွဲ့ မသတ်မှတ်ရသေးပါ။',
      'account_creation_invalid_default_group'                => 'မူလအသုံးပြုသူအဖွဲ့ မမှန်ပါ။',
      'account_creation_register'                             => 'မှတ်ပုံတင်ရန်',
   // စကားဝှက်
   'password_change_successful'                            => 'စကားဝှက်ပြောင်းခြင်း အောင်မြင်ပါသည်။',
   'password_change_unsuccessful'                          => 'စကားဝှက်ပြောင်းလဲခြင်း မအောင်မြင်ပါ။',
   'forgot_password_successful'                            => 'စကားဝှက်ပြန်သတ်မှတ်ရန် Email ပို့ပြီးပါပြီ။',
   'forgot_password_unsuccessful'                          => 'စကားဝှက်ပြန်သတ်မှတ်ရန် Email မပို့နိုင်ပါ။',

   // အကောင့်ဖွင့်/ပိတ်
   'activate_successful'                                   => 'အကောင့်ဖွင့်ခြင်း အောင်မြင်ပါသည်။',
   'activate_unsuccessful'                                 => 'အကောင့်ဖွင့်ခြင်း မအောင်မြင်ပါ။',
   'active_current_user_unsuccessful'                      => 'သင့်အကောင့်ကို ကိုယ်တိုင်ဖွင့်လို့မရပါ။',
   'deactivate_successful'                                 => 'အကောင့်ပိတ်ခြင်း အောင်မြင်ပါသည်။',
   'deactivate_unsuccessful'                               => 'အကောင့်ပိတ်ခြင်း မအောင်မြင်ပါ။',
   'activation_email_successful'                           => 'အကောင့်ဖွင့်ရန် Email ပို့ပြီးပါပြီ။ Email (Inbox) သို့မဟုတ် Spam Folder ကို စစ်ဆေးပါ။',
   'activation_email_unsuccessful'                         => 'အကောင့်ဖွင့်ရန် Email မပို့နိုင်ပါ။',

   // Login / Logout
   'login_successful'                                      => 'အကောင့်ဝင်ခြင်း အောင်မြင်ပါသည်။',
   'login_unsuccessful'                                    => 'အသုံးပြုသူအမည် သို့မဟုတ် စကားဝှက်မှားနေပါသည်။',
   'login_unsuccessful_not_active'                         => 'အကောင့်ကို မဖွင့်ရသေးပါ။',
   'login_timeout'                                         => 'အကောင့်သယ်ဆောင်မှု ရပ်နားထားပါသည်။ နောက်မှ ထပ်စမ်းကြည့်ပါ။',
   'logout_successful'                                     => 'အကောင့်ထွက်ခြင်း အောင်မြင်ပါသည်။',
   'logout_heading'                                        => 'အကောင့်ထွက်ရန်',

   // အကောင့်ပြောင်းလဲမှု
   'update_successful'                                     => 'အကောင့်အချက်အလက်များကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။',
   'update_unsuccessful'                                   => 'အကောင့်အချက်အလက်များကို ပြင်ဆင်လို့မရပါ။',
   'delete_successful'                                     => 'အသုံးပြုသူအား အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။',
   'delete_unsuccessful'                                   => 'အသုံးပြုသူအား ဖျက်မရပါ။',
   'delete_confirmation'                                   => 'အသုံးပြုသူ \':name\' ကို ဖျက်မှာ သေချာပါသလား။',
   'delete_confirmation_heading'                           => 'ဤအရာကို ဖျက်မလား?',

   // အခန်း (Roles)
   'role_creation_successful'                              => 'အခန်းဖန်တီးခြင်း အောင်မြင်ပါသည်။',
   'role_already_exists'                                   => 'အခန်းအမည်သည် ရှိပြီးသားဖြစ်သည်။',
   'role_update_successful'                                => 'အခန်းအသေးစိတ် အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။',
   'role_delete_successful'                                => 'အခန်းအား အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။',
   'role_delete_unsuccessful'                              => 'အခန်းအား ဖျက်မရပါ။',
   'role_delete_notallowed'                                => 'မူလအခန်းအား ဖျက်ခွင့်မရှိပါ။',
   'role_name_required'                                    => 'အခန်းအမည် ထည့်ရန် လိုအပ်ပါသည်။',
   'role_name_admin_not_alter'                             => 'Admin အခန်းအမည်ကို ပြောင်းလဲလို့မရပါ။',

    // အကောင့်ဖွင့်ရန် Email
    'email_activation_subject'                              => 'အကောင့်ဖွင့်ရန်',
    'email_activate_heading'                                => '%s အတွက် အကောင့်ဖွင့်ရန်',
    'email_activate_subheading'                             => 'ကျေးဇူးပြု၍ ဤလင့်ခ်ကိုနှိပ်ပြီး %s။',
    'email_activate_link'                                   => 'သင့်အကောင့်ကို ဖွင့်ပါ',

    // စကားဝှက်မေ့သွားမှု Email
    'email_forgotten_password_subject'                      => 'စကားဝှက်မေ့သွားမှု အတည်ပြုရန်',
    'email_forgot_password_heading'                         => '%s အတွက် စကားဝှက်ပြန်သတ်မှတ်ရန်',
    'email_forgot_password_subheading'                      => 'ကျေးဇူးပြု၍ ဤလင့်ခ်ကိုနှိပ်ပြီး %s။',
    'email_forgot_password_link'                            => 'သင့်စကားဝှက်ကို ပြန်သတ်မှတ်ပါ',

    // စကားဝှက်အသစ် Email
    'email_new_password_subject'                            => 'စကားဝှက်အသစ်',
    'email_new_password_heading'                            => '%s အတွက် စကားဝှက်အသစ်',
    'email_new_password_subheading'                         => 'သင့်စကားဝှက်ကို ပြန်သတ်မှတ်လိုက်ပြီး: %s',

    // ဖျက်ခြင်း
    'deactivate_current_user_unsuccessful'                  => 'သင့်ကိုယ်တိုင်အကောင့်ကို ပိတ်လို့မရပါ။',
    'delete_account'                                        => 'အကောင့်ကို အောင်မြင်စွာ ဖျက်လိုက်ပါပြီ။',
];
