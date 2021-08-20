<?php
use Carbon\Carbon;
$locale = App::getLocale();
$method_lang = "method_".$locale;
$race_lang = "race_".$locale;
$occupation_lang = "occupation_".$locale;
$gender_lang = "gender_".$locale;
$designation_lang = 'designation_'.$locale;
?>

<style>
	.modal-body {padding: 0px;}

    .control-label-custom  {
        padding-top: 15px !important;
    }
</style>

<div class="modal-body">
	<div class="portlet light bordered form-fit">
		<div class="portlet-body form">
			<form action="#" class="form-horizontal form-bordered ">
				<div class="form-body">
					<div class="form-group" style="display: flex;">
						<div class="col-md-12" style="align-items: stretch;border-left: none;">
							<span class="bold" style="align-items: stretch;">{{ __('new.details') }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.name')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->name or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">@if($user->public_data->user_public_type_id == 2){{ trans('new.company_no')}}@elseif($user->public_data->individual->nationality_country_id == 129){{ trans('new.ic')}}@else{{ trans('new.passport')}}@endif</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->username }}</span>
						</div>
					</div>
					@if($user->public_data->user_public_type_id == 1 && $user->public_data->individual->nationality_country_id != 129)
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.status')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->individual->nationality->country or '' }}</span>
						</div>
					</div>
					@endif



					<div class="form-group" style="display: flex;">
						<div class="col-md-12" style="align-items: stretch;border-left: none;">
							<span class="bold" style="align-items: stretch;">{{ __('new.contact_info') }}</span>
						</div>
					</div>
					@if($user->public_data->user_public_type_id == 1)
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_home')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->individual->phone_home or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_mobile')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->individual->phone_mobile or '' }}</span>
						</div>
					</div>
					@endif

					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_office')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->phone_office or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_fax')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->phone_fax or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.email')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->email or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.notification_method')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->notification ? $user->public_data->notification->$method_lang : '' }}</span>
						</div>
					</div>





					<div class="form-group" style="display: flex;">
						<div class="col-md-12" style="align-items: stretch;border-left: none;">
							<span class="bold" style="align-items: stretch;">{{ __('new.address') }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.street')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->address_street_1 or '' }} <br>
							{{ $user->public_data->address_street_2 or '' }} <br>
							{{ $user->public_data->address_street_3 or '' }}
							</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.postcode')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->address_postcode or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.district')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->district ? $user->public_data->district->district : '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.state')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->state ? $user->public_data->state->state : '' }}</span>
						</div>
					</div>





					<div class="form-group" style="display: flex;">
						<div class="col-md-12" style="align-items: stretch;border-left: none;">
							<span class="bold" style="align-items: stretch;">{{ __('new.mailing_address') }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.street')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->address_mailing_street_1 or '' }} <br>
										{{ $user->public_data->address_mailing_street_2 or '' }}<br>
										{{ $user->public_data->address_mailing_street_3 or '' }}
							</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.postcode')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->address_mailing_postcode or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.district')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">@if($user->public_data->address_mailing_district_id){{ $user->public_data->mailing_district->district }}@endif</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.state')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">@if($user->public_data->address_mailing_state_id){{ $user->public_data->mailing_state->state }}@endif</span>
						</div>
					</div>





					@if($user->public_data->user_public_type_id == 1)
					<div class="form-group" style="display: flex;">
						<div class="col-md-12" style="align-items: stretch;border-left: none;">
							<span class="bold" style="align-items: stretch;">{{ __('new.demographic') }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.gender')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->individual->gender->$gender_lang or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.dob')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id=""><?= Carbon::parse($user->public_data->individual->date_of_birth)->format('d/m/Y') ?></span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.race')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->individual->race->$race_lang or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.occupation')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->individual->occupation->$occupation_lang or '' }}</span>
						</div>
					</div>
					@else
					<div class="form-group" style="display: flex;">
						<div class="col-md-12" style="align-items: stretch;border-left: none;">
							<span class="bold" style="align-items: stretch;">{{ __('new.rep_info') }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.name')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->company->representative_name or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">@if($user->public_data->company->representative_nationality_country_id == 129){{ trans('new.ic')}}@else{{ trans('new.passport')}}@endif</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->company->representative_identification_no or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.designation')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->company->designation->$designation_lang or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_home')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->company->representative_phone_home or '' }}</span>
						</div>
					</div>
					<div class="form-group" style="display: flex;">
						<div class="control-label col-xs-3 control-label-custom" style="border-left: none;">{{ trans('new.phone_mobile')}}</div>
						<div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $user->public_data->company->representative_phone_mobile or '' }}</span>
						</div>
					</div>
					@endif
					
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('new.close')}}</button>
</div>