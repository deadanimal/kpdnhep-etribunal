{{ textInput($errors, 'text', NULL, 'address_street_1', trans('new.street'), true) }}

{{ textInput($errors, 'text', NULL, 'address_street_2', trans('new.zero')) }}

{{ textInput($errors, 'text', NULL, 'address_street_3', trans('new.zero')) }}

{{ textInputNumeric($errors, 'text', NULL, 'address_postcode', trans('new.postcode'), true) }}

{{ masterSelect($errors, $masterState, NULL, 'address_state_id', 'state_id', 'state', trans('new.state'), true) }}

{{ masterSelect($errors, false, NULL, 'address_district_id', 'district_id', 'district', trans('new.district'), true) }}