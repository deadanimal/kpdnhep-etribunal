@if($claim_case->multiOpponents != null)
    @foreach($claim_case->multiOpponents as $i => $opponent)
        <div class="portlet light bordered form-fit">
            <div class="portlet-body form">
                <form action="#" class="form-horizontal form-bordered ">

                    <div class="form-group" style="display: flex;">
                        <div class="col-xs-12 font-green-sharp" style="align-items: stretch;">
                            <span class="bold">{{ trans('form1.opponent_info') }} {{$i+1}}</span>
                 @if($claim_case->form1_id && ($claim_case->claimant_user_id != Auth::id()) && (empty($opponent->form2) || ($is_staff ?? false)))
                                @if(($allow ?? false) && $claim_case->form1->form_status_id==17 && empty($opponent->form2) && !$claim_case->is_form2_lock)
                                    <a class="btn green-sharp" href="{{ route('form2-create', ['claim_case_id'=>$opponent->id]) }}" style='margin-bottom: 10px; margin-left: 5px;'>
                                        <i class="fa fa-add"></i>{{ trans('button.file_form2') }}
                                    </a>
                                @endif
                            @endif
                            @if($claim_case->form1_id && $claim_case->case_status_id > 3 && !empty($opponent->form2))
                                <a class="btn green-sharp"
                                   href="{{ route('form2-view', ['claim_case_id'=>$opponent->id]) }}"
                                   style='margin-bottom: 10px; margin-left: 5px;'>
                                    <i class="fa fa-search"></i>{{ trans('home_user.view_f2') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4"
                                 style="padding-top: 13px;">
                                @if($opponent->opponent_address->is_company == 0)
                                    @if($opponent->opponent_address->nationality_country_id != 129 )
                                        {{ __('form1.passport_no') }}
                                    @else
                                        {{ __('form1.ic_no') }}
                                    @endif
                                @else
                                    {{ __('form1.company_no') }}
                                @endif</div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_identification_no">{{ $opponent->opponent_address->identification_no }}</span>
                            </div>
                        </div>

                        @if( $opponent->opponent_address->is_company == 0 && $opponent->opponent_address->nationality_country_id != 129 )
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.nationality') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_nationality">{{ $opponent->opponent_address->nationality->country }}</span>
                                </div>
                            </div>
                        @endif

                        @if($opponent->opponent_address->is_company == 1)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('new.company_name') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_name">{{ $opponent->opponent_address->user->name }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.name') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_name">{{ $opponent->opponent_address->name }}</span>
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
                                    <span id="view_opponent_street1">{{ $opponent->opponent_address->street_1 }}
                                        <br>{{ $opponent->opponent_address->street_2 }}
                                        <br>{{ $opponent->opponent_address->street_3 }}
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_postcode">{{ $opponent->opponent_address->postcode }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_district">{{ $opponent->opponent_address->district ? $opponent->opponent_address->district->district : '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_state">{{ $opponent->opponent_address->state ? $opponent->opponent_address->state->state : '' }}</span>
                                </div>
                            </div>
                            @if($opponent->opponent_address->is_company == 0)
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4"
                                         style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        <span id="view_opponent_phone_home">{{ $opponent->opponent_address->phone_home }}</span>
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4"
                                         style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        <span id="view_opponent_phone_mobile">{{ $opponent->opponent_address->phone_mobile }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_office">{{ $opponent->opponent_address->phone_office }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_fax">{{ $opponent->opponent_address->phone_fax }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4"
                                     style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_email">{{ $opponent->opponent_address->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endif
