<?php
$locale = App::getLocale();
$title_lang = "title_" . $locale;
$description_lang = "description_" . $locale;
$type_lang = "announcement_type_" . $locale;
$display_name = "display_name_" . $locale;
$is_public_personal = Auth::user()->public_data->user_public_type_id == 1;
?>

@extends('layouts.app')

@section('after_styles')
    <style>
        .no-shadow {
            box-shadow: unset !important;
        }

        .panel-add:hover .panel {
            border: 1px solid #2ab4c0 !important;
            background-color: rgba(42, 180, 192, 0.2) !important;
        }

        .panel-add:hover span {
            color: #2ab4c0 !important;
            font-size: 18px;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
        }

        .case-panel {
            padding-right: 0px;
        }

        @media (max-width: 500px) {
            .case-panel {
                padding-right: 15px;
            }
        }

        .btn-action {
            position: absolute !important;
            right: 30px;
        }

        .label {
            padding: 3px 4px 3px !important;
        }

        .parent {
            position: relative;
        }

        .child {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .list-status > .btn {
            font-size: 11px !important;
            text-transform: capitalize !important;
            font-weight: normal !important;
        }

        .list-status li a {
            font-size: small !important;
            text-transform: capitalize !important;
            font-weight: normal !important;
        }

        .list-status .dropdown-menu {
            min-width: 160px !important;
        }
    </style>
@endsection


@section('content')
    <!-- BEGIN PAGE TITLE-->
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
        <h1 class="page-title" style="margin: 0; padding-bottom: 25px;">
            <span class='bold'>{{ __('login.welcome') }}</span>&nbsp;
            <small>{{ __('home_user.logged_in') }} {{ trans('new.public_user') }}</small>
        </h1>

        <div style="padding-bottom: 25px;">
            @if($is_public_personal)
                <button onclick="location.href='{{ route('form1-create')}}'" style="font-weight: normal;"
                        class="btn btn-default btn-circle pull-right"><i
                            class="glyphicon glyphicon-plus "></i> {{ __('home_user.file_claim') }}</button>
            @endif

            <button onclick="location.href='{{ route('inquiry.create')}}'"
                    style="margin-right: 5px; font-weight: normal;" class="btn green-sharp btn-circle pull-right"><i
                        class="glyphicon glyphicon-plus "></i>{{ __('home_user.open_inquiry') }}</button>
        </div>
    </div>
    <!-- END PAGE TITLE-->
    <div class='row'>
        <div class="col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption caption-md">
                        <i class="icon-bell font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase"> {{ __('home_user.annoucement') }} </span>
                        <!-- <span class="caption-helper">3 unread</span> -->
                    </div>
                </div>
                <div class="portlet-body" style="padding-top: 0px; max-height: 364px; overflow-y: auto;">
                    <div class="general-item-list">
                        @if(count($announcements) == 0)
                            <div class="parent" style="text-align: center; height: 80px;">
                                <span class='font-grey-salt child'
                                      style="cursor: default;">{{ trans('home_user.no_available_announcement') }}</span>
                            </div>
                        @else
                            @foreach($announcements as $announcement)
                                <div class="item clickme"
                                     onclick='openAnnouncement({{ $announcement->announcement_id }})'>
                                    <div class="item-head">
                                        <div class="item-details">
                                            <a class="item-name bold font-grey-mint">{{ $announcement->$title_lang }}</a>
                                            <div>
									            <span class="label label-xs {{
									                $announcement->announcement_type_id == 1 ? 'label-danger'
									                : $announcement->announcement_type_id == 2 ? 'label-warning'
									                : $announcement->announcement_type_id == 3 ? 'label-info'
									                : ''
									            }}">
                                                    {{ $announcement->type->$type_lang }}
                                                </span>
                                                <span style='font-size: smaller' class="item-label font-green-sharp">
                                                    {{ __('home_user.by') }} {{ $announcement->created_by->roleuser->first()->role->$display_name }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-body"
                                         style="font-size: small">{{ substr($announcement->$description_lang,0,150) }}
                                        ...
                                    </div>
                                </div>
                            @endforeach

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @if($is_public_personal)
            <div class="col-lg-8 col-sm-12 case-panel">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption font-green-sharp">
                            <i class="icon-folder-alt  font-green-sharp"></i>
                            <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('home_user.claim_case') }} </span>
                            <span class="caption-helper"></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id='claim' class='row'>
                            @if(count($claim) == 0)
                                @if(Auth::user()->public_data->user_public_type_id == 2)
                                    <div class="panel-group col-xs-12">
                                        <div class="panel panel-default no-shadow" style="border: 1px solid #eee;">
                                            <div class="panel-body parent" style="text-align: center; height: 120px;">
                                                <span class='font-grey-salt child'
                                                      style="cursor: default;">{{ trans('home_user.no_available_case') }}</span>
                                                <!-- <button class='btn green-sharp btn-xs'>View</button> -->
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="panel-group col-xs-12 panel-add"
                                         onclick="location.href='{{ route('form1-create') }}'">
                                        <div class="panel panel-default no-shadow clickme"
                                             style="border: 1px solid #eee;">
                                            <div class="panel-body parent" style="text-align: center; height: 120px;">
                                                <span class='font-grey-salt child'><i class='icon-plus'></i> {{ trans('home_user.new_claim_case') }}</span>
                                                <!-- <button class='btn green-sharp btn-xs'>View</button> -->
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                @foreach ($claim as $i => $case)
                                    <div class="panel-group col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <span class='bold font-grey-mint' style="font-size: 16px;">
                                                    <i class='icon-check' style="margin-right: 10px;"></i>{{ $case->case_no }}
                                                    @if($case->form1_id)
                                                        <a class='btn btn-xs btn-primary'
                                                           data-toggle="tooltip"
                                                           title="{{ trans('home_user.view_f1') }}"
                                                           href="{{ route('form1-view', ['claim_case_id' => $case->claim_case_id]) }}">
                                                            {{ trans('home_user.f1') }}
                                                        </a>
                                                    @endif
                                                </span>
                                                <small class='label no-shadow pull-right'
                                                       style='background-color: #a0d046'>{{ $case->status->case_status }}</small>
                                                <br><small>{{__('new.process_date')}}
                                                    : {{ ($case->form1 && $case->form1->processed_at != null) ? \Carbon\Carbon::parse($case->form1->processed_at)->format('d/m/Y') : '-'}}</small>
                                                <br><br><small class='font-grey-mint'>{{ trans('home_user.against') }}
                                                    :</small>
                                                @if($case->multiOpponents == null)
                                                    <tr id="complaints_table_no_data">
                                                        <td colspan="5">{{ __('new.no_data_found') }}</td>
                                                    </tr>
                                                @else
                                                    <table class="table table-bordered margin-top-10">
                                                        <thead>
                                                        <tr>
                                                            <th width="15px">No.</th>
                                                            <th width="50%">{{__('new.opponent_name')}}</th>
                                                            <th>{{__('datatable.action')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($case->multiOpponents as $i => $claim_case_opponent)
                                                            <tr style="line-height: 3em">
                                                                <th>{{$i+1}}</th>
                                                                <th>
                                                                    {{$claim_case_opponent->opponent_address->name}}
                                                                    <br><small
                                                                            class="text-muted">{{$claim_case_opponent->opponent_address->identification_no}}</small>
                                                                </th>
                                                                <th>
                                                                    @php
                                                                        $form2 = $claim_case_opponent->form2;
                                                                    @endphp

                                                                    @if($form2 && $form2->form_status_id == 22)
                                                                        <a class='btn btn-xs btn-primary'
                                                                           data-toggle="tooltip"
                                                                           title="{{ trans('home_user.view_f2') }}"
                                                                           href="{{ route('form2-view', ['claim_case_id' => $claim_case_opponent->id]) }}">
                                                                            {{ trans('home_user.f2') }}
                                                                        </a>
                                                                    @endif

                                                                    @if( $case->case_status_id > 3 && $form2)
                                                                        @if($form2->form3 && $form2->form3->form_status_id < 32 )
                                                                            <a class='btn btn-xs btn-primary'
                                                                               data-toggle="tooltip"
                                                                               title="{{ trans('home_user.edit_f3_full') }}"
                                                                               href="{{ route('form3-edit', ['id' => $claim_case_opponent->id]) }}">
                                                                                {{ trans('home_user.edit_f3') }}
                                                                            </a>
                                                                        @endif
                                                                        @if($form2->form3 && $form2->form3->form_status_id >= 32 )
                                                                            <a class='btn btn-xs btn-primary'
                                                                               data-toggle="tooltip"
                                                                               title="{{ trans('home_user.view_f3') }}"
                                                                               href="{{ route('form3-view', ['id' => $claim_case_opponent->id]) }}">
                                                                                {{ trans('home_user.f3') }}
                                                                            </a>
                                                                        @endif
                                                                        @if(!$form2->form3 && $form2->counterclaim_id && $form2->form_status_id == 22)
                                                                            <a class='btn green-sharp btn-xs'
                                                                               data-toggle="tooltip"
                                                                               title="{{ trans('home_user.edit_f3_full') }}"
                                                                               href="{{ route('form3-create', ['id' => $claim_case_opponent->id]) }}">
                                                                                {{ trans('home_user.file_f3') }}
                                                                            </a>
                                                                        @endif
                                                                    @endif

                                                                    @if($claim_case_opponent->last_form4)
                                                                        <a class='btn btn-primary btn-xs'
                                                                           data-toggle="tooltip"
                                                                           title="{{ trans('home_user.view_f4') }}"
                                                                           href="{{ route('claimcase-view-cc', [$claim_case_opponent->id, 'cc']) }}">{{ trans('home_user.f4') }}</a>
                                                                    @endif
                                                                </th>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                                <br>
                                                @if( $case->case_status_id == 2 )
                                                    <small class='font-green-sharp'>* {{ trans('home_user.status_2_claim') }}</small>
                                                @elseif( $case->case_status_id == 4 )
                                                    <small class='font-red-thunderbird'>* {{ trans('home_user.status_4_claim') }}</small>
                                                @elseif( $case->case_status_id == 6 )
                                                    <small class='font-green-sharp'>* {{ trans('home_user.status_6_claim') }}</small>
                                                @elseif( $case->case_status_id == 7 )
                                                    <small class='font-grey-mint'>* {{ trans('home_user.status_7_claim') }}</small>
                                                @elseif( $case->case_status_id == 8 )
                                                    <small class='font-grey-mint'>* {{ trans('home_user.status_8_claim') }}</small>
                                                @elseif( $case->case_status_id == 9 )
                                                    <small class='font-grey-mint'>* {{ trans('home_user.status_9_claim') }}</small>
                                            @endif
                                            <!-- <button class='btn green-sharp btn-xs'>View</button> -->
                                            </div>
                                            <div class="panel-footer">
                                                <small>{{__('new.created_at')}}
                                                    : {{\Carbon\Carbon::parse($case->created_at)->format('d/m/Y')}}</small>
                                                @if( $case->case_status_id == 1 )
                                                    @if($case->form1_id)
                                                        @if(($case->form1->form_status_id < 16 || $case->form1->form_status_id == 61) && (!$case->case_no || $case->case_no == "DRAFT"))
                                                            <a class='btn dark btn-xs pull-right btn-action2'
                                                               data-toggle="tooltip"
                                                               title="{{ trans('home_user.edit_f1_full') }}"
                                                               href="{{ route('form1-edit', ['claim_case_id' => $case->claim_case_id]) }}">{{ trans('home_user.edit_f1') }}</a>
                                                            <a class='btn btn-xs pull-right btn-action2 btn-muted'
                                                               data-toggle="tooltip"
                                                               style="margin-right: 10px"
                                                               onclick="deleteForm1({{$case->claim_case_id}})"
                                                               title="{{ trans('home_user.delete_f1') }}"
                                                            >{{ trans('home_user.delete_f1') }}</a>
                                                        @elseif($case->form1->form_status_id < 16 && $case->form1->form_status_id != 14)
                                                            <a class='btn dark btn-xs pull-right btn-action'
                                                               data-toggle="tooltip"
                                                               title="{{ trans('home_user.edit_f1_full') }}"
                                                               href="{{ route('form1-edit', ['claim_case_id' => $case->claim_case_id]) }}">{{ trans('home_user.edit_f1') }}</a>
                                                        @endif
                                                    @elseif(!$case->form1_id)
                                                        @if(!$case->case_no || $case->case_no == "DRAFT")
                                                            <a class='btn dark btn-xs pull-right btn-action2'
                                                               data-toggle="tooltip"
                                                               title="{{ trans('home_user.edit_f1_full') }}"
                                                               href="{{ route('form1-edit', ['claim_case_id' => $case->claim_case_id]) }}">{{ trans('home_user.edit_f1') }}</a>
                                                            <a class='btn btn-xs pull-right btn-action2 btn-muted'
                                                               data-toggle="tooltip"
                                                               style="margin-right: 10px"
                                                               onclick="deleteForm1({{$case->claim_case_id}})"
                                                               title="{{ trans('home_user.delete_f1') }}"
                                                            >{{ trans('home_user.delete_f1') }}</a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if(count($claim) > 4)
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <ul class="pagination pull-right" id="pagination-claim"></ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="{{ $is_public_personal ? 'col-lg-4 col-sm-12 case-panel' : 'col-md-12'}}">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-green-sharp">
                        <i class="icon-folder-alt  font-green-sharp"></i>
                        <span class="caption-subject bold font-green-sharp uppercase"> {{ trans('home_user.opposed_case') }} </span>
                        <span class="caption-helper"></span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" data-toggle="modal" data-target="#modalAdd"
                           class="btn btn-circle btn-xs yellow-casablanca">
                            <i class="fa fa-plus"></i> {{ __('button.searching') }}
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id='opposed' class='row'>
                        @if(count($opposed) == 0)
                            <div class="panel-group col-xs-12">
                                <div class="panel panel-default no-shadow" style="border: 1px solid #eee;">
                                    <div class="panel-body parent" style="text-align: center; height: 120px;">
                                            <span class='font-grey-salt child'
                                                  style="cursor: default;">{{ trans('home_user.no_available_case') }}</span>
                                        <!-- <button class='btn green-sharp btn-xs'>View</button> -->
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach ($opposed as $i=>$case)
                                <div class="panel-group col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                                <span class='bold font-grey-mint' style="font-size: 16px;"><i
                                                            class='icon-check' style="margin-right: 10px;"></i>{{ $case->claimCase->case_no }}</span>
                                            <small class='label no-shadow pull-right'
                                                   style='background-color: #a0d046'>{{ $case->claimCase->status->case_status }}</small>
                                            <br>
                                            <small class='font-grey-mint'>{{ trans('home_user.by') }}
                                                : {{ $case->claimCase->claimant->name }}</small><br>
                                            @if( $case->claimCase->case_status_id == 2 )
                                                <small class='font-red-thunderbird'>* {{ trans('home_user.status_2_opposed') }}</small>
                                            @elseif( $case->claimCase->case_status_id == 4 )
                                                <small class='font-red-thunderbird'>* {{ trans('home_user.status_4_opposed') }}</small>
                                            @elseif( $case->claimCase->case_status_id == 6 )
                                                <small class='font-red-thunderbird'>* {{ trans('home_user.status_6_opposed') }}</small>
                                                <br>
                                                <small class='font-green-sharp'>* {{ trans('home_user.status_6_claim') }}</small>
                                            @elseif( $case->claimCase->case_status_id == 7 )
                                                <small class='font-grey-mint'>* {{ trans('home_user.status_7_claim') }}</small>
                                            @elseif( $case->claimCase->case_status_id == 8 )
                                                <small class='font-grey-mint'>* {{ trans('home_user.status_8_claim') }}</small>
                                            @elseif( $case->claimCase->case_status_id == 9 )
                                                <small class='font-grey-mint'>* {{ trans('home_user.status_9_claim') }}</small>
                                        @endif
                                        <!-- <button class='btn green-sharp btn-xs'>View</button> -->
                                        </div>
                                        <div class="panel-footer">
                                            <a class='btn btn-xs
                    					@if($case->claimCase->form1_id)
                                                    btn-primary' data-toggle="tooltip"
                                               title="{{ trans('home_user.view_f1') }}"
                                               href="{{ route('form1-view', ['claim_case_id' => $case->claimCase->claim_case_id]) }}"
                                               @else
                                               btn-default' disabled
                                            @endif
                                            >{{ trans('home_user.f1') }}</a>

                                            @if($case->form2)
                                                <a class='btn btn-xs btn-primary'
                                                   data-toggle="tooltip"
                                                   title="{{ trans('home_user.view_f2') }}"
                                                   href="{{ route('form2-view', ['claim_case_id' => $case->id]) }}">
                                                    {{ trans('home_user.f2') }}
                                                </a>
                                            @else
                                                <a class='btn btn-xs btn-default'
                                                   disabled
                                                   data-toggle="tooltip">
                                                    {{ trans('home_user.f2') }}
                                                </a>
                                            @endif

                                            <a class='btn btn-xs

                    					@if($case->claimCase->form1_id)
                                            @if($case->form2)
                                            @if($case->form2->form3 && $case->form2->form3->form_status_id == 46)
                                                    btn-primary' data-toggle="tooltip"
                                               title="{{ trans('home_user.view_f3') }}"
                                               href="{{ route('form3-view', ['claim_no' => $case->claimCase->claim_case_id]) }}"
                                               @else
                                               btn-default' disabled
                                            @endif
                                            @else
                                                btn-default' disabled
                                            @endif
                                            @else
                                                btn-default' disabled
                                            @endif
                                            >{{ trans('home_user.f3') }}</a>

                                            @if( $case->claimCase->last_form4 )
                                                <a class='btn btn-primary btn-xs' data-toggle="tooltip"
                                                   title="{{ trans('home_user.view_f4') }}"
                                                   href="{{ route('claimcase-view-cc', [$case->id, 'cc' => 'cc']) }}">{{ trans('home_user.f4') }}</a>
                                            @endif

                                            @if($case->claimCase->case_status_id > 1 && !$case->form2)
                                                <a class='btn green-sharp btn-xs pull-right btn-action'
                                                   data-toggle="tooltip"
                                                   title="{{ trans('home_user.file_f2_full') }}"
                                                   href="{{ route('form2-create', ['claim_case_id' => $case->id]) }}">{{ trans('home_user.file_f2') }}</a>
                                            @elseif($case->claimCase->case_status_id > 1 && $case->form2 && $case->form2->form_status_id != 19 && $case->form2->form_status_id < 21)
                                                <a class='btn green-sharp btn-xs pull-right btn-action'
                                                   data-toggle="tooltip"
                                                   title="{{ trans('home_user.edit_f2_full') }}"
                                                   href="{{ route('form2-edit', ['claim_case_id' => $case->id]) }}">{{ trans('home_user.edit_f2') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        @endif
                    </div>
                    @if(count($opposed) > 4)
                        <div class='row'>
                            <div class='col-xs-12'>
                                <ul class="pagination pull-right" id="pagination-opposed"></ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-modal-lg" id="modalperanan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ trans('others.announcement_info')}}</h4>
                </div>
                <div class="modal-body" id="modalbodyperanan">
                    <div style="text-align: center;">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalAdd" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('new.retrieve_case') }}</h4>
                </div>
                <div class="modal-body">
                    <small>{{ __('new.retrieve_info') }}</small>

                    <form id='retrieveForm' method='post' action='{{ route("form1-retrieve") }}' role="form"
                          class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label"
                                       for="ttpm_no">{{ __('form1.ttpm_case_no') }}<i
                                            class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
                                <div class="col-md-7">
                                    <input class="form-control" id="ttpm_no" name="ttpm_no"
                                           placeholder="e.g. TTPM-WPPJ-(B)-1-2001" type="text">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-4 control-label"
                                       for="receipt_no">{{ __('form1.receipt_no') }}<i
                                            class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
                                <div class="col-md-7">
                                    <input class="form-control" id="receipt_no" name="receipt_no"
                                           placeholder="e.g. T170000001" type="text">
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                            <fieldset class="user-data hidden">
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-4 control-label"
                                           for="claimant_name">{{ __('form1.claimant_name') }}</label>
                                    <div class="col-md-7">
                                        <input class="form-control" id="claimant_name" disabled type="text">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-4 control-label" id="label_claimant_identification_no"
                                           for="claimant_identification_no">{{ __('form1.ic_no') }}</label>
                                    <div class="col-md-7">
                                        <input class="form-control" id="claimant_identification_no" disabled
                                               type="text">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-4 control-label" id="label_claimant_identification_no"
                                           for="claimant_identification_no">{{ __('new.opponent_name') }}</label>
                                    <div class="col-md-7" id="claim_case_opponent_div">
                                        {{--                                        <input class="" required="required" name="claim_case_opponent_id" type="radio" value="1"> Penentang 1--}}
                                        {{--                                        <br>--}}
                                        {{--                                        <input class="" required="required" name="claim_case_opponent_id" type="radio" value="2"> Penentang 2--}}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left"
                            data-dismiss="modal">{{ __('button.close') }}</button>
                    <button type="button" class="btn green-jungle btn-outline"
                            onclick='checkForm()'>{{ __('button.check') }}</button>
                    <button id='button-transfer' type="button" class="btn green-jungle hidden"
                            onclick='submitForm()'>{{ __('button.insert_list') }}</button>
                </div>
            </div>

        </div>
    </div>




@endsection


@section('after_scripts')
    <script src="{{ URL::to('/assets/global/plugins/jquery.twbsPagination.min.js') }}" type="text/javascript"></script>
    <script>
      $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })

      $('.list-status li a').on('click', function () {
        $(this).parents('.list-status').find('span').html($(this).html())
        //$('.list-status > .btn > span').html( $(this).html() );
      })

      function submitForm() {
        $('#retrieveForm').submit()
      }

      function checkForm() {
        if ($('#ttpm_no').val().length == 0 || $('#receipt_no').val().length == 0) {
          swal("{{ __('new.sorry') }}", "{{ __('swal.form_not_complete') }}", 'error')

          return false
        }

        var form = $('#retrieveForm')

        $.ajax({
          url: "{{ route('form1-check') }}",
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          method: form.attr('method'),
          data: new FormData(form[ 0 ]),
          dataType: 'json',
          contentType: false,
          processData: false,
          async: true,
          success: function (data) {
            if (data.status == 'found') {
              $('.user-data, #button-transfer').removeClass('hidden')

              $('#claimant_name').val(data.claimant_name)
              $('#claimant_identification_no').val(data.claimant_identification_no)

              if (data.claimant_type == 1) {
                $('#label_claimant_identification_no').text("{{ __('form1.ic_no') }}")
              } else if (data.claimant_type == 2) {
                $('#label_claimant_identification_no').text("{{ __('form1.passport_no') }}")
              } else if (data.claimant_type == 3) {
                $('#label_claimant_identification_no').text("{{ __('form1.company_no') }}")
              }

              console.log(data.opponents)
              var cco_div = $('#claim_case_opponent_div')


              $.each(data.opponents, function (index, opponent) {
                cco_div.append('<input class="" required="required" name="claim_case_opponent_id" type="radio" value="' + opponent.id + '"> ' + opponent.opponent_address.name + '<br>')
              })

            } else if (data.status == 'same') {
              $('.user-data, #button-transfer').addClass('hidden')
              swal("{{ __('new.sorry') }}", "{{ __('swal.same_id_error') }}", 'error')
            } else {
              $('.user-data, #button-transfer').addClass('hidden')
              swal('{{ __("new.error") }}', '{{ __("new.no_data_found") }}!', 'error')
            }
          },
          error: function (xhr) {
            console.log(xhr.status)
          }
        })
      }

      $('#retrieveForm').submit(function (e) {

        e.preventDefault()
        var form = $(this)

        $.ajax({
          url: form.attr('action'),
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          method: form.attr('method'),
          data: new FormData(form[ 0 ]),
          dataType: 'json',
          contentType: false,
          processData: false,
          async: true,
          beforeSend: function () {

          },
          success: function (data) {
            if (data.status == 'ok') {
              swal({
                  title: "{{ __('new.success') }}",
                  text: '',
                  type: 'success'
                },
                function () {
                  $('#modalAdd').modal('hide')
                  location.reload()
                })
            } else if (data.status == 'notfound') {
              swal('{{ __("new.error") }}', '{{ __("new.no_data_found") }}!', 'error')
            } else {
              var inputError = []

              console.log(Object.keys(data.message)[ 0 ])
              if ($('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':radio') || $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':checkbox')) {
                var input = $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']')
              } else {
                var input = $('#' + Object.keys(data.message)[ 0 ])
              }

              $('html,body').animate(
                { scrollTop: input.offset().top - 100 },
                'slow', function () {
                  //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                  input.focus()
                }
              )

              $.each(data.message, function (key, data) {
                if ($('input[name=\'' + key + '\']').is(':radio') || $('input[name=\'' + key + '\']').is(':checkbox')) {
                  var input = $('input[name=\'' + key + '\']')
                } else {
                  var input = $('#' + key)
                }
                var parent = input.parents('.form-group')
                parent.removeClass('has-success')
                parent.addClass('has-error')
                parent.find('.help-block').html(data[ 0 ])
                inputError.push(key)
              })

              $.each(form.serializeArray(), function (i, field) {
                if ($.inArray(field.name, inputError) === -1) {
                  if ($('input[name=\'' + field.name + '\']').is(':radio') || $('input[name=\'' + field.name + '\']').is(':checkbox')) {
                    var input = $('input[name=\'' + field.name + '\']')
                  } else {
                    var input = $('#' + field.name)
                  }
                  var parent = input.parents('.form-group')
                  parent.removeClass('has-error')
                  parent.addClass('has-success')
                  parent.find('.help-block').html('')
                }
              })
            }
          },
          error: function (xhr) {
            console.log(xhr.status)
          }
        })
        return false
      })

      @if(count($claim) > 10)
      // Claim Case - Current
      $(function () {
        window.pagObj = $('#pagination-claim').twbsPagination({
          totalPages: {{ ceil(count($claim)/10) }},
          visiblePages: 3,
          first: '<span aria-hidden="true">&laquo;</span>',
          last: '<span aria-hidden="true">&raquo;</span>',
          next: '<span aria-hidden="true">&rsaquo;</span>',
          prev: '<span aria-hidden="true">&lsaquo;</span>',
          onPageClick: function (event, page) {
            //console.info(page + ' (from options)');
            var n = ((page - 1) * 10) + 1

            //console.log("Total Claim: "+$('#claim .panel-group').length);

            $('#claim .panel-group').addClass('hidden')
            var i
            for (i = 0; i <= 9; i++) {
              $('#opposed .panel-group:nth-child(' + (n + i) + ')').removeClass('hidden')
            }
            $('#claim').parents('.portlet').animate({ scrollTop: 0 }, 2000)
          }
        })
      })
      @endif

      @if(count($opposed) > 10)
      // Opposed Case - Current
      $(function () {
        window.pagObj = $('#pagination-opposed').twbsPagination({
          totalPages: {{ ceil(count($opposed)/10) }},
          visiblePages: 3,
          first: '<span aria-hidden="true">&laquo;</span>',
          last: '<span aria-hidden="true">&raquo;</span>',
          next: '<span aria-hidden="true">&rsaquo;</span>',
          prev: '<span aria-hidden="true">&lsaquo;</span>',
          onPageClick: function (event, page) {
            //console.info(page + ' (from options)');
            var n = ((page - 1) * 10) + 1

            //console.log("Total Opposed: "+$('#claim .panel-group').length);

            $('#opposed .panel-group').addClass('hidden')
            var i
            for (i = 0; i <= 9; i++) {
              $('#opposed .panel-group:nth-child(' + (n + i) + ')').removeClass('hidden')
            }
            $('#opposed').parents('.portlet').animate({ scrollTop: 0 }, 2000)
          }
        })
      })
      @endif

      //console.log("Total Announcement: {{ $announcements->count() }}");

      $('#modalperanan').on('hidden.bs.modal', function () {
        $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>')
      })

      function openAnnouncement(id) {
        $('#modalperanan').modal('show')
          .find('#modalbodyperanan')
          .load('{{ url("others/announcement") }}/' + id + '/view_dashboard')
      }

      function deleteForm1(claim_case_id) {
        if (confirm('{{ __('new.destroy_data') }}')) {
          myBlockui()
          $.ajax({
            url: 'form1/' + claim_case_id + '/delete',
            type: 'GET',
            success: function (data) {
              console.log('success to remove data', data)
              $.unblockUI()
              location.reload()
            }
          })
        }
      }

    </script>
@endsection