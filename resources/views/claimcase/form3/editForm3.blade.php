@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<!--Button-->
<link href="{{ URL::to('/assets/global/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css"><!--end button -->
<!--Plugin dropdown -->  
<style>
    #step_4 .control-label, .control-label-custom  {
        padding-top: 15px !important;
    }

    .clickme {
        cursor: pointer !important;
    }

    #step_header {
        display: flex;
        flex-wrap: wrap;
    }

    .step_header_item {
        position: relative;
        flex: auto;
        min-width: 130px;
    }

</style>
@endsection

@section('content')
<!-- START CONTENT BODY -->

<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"> {{ trans('form3.form3_registration') }}
    <small></small>
</h1>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->


<div class="mt-content-body" id="form_wizard_1">
    <div class="row">
        <div class="portlet-body form">
            <form action="{{route('form3.store',$id)}}" class="form-horizontal" enctype="multipart/form-data" id="submit_form" method="post" name="submit_form" role="form">
            {{ csrf_field() }}
                <div class="form-wizard">
                    <div class="form-body">
                    <div class="mt-element-step" style="background:#f5f5f5">
                        <div class="row step-background-thin">
                            <ul class="nav nav-pills nav-justified">
                                <li id="nav1">
                                    <a href="#tab1" data-toggle="tab" class="step" style="background: transparent;">
                                    <div class="col-md-12 mt-step-col">
                                            <div class="mt-step-number">1</div>
                                            <div class="mt-step-title uppercase font-grey-cascade">{{ trans('form3.step') }}</div>
                                            <div class="mt-step-content font-grey-cascade">{{ trans('form3.view_form2') }}</div>
                                    </div>
                                    </a>
                                </li>
                                <li id="nav2">
                                    <a href="#tab2" data-toggle="tab" class="step" style="background: transparent;">
                                    <div class="col-md-12 mt-step-col">
                                            <div class="mt-step-number">2</div>
                                            <div class="mt-step-title uppercase font-grey-cascade">{{ trans('form3.step') }}</div>
                                            <div class="mt-step-content font-grey-cascade">{{ trans('form3.defence_counterclaim') }}</div>
                                    </div>
                                    </a>
                                </li>
                                <li id="nav3">
                                    <a href="#tab3" data-toggle="tab" class="step" style="background: transparent;">
                                    <div class="col-md-12 mt-step-col">
                                            <div class="mt-step-number">3</div>
                                            <div class="mt-step-title uppercase font-grey-cascade">{{ trans('form3.step') }}</div>
                                            <div class="mt-step-content font-grey-cascade">{{ trans('form3.verification') }}</div>
                                    </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <br>
                        <div class="tab-content">
                            <div class="alert alert-danger display-none">
                                <button class="close" data-dismiss="alert"></button> Sila isi ruangan yang bertanda merah!
                            </div>
                            <div class="alert alert-success display-none">
                                <button class="close" data-dismiss="alert"></button> Pengesahan permohonan telah berjaya!
                            </div>

                            <!--  maklumat syarikat -->
                            <div class="tab-pane active" id="tab1">
                                <!-- Claimant -->
                                <div class="col-md-12">
                                    <div class="portlet light">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-layers font-green-sharp"></i>
                                                <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.claimant_info') }} </span>
                                                <span class="caption-helper"></span>
                                            </div>
                                            <div class="tools">
                                                <a href="" class="collapse"></a>
                                                <a href="" class="fullscreen"></a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-horizontal">
                                                <div class="form-body">
                                                    @if($claim->claimant->public_data->user_public_type_id == 1)
                                                    <div class="form-group form-md-line-input">
                                                        <label for="claimant_identification_no" style="padding-top: 0px" class="control-label col-xs-4"><span id="">Identity Card No. / Passport No. / Company No. :</span>

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->claimant->public_data->individual->identification_no  or ''}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input">
                                                        <label for="claimant_name" style="padding-top: 0px" class="control-label col-xs-4">{{ trans('form3.claimant_name') }} :

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->claimant->name  or ''}}
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($claim->claimant->public_data->user_public_type_id == 2)
                                                    <div class="form-group form-md-line-input">
                                                        <label for="opponent_identification_no" style="padding-top: 0px" class="control-label col-xs-4"><span id="">Company No. :</span>

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->claimant->public_data->company->company_no  or ''}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input">
                                                        <label for="opponent_name" style="padding-top: 0px" class="control-label col-xs-4">{{ trans('form3.opponent_name') }} :

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->opponent->name  or ''}}
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Opponent -->
                                <div class="col-md-12 ">
                                    
                                    <div class="portlet light">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-layers font-green-sharp"></i>
                                                <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.respondent') }} </span>
                                                <span class="caption-helper"></span>
                                            </div>
                                            <div class="tools">
                                                <a href="" class="collapse"></a>
                                                <a href="" class="fullscreen"></a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-horizontal">
                                                <div class="form-body">
                                                    @if($claim->opponent->public_data->user_public_type_id == 1)

                                                    <div class="form-group form-md-line-input">
                                                        <label for="claimant_identification_no" style="padding-top: 0px" class="control-label col-xs-4"><span id="">Identity Card No. / Passport No. / Company No. :</span>

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->opponent->public_data->individual->identification_no  or ''}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input">
                                                        <label for="claimant_name" style="padding-top: 0px" class="control-label col-xs-4">{{ trans('form3.opponent_name')  }} :

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->opponent->name  or ''}}
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($claim->opponent->public_data->user_public_type_id == 2)
                                                    <div class="form-group form-md-line-input">
                                                        <label for="opponent_identification_no" style="padding-top: 0px" class="control-label col-xs-4"><span id="">Company No. :</span>

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->opponent->public_data->company->company_no  or ''}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input">
                                                        <label for="opponent_name" style="padding-top: 0px" class="control-label col-xs-4">{{ trans('form3.opponent_name') }} :

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->opponent->name  or ''}}
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Claim Details-->
                                <div class="col-md-12 ">

                                    <div class="portlet light">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-layers font-green-sharp"></i>
                                                <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.claim_info') }} </span>
                                                <span class="caption-helper"></span>
                                            </div>
                                            <div class="tools">
                                                <a href="" class="collapse"></a>
                                                <a href="" class="fullscreen"></a>
                                            </div>
                                        </div>

                                        <div class="portlet-body form">
                                            <div class="form-horizontal">
                                                <div class="form-body">
                                                    <div class="form-group form-md-line-input">
                                                        <label for="detail_claim" style="padding-top: 0px" class="control-label col-xs-4">{{ trans('form3.particular_claim') }} :

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->form1->claim_details  or ''}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input">
                                                        <label for="amount_claim" style="padding-top: 0px" class="control-label col-xs-4">{{ trans('form3.amount_claim') }} :

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->form1->claim_amount  or ''}}
                                                       </div>
                                                   </div>
                                                    <div class="form-group form-md-line-input" >
                                                        <label for="claim_attachment" style="padding-top: 0px" class="control-label col-xs-4">{{ trans('form3.supporting_docs') }} :

                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->form1->claim_details  or ''}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Defense and counterclaim Details-->
                                <div class="col-md-12 ">

                                    <div class="portlet light">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-layers font-green-sharp"></i>
                                                <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.defence_counterclaim_info') }} </span>
                                                <span class="caption-helper"></span>
                                            </div>
                                            <div class="tools">
                                                <a href="" class="collapse"></a>
                                                <a href="" class="fullscreen"></a>
                                            </div>
                                        </div>

                                        <div class="portlet-body form">
                                            <div class="form-horizontal">
                                                <div class="form-body">
                                                    <div class="form-group form-md-line-input">
                                                        <label for="purchased_item" class="control-label col-xs-4"> {{ trans('form3.statement_defence') }} :
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->form1->form2->counterclaim->defence_statement  or ''}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input">
                                                        <label for="purchased_item" class="control-label col-xs-4"> {{ trans('form3.statement_counterclaim') }} :
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->form1->form2->counterclaim->counterclaim_statement  or ''}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input">
                                                    <label for="amont_counterclaim" class="control-label col-md-4">{{ trans('form3.total_counterclaim') }} :
                                                            <span id="amont_counterclaim" class="required">&nbsp;&nbsp; </span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->form1->form2->counterclaim->counterclaim_amount  or ''}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input"">
                                                        <label class="col-md-4 control-label">{{ trans('form3.supporting_docs') }} :
                                                            <span>&nbsp;&nbsp;</span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            {{$claim->form1->form2->counterclaim->defence_statement  or ''}}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end maklumat syarikat -->
                            <!--  wakil syarikat -->
                            <div class="tab-pane" id="tab2">
                                
                                <div class="col-md-12 ">
                                    <!-- Defense and counterclaim Details-->

                                    <div class="portlet light">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-layers font-green-sharp"></i>
                                                <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.defence_towards_counterclaim') }}</span>
                                                <span class="caption-helper"></span>
                                            </div>
                                            <div class="tools">
                                                <a href="" class="collapse"></a>
                                                <a href="" class="fullscreen"></a>
                                            </div>
                                        </div>

                                        <div class="portlet-body">
                                            <div class="form-horizontal">
                                                <div class="form-body">
                                                    <div class="form-group form-md-line-input">
                                                        <label for="defence_counterclaim_statement" class="control-label col-xs-4"> {{ trans('form3.defence_towards_counterclaim') }} :
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <textarea id="defence_counterclaim_statement" name="defence_counterclaim_statement" class="form-control" maxlength="225" rows="2" placeholder="" required="required">{{$claim->form1->form2->form3->defence_counterclaim_statement  or ''}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input"">
                                                        <label class="col-md-4 control-label">{{ trans('form3.supporting_docs') }} :
                                                            <span>&nbsp;&nbsp;</span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <center>
                                                                <div name="data" class="dropzone drdr" id="mydropzone"  action="{{route('form3.form3docs',$form3_id)}}" enctype="multipart/form-data" style="width: 500px; margin-top: 10px; background:url('')}});background-position-x: center;background-position-y: 40px;  background-size: 70px 70px; background-repeat: no-repeat; border-radius: 5%; height: auto; width:100%;">
                                                                    {{ csrf_field() }}
                                                                    <div class="fallback">
                                                                        <input id="file" name="file" type="file" multiple />
                                                                        </div>
                                                                    <!-- <input type="hidden" name="temp_id" id="temp_id"> -->
                                                                    <h3 class="sbold hideit addedhide">
                                                                        <font color="black">{{trans('dropzone.drop_file')}}</font>
                                                                    </h3>
                                                                    <br class="addedhide"><br class="addedhide"><br class="addedhide"><br class="addedhide">
                                                                    <p class="hideit ">
                                                                        <font color="black">
                                                                            {{trans('dropzone.maximum_upload')}}<br/>
                                                                            {{trans('dropzone.maximum_size_is')}} 2MB <br><br>
                                                                            {{trans('dropzone.file_format')}} : <span class="font-green-sharp">txt, doc, docx, xls, xlsx, pdf, jpg, jpeg, gif, png</span>
                                                                        </font>
                                                                    </p>
                                                                    <div class="dz-default dz-message"><span style="font-style: italic; color: grey;">{{trans('dropzone.drop_file2')}}</span></div>
                                                                </div>
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--  end wakil syarikat -->
                            <!--  dokumen -->
                            <div class="tab-pane" id="tab3">
                                
                                <div class="col-md-12 ">
                                    <div class="portlet light form-fit bordered">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption">
                                                <i class="icon-layers font-green-sharp"></i>
                                                <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('form3.review_info') }} </span>
                                                <span class="caption-helper"></span>
                                            </div>
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#portlet_tab1" data-toggle="tab"> {{ trans('form3.claimant') }} </a>
                                                </li>
                                                <li>
                                                    <a href="#portlet_tab2" data-toggle="tab"> {{ trans('form3.opponent') }} </a>
                                                </li>
                                                <li>
                                                    <a href="#portlet_tab3" data-toggle="tab"> {{ trans('form3.defence_towards_counterclaim') }} </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="portlet_tab1">
                                                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                                                        <div class="scroller" style="overflow: hidden; width: auto;" data-initialized="1">
                                                                <div class="form-body form-horizontal form-bordered ">
                                                                    
                                                            <div action="#" class="form-horizontal form-bordered ">
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="col-md-12">
                                                                            <span class="bold" style="align-items: stretch;">{{ trans('form3.claimant_info') }}</span>
                                                                        </div>
                                                                    </div>

                                                                    @if($claim->claimant->public_data->user_public_type_id == 1)
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">Identity Card No. / Passport No. / Company No. :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->individual->identification_no  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">Nationality :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.claimant_name') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->name  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @if($claim->claimant->public_data->user_public_type_id == 2)
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">Company No. :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->public_data->company->company_no  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">Nationality :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.claimant_name') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->name  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    @endif

                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="col-md-12">
                                                                            <span class="bold" style="align-items: stretch;">{{ trans('form3.claimant_contact_info') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group non-tourist" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.address_street') }} 1 :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->address_street_1  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group non-tourist" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.address_street') }} 2 :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->address_street_2  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group non-tourist" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.address_street') }} 3 :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->address_street_3  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group non-tourist" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.postcode') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->address_postcode  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group non-tourist" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.district') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->district->district  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group non-tourist" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.state') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->state->state  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.home_phone') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->individual->phone_home  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.mobile_phone') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->individual->phone_mobile  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.office_phone') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->phone_office  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.fax_no') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->phone_fax  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.email') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->email  or ''}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="portlet_tab2">
                                                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                                                        <div class="scroller" style="overflow: hidden; width: auto;" data-initialized="0">
                                                            <div action="#" class="form-horizontal form-bordered ">
                                                                <div class="form-body">
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="col-md-12">
                                                                            <span class="bold" style="align-items: stretch;">{{ trans('form3.opponent_info') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    @if($claim->opponent->public_data->user_public_type_id == 1)
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">Identity Card No. / Passport No. / Company No. :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->public_data->individual->identification_no  or ''}}
                                                                        </div>
                                                                    </div>
                                                                   <!--  <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.nationality') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.opponent_name') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->name  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @if($claim->opponent->public_data->user_public_type_id == 2)
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">Company No. :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->public_data->company->company_no  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.nationality') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.opponent_name') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->name  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="col-md-12">
                                                                            <span class="bold" style="align-items: stretch;">{{ trans('form3.opponent_contact_info') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.address_street') }} 1 :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->public_data->address_street_1  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.address_street') }} 2 :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->public_data->address_street_2  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.address_street') }} 3 :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->public_data->address_street_3  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.postcode') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->public_data->address_postcode  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.district') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->public_data->district->district  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.state') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->opponent->public_data->state->state  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.home_phone') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->individual->phone_home  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.mobile_phone') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->public_data->individual->phone_mobile  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.office_phone') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->phone_office  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.fax_no') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->phone_fax  or ''}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.email') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            {{$claim->claimant->email  or ''}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="portlet_tab3">
                                                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                                                        <div class="scroller" style="overflow: hidden; width: auto;" data-initialized="0">
                                                            <div action="#" class="form-horizontal form-bordered ">
                                                                <div class="form-body">
                                                                    
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="col-md-12">
                                                                            <span class="bold" style="align-items: stretch;">{{ trans('form3.defence_towards_counterclaim') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.defence_towards_counterclaim') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" style="display: flex;">
                                                                        <div class="control-label col-xs-4">{{ trans('form3.supporting_docs') }} :</div>
                                                                        <div class="col-xs-8 font-green-sharp" style="align-items: stretch;">
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  end dokumen -->
                        </div>
                        <div class="form-actions" style="background: transparent;">

                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <a href="javascript:;" class="btn default button-previous btn-lg">
                                        <i class="fa fa-angle-left "></i> {{ trans('button.back') }} </a>
                                    <a href="javascript:;" class="btn btn-outline green button-next btn-lg"> {{ trans('button.next') }}
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <a><button name="masuk" type="submit" id="submit-all" class="btn green button-submit btn-lg">
                                        <i class="fa fa-check"></i>
                                        {{ trans('button.save') }}</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade bs-modal-lg" id="modalUpI" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Dokumen Borang 3</h4>
            </div>
            <div class="modal-body">
                <div style="max-height: 100%">
                <center>
                <div>
                <img class="loadedimage" style="max-height: 50%;max-width: 50%;"></img><br><br>
                <a class="loadedimage2" style="margin-top: 5px" href="" download=""><button type='button' class='btn btn-xs btn-info' style='margin-bottom: 10px'><i class='fa fa-download'></i>Download</button></a></div>
                </center>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-modal-lg" id="modalUpF" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Dokumen Borang 3</h4>
            </div>
            <div class="modal-body">
                <div style="height: 800px;">
                    <object class="loadedfile" data="" type="application/pdf" width="100%" height="90%">
                    <a class="loadedfile2" href=""></a>
                    </object>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END CONTENT BODY -->
@endsection

@section('after_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!--Button-->
<script src="{{URL::to('/assets/global/plugins/ladda/spin.min.js')}}" type="text/javascript"></script>
<script src="{{URL::to('/assets/global/plugins/ladda/ladda.min.js')}}" type="text/javascript"></script>
<script src="{{URL::to('/assets/pages/scripts/ui-buttons.min.js')}}" type="text/javascript"></script>
<!-- End button -->
<!-- Form Validation -->
<script src="{{URL::to('/assets/global/plugins/dropzone/dropzone.min.js')}}" type="text/javascript"></script>
<script src="{{URL::to('/assets/pages/scripts/form-dropzone.min.js')}}" type="text/javascript"></script>
<script src="{{URL::to('/assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{URL::to('/assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
<script src="{{URL::to('/assets/pages/scripts/form-validation.min.js')}}" type="text/javascript"></script>
<script src="{{URL::to('/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
<script src="{{URL::to('/assets/pages/scripts/form-wizard.min.js')}}" type="text/javascript"></script>


{{-- Simpan data dari dropzone --}}
<script type="text/javascript">
Dropzone.options.mydropzone = {
  maxUploads:5,parallelUploads: 5,maxFilesize: 3,dictMaxFilesExceeded:"{{trans('dropzone.file_exceed')}}",acceptedFiles: ".pdf, .jpg, .jpeg, .png",maxFiles:5,dictDefaultMessage:"",dictFallbackMessage:"{{trans('dropzone.browser_unsupport')}}",dictInvalidFileType:"{{trans('dropzone.invalid_type')}}",dictFileTooBig:"{{trans('dropzone.file_big')}}",
  init: function() {
    myDropzone=this;
    myDropzone.on("addedfile", function(file) {
        $('.addedhide').hide();
    });
    var mocknum = 0;
    $.getJSON("{{route('form3.mockform3docs',$form3_id)}}", function(data) {
      $.each(data, function(index, val) {
        var mockFile = { name: val.attachment_name, id: val.attachment_id, size: val.size };
        myDropzone.options.addedfile.call(myDropzone, mockFile);
        if(val.mime == "image/jpeg" || val.mime == "image/png")
        myDropzone.createThumbnailFromUrl(mockFile, val.url);
        myDropzone.emit("complete", mockFile);
        myDropzone.files.push(mockFile);
        mockFile.previewElement.classList.add('dz-preview');
        mockFile.previewElement.classList.add('dz-image');
        mockFile.previewElement.classList.add('dz-complete');
        mockFile.previewElement.classList.add('dz-success');

        var totalFileCount = myDropzone.files.length;
        if(totalFileCount == '0')
            $('.addedhide').show();
        else
            $('.addedhide').hide();

        var id = {{$form3_id}};
        var removeButton = Dropzone.createElement("<button data-dz-remove " +
                    "class='del_thumbnail btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>");
        removeButton.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            swal({
                title: "{{ trans('swal.sure') }} ?",
                text: "{{ trans('swal.data_deleted') }} !",
                type: "info",
                showCancelButton: true,
                cancelButtonClass: "btn-danger",
                confirmButtonClass: "green meadow",
                confirmButtonText: "{{ trans('button.delete') }}",
                cancelButtonText: "{{ trans('button.cancel') }}",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    var server_file = "{{route('form3.destroyform3docs',"ids:")}}";
                    server_file = server_file.replace('ids:', val.attachment_id);
                    $.ajax({
                        url: server_file,
                        type: 'get',
                        success: function (response) {
                            if(response.status=='ok'){
                                swal({
                                    title: " {{ trans('swal.success') }} !",
                            text: " {{ trans('swal.success_deleted') }}.",
                                    type: "success",
                                    timer: 500,
                                    showConfirmButton: false,
                                });
                                myDropzone.removeFile(mockFile);
                                var totalFileCount = myDropzone.files.length;
                                if(totalFileCount == '0')
                                    $('.addedhide').show();
                                mocknum--;
                                sessionStorage.setItem('dzmock',mocknum);
                            }else{
                                swal(" {{ trans('swal.error') }} !", "  {{ trans('swal.fail_deleted') }} ", "error");
                            }
                        }
                    });
                    return false;
                }
            });
        });
        var viewButton = Dropzone.createElement("<button data-dz-view " +
                        "class='del_thumbnail btn btn-default'><span class='glyphicon glyphicon-search'></span></button>");
        viewButton.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            var server_file = "{{route('form3.viewform3docsbtn',"ids:")}}";
            server_file = server_file.replace('ids:', val.attachment_id);
            $.ajax({
                method: 'get',
                url: server_file,
                success: function (response) {
                    if(response.status == 'ok'){
                        file = response.attachment;
                        if(val.mime == "image/jpeg" || val.mime == "image/png"){
                            $('#modalUpI').modal('show');
                            $('.loadedimage').attr('src',file.url);
                            $('.loadedimage2').attr('href',file.url);
                            $('.loadedimage2').attr('download',file.attachment_name);
                        } else {
                            $('#modalUpF').modal('show');
                            $('.loadedfile').attr('data',file.url);
                            $('.loadedfile2').attr('href',file.url);
                        }
                    }
                }
            });
        });
        mockFile.previewElement.appendChild(viewButton);
        mockFile.previewElement.appendChild(removeButton);
        mocknum++;

        sessionStorage.setItem('dzmock',mocknum);
      });
    });
    myDropzone.on("sending", function(file) {
        if(parseInt(mocknum) < 5){
            var id = {{$form3_id}};
            var server_file = "{{route('form3.form3docs',"ids:")}}";
            myDropzone.options.url = server_file.replace('ids:', id);
            // trig();
        }
        else{
            myDropzone.removeFile(file);
        }
    });

    myDropzone.on("success",function(file,response){
        var id = sessionStorage.getItem("id");
        var removeButtons = Dropzone.createElement("<button data-dz-remove " +
                    "class='del_thumbnail btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>");
        removeButtons.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            swal({
                title: "{{ trans('swal.sure') }} ?",
                text: "{{ trans('swal.data_deleted') }} !",
                type: "info",
                showCancelButton: true,
                cancelButtonClass: "btn-danger",
                confirmButtonClass: "green meadow",
                confirmButtonText: "{{ trans('button.delete') }}",
                cancelButtonText: "{{ trans('button.cancel') }}",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    var server_file = "{{route('form3.destroyform3docs',"ids:")}}";
                    server_file = server_file.replace('ids:', response.id);
                    $.ajax({
                        url: server_file,
                        type: 'get',
                        success: function (response) {
                            if(response.status=='ok'){
                                swal({
                                title: " {{ trans('swal.success') }} !",
                                text: " {{ trans('swal.success_deleted') }}.",
                                    type: "success",
                                    timer: 500,
                                    showConfirmButton: false,
                                });
                                myDropzone.removeFile(file);
                                var totalFileCount = myDropzone.files.length;
                                if(totalFileCount == '0')
                                    $('.addedhide').show();
                            }else{
                                swal(" {{ trans('swal.error') }} !", "  {{ trans('swal.fail_deleted') }} ", "error");
                            }
                        }
                    });
                    return false;
                }
            });
        });
        var viewButtons = Dropzone.createElement("<button data-dz-view " +
                        "class='del_thumbnail btn btn-default'><span class='glyphicon glyphicon-search'></span></button>");
        viewButtons.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            var server_file = "{{route('form3.viewform3docsbtn',"ids:")}}";
            server_file = server_file.replace('ids:', response.id);
            $.ajax({
                method: 'get',
                url: server_file,
                success: function (response) {
                    if(response.status == 'ok'){
                        filer = response.attachment;
                        if(filer.mime == "image/jpeg" || filer.mime == "image/png"){
                            $('#modalUpI').modal('show');
                            $('.loadedimage').attr('src',filer.url);
                            $('.loadedimage2').attr('href',filer.url);
                            $('.loadedimage2').attr('download',filer.attachment_name);
                        } else {
                            $('#modalUpF').modal('show');
                            $('.loadedfile').attr('data',filer.url);
                            $('.loadedfile2').attr('href',filer.url);
                        }
                    }
                }
            });
        });
        file.previewElement.appendChild(viewButtons);
        file.previewElement.appendChild(removeButtons);

        var a = sessionStorage.getItem('dzfile');
        var a = a + 1;
        sessionStorage.setItem('dzfile',a);
    });

    myDropzone.on("error", function(file) {
        var totalFileCount = parseInt(myDropzone.files.length) + mocknum;
        var text = "{{trans('dropzone.size_type')}}";
        if(totalFileCount > 5){
            text = "{{trans('dropzone.maximum_upload')}}";
        }
        myDropzone.removeFile(file);
        var totalFileCountss = parseInt(myDropzone.files.length) + mocknum;
        if(totalFileCountss == 0)
            $('.addedhide').show();
        swal({
        title: "{{trans('holiday.sorry')}}",
        text: text,
        type: "error",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
        });
    });
    myDropzone.on("removedfile", function(file) {
        var totalFileCount = parseInt(myDropzone.files.length);
        sessionStorage.setItem('dzmock',mocknum);
        sessionStorage.setItem('dzfile',totalFileCount);
    });
  }
}
</script>
 @endsection