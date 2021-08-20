{{ textInput($errors, 'text', NULL, 'address_mailing_street_1', trans('new.street'), true) }}

{{ textInput($errors, 'text', NULL, 'address_mailing_street_2', trans('new.zero')) }}

{{ textInput($errors, 'text', NULL, 'address_mailing_street_3', trans('new.zero')) }}

{{ textInputNumeric($errors, 'text', NULL, 'address_mailing_postcode', trans('new.postcode'), true) }}

{{ masterSelect($errors, $masterState, NULL, 'address_mailing_state_id', 'state_id', 'state', trans('new.state'), true) }}

{{ masterSelect($errors, false, NULL, 'address_mailing_district_id', 'district_id', 'district', trans('new.district'), true) }}