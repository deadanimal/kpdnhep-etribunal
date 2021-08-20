<?
$locale = App::getLocale();
?>
<div class="portlet light bordered form-fit">
    <div class="portlet-body form">
        <form action="#" class="form-horizontal form-bordered ">
            <div class="form-group" style="display: flex;">
                <div class="col-xs-12 font-green-sharp" style="align-items: stretch;">
                    <span class="bold">{{ trans('form1.claimant_info') }}</span>
                </div>
            </div>
            <div class="form-body">
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4"
                         style="padding-top: 13px;">@if( $claim_case->claimant_address->is_company == 0)
                            @if($claim_case->claimant_address->nationality_country_id != 129 )
                                {{ __('form1.passport_no') }}
                            @else
                                {{ __('form1.ic_no') }}
                            @endif
                        @else
                            {{ __('form1.company_no') }}
                        @endif</div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                        <span id="view_claimant_identification_no">{{ $claim_case->claimant_address->identification_no }}</span>
                    </div>
                </div>
            

                @if( $claim_case->claimant_address->is_company == 0 && $claim_case->claimant_address->nationality_country_id != 129 )
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.nationality') }} </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claimant_nationality">{{ $claim_case->claimant_address->nationality->country }}</span>
                        </div>
                    </div>
                @endif
                <div class="form-group" style="display: flex;">
                    <div class="control-label col-xs-4"
                         style="padding-top: 13px;">{{ __('form1.name') }} </div>
                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                        <span id="view_claimant_name">{{ $claim_case->claimant_address->name }}</span>
                    </div>
                </div>

                <div id="show_claimant_info" onclick="toggleClaimantInfo()"
                     style="text-align: center; font-size: small; cursor: pointer; padding: 5px;"
                     class="bg-green-sharp font-white camelcase">{{ strtolower(trans('form1.full_info')) }}</div>

                <div id="claimant_info" style="display:none;">

                    <div class="form-group non-tourist" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.address_street') }}  </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_street1">{{ $claim_case->claimant_address->street_1 }}<br>{{ $claim_case->claimant_address->street_2 }}<br>{{ $claim_case->claimant_address->street_3 }}
                                    </span>
                        </div>
                    </div>
                    <div class="form-group non-tourist" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claimant_postcode">{{ $claim_case->claimant_address->postcode }}</span>
                        </div>
                    </div>
                    <div class="form-group non-tourist" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.district') }} </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claimant_district">{{ $claim_case->claimant_address->district ? $claim_case->claimant_address->district->district : '-' }}</span>
                        </div>
                    </div>
                    <div class="form-group non-tourist" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.state') }} </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claimant_state">{{ $claim_case->claimant_address->state ? $claim_case->claimant_address->state->state : '-' }}</span>
                        </div>
                    </div>
                    <!-- Mailing Address -->
                    @if($claim_case->claimant_address->address_mailing_street_1)
                        <div class="form-group non-tourist" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mailing_street') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_state">{{ $claim_case->claimant_address->address_mailing_street_1 }}<br>{{ $claim_case->claimant_address->address_mailing_street_2 }}<br>{{ $claim_case->claimant_address->address_mailing_street_3 }}</span>
                            </div>
                        </div>
                        <div class="form-group non-tourist" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mailing_postcode') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_state">{{ $claim_case->claimant_address->address_mailing_postcode }}</span>
                            </div>
                        </div>
                        <div class="form-group non-tourist" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mailing_district') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_state">{{ $claim_case->claimant_address->address_mailing_district_id ? $claim_case->claimant_address->districtmailing->district : '-' }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group non-tourist" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mailing_state') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_state">{{ $claim_case->claimant_address->address_mailing_state_id ? $claim_case->claimant_address->statemailing->state : '-' }}</span>
                            </div>
                        </div>
                    @endif
                    @if($claim_case->claimant_address->is_company == 0)
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4"
                                 style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_phone_home">{{ $claim_case->claimant_address->phone_home }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4"
                                 style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_phone_mobile">{{ $claim_case->claimant_address->phone_mobile}}</span>
                            </div>
                        </div>
                    @endif
                    <div class="form-group non-tourist" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claimant_phone_office">{{ $claim_case->claimant_address->phone_office }}</span>
                        </div>
                    </div>
                    <div class="form-group non-tourist" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claimant_phone_fax">{{ $claim_case->claimant_address->phone_fax }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.email') }} </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claimant_email">{{ $claim_case->claimant_address->email }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.race') }} </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claimant_race">{{ $claim_case->claimant->public_data->individual->race->$race ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4"
                             style="padding-top: 13px;">{{ __('form1.occupation') }} </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="view_claimant_occupation">{{ $claim_case->claimant->public_data->individual->occupation->$work ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>