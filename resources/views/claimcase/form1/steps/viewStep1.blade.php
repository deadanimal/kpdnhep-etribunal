<?php
$locale = App::getLocale();
$category_lang = "category_" . $locale;
$relationship_lang = "relationship_" . $locale;
?>

<div id="step_1" class="row step_item">
    <div id='block_inquiry_info' class="col-md-12">

        <!-- Inquiry-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form1.inquiry_info') }} </span>
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
                        <div id="row_inquiry_no" class="form-group form-md-line-input">
                            <label for="inquiry_no" id="label_inquiry_no"
                                   class="control-label col-md-4">{{ __('form1.inquiry_ref_no') }} :</label>
                            <div class="col-md-6">
                                <input hidden type="text" id="claim_case_id" name="claim_case_id"
                                       @if(isset($case))
                                       value="{{ $case->claim_case_id }}"
                                        @endif
                                />
                                <input onchange="updateReview()" type="text" class="form-control" id="inquiry_no"
                                       name="inquiry_no"
                                       @if(isset($case))
                                       @if($case->inquiry_id)
                                       value="{{ $case->inquiry->inquiry_no }}" readonly
                                       @endif
                                       @elseif($inquiry)
                                       value="{{ $inquiry->inquiry_no }}" readonly
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <!-- Claimant-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form1.claimant_info') }} </span>
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
                        <div id="row_claimant_identification_no" class="form-group form-md-line-input">
                            <label for="claimant_identification_no" style="padding-top: 0px"
                                   class="control-label col-md-4 col-xs-12">
                                @if(!$is_staff || $inquiry)

                                    <span id="label_claimant_identification_no">{{ __('form1.ic_no') }} :</span>
                                    <input type="hidden" name="claimant_identity_type"
                                           @if($user)
                                           @if($user->public_data->user_public_type_id == 2) value="3"
                                           @elseif($user->public_data->individual->nationality_country_id == 129) value="1"
                                           @else value="2"
                                            @endif />
                                @endif
                                @else
                                    <select id="claimant_identity_type" name="claimant_identity_type"
                                            onchange="changeClaimantType()" class="bs-select form-control"
                                            data-width="60%">
                                        <option value="1">{{ __('form1.ic_no') }}</option>
                                        <option value="2">{{ __('form1.passport_no') }}</option>
                                        {{-- <option value="3">{{ __('form1.company_no') }}</option> --}}
                                    </select>
                                    <span>:</span>
                                @endif
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-control">
                                        <input @if(!$is_staff || $inquiry) readonly @endif type="text"
                                               class="form-control" id="claimant_identification_no" required
                                               onchange="checkClaimant()" name="claimant_identification_no"
                                               @if(!$is_staff || $inquiry)
                                               @if($user)
                                               @if($user->public_data->user_public_type_id != 3) value="{{ $user->username }}"
                                               @else value="{{ $user->public_data->individual->identification_no }}"
                                               @endif
                                               @endif
                                               @else
                                               @if($case)
                                               @if($case->claimant->public_data->user_public_type_id != 3) value="{{ $case->claimant->username }}"
                                               @else value="{{ $case->claimant->public_data->individual->identification_no }}"
                                        @endif
                                        @endif
                                        @endif" />
                                        <span class="help-block"></span><br>
                                        <small id='claimant_myidentity_info'></small>
                                    </div>

                                    <span class="input-group-btn btn-right"
                                          @if(!$is_staff) style='display: table-column;' @endif >
                                        @if($is_staff)
                                            <a id='btn_claimant_myidentity' href="javascript:;"
                                               onclick='checkMyIdentityClaimant()' class="btn btn-primary btn-circle">
                                            <i class="fa fa-search"></i> {{ __('button.check') }} MyIdentity
                                        </a>
                                            <a id='btn_claimant_ecbis' href="javascript:;"
                                               onclick='checkEcbisClaimant()' class="btn btn-primary btn-circle">
                                            <i class="fa fa-search"></i> {{ __('button.check') }} ECBIS (SSM)
                                        </a>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="row_claimant_nationality" class="form-group form-md-line-input">
                            <label for="claimant_nationality" id="label_claimant_nationality"
                                   class="control-label col-md-4">{{ __('form1.nationality') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select @if(!$is_staff || $inquiry) readonly @endif required onchange="updateReview()"
                                        class="form-control select2 bs-select" id="claimant_nationality"
                                        name="claimant_nationality" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($countries as $country)
                                        <option
                                                @if(!$is_staff || $inquiry)
                                                @if($user)
                                                @if($user->public_data->user_public_type_id == 1)
                                                @if($user->public_data->individual->nationality_country_id == $country->country_id) selected
                                                @endif
                                                @endif
                                                @endif
                                                @else
                                                @if($case)
                                                @if($case->claimant->public_data->user_public_type_id == 1)
                                                @if($case->claimant->public_data->individual->nationality_country_id == $country->country_id) selected
                                                @endif
                                                @endif
                                                @endif
                                                @endif value="{{ $country->country_id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_name" class="form-group form-md-line-input">
                            <label for="claimant_name" id="label_claimant_name" style="padding-top: 0px"
                                   class="control-label col-md-4">{{ __('form1.claimant_name') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input @if(!$is_staff || $inquiry) readonly @endif onchange="updateReview()" type="text"
                                       class="form-control" id="claimant_name" name="claimant_name"
                                       @if(!$is_staff || $inquiry)
                                       @if($user)
                                       value="{{ $user->name }}"
                                       @endif
                                       @else
                                       @if($case)
                                       value="{{ $case->claimant_address->name }}"
                                        @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <!-- Claimant Contact Details-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form1.claimant_contact_info') }} </span>
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
                        <div id="row_claimant_street1" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street1" id="label_claimant_street1"
                                   class="control-label col-md-4">{{ __('form1.street') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input required onchange="updateReview()" type="text" class="form-control"
                                       id="claimant_street1" name="claimant_street1"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->public_data->address_street_1 }}"
                                       @endif
                                       @else @if($case) value="{{ $case->claimant_address->street_1 }}" @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_street2" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street2" id="label_claimant_street2"
                                   class="control-label col-md-4"><span class="required">&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control" id="claimant_street2"
                                       name="claimant_street2"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->public_data->address_street_2 }}"
                                       @endif
                                       @else @if($case) value="{{ $case->claimant_address->street_2 }}" @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_street3" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street3" id="label_claimant_street3"
                                   class="control-label col-md-4"><span class="required">&nbsp;&nbsp;</span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control" id="claimant_street3"
                                       name="claimant_street3"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->public_data->address_street_3 }}"
                                       @endif
                                       @else @if($case) value="{{ $case->claimant_address->street_3 }}" @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_postcode" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_postcode" id="label_claimant_postcode"
                                   class="control-label col-md-4">{{ __('form1.postcode') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input required onchange="updateReview()" maxlength="5" type="text"
                                       class="form-control numeric" id="claimant_postcode" name="claimant_postcode"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->public_data->address_postcode }}"
                                       @endif
                                       @else @if($case) value="{{ $case->claimant_address->postcode }}" @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_state" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_state" id="label_claimant_state"
                                   class="control-label col-md-4">{{ __('form1.state') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select onchange="loadDistricts('claimant_state','claimant_district')"
                                        class="form-control select2 bs-select" id="claimant_state" name="claimant_state"
                                        data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($states as $state)
                                        <option
                                                @if(!$is_staff || $inquiry) @if($user){{ $user->public_data->address_state_id == $state->state_id ? " selected='selected' " : "" }}@endif
                                                @else @if($case){{ $case->claimant_address->state_id == $state->state_id ? " selected='selected' " : "" }}@endif
                                                @endif
                                                value="{{ $state->state_id }}">{{ $state->state }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_district" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_district" id="label_claimant_district"
                                   class="control-label col-md-4">{{ __('form1.district') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-control">
                                        <select required
                                                onchange="loadSubdistricts('claimant_state','claimant_district','claimant_subdistrict')"
                                                class="form-control select2 bs-select" id="claimant_district"
                                                name="claimant_district" data-placeholder="---">
                                            <option value="" disabled selected>---</option>
                                            @if($state_districts)
                                                @foreach ($state_districts as $district)
                                                    <option
                                                            @if($case)
                                                            {{ $case->claimant_address->district_id == $district->district_id ? " selected='selected' " : "" }}
                                                            @elseif((!$is_staff || $inquiry) && $user)
                                                            {{ $user->public_data->address_district_id == $district->district_id ? " selected='selected' " : "" }}
                                                            @endif
                                                            value="{{ $district->district_id }}">
                                                        {{ $district->district }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="help-block"></span><br>
                                    </div>
                                    <span class="input-group-btn btn-right">
                                        <a href="{{ url('files/ref_district.pdf') }}" target="_blank"
                                           class="btn btn-circle">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="row_claimant_subdistrict" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_subdistrict" id="label_claimant_subdistrict"
                                   class="control-label col-md-4">{{ __('form1.sub-district') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-control">
                                        <select required onchange="updateReview()"
                                                class="form-control select2" id="claimant_subdistrict"
                                                name="claimant_subdistrict" data-placeholder="---">
                                            <option value="" disabled>---</option>
                                            @if($state_subdistricts)
                                                @foreach ($state_subdistricts as $subdistrict)
                                                    <option
                                                            @if($case)
                                                            {{ $case->claimant_address->subdistrict_id == $subdistrict->id ? " selected=selected" : "" }}
                                                            @elseif((!$is_staff || $inquiry) && $user)
                                                            {{ $user->public_data->address_subdistrict_id == $subdistrict->id ? " selected=selected" : "" }}
                                                            @endif
                                                            value="{{ $subdistrict->id }}">
                                                        {{ $subdistrict->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="help-block"></span><br>
                                    </div>
                                    <span class="input-group-btn btn-right">
                                        <a href="{{ url('files/ref_district.pdf') }}" target="_blank"
                                           class="btn btn-circle">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 ">
        <!-- Claimant Mailing Address Details-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form1.claimant_mailing_address_info') }} </span>
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
                        <div id="row_claimant_street1" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street1" id="label_claimant_street1"
                                   class="control-label col-md-4">{{ __('form1.street') }} :
                            </label>
                            <div class="col-md-6">
                                <input required onchange="updateReview()" type="text" class="form-control"
                                       id="claimant_mailing_street1" name="claimant_mailing_street1"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->public_data->address_mailing_street_1 }}"
                                       @endif
                                       @else @if($case) value="{{ $case->claimant_address->address_mailing_street_1 }}" @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_street2" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street2" id="label_claimant_street2" class="control-label col-md-4">
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control"
                                       id="claimant_mailing_street2" name="claimant_mailing_street2"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->public_data->address_mailing_street_2 }}"
                                       @endif
                                       @else @if($case) value="{{ $case->claimant_address->address_mailing_street_2 }}" @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_street3" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_street3" id="label_claimant_street3" class="control-label col-md-4">
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text" class="form-control"
                                       id="claimant_mailing_street3" name="claimant_mailing_street3"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->public_data->address_mailing_street_3 }}"
                                       @endif
                                       @else @if($case) value="{{ $case->claimant_address->address_mailing_street_3 }}" @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_postcode" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_postcode" id="label_claimant_postcode"
                                   class="control-label col-md-4">{{ __('form1.postcode') }} :
                            </label>
                            <div class="col-md-6">
                                <input required onchange="updateReview()" maxlength="5" type="text"
                                       class="form-control numeric" id="claimant_mailing_postcode"
                                       name="claimant_mailing_postcode"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->public_data->address_mailing_postcode }}"
                                       @endif
                                       @else @if($case) value="{{ $case->claimant_address->address_mailing_postcode }}" @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_state" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_state" id="label_claimant_state"
                                   class="control-label col-md-4">{{ __('form1.state') }} :
                            </label>
                            <div class="col-md-6">
                                <select onchange="loadDistricts('claimant_mailing_state','claimant_mailing_district')"
                                        class="form-control select2 bs-select" id="claimant_mailing_state"
                                        name="claimant_mailing_state" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($states as $state)
                                        <option
                                                @if(!$is_staff || $inquiry) @if($user){{ $user->public_data->address_mailing_state_id == $state->state_id ? " selected='selected' " : "" }}@endif
                                                @else @if($case){{ $case->claimant_address->address_mailing_state_id == $state->state_id ? " selected='selected' " : "" }}@endif
                                                @endif
                                                value="{{ $state->state_id }}">{{ $state->state }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_district" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_district" id="label_claimant_district"
                                   class="control-label col-md-4">{{ __('form1.district') }} :
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-control">
                                        <select onchange="loadSubdistricts('claimant_mailing_state','claimant_mailing_district','claimant_mailing_subdistrict')"
                                                class="form-control select2 bs-select" id="claimant_mailing_district"
                                                name="claimant_mailing_district" data-placeholder="---">
                                            <option value="" disabled selected>---</option>
                                            @foreach ($districts as $mailing_district)
                                                <option
                                                        @if(!$is_staff || $inquiry) @if($user){{ $user->public_data->address_mailing_district_id == $mailing_district->district_id ? " selected='selected' " : "" }}@endif
                                                        @else @if($case){{ $case->claimant_address->address_mailing_district_id == $mailing_district->district_id ? " selected='selected' " : "" }}@endif
                                                        @endif
                                                        value="{{ $mailing_district->district_id }}">{{ $mailing_district->district }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block"></span><br>
                                    </div>
                                    <span class="input-group-btn btn-right">
                                        <a href="{{ url('files/ref_district.pdf') }}" target="_blank"
                                           class="btn btn-circle">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="row_claimant_mailing_subdistrict" class="form-group form-md-line-input non-tourist">
                            <label for="claimant_mailing_subdistrict" id="label_claimant_mailing_subdistrict"
                                   class="control-label col-md-4">{{ __('form1.sub-district') }} :
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-control">
                                        <select onchange="updateReview()" class="form-control select2"
                                                id="claimant_mailing_subdistrict" name="claimant_mailing_subdistrict"
                                                data-placeholder="---">
                                            <option value="" disabled selected>---</option>
                                            @if($subdistricts)
                                                @foreach ($subdistricts as $subdistrict)
                                                    <option
                                                            @if(!$is_staff || $inquiry) @if($user){{ $user->public_data->address_mailing_subdistrict_id == $subdistrict->id ? " selected='selected' " : "" }}@endif
                                                            @else @if($case){{ $case->claimant_address->subdistrict_id == $district->id ? " selected='selected' " : "" }}@endif
                                                            @endif
                                                            value="{{ $subdistrict->id }}">
                                                        {{ $subdistrict->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="help-block"></span><br>
                                    </div>
                                    <span class="input-group-btn btn-right">
                                        <a href="{{ url('files/ref_district.pdf') }}" target="_blank"
                                           class="btn btn-circle">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 ">
        <!-- Claimant Contact Details-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('form1.claimant_contact_info') }} </span>
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
                        <div id="row_claimant_phone_home" class="form-group form-md-line-input"
                             id="row_claimant_phone_home">
                            <label for="claimant_phone_home" id="label_claimant_phone_home"
                                   class="control-label col-md-4"><span id="label_claimant_phone_home">{{ __('form1.home_phone') }} :</span>
                                <span class="required"> ** {{ __('new.at_least_one') }} </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="tel" class="form-control numeric"
                                       id="claimant_phone_home" name="claimant_phone_home" @if(!$is_staff || $inquiry)
                                       @if($user)
                                       @if($user->public_data->user_public_type_id == 1) value="{{ $user->public_data->individual->phone_home }}"
                                       @endif
                                       @endif
                                       @else
                                       @if($case)
                                       @if($case->claimant->public_data->user_public_type_id == 1) value="{{ $case->claimant->public_data->individual->phone_home }}"
                                        @endif
                                        @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_phone_mobile" class="form-group form-md-line-input"
                             id="row_claimant_phone_mobile">
                            <label for="claimant_phone_mobile" id="label_claimant_phone_mobile"
                                   class="control-label col-md-4">{{ __('form1.mobile_phone') }} :
                                <span id="required_claimant_phone_mobile"
                                      class="required">** {{ __('new.at_least_one') }}</span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="tel" class="form-control numeric"
                                       id="claimant_phone_mobile" name="claimant_phone_mobile"
                                       @if(!$is_staff || $inquiry)
                                       @if($user)
                                       @if($user->public_data->user_public_type_id == 1) value="{{ $user->public_data->individual->phone_mobile }}"
                                       @endif
                                       @endif
                                       @else
                                       @if($case)
                                       @if($case->claimant->public_data->user_public_type_id == 1) value="{{ $case->claimant->public_data->individual->phone_mobile }}"
                                        @endif
                                        @endif
                                        @endif
                                />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_phone_office" class="form-group form-md-line-input non-tourist"
                             id="row_claimant_phone_office">
                            <label for="claimant_phone_office" id="label_claimant_phone_office"
                                   class="control-label col-md-4">{{ __('form1.office_phone') }} :
                                <span id="required_claimant_phone_office" class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="tel" class="form-control numeric"
                                       id="claimant_phone_office" name="claimant_phone_office"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->phone_office }}"
                                       @endif @else @if($case) value="{{ $case->claimant->phone_office }}" @endif @endif/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_phone_fax" class="form-group form-md-line-input non-tourist"
                             id="row_claimant_phone_fax">
                            <label for="claimant_phone_fax" id="label_claimant_phone_fax"
                                   class="control-label col-md-4">{{ __('form1.fax_no') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="tel" class="form-control numeric"
                                       id="claimant_phone_fax" name="claimant_phone_fax"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->phone_fax }}"
                                       @endif @else @if($case) value="{{ $case->claimant->phone_fax }}" @endif @endif/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_claimant_email" class="form-group form-md-line-input">
                            <label for="claimant_email" id="label_claimant_email"
                                   class="control-label col-md-4">{{ __('form1.email') }} :
                                <span class="required"> {{ $is_staff ? '&nbsp;&nbsp;' : '*' }} </span>
                            </label>
                            <div class="col-md-6">
                                <input required onchange="updateReview()" type="email" class="form-control"
                                       id="claimant_email" name="claimant_email"
                                       @if(!$is_staff || $inquiry) @if($user) value="{{ $user->email }}"
                                       @endif @else @if($case) value="{{ $case->claimant->email }}" @endif @endif/>
                                <span class="help-block"></span>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <!-- Claimant-->

        <div class="portlet light">
            <div class="portlet-title">
                <form class="" role="form">
                    <div class="caption">
                        <i class="icon-layers font-green-sharp"></i>
                        <span class="caption-subject bold font-green-sharp uppercase md-checkbox-inline">
                            {{ __('form1.extra_claimant_info') }}
                            <div class="md-checkbox font-dark" style="margin-left: 10px; text-transform: capitalize;">
                                <input name="has_extra_claimant" id="has_extra_claimant" class="md-check"
                                       type="checkbox" onchange="toggleDiv(this)">
                                <label class="font-dark" for="has_extra_claimant">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('form1.if_applicable') }}
                                </label>
                            </div>
                        </span>
                        <span class="caption-helper"></span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"></a>
                        <a href="" class="fullscreen"></a>
                    </div>
                </form>
            </div>

            <div class="portlet-body form" style="display: none;">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div id="row_extra_claimant_identification_no" class="form-group form-md-line-input">
                            <label for="extra_claimant_identification_no" style="padding-top: 0px"
                                   class="control-label col-md-4 col-xs-12">
                                <select id="extra_claimant_identity_type" name="extra_claimant_identity_type"
                                        onchange="changeExtraClaimantType()" class="bs-select form-control"
                                        data-width="60%">
                                    <option value="1">{{ __('form1.ic_no') }}</option>
                                    <option value="2">{{ __('form1.passport_no') }}</option>
                                </select>
                                <span>:</span>
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-control">
                                        @if($is_staff)
                                            <input type="text" 
                                                class="form-control" 
                                                id="extra_claimant_identification_no" 
                                                required 
                                                onchange="checkExtraClaimant()"
                                                name="extra_claimant_identification_no" 
                                                value="" />
                                        @else
                                            <input type="text" 
                                                class="form-control" 
                                                id="extra_claimant_identification_no" 
                                                required 
                                                name="extra_claimant_identification_no" 
                                                value="" />
                                        @endif
                                        <span class="help-block"></span><br>
                                        <small id='extra_claimant_myidentity_info'></small>
                                    </div>

                                    <span class="input-group-btn btn-right"
                                          @if(!$is_staff) style='display: table-column;' @endif >
                                        @if($is_staff)
                                            <a id='btn_claimant_myidentity' href="javascript:;"
                                               onclick='checkMyIdentityExtraClaimant()'
                                               class="btn btn-primary btn-circle">
                                            <i class="fa fa-search"></i> {{ __('button.check') }} MyIdentity
                                        </a>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="row_extra_claimant_nationality" class="form-group form-md-line-input"
                             style="display:none;">
                            <label for="extra_claimant_nationality" id="label_extra_claimant_nationality"
                                   class="control-label col-md-4">{{ __('form1.nationality') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select @if(!$is_staff || $inquiry) readonly @endif required onchange="updateReview()"
                                        class="form-control select2 bs-select" id="extra_claimant_nationality"
                                        name="extra_claimant_nationality" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->country_id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_extra_claimant_name" class="form-group form-md-line-input">
                            <label for="extra_claimant_name" id="label_extra_claimant_name" style="padding-top: 0px"
                                   class="control-label col-md-4">{{ __('form1.extra_claimant_name') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input onchange="updateReview()" type="text"
                                       class="form-control" id="extra_claimant_name" name="extra_claimant_name"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div id="row_extra_claimant_relationship" class="form-group form-md-line-input">
                            <label for="extra_claimant_relationship" id="label_extra_claimant_relationship"
                                   class="control-label col-md-4">{{ __('form1.relationship') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select @if(!$is_staff || $inquiry) readonly @endif 
                                        required 
                                        onchange="updateReview()"
                                        class="form-control select2 bs-select" 
                                        id="extra_claimant_relationship"
                                        name="extra_claimant_relationship" 
                                        data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($relationships as $relationship)
                                        <option value="{{ $relationship->relationship_id }}">
                                            {{ strtoupper($relationship->$relationship_lang) }}
                                        </option>
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


    @if(strpos(Request::url(),'edit') === false)
        @if($is_staff)
            <div class="col-md-12 mt-element-ribbon hidden">
                <!-- Process-->

                <div class="ribbon ribbon-right ribbon-clip ribbon-color-danger uppercase">
                    <div class="ribbon-sub ribbon-clip ribbon-right"></div> {{ __('form1.office_use') }}
                </div>

                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-layers font-red-thunderbird"></i>
                            <span class="caption-subject bold font-red-thunderbird uppercase"> {{ __('form1.instant_form1_process') }}</span>
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

                                <div id="inst_row_filing_date" class="form-group form-md-line-input">
                                    <label for="filing_date" id="label_filing_date"
                                           class="control-label col-md-4">{{ __('form1.filing_date') }} :
                                        <span class="required"> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-group date" data-date-format="dd/mm/yyyy">
                                            <input required
                                                   class="form-control form-control-inline date-picker datepicker clickme"
                                                   name="inst_filing_date" id="inst_filing_date" readonly=""
                                                   data-date-format="dd/mm/yyyy" type="text" value=""/>
                                        </div>
                                    </div>
                                </div>

                                <div id="inst_row_claim_category" class="form-group form-md-line-input">
                                    <label for="claim_category" id="label_claim_category"
                                           class="control-label col-md-4">{{ __('form1.category_claim') }} :
                                        <span class="required"> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-6">
                                        <select required class="form-control select2 bs-select" id="inst_claim_category"
                                                name="inst_claim_category" data-placeholder="---">
                                            <option value="" disabled selected>---</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->claim_category_id }}">
                                                    {{ $category->$category_lang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
