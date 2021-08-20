<div class="modal inmodal" id="opponentFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase">{{ __('form1.opponent_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form class="form-horizontal" id="opponent-form" role="form">
                        <div class="form-body">
                            <div id="row_opponent_identification_no" class="form-group form-md-line-input">
                                <label for="opponent_identification_no" id="label_opponent_identification_no"
                                       class="control-label col-md-4 col-xs-12">
                                    <select id="opponent_identity_type" name="opponent_identity_type"
                                            onchange="changeOpponentType()" class="bs-select form-control"
                                            data-width="60%">
                                        <option value="1">{{ __('form1.ic_no') }}</option>
                                        <option value="2">{{ __('form1.passport_no') }}</option>
                                        <option value="3">{{ __('form1.company_no') }}</option>
                                    </select>
                                    <span>:</span>
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-control">
                                            <input required onchange="checkOpponent()" type="text" class="form-control"
                                                   id="opponent_identification_no" name="opponent_identification_no"
                                                   @if(isset($case))
                                                   @if($case->opponent_user_id) value="{{ $case->opponent->username }}"
                                                   @endif
                                                   @elseif($inquiry)
                                                   @if($inquiry->opponent_user_extra_id) value="{{ $inquiry->opponent->identification_no }}"
                                                    @endif
                                                    @endif/>
                                            <span class="help-block"></span><br>
                                            <small id='opponent_myidentity_info'></small>
                                        </div>
                                        <span class="input-group-btn btn-right"
                                              @if(!$is_staff) style='display: table-column;' @endif >
                                        @if($is_staff)
                                                <a id='btn_opponent_myidentity' href="javascript:;"
                                                   onclick='checkMyIdentityOpponent()'
                                                   class="btn btn-primary btn-circle">
                                            <i class="fa fa-search"></i> {{ __('button.check') }} MyIdentity
                                        </a>
                                                <a id='btn_opponent_ecbis' href="javascript:;"
                                                   onclick='checkEcbisOpponent()' class="btn btn-primary btn-circle">
                                            <i class="fa fa-search"></i> {{ __('button.check') }} ECBIS (SSM)
                                        </a>
                                            @endif
                                    </span>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-6" style="margin-top: 18px">
                                    {!! __('form1.identitiy_note') !!}
                                </div>
                            </div>
                            <div id="row_opponent_nationality" class="form-group form-md-line-input">
                                <label for="opponent_nationality" id="label_opponent_nationality"
                                       class="control-label col-md-4">{{ __('form1.nationality') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <select required onchange="updateReview()" class="form-control select2 bs-select"
                                            id="opponent_nationality" name="opponent_nationality"
                                            data-placeholder="---">
                                        <option value="" disabled selected>---</option>
                                        @foreach ($countries as $country)
                                            <option
                                                    @if(isset($case))
                                                    @if($case->opponent_user_id)
                                                    @if($case->opponent->public_data->user_public_type_id==1)
                                                    @if($case->opponent->public_data->individual->nationality_country_id == $country->country_id) selected
                                                    @endif
                                                    @endif
                                                    @endif
                                                    @elseif($inquiry)
                                                    @if($inquiry->opponent_extra_user_id)
                                                    @if($inquiry->opponent->nationality_country_id == $country->country_id) selected
                                                    @endif
                                                    @endif
                                                    @endif
                                                    value="{{ $country->country_id }}">{{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_name" class="form-group form-md-line-input">
                                <label for="opponent_name" id="label_opponent_name"
                                       class="control-label col-md-4">{{ __('form1.name') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input required onchange="updateReview()" type="text" class="form-control"
                                           id="opponent_name" name="opponent_name"
                                           @if(isset($case))
                                           @if($case->opponent_user_id) value="{{ $case->opponent_address->name }}"
                                           @endif
                                           @elseif($inquiry)
                                           @if($inquiry->opponent) value="{{ $inquiry->opponent->name }}"
                                            @endif
                                            @endif
                                    />
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-body">
                            <div id="row_opponent_street1" class="form-group form-md-line-input">
                                <label for="opponent_street1" id="label_opponent_street1"
                                       class="control-label col-md-4">{{ __('form1.street') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input required onchange="updateReview()" type="text" class="form-control"
                                           id="opponent_street1" name="opponent_street1"
                                           value="@if(isset($case)) @if($case->opponent_address_id){{ $case->opponent_address->street_1 }}@endif @endif"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_street2" class="form-group form-md-line-input">
                                <label for="opponent_street2" id="label_opponent_street2"
                                       class="control-label col-md-4"><span class="required">&nbsp;&nbsp;</span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="text" class="form-control"
                                           id="opponent_street2"
                                           name="opponent_street2"
                                           value="@if(isset($case)) @if($case->opponent_address_id){{ $case->opponent_address->street_2 }}@endif @endif"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_street3" class="form-group form-md-line-input">
                                <label for="opponent_street3" id="label_opponent_street3"
                                       class="control-label col-md-4"><span class="required">&nbsp;&nbsp;</span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="text" class="form-control"
                                           id="opponent_street3"
                                           name="opponent_street3"
                                           value="@if(isset($case)) @if($case->opponent_address_id){{ $case->opponent_address->street_3 }}@endif @endif"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_postcode" class="form-group form-md-line-input">
                                <label for="opponent_postcode" id="label_opponent_postcode"
                                       class="control-label col-md-4">{{ __('form1.postcode') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input required onchange="updateReview()" maxlength="5" type="text"
                                           class="form-control numeric" id="opponent_postcode" name="opponent_postcode"
                                           @if(isset($case)) @if($case->opponent_address_id)value="{{ $case->opponent_address->postcode }}"
                                            @endif @endif/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_state" class="form-group form-md-line-input">
                                <label for="opponent_state" id="label_opponent_state"
                                       class="control-label col-md-4">{{ __('form1.state') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <select required onchange="loadDistricts('opponent_state','opponent_district')"
                                            class="form-control select2 bs-select" id="opponent_state"
                                            name="opponent_state"
                                            data-placeholder="---">
                                        <option value="" disabled selected>---</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->state_id }}">{{ $state->state }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_district" class="form-group form-md-line-input">
                                <label for="opponent_district" id="label_opponent_district"
                                       class="control-label col-md-4">{{ __('form1.district') }} :
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-control">
                                            <select required onchange="updateReview()"
                                                    class="form-control select2 bs-select" id="opponent_district"
                                                    name="opponent_district" data-placeholder="---">
                                                <option value="" disabled selected>---</option>
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

                            <div id="row_opponent_phone_home" class="form-group form-md-line-input"
                                 id="row_opponent_phone_home">
                                <label for="opponent_phone_home" id="label_opponent_phone_home"
                                       class="control-label col-md-4">{{ __('form1.home_phone') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="tel" class="form-control numeric"
                                           id="opponent_phone_home" name="opponent_phone_home"
                                           @if(isset($case)) @if($case->opponent_user_id) @if($case->opponent->public_data->user_public_type_id == 1)value="{{ $case->opponent->public_data->individual->phone_home }}"
                                            @endif @endif @endif/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_phone_mobile" class="form-group form-md-line-input"
                                 id="row_opponent_phone_mobile">
                                <label for="opponent_phone_mobile" id="label_opponent_phone_mobile"
                                       class="control-label col-md-4">{{ __('form1.mobile_phone') }} :
                                    <span id="required_opponent_phone_mobile" class="required">&nbsp;&nbsp;</span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="tel" class="form-control numeric"
                                           id="opponent_phone_mobile" name="opponent_phone_mobile"
                                           @if(isset($case)) @if($case->opponent_user_id) @if($case->opponent->public_data->user_public_type_id == 1)value="{{ $case->opponent->public_data->individual->phone_mobile }}"
                                            @endif @endif @endif/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_phone_ofice" class="form-group form-md-line-input"
                                 id="row_opponent_phone_office">
                                <label for="opponent_phone_office" id="label_opponent_phone_office"
                                       class="control-label col-md-4">{{ __('form1.office_phone') }} :
                                    <span id="required_opponent_phone_office" class="required">&nbsp;&nbsp;</span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="tel" class="form-control numeric"
                                           id="opponent_phone_office" name="opponent_phone_office"
                                           @if(isset($case)) @if($case->opponent_user_id)value="{{ $case->opponent->phone_office }}"
                                            @endif @endif/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_phone_fax" class="form-group form-md-line-input"
                                 id="row_opponent_phone_fax">
                                <label for="opponent_phone_fax" id="label_opponent_phone_fax"
                                       class="control-label col-md-4">{{ __('form1.fax_no') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <input onchange="updateReview()" type="tel" class="form-control numeric"
                                           id="opponent_phone_fax" name="opponent_phone_fax"
                                           @if(isset($case)) @if($case->opponent_user_id)value="{{ $case->opponent->phone_fax }}"
                                            @endif @endif/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div id="row_opponent_email" class="form-group form-md-line-input">
                                <label for="opponent_email" id="label_opponent_email"
                                       class="control-label col-md-4">{{ __('form1.email') }} :
                                    <span class="required"> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-6">
                                    <input required onchange="updateReview()" type="email" class="form-control"
                                           id="opponent_email" name="opponent_email"
                                           @if(isset($case)) @if($case->opponent_user_id)value="{{ $case->opponent->email }}"
                                            @endif @endif/>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="submitOpponent()">Hantar
                </button>
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>