<div class="row">
    <div class="col-md-12" style="padding: 10px 30px;">
        <div class="portlet light bordered form-fit">
            <div class="portlet-body form">
                <form action="#" class="form-horizontal form-bordered ">
                    <div class="form-group" style="display: flex;">
                        <div class="col-xs-12 font-green-sharp" style="align-items: stretch;">
                            <span class="bold">{{ trans('form1.opponent_info') }} {{$i+1}}</span>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 osd_idtype"
                                 style="padding-top: 13px;">
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_identification_no" class="osd_id">
                                  
                                </span>
                            </div>
                        </div>

                            <div class="form-group osd_countryNonCitizenDiv" style="display: none;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.nationality') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_nationality" class="osd_countryNonCitizen"></span>
                                </div>
                            </div>

   
                            <div class="form-group osd_isCompany" style="display: none;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('new.company_name') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_name" class="osd_isCompanyOpponentName"></span>
                                </div>
                            </div>

                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.name') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_name" class="osd_opponentName"></span>
                            </div>
                        </div>

                        <div id="show_opponent_info" onclick="toggleOpponentInfo({{$i}})"
                             style="text-align: center; font-size: small; cursor: pointer; padding: 5px;"
                             class="bg-green-sharp font-white camelcase">{{ strtolower(__('form1.full_info')) }}</div>

                        <div id="opponent_info_{{$i}}" style="display:none;">

                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.address_street') }}</div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_street1" class="osd_opponentAddress">
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_postcode" class="osd_opponentPostcode"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_district" class="osd_opponentDistrict"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_state" class="osd_opponentState"></span>
                                </div>
                            </div>
                                <div class="form-group osd_isCompanyHomePhoneDiv" style="display: none;">
                                    <div class="control-label col-xs-4"
                                         style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        <span id="view_opponent_phone_home" class="osd_isCompanyHomePhone"></span>
                                    </div>
                                </div>
                                <div class="form-group osd_isCompanyMobilePhoneDiv" style="display: none;">
                                    <div class="control-label col-xs-4"
                                         style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        <span id="view_opponent_phone_mobile" class="osd_isCompanyMobilePhone"></span>
                                    </div>
                                </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_office" class="osd_officePhone"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_fax" class="osd_fax"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_email" class="osd_email"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
