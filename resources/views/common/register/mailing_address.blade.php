{{ textInput($errors, 'text', $userPublic, 'address_mailing_street_1', trans('new.street').' 1', true) }}

{{ textInput($errors, 'text', $userPublic, 'address_mailing_street_2', ' ') }}

{{ textInput($errors, 'text', $userPublic, 'address_mailing_street_3', ' ') }}

{{ textInputNumeric($errors, 'text', $userPublic, 'address_mailing_postcode', trans('new.postcode'), true) }}

{{ masterSelect($errors, $masterState, $userPublic, 'address_mailing_state_id', 'state_id', 'state', trans('new.state'), true) }}

{{ masterSelect($errors, false, $userPublic, 'address_mailing_district_id', 'district_id', 'district', trans('new.district'), true) }}