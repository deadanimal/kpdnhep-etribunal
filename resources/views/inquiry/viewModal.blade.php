<?php
$locale = App::getLocale();
$method_lang = "method_" . $locale;
$type_lang = "type_" . $locale;
$category_lang = "category_" . $locale;
$classification_lang = "classification_" . $locale;
$feedback_lang = "feedback_" . $locale;
?>

<style>
    .modal-body {
        padding: 0px;
    }

    .control-label-custom {
        padding-top: 15px !important;
    }

    /*#map {
    	width: 100%;
    	height: 400px;
    	background-color: grey;
    }*/

    .btn-outline {
        margin: 10px;
    }

    .btn-sidepadding .btn-outline {
        margin-left: 0px;
    }
</style>
<div class="modal-body">
    <div class="portlet light bordered form-fit">
        <div class="portlet-body form">
            <form action="#" class="form-horizontal form-bordered ">
                <div class="form-body">
                    <div class="form-group text-right btn-sidepadding">
                        @if(($is_staff) && $is_process != 1 && $inquiry->inquiry_form_status_id < 11)
                            <a id="btn_next" class="btn btn-outline blue button-next"
                               href="{{route('inquiry.process',[$inquiry->inquiry_id])  }}">
                                {{ trans('button.process')}}
                                <i class="fa fa-angle-right"></i>
                            </a>
                        @endif
                        @if(($inquiry->form1_id) && $inquiry->inquiry_feedback_id == 1 && !$claimed && ($inquiry->inquired_by->public_data->individual ?? false))
                            <a id="btn_next" class="btn btn-outline green button-next"
                               href="{{route('inquiry.createform1',[$inquiry->inquiry_id])  }}">
                                {{ trans('inquiry.create_inquiry')}} 1
                                <i class="fa fa-angle-right"></i>
                            </a>
                        @endif
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4 control-label-custom"
                             style="border-left: none;">{{ trans('inquiry.inquiry_method')}} :
                        </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="">{{ $inquiry->method->$method_lang or ''}}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4 control-label-custom"
                             style="border-left: none;">{{ trans('inquiry.inquiry_date')}} :
                        </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="">{{ date('d/m/Y h:i A', strtotime($inquiry->created_at)) }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4 control-label-custom"
                             style="border-left: none;">{{ trans('inquiry.inquiry_type')}} :
                        </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="">{{ $inquiry->type->$type_lang or '' }}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="col-md-12" style="align-items: stretch;">
                            <span class="bold"
                                  style="align-items: stretch;">{{ trans('inquiry.inquiry_parties')}}</span>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">
                            @if($inquiry->inquired_by->public_data->user_public_type_id == 2)
                                {{ trans('inquiry.company_no')}} :
                            @elseif($inquiry->inquired_by->public_data->individual->nationality_country_id == 129)
                                {{ trans('inquiry.ic_no')}} :
                            @else
                                {{ trans('inquiry.passport_no')}} :
                            @endif
                        </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="">{{ $inquiry->inquired_by->username or '' }}</span>
                        </div>
                    </div>
                    @if($inquiry->inquired_by->user_public_type_id == 1)
                        @if($inquiry->inquired_by->public_data->individual->nationality_country_id != 129)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom"
                                     style="border-left: none;">{{ trans('inquiry.nationality')}} :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="">{{ $inquiry->inquired_by->public_data->individual->nationality->country or '' }}</span>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="form-group" style="display: flex;">
                        <div class="control-label col-xs-4 control-label-custom"
                             style="border-left: none;">{{ trans('inquiry.name')}} :
                        </div>
                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                            <span id="">{{ $inquiry->inquired_by->name or '' }}</span>
                        </div>
                    </div>


                    @if($inquiry->inquired_by->user_public_type_id == 1)
                        <div class="form-group" style="display: flex;">
                            <div class="col-md-12" style="align-items: stretch;">
                                <span class="bold"
                                      style="align-items: stretch;">{{ trans('inquiry.contact_info')}}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.address')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
							<span id="">{{ $inquiry->inquired_by->public_data->address_mailing_street_1 or '' }} <br>{{ $inquiry->inquired_by->public_data->address_mailing_street_2 or '' }} <br>{{ $inquiry->inquired_by->public_data->address_mailing_street_3 or '' }}
							</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.postcode')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $inquiry->inquired_by->public_data->address_postcode or '' }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.district')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">@if($inquiry->inquired_by->public_data->address_district_id){{ $inquiry->inquired_by->public_data->district->district }}@endif</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.state')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">@if($inquiry->inquired_by->public_data->address_state_id){{ $inquiry->inquired_by->public_data->state->state }}@endif</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.home_phone')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $inquiry->inquired_by->public_data->individual->phone_home or '' }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.mobile_phone')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $inquiry->inquired_by->public_data->individual->phone_mobile or '' }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.office_phone')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $inquiry->inquired_by->phone_office or '' }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.fax')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $inquiry->inquired_by->phone_fax or '' }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.email')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $inquiry->inquired_by->email or '' }}</span>
                            </div>
                        </div>
                    @endif



                    @if($inquiry->inquiry_msg)
                        <div class="form-group" style="display: flex;">
                            <div class="col-md-12" style="align-items: stretch;">
                                <span class="bold"
                                      style="align-items: stretch;">{{ trans('inquiry.inquiry_info')}}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom"
                                 style="border-left: none;">{{ trans('inquiry.inquiry_msg')}} :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="">{{ $inquiry->inquiry_msg or '' }}</span>
                            </div>
                        </div>


                    @else
                        @if($inquiry->opponent_user_extra_id)
                            <div class="form-group" style="display: flex;">
                                <div class="col-md-12" style="align-items: stretch;">
                                    <span class="bold"
                                          style="align-items: stretch;">{{ trans('inquiry.opponent_info')}}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom" style="border-left: none;">
                                    @if($inquiry->opponent->nationality_country_id == 129)
                                        {{ trans('inquiry.ic_no')}} :
                                    @else
                                        {{ trans('inquiry.passport_no')}} :
                                    @endif
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="">{{ $inquiry->opponent ? $inquiry->opponent->identification_no : '' }}</span>
                                </div>
                            </div>
                            @if($inquiry->opponent->nationality_country_id != 129)
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4 control-label-custom"
                                         style="border-left: none;">{{ trans('inquiry.nationality')}} :
                                    </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        <span id="">{{ $inquiry->opponent ? $inquiry->opponent->nationality->country : '' }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom"
                                     style="border-left: none;">{{ trans('inquiry.name')}} :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="">{{ $inquiry->opponent ? $inquiry->opponent->name : ''}}</span>
                                </div>
                            </div>
                        @endif


                        @if($inquiry->form1_id)
                            <div class="form-group" style="display: flex;">
                                <div class="col-md-12">
                                    <span class="bold"
                                          style="align-items: stretch;">{{ __('form1.transaction_info') }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('form1.online_purchased') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
									<span id="view_is_online_transaction">
									@if($inquiry->form1->is_online_purchased == 1)
                                            {{ trans('inquiry.yes')}}
                                        @else
                                            {{ trans('inquiry.no')}}
                                        @endif
									</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('form1.transaction_date') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_purchased_date">{{ $inquiry->form1->purchased_date or '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('form1.purchased_used') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_purchased_item">{{ $inquiry->form1->purchased_item_name or '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('form1.brand_model') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_purchased_brand">{{ $inquiry->form1->purchased_item_brand or '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('form1.amount_paid') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_purchased_amount">{{ $inquiry->form1->purchased_amount ? number_format($inquiry->form1->purchased_amount, 2, '.', ',') : "-" }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('inquiry.phone_no') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_phone_no">{{ $inquiry->phone_no or '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('inquiry.transaction_address') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_transaction_address">{{ $inquiry->transaction_address or '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('inquiry.transaction_postcode') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_transaction_postcode">{{ $inquiry->transaction_postcode or '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('inquiry.transaction_state') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_transaction_state">{{ $inquiry->state->state_name or '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('inquiry.transaction_district') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_transaction_district">{{ $inquiry->district->district or '' }}</span>
                                </div>
                            </div>





                            <div class="form-group" style="display: flex;">
                                <div class="col-md-12">
                                    <span class="bold" style="align-items: stretch;">{{ __('form1.claim_info') }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('form1.particular_claim') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claim_details">{{ $inquiry->form1->claim_details or '' }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('form1.amount_claim') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claim_amount">{{ $inquiry->form1->claim_amount ? number_format($inquiry->form1->claim_amount, 2, '.', ',') : "-" }}</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ __('form1.prev_court') }}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
									<span id="view_is_filed_on_court">
									@if( $inquiry->form1->court_case_id )
                                            {{ trans('inquiry.yes')}}
                                        @else
                                            {{ trans('inquiry.no')}}
                                        @endif
									</span>
                                </div>
                            </div>




                            @if($inquiry->form1_id OR false)
                                @if($inquiry->form1->court_case_id OR false)
                                    <div class="form-group is_filed" style="display: flex;">
                                        <div class="col-md-12">
                                            <span class="bold"
                                                  style="align-items: stretch;">{{ __('form1.court_info') }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group is_filed" style="display: flex;">
                                        <div class="control-label col-md-4">{{ __('form1.court_name') }} :</div>
                                        <div class="col-md-8 font-green-sharp" style="align-items: stretch;">
                                            <span id="view_case_name">{{ $inquiry->form1->court_case->court_case_name }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group is_filed" style="display: flex;">
                                        <div class="control-label col-md-4">{{ __('form1.status_case') }} :</div>
                                        <div class="col-md-8 font-green-sharp" style="align-items: stretch;">
                                            <span id="view_case_status">{{ $inquiry->form1->court_case->court_case_status }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group is_filed" style="display: flex;">
                                        <div class="control-label col-md-4">{{ __('form1.place_case') }} :</div>
                                        <div class="col-md-8 font-green-sharp" style="align-items: stretch;">
                                            <span id="view_case_place">{{ $inquiry->form1->court_case->court_case_location }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group is_filed" style="display: flex;">
                                        <div class="control-label col-md-4">{{ __('form1.filing_date') }} :</div>
                                        <div class="col-md-8 font-green-sharp" style="align-items: stretch;">
                                            <span id="view_case_created_at">@if($inquiry->form1->court_case->filing_date){{ date('d/m/Y', strtotime($inquiry->form1->court_case->filing_date)) }}@endif</span>
                                        </div>
                                    </div>
                                @endif
                            @endif




                            @if($attachments)
                                @if($attachments->count() > 0)
                                    <div class="form-group" style="display: flex;">
                                        <div class="col-md-12">
                                            <span class="bold"
                                                  style="align-items: stretch;">{{ trans('form1.attachment_list')}}</span>
                                        </div>
                                    </div>
                                    @foreach($attachments as $att)
                                        <div class="form-group" style="display: flex;">
                                            <div class="control-label col-xs-4" style="padding-top: 13px;">
                                                <a target="_blank"
                                                   href='{{ route("general-getattachment", ["attachment_id" => $att->attachment_id, "filename" => $att->attachment_name]) }}'
                                                   class='btn dark btn-outline'>{{ trans('button.download')}}</a>
                                            </div>
                                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                <span id="view_claim_details">{{ $att->attachment_name }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif

                        @endif

                    @endif


                    @if($inquiry->inquiry_form_status_id != 9)
                        <div class="form-group" style="display: flex;">
                            <div class="col-md-12">
                                <span class="bold"
                                      style="align-items: stretch;">{{ trans('inquiry.inquiry_process')}}</span>
                            </div>
                        </div>

                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom">{{ __('inquiry.processed_by') }}
                                :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_category">{{ $inquiry->processed_by->name ?? '' }} ({{ $inquiry->processed_by ? $inquiry->processed_by->ttpm_data->branch->branch_name : '' }})</span>
                            </div>
                        </div>

                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom">{{ __('inquiry.processed_at') }}
                                :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_category">{{ $updated_at or "" }}</span>
                            </div>
                        </div>


                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom">{{ __('form1.category_claim') }}
                                :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_category">{{ $inquiry->form1->classification->category->$category_lang or "" }}</span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom">{{ __('form1.classification_claim') }}
                                :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claim_classification">{{ $inquiry->form1->classification->$classification_lang or "" }}</span>
                            </div>
                        </div>

                        @if($inquiry->inquiry_feedback_id)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ trans('inquiry.feedback')}}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_feedback">{{ $inquiry->feedback->$feedback_lang or '' }}</span>
                                </div>
                            </div>
                        @endif

                        @if(!$inquiry->inquiry_feedback_id == 2)
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4 control-label-custom">{{ trans('inquiry.reason')}}
                                    :
                                </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
								<span id="view_reason">
								@if($inquiry->jurisdiction_organization_id == 1)
                                        {{ trans('inquiry.outside_jurisdiction')}}
                                    @else
                                        {{ trans('inquiry.any_other')}}
                                    @endif
								</span>
                                </div>
                            </div>

                            @if(!$inquiry->jurisdiction_organization_id)
                                <div class="form-group" style="display: flex;">
                                    <div class="control-label col-xs-4 control-label-custom">{{ trans('inquiry.org_jurisdiction')}}
                                        :
                                    </div>
                                    <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                        <span id="view_organization">{{ $inquiry->organization->organization or '' }}</span>
                                    </div>
                                </div>
                            @endif
                        @endif




                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4 control-label-custom">{{ trans('inquiry.feedback_msg')}}
                                :
                            </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_feedback_msg">{!! nl2br($inquiry->inquiry_feedback_msg ?? '') !!}</span>
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
    @if($inquiry->inquiry_form_status_id == 9)
        <a type="button" class="btn green-meadow" href="{{ route('inquiry.edit', ['id' => $inquiry->inquiry_id]) }}"><i
                    class="fa fa-edit"></i> {{ trans('button.edit')}}</a>
    @endif
    <a type="button" class="btn dark" href="{{ route('inquiry.print', ['inquiry_id' => $inquiry->inquiry_id]) }}"><i
                class="fa fa-download"></i> {{ trans('button.download')}}</a>
</div>
<!-- <script>
	function initMap() {
		var myLocation = {lat: -25.363, lng: 131.044};
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 5,
			center: myLocation
		});
		var marker = new google.maps.Marker({
			position: myLocation,
			map: map
		});
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqxUL2IsDDjAcTMOLysEuUTDwlgKspkXI&callback=initMap"></script> -->