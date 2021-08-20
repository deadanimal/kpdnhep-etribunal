@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<style>

    .control-label-custom  {
        padding-top: 15px !important;
    }

</style>
@endsection

@section('heading', 'Roles')


@section('content')

<div class="m-heading-1 border-green m-bordered margin-top-10">
    <h3> Detail of Form 4 </h3>
    <span> View Form 4 Details </span>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">  B4-2121-2017 | <small style="font-weight: normal;">27 November 2017</small></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                        <a href="#tab_counterclaim" data-toggle="tab" aria-expanded="true"> Hearing Notice </a>
                        </li>
                    </ul>
                    <div class="tab-content" style="padding-top: 0px;">
                        <div class="tab-pane active" id="tab_counterclaim" style="margin-top: 30px;">
                            <div class="portlet light bordered form-fit">
                                <div class="portlet-body form">
                                    <form action="#" class="form-horizontal form-bordered ">
                                        <div class="form-body">
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;"> Hearing Date </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_is_online_transaction">
                                                        
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;"> Hearing Time </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_purchased_item"></span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;"> Branch </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_purchased_item"></span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-4" style="padding-top: 13px;"> Hearing Address </div>
                                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                    <span id="view_purchased_item"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="portlet light bordered form-fit">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ trans('form2.claimant_info') }}</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form action="#" class="form-horizontal form-bordered ">
                    <div class="form-body">
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.ic_no') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_identification_no"></span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.name') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_claimant_name"></span>
                            </div>
                        </div>

                        <div id="show_claimant_info" onclick="toggleClaimantInfo()" style="text-align: center; font-size: small; cursor: pointer; padding: 5px;" class="bg-green-sharp font-white">{{ trans('form2.full_info')}}</div>

                        <div id="claimant_info" style="display:none;">

                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.address_street') }} 1 </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_street1"></span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form2.address_street') }} 2 </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_street2"></span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }} 3 </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_street3"></span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_postcode"></span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_district"></span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_state"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_home"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_mobile"></span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_office"></span>
                                </div>
                            </div>
                            <div class="form-group non-tourist" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_phone_fax"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_claimant_email"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="portlet light bordered form-fit">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ __('form1.opponent_info') }}</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form action="#" class="form-horizontal form-bordered ">
                    <div class="form-body">
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.ic_no') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_identification_no"></span>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.name') }} </div>
                            <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                <span id="view_opponent_name"></span>
                            </div>
                        </div>

                        <div id="show_opponent_info" onclick="toggleOpponentInfo()" style="text-align: center; font-size: small; cursor: pointer; padding: 5px;" class="bg-green-sharp font-white"> {{ __('form2.full_info') }} </div>

                        <div id="opponent_info" style="display:none;">

                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }} 1 </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_street1"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }} 2 </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_street2"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.address_street') }} 3 </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_street3"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.postcode') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_postcode"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.district') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_district"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.state') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_state"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.home_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_home"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.mobile_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_mobile"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.office_phone') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_office"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.fax_no') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_phone_fax"></span>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="control-label col-xs-4" style="padding-top: 13px;">{{ __('form1.email') }} </div>
                                <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                    <span id="view_opponent_email"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    
     $("#opponent_info").slideUp(0)
        $("#claimant_info").slideUp(0)

        function toggleOpponentInfo(){
            $("#opponent_info").slideToggle();
        }

        function toggleClaimantInfo(){
            $("#claimant_info").slideToggle();
        }

</script>

@endsection