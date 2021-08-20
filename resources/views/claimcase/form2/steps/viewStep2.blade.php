<?php
$locale = App::getLocale();
$designation_lang = 'designation_'.$locale;
?>
<div id="step_2" class="row step_item">

	<div class="col-md-12 ">
		<!-- Opponent Details-->

		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-layers font-green-sharp"></i>
					<span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.opponent_info') }} </span>
					<span class="caption-helper"></span>
				</div>
				<div class="tools">
					<a href="" class="collapse"></a>
					<a href="" class="fullscreen"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<form class="form-horizontal" role="form">
					<div class="form-body">
						<div id="opponent_identification_no"  class="form-group form-md-line-input" >
							<label for="opponent_identification_no" class="control-label col-md-4" style="padding-top: 0px">
								<span id="label_opponent_identification_no">
								@if($caseOppo->opponent_address->is_company == 0)
                                    @if($caseOppo->opponent_address->nationality_country_id == 129)
                                        {{ __('form2.ic_no') }} :
                                    @else
                                        {{ __('form2.passport_no') }} :
                                    @endif
                                @else
                                    {{ __('form2.company_no') }} :
                                @endif
                                </span>
								<span class="required"> &nbsp;&nbsp; </span>
							</label>
							<div class="col-md-6">
								{{ $caseOppo->opponent_address->identification_no }}
							</div>
						</div> 
						<div class="form-group form-md-line-input">
							<label for="opponent_name" class="control-label col-md-4" style="padding-top: 0px">
								<span id="label_opponent_name">{{ __('form2.opponent_name') }} : </span>
								<span class="required"> &nbsp;&nbsp; </span>
							</label>
							<div class="col-md-6">
								{{ $caseOppo->opponent_address->name }}
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	@if($caseOppo->opponent_address->is_company == 1)
	<div id="block_opponent_representative" class="col-md-12 ">
		<!-- Opponent Details-->

		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-layers font-green-sharp"></i>
					<span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.representative_info') }} </span>
					<span class="caption-helper"></span>
				</div>
				<div class="tools">
					<a href="" class="collapse"></a>
					<a href="" class="fullscreen"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<form class="form-horizontal" role="form">
					<div class="form-body">
						<div class="form-group form-md-line-input">
							<label for="representative_identification_no" class="control-label col-md-4">
								<select id="representative_identity_type" onchange="changeRepresentativeType()" class="bs-select form-control" data-width="50%">
									<option @if($caseOppo->opponent->public_data->company && $caseOppo->opponent->public_data->company->representative_nationality_country_id == 129) selected @endif value="1">{{ __('form2.ic_no') }}</option>
									<option @if($caseOppo->opponent->public_data->company && $caseOppo->opponent->public_data->company->representative_nationality_country_id != 129) selected @endif value="2">{{ __('form2.passport_no') }}</option>
								</select>
								<span>:</span>
								<span class="required"> &nbsp;&nbsp; </span>
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="text" class="form-control" id="representative_identification_no" name="representative_identification_no" value="{{ $caseOppo->opponent->public_data->company ? $caseOppo->opponent->public_data->company->representative_identification_no : '-' }}"/>
								<span class="help-block"></span>
							</div>
						</div>
						@if($caseOppo->opponent->public_data->company && $caseOppo->opponent->public_data->company->representative_nationality_country_id != 129)
						<div id="row_representative_nationality" class="form-group form-md-line-input">
							<label for="representative_nationality" class="control-label col-md-4">{{ __('form2.nationality') }} :
								<span>&nbsp;&nbsp;</span>
							</label>
							
							<div class="col-md-6">
								<select class="form-control select2 bs-select" id="representative_nationality" name="representative_nationality"  data-placeholder="---">
									@foreach ($countries as $country)
                                        <option 
                                        @if($caseOppo->opponent->public_data->company && $caseOppo->opponent->public_data->company->representative_nationality_country_id == $country->country_id) selected
                                        @endif
                                        value="{{ $country->country_id }}">{{ $country->country }}
                                        </option>
                                    @endforeach
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						@endif
						<div class="form-group form-md-line-input">
							<label for="representative_name" class="control-label col-md-4">{{ __('form2.representative_name') }} :
								<span class="required"> &nbsp;&nbsp; </span>
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="text" class="form-control" id="representative_name" name="representative_name" value="{{ $caseOppo->opponent->public_data->company ? $caseOppo->opponent->public_data->company->representative_name : '-' }}"/>
								<span class="help-block"></span>
							</div>
						</div>
						<div id="row_representative_desg" class="form-group form-md-line-input">
							<label for="representative_desg" class="control-label col-md-4">{{ __('form2.representative_designation') }} :
								<span class="required"> &nbsp;&nbsp; </span>
							</label>
							<div class="col-md-6">
								<select class="form-control select2 bs-select" id="representative_designation" name="representative_designation"  data-placeholder="---">
									@foreach ($designations as $designation)
										<option 
										@if($caseOppo->opponent->public_data->company && $caseOppo->opponent->public_data->company->representative_designation_id == $designation->designation_id) selected
                                        @endif
										value="{{ $designation->designation_id }}">{{ $designation->$designation_lang }}</option>
									@endforeach
								</select>
								<span class="help-block"></span>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endif

	<div class="col-md-12 ">
		<!-- Opponent Contact Details-->

		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-layers font-green-sharp"></i>
					<span class="caption-subject bold font-green-sharp uppercase"> {{ __('form2.opponent_contact_info') }} </span>
					<span class="caption-helper"></span>
				</div>
				<div class="tools">
					<a href="" class="collapse"></a>
					<a href="" class="fullscreen"></a>
				</div>
			</div>

			<div class="portlet-body form">
				<form class="form-horizontal" role="form">
					<div class="form-body">
						<div class="form-group form-md-line-input">
							<label for="opponent_street1" class="control-label col-md-4">{{ __('form2.street') }} 1 :
								<span class="required"> * </span>
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="text" class="form-control" id="opponent_street1" name="opponent_street1" value="{{ $caseOppo->opponent_address->street_1 }}"/>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label for="opponent_street2" class="control-label col-md-4">
								<span>&nbsp;&nbsp;</span>
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="text" class="form-control" id="opponent_street2" name="opponent_street2" value="{{ $caseOppo->opponent_address->street_2 }}"/>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label for="opponent_street3" class="control-label col-md-4">
								<span>&nbsp;&nbsp;</span>
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="text" class="form-control" id="opponent_street3" name="opponent_street3" value="{{ $caseOppo->opponent_address->street_3 }}"/>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label for="opponent_postcode" class="control-label col-md-4">{{ __('form2.postcode') }} :
								<span class="required"> * </span>
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" class="form-control numeric" id="opponent_postcode" name="opponent_postcode" value="{{ $caseOppo->opponent_address->postcode }}"/>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label for="opponent_state" class="control-label col-md-4">{{ __('form2.state') }} :
								<span class="required"> * </span>
							</label>
							<div class="col-md-6">
								<select onchange="loadDistricts('opponent_state','opponent_district')" class="form-control select2 bs-select" id="opponent_state" name="opponent_state"  data-placeholder="---">
									@foreach ($states as $state)
                                        <option 
                                        {{ $caseOppo->opponent_address->state_id == $state->state_id ? " selected='selected' " : "" }}
                                        value="{{ $state->state_id }}">{{ $state->state }}</option>
                                    @endforeach
								</select>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label for="opponent_district" class="control-label col-md-4">{{ __('form2.district') }}:
								<span class="required"> * </span>
							</label>
							<div class="col-md-6">
								<div class="input-group">
                                    <div class="input-group-control">
                                        <select onchange="updateReview()" class="form-control select2 bs-select" id="opponent_district" name="opponent_district"  data-placeholder="---">
											@if($state_districts)
		                                    @foreach ($state_districts as $district)
		                                        <option 
		                                        {{ $caseOppo->opponent_address->district_id == $district->district_id ? " selected='selected' " : "" }}
		                                        value="{{ $district->district_id }}">{{ $district->district }}</option>
		                                    @endforeach
		                                    @endif
										</select>
                                        <span class="help-block"></span><br> 
                                    </div>
                                    <span class="input-group-btn btn-right" >
                                        <a href="{{ url('files/ref_district.pdf') }}" class="btn btn-circle">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </span>
                                </div>
							</div>
						</div>
						<div class="form-group form-md-line-input hidden" id="row_opponent_phone_home">
							<label for="opponent_phone_home" class="control-label col-md-4">{{ __('form2.home_phone') }} :
								<span class="required"> &nbsp;&nbsp; </span>
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="tel" class="form-control numeric" id="opponent_phone_home" name="opponent_phone_home" @if($caseOppo->opponent_address->is_company == 0) value="{{ $caseOppo->opponent_address->phone_home }}" @else value="{{ $caseOppo->opponent->public_data->company ? $caseOppo->opponent->public_data->company->representative_phone_home : '' }}" @endif/>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group form-md-line-input" id="row_opponent_phone_mobile">
							<label for="opponent_phone_mobile" class="control-label col-md-4">{{ __('form2.mobile_phone') }} :
								@if($caseOppo->opponent_address->is_company == 1)
								<span id="required_opponent_phone_mobile" class="required"> &nbsp;&nbsp; </span>
								@else
								<span id="required_opponent_phone_mobile" class="required"> &nbsp;&nbsp; </span>
								@endif
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="tel" class="form-control numeric" id="opponent_phone_mobile" name="opponent_phone_mobile" @if($caseOppo->opponent_address->is_company == 0) value="{{ $caseOppo->opponent_address->phone_mobile }}" @else value="{{ $caseOppo->opponent->public_data->company ? $caseOppo->opponent->public_data->company->representative_phone_mobile : '' }}" @endif/>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group form-md-line-input" id="row_opponent_phone_office">
							<label for="opponent_phone_office" class="control-label col-md-4">{{ __('form2.office_phone') }} :
								@if($caseOppo->opponent_address->is_company == 1)
								<span id="required_opponent_phone_office" class="required"> &nbsp;&nbsp; </span>
								@else
								<span id="required_opponent_phone_office" class="required"> &nbsp;&nbsp; </span>
								@endif
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="tel" class="form-control numeric" id="opponent_phone_office" name="opponent_phone_office" value="{{ $caseOppo->opponent_address->phone_office }}"/>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group form-md-line-input" id="row_opponent_phone_fax">
							<label for="opponent_phone_fax" class="control-label col-md-4">{{ __('form2.fax_no') }}:
								<span class="required"> &nbsp;&nbsp; </span>
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="tel" class="form-control numeric" id="opponent_phone_fax" name="opponent_phone_fax" value="{{ $caseOppo->opponent_address->phone_fax }}"/>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label for="opponent_email" class="control-label col-md-4">{{ __('form2.email') }} :
								<span class="required"> &nbsp;&nbsp;  </span>
							</label>
							<div class="col-md-6">
								<input onchange="updateReview()" type="email" class="form-control" id="opponent_email" name="opponent_email" value="{{ $caseOppo->opponent_address->email }}"/>
								<span class="help-block"></span>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>