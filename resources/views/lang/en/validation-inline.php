<?php

/*
|--------------------------------------------------------------------------
| Validation Language Lines
|--------------------------------------------------------------------------
|
| The following language lines contain the default error messages used by
| the validator class. Some of these rules have multiple versions such
| as the size rules. Feel free to tweak each of these messages here.
|
*/

return [
    'accepted'             => 'This field must be accepted.',
    'active_url'           => 'This field is not a valid URL.',
    'after'                => 'This field must be a date after :date.',
    'after_or_equal'       => 'This field must be a date after or equal to :date.',
    'alpha'                => 'This field may only contain letters.',
    'alpha_dash'           => 'This field may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'This field may only contain letters and numbers.',
    'array'                => 'This field must be an array.',
    'attached'             => 'This field has already been attached.',
    'before'               => 'This field must be a date before :date.',
    'before_or_equal'      => 'This field must be a date before or equal to :date.',
    'between'              => [
        'array'   => 'This field must have between :min and :max items.',
        'file'    => 'The file size for this field must be between :min and :max kilobytes.',
        'numeric' => 'This field must be between :min and :max.',
        'string'  => 'This field must be between :min and :max characters.',
    ],
    'boolean'              => 'This field must be true or false.',
    'confirmed'            => 'The confirmation does not match.',
    'current_password'     => 'The password is incorrect.',
    'date'                 => 'This field is not a valid date.',
    'date_equals'          => 'This field must be a date equal to :date.',
    'date_format'          => 'This field does not match the format :format.',
    'different'            => 'This field and :other must be different.',
    'digits'               => 'This field must be :digits digits.',
    'digits_between'       => 'This field must be between :min and :max digits.',
    'dimensions'           => 'This field has invalid image dimensions.',
    'distinct'             => 'This field has a duplicate value.',
    'email'                => 'This field must be a valid email address.',
    'ends_with'            => 'This field must end with one of the following values: :values',
    'exists'               => 'The selected value is invalid.',
    'file'                 => 'This field must be a file.',
    'filled'               => 'This field must have a value.',
    'gt'                   => [
        'array'   => 'This array must have more than :value items.',
        'file'    => 'The file size for this field must be greater than :value kilobytes.',
        'numeric' => 'This field must be greater than :value.',
        'string'  => 'This field must be greater than :value characters.',
    ],
    'gte'                  => [
        'array'   => 'This array must have at least :value items.',
        'file'    => 'The file size for this field must be greater than or equal to :value kilobytes.',
        'numeric' => 'This field must be greater than or equal to :value.',
        'string'  => 'This field must be greater than or equal to :value characters.',
    ],
    'image'                => 'This field must be an image.',
    'in'                   => 'The selected value is invalid.',
    'in_array'             => 'This field must exist in :other.',
    'integer'              => 'This field must be an integer.',
    'ip'                   => 'This field must be a valid IP address.',
    'ipv4'                 => 'This field must be a valid IPv4 address.',
    'ipv6'                 => 'This field must be a valid IPv6 address.',
    'json'                 => 'This field must be a valid JSON string.',
    'lt'                   => [
        'array'   => 'This array must have less than :value items.',
        'file'    => 'The file size for this field must be less than :value kilobytes.',
        'numeric' => 'This field must be less than :value.',
        'string'  => 'This field must be less than :value characters.',
    ],
    'lte'                  => [
        'array'   => 'This array may not have more than :value items.',
        'file'    => 'The file size for this field must be less than or equal to :value kilobytes.',
        'numeric' => 'This field must be less than or equal to :value.',
        'string'  => 'This field must be less than or equal to :value characters.',
    ],
    'max'                  => [
        'array'   => 'This field may not have more than :max items.',
        'file'    => 'The file size for this field may not be greater than :max kilobytes.',
        'numeric' => 'This field may not be greater than :max.',
        'string'  => 'This field may not be greater than :max characters.',
    ],
    'mimes'                => 'This field must be a file of type: :values.',
    'mimetypes'            => 'This field must be a file of type: :values.',
    'min'                  => [
        'array'   => 'This field must have at least :min items.',
        'file'    => 'The file size for this field must be at least :min kilobytes.',
        'numeric' => 'This field must be at least :min.',
        'string'  => 'This field must be at least :min characters.',
    ],
    'multiple_of'          => 'This field must be a multiple of :value.',
    'not_in'               => 'The selected value is invalid.',
    'not_regex'            => 'This field format is invalid.',
    'numeric'              => 'This field must be a number.',
    'password'             => 'The password is incorrect.',
    'present'              => 'This field must be present.',
    'prohibited'           => 'This field is prohibited.',
    'prohibited_if'        => 'This field is prohibited when :other is :value.',
    'prohibited_unless'    => 'This field is prohibited unless :other is one of :values.',
    'regex'                => 'This field format is invalid.',
    'relatable'            => 'This field may not be associated with this resource.',
    'required'             => 'This field is required.',
    'required_if'          => 'This field is required when :other is :value.',
    'required_unless'      => 'This field is required unless :other is in :values.',
    'required_with'        => 'This field is required when :values is present.',
    'required_with_all'    => 'This field is required when all of :values are present.',
    'required_without'     => 'This field is required when any of :values are not present.',
    'required_without_all' => 'This field is required when none of :values are present.',
    'same'                 => 'This field and :other must match.',
    'size'                 => [
        'array'   => 'This field must contain :size items.',
        'file'    => 'The file size for this field must be :size kilobytes.',
        'numeric' => 'This field must be :size.',
        'string'  => 'This field must be :size characters.',
    ],
    'starts_with'          => 'This field must start with one of the following: :values',
    'string'               => 'This field must be a string.',
    'timezone'             => 'This field must be a valid timezone.',
    'unique'               => 'This field has already been taken.',
    'uploaded'             => 'This field failed to upload.',
    'url'                  => 'This field format is invalid.',
    'uuid'                 => 'This field must be a valid UUID string.',
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    'attributes'           => [],
];

