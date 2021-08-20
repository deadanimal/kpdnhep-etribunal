{{ textInput($errors, 'text', $userPublic, 'address_mailing_street_1', trans('new.street'), true) }}

{{ textInput($errors, 'text', $userPublic, 'address_mailing_street_2', ' ') }}

{{ textInput($errors, 'text', $userPublic, 'address_mailing_street_3', ' ') }}

{{ textInputNumeric($errors, 'text', $userPublic, 'address_mailing_postcode', trans('new.postcode'), true) }}

{{-- {{ masterSelect($errors, $masterState, $userPublic, 'address_mailing_state_id', 'state_id', 'state', trans('new.state'), true) }} --}}

<div class="form-group form-md-line-input">
    <label for="language" class="control-label col-md-4">{{ trans('new.state') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">

        <div class="input-icon right">
            <select class="form-control select2" id="address_mailing_state_id" name="address_mailing_state_id">
                @foreach($masterState AS $key => $value)
                    @if($value->state_id == $userPublic->address_mailing_state_id)
                        <option value="{{$value->state_id}}" selected>{{$value->state}}</option>
                    @else
                        <option value="{{$value->state_id}}">{{$value->state}}</option>
                    @endif
                @endforeach

            </select>

		</div>
	</div>
</div>

{{ masterSelect($errors, false, $userPublic, 'address_mailing_district_id', 'district_id', 'district', trans('new.district'), true) }}