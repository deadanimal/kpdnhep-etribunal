<?php

return [

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

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [

        'username' => 'Username',
        'password' => 'Password',
        'repeat_password' => 'Repeat Password',
        'email' => 'Email',
        'password_confirmation' => 'Password Confirmation',
        'address_street_1' => 'Address',
        'address_street_2' => 'Address 2',
        'address_street_3' => 'Address 3',
        'address_mailing_street_1' => 'Mailing Address',
        'address_mailing_street_2' => 'Mailing Address 2',
        'address_mailing_street_3' => 'Mailing Address 3',
        'address_postcode' => 'Postcode',
        'address_state_id' => 'State',
        'address_district_id' => 'District',
        'phone_home' => 'Home Phone No.',
        'phone_mobile' => 'Mobile Phone No.',
        'phone_office' => 'Office Phone No.',
        'phone_fax' => 'Fax No.',
        'race' => 'Race',
        'occupation' => 'Occupation',
        'country' => 'Country',
        'identification_no' => 'Identification No.',
        'name' => 'Name',

        'branch_name' => 'Branch Name',
        'branch_code' => 'Branch Code',
        'branch_address' => 'Branch Address 1',
        'branch_address2' => 'Branch Address 2',
        'branch_address3' => 'Branch Address 3',
        'branch_postcode' => 'Branch Postcode',
        'branch_office_phone' => 'Branch Office Phone',
        'branch_email' => 'Branch Email',

        'claimant_identification_no' => 'Claimant Identification No.',
        'claimant_name' => 'Claimant Name',
        'claimant_street1' => 'Address 1',
        'claimant_postcode' => 'Postcode',
        'claimant_phone_mobile' => 'Mobile Phone No.',
        'claimant_phone_home' => 'Home Phone No.',
        'claimant_email' => 'Email',

        'opponent_identification_no' => 'Respondent Identification No.',
        'opponent_name' => 'Respondent Name',
        'opponent_street1' => 'Address',
        'opponent_postcode' => 'Postcode',
        'opponent_phone_mobile' => 'Mobile Phone No.',
        'opponent_phone_office' => 'Office Phone No.',
        'opponent_phone_home' => 'Home Phone No.',
        'opponent_email' => 'Email',
        'defence_statement' => 'Defence Statement',

        'representative_name' => 'Representative Name',
        'representative_identification_no' => 'Identification No.',
        'representative_phone_mobile' => 'Mobile Phone No.',

        'user_type_id' => 'User Type',
        'display_name' => 'Display Name',
        'description' => 'Description',
        'role_type' => 'Role Type',
        'nationality_country_id' => 'Nationality Country',
        'company_no' => 'Company Registration No.',
        'claim_amount' => 'Claim Amount',
        'case_name' => 'Court Name',
        'payment_postalorder' => 'Postal Order Payment',
        'document_desc' => 'Document Description',
        'total_counterclaim' => 'Total Counter Claim',
        'counterclaim_desc' => 'Counter Claim Description',
        'inquiry_msg' => 'Inquiry Message',
        'absence_reason' => 'Absense Reason',
        'complaints' => 'Complaints',
        'court_details' => 'Court Details',
        'title_en' => 'Title (English)',
        'title_my' => 'Title (Malay)',
        'description_en' => 'Description (English)',
        'description_my' => 'Description (Malay)',
        'journal_desc' => 'Journal Description',
        'branch_emel' => 'Branch Email',
        'classification_en' => 'Classification (English)',
        'classification_my' => 'Classification (Malay)',
        'rcy_id' => 'Classification Code',
        'category_en' => 'Category (English)',
        'category_my' => 'Category (Malay)',
        'category_code' => 'Category Code',
        'hearing_room' => 'Hearing Room',
        'address' => 'Address',
        'hearing_venue' => 'Hearing Venue',
        'occupation_en' => 'Occupation (English)',
        'occupation_my' => 'Occupation (Malay)',
        'offence_description_en' => 'Offence (English)',
        'offence_description_my' => 'Offence (Malay)',
        'offence_code' => 'Offence Code',
        'organization' => 'Organization',
        'org_address' => 'Address',
        'address1' => 'Address',
        'org_postcode' => 'Postcode',
        'org_office_phone' => 'Office Phone No.',
        'stop_reason_en' => 'Stop Notice Reason (English)',
        'stop_reason_my' => 'Stop Notice Reason (Malay)',
        'stop_method_en' => 'Stop Notice Method (English)',
        'stop_method_my' => 'Stop Notice Method (Malay)',
        'method_en' => 'Method (English)',
        'method_my' => 'Method (Malay)',
        'code' => 'Code',
        'salutation_en' => 'Salutation (English)',
        'salutation_my' => 'Salutation (Malay)',
        'reason_en' => 'Reason (English)',
        'reason_my' => 'Reason (Malay)',
        'term_en' => 'Term (English)',
        'term_my' => 'Term (Malay)',
        'postcode' => 'Postcode',
        'court_name' => 'Court Name',
        'designation_en' => 'Designation (English)',
        'designation_my' => 'Designation (Malay)',
        'copy_address' => 'Address checkbox',
        'address_mailing_postcode' => 'Postcode',
        'type_en' => 'Type (English)',
        'type_my' => 'Type (Malay)',
        'display_name_en' => 'Display Name (English)',
        'display_name_my' => 'Display Name (Malay)',
        'receipt_no' => 'Receipt No.',
        'inquiry_feedback_msg' => 'Feedback Message',
        'extra_claimant_identification_no' => 'Additional Claimant Identification No',
        'extra_claimant_nationality' => 'Additional Claimant Nationality',
        'extra_claimant_relationship' => 'Additional Claimant Relationship',
        'extra_claimant_name' => 'Additional Claimant Name',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
    ],

];
