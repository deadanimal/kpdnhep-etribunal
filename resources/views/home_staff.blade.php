<?php
$locale = App::getLocale();
$title_lang = "title_" . $locale;
$description_lang = "description_" . $locale;
$type_lang = "announcement_type_" . $locale;
$form_status_desc_lang = "form_status_desc_" . $locale;
$display_name = "display_name_" . $locale;
$month_lang = "month_" . $locale;
?>
@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <style>
        .parent {
            position: relative;
        }

        .child {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .portlet.calendar.light .fc-button {
            top: -47px;
            margin-top: -13px;
        }

        .btn-box {
            transition: all .1s ease-in-out;
        }

        .btn-box:hover {
            transform: scale(1.1);
        }
    </style>
@endsection

@section('content')

    @if(!Auth::user()->ttpm_data->signature_blob && !Auth::user()->ttpm_data->signature_filename)
        <div class="note note-danger bg-red font-white">
            <h4 class="block bold">{{ __('home_staff.attention')}} !</h4>
            <p> {{ __('home_staff.signature_reminder')}}
                <a class='btn btn-outline white btn-sm'
                   href='{{ url("profile") }}'
                   style="box-shadow: unset;">{{ __('home_staff.update_profile')}}</a>
            </p>
        </div>
    @endif

    <!-- BEGIN PAGE TITLE-->
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
        <h1 class="page-title" style="margin: 0; padding-bottom: 25px;">
            {{ __('login.welcome') }}&nbsp;
            <small>{{ __('home_user.logged_in') }} @if(Auth::user()->user_type_id == 2){{ trans('new.ttpm_staff')." (".Auth::user()->ttpm_data->branch->branch_name.")" }} @endif</small>
        </h1>

        <div style="padding-bottom: 25px;">
            <button onclick="location.href='{{ route('form1-create')}}'"
                    style="font-weight: normal;"
                    class="btn btn-default btn-circle pull-right">
                <i class="glyphicon glyphicon-plus "></i> {{ __('home_user.file_claim') }}
            </button>
            <button onclick="location.href='{{ route('inquiry.create')}}'"
                    style="margin-right: 5px; font-weight: normal;"
                    class="btn btn-success btn-circle pull-right">
                <i class="glyphicon glyphicon-plus "></i>{{ __('home_user.open_inquiry') }}
            </button>
        </div>
    </div>
    <!-- END PAGE TITLE-->

    <div class="row">
        <!-- above -->
        <div class="col-md-6" style="padding-right: 0px;">
            <div class="row">
                <div class='col-xs-12 hidden-sm hidden-xs' style="padding-bottom: 15px">
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 purple"
                           @if(Auth::user()->hasRole('setiausaha')) href="{{ route('onlineprocess.inquiry', ['status' => 10]) }}"
                           @else href="{{ route('onlineprocess.inquiry', ['branch' => $branch_staff, 'status' => 9]) }}" @endif >
                            <div class="visual">
                                <i class="fa fa-question" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $inquiry }}">{{ $inquiry }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.inquiry') }} </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 yellow-lemon"
                           href="{{ route('onlineprocess.form1', ['status' => 14, 'branch' => $branch_staff, 'year' => 0] ) }}">
                            <div class="visual">
                                <i class="fa fa-files-o" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form1 }}">{{ $form1 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 1
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 red-pink"
                           href="{{ route('onlineprocess.form2', ['status' => 19, 'branch' => $branch_staff, 'year' => 0] ) }}">
                            <div class="visual">
                                <i class="fa fa-files-o" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form2 }}">{{ $form2 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 2
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 green-jungle"
                           href="{{ route('onlineprocess.form3', ['status' => 31, 'branch' => $branch_staff, 'year' => 0] ) }}">
                            <div class="visual">
                                <i class="fa fa-files-o" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form3 }}">{{ $form3 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 3
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 blue"
                           href="{{ route('onlineprocess.form4', ['year' => date('Y')]) }}">
                            <div class="visual">
                                <i class="fa fa-files-o" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form4 }}">{{ $form4 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 4
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 grey-silver">
                            <div class="visual">
                                <i class="fa fa-gavel" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form5 }}">{{ $form5 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}
                                    5
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 red-pink">
                            <div class="visual">
                                <i class="fa fa-gavel" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form6 }}">{{ $form6 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}
                                    6
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 red-haze">
                            <div class="visual">
                                <i class="fa fa-gavel" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form7 }}">{{ $form7 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}
                                    7
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 red-mint">
                            <div class="visual">
                                <i class="fa fa-gavel" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form8 }}">{{ $form8 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}
                                    8
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 blue">
                            <div class="visual">
                                <i class="fa fa-gavel" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form9 }}">{{ $form9 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}
                                    9
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 blue-sharp">
                            <div class="visual">
                                <i class="fa fa-gavel" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form10 }}">{{ $form10 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}
                                    10
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 white"
                           href="{{ route('onlineprocess.form11') }}">
                            <div class="visual">
                                <i class="fa fa-files-o" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form11 }}">{{ $form11 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 11
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 white"
                           href="{{ route('onlineprocess.form12') }}">
                            <div class="visual">
                                <i class="fa fa-files-o" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $form12 }}">{{ $form12 }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 12
                                </div>
                            </div>
                        </a>
                    </div>

                    @if($user->roleuser->first()->role_id == 6 )
                        <div class="btn-box col-md-4 col-sm-4 col-xs-6" style="padding-left: 0px;">
                            <a class="dashboard-stat dashboard-stat-v2 yellow" href="{{ route('others.suggestion') }}">
                                <div class="visual">
                                    <i class="fa fa-comments" style="opacity: .2"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                              data-value="{{ $suggestion }}">{{ $suggestion }}</span>
                                    </div>
                                    <div class="desc bold"
                                         style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.suggestion') }} </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
                        <a class="dashboard-stat dashboard-stat-v2 dark-blue" href="{{ route('form4-transfer-list') }}">
                            <div class="visual">
                                <i class="fa fa-exchange" style="opacity: .2"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $transfer }}">{{ $transfer }}</span>
                                </div>
                                <div class="desc bold"
                                     style="text-shadow: 1px 1px #909090;"> {{ __('menu.transfer') }}</div>
                            </div>
                        </a>
                    </div>

                </div>

                <div class='col-xs-12' style="padding-bottom: 15px; padding-right: 30px;">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bell font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase"> {{ __('new.total_filings')." ".date("Y") }} </span>
                                <!-- <span class="caption-helper">3 unread</span> -->
                            </div>
                        </div>
                        <div class="portlet-body">
                            <canvas id="myChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class='col-xs-12' style="padding-bottom: 15px">
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
	    									<span class="label 
	    									@if($announcement->announcement_type_id == 1)
                                                    label-danger
											@elseif($announcement->announcement_type_id == 2)
                                                    label-warning
											@elseif($announcement->announcement_type_id == 3)
                                     	               label-info
											@endif
                                                    label-xs">{{ $announcement->type->$type_lang }}</span>
                                                        <span style='font-size: smaller'
                                                              class="item-label font-green-sharp">{{ __('home_user.by') }} {{ $announcement->created_by->roleuser->first()->role->$display_name }}</span>
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

                @if(!auth()->user()->hasRole('presiden') || (auth()->user()->hasRole('presiden') && auth()->user()->hasRole('pengerusi')))
                {{-- presiden --}}
                <div class='col-xs-12' style="padding-bottom: 15px">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bell font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase"> {{ __('home_user.today_action') }} </span>
                                <!-- <span class="caption-helper">3 unread</span> -->
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="form-body">
                                <div class="tab-pane" id="overview_2">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered">
                                            <tbody>
                                            <tr>
                                                <td>{{ __('home_staff.inquiry_ans') }}</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">

                                                        {{ $inquiry_30 }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if(Auth::user()->hasRole('setiausaha'))
                                                        <a href="{{ route('onlineprocess.inquiry', ['status' => 10, 'branch' => 0, 'more_than' => 30]) }}"
                                                           class="btn btn-sm btn-default">
                                                            <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                        </a>
                                                    @elseif($user->roleuser->first()->role_id != 9 )
                                                        <a href="{{ route('onlineprocess.inquiry', ['status' => 9, 'branch' => $branch_staff]) }}"
                                                           class="btn btn-sm btn-default">
                                                            <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('onlineprocess.inquiry', ['status' => 10, 'branch' => $branch_staff]) }}"
                                                           class="btn btn-sm btn-default">
                                                            <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('home_staff.pending_payment_form1') }}</td>
                                                <td>
                                                    <a href="" class="btn btn-circle btn-icon-only red">
                                                        {{ $form1_unpaid }}
                                                    </a>
                                                </td>


                                                <td>
                                                    <a href="{{ route('onlineprocess.form1', ['status' => 15, 'branch' => $branch_staff]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('home_staff.pending_payment_form2') }} </td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">
                                                        {{ $form2_unpaid }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('onlineprocess.form2', ['status' => 20, 'branch' => $branch_staff]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('home_staff.new_claim') }}</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">
                                                        {{ $form1 }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('onlineprocess.form1', ['status' => 14, 'branch' => $branch_staff]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('home_staff.f1_incomplete') }}</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">
                                                        {{ $form1_incomplete }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('onlineprocess.form1', ['status' => 16, 'branch' => $branch_staff]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('home_staff.form2_process') }} </td>
                                                <td>
                                                    <a href="" class="btn btn-circle btn-icon-only red">
                                                        {{ $form2 }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('onlineprocess.form2', ['status' => 19, 'branch' => $branch_staff]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> {{ __('home_staff.claim_without_hearing') }}</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">
                                                        {{ $claim_no_hearing_date }}
                                                    </a>
                                                </td>


                                                <td>
                                                    <a href="{{ url('/hearing') }}/without_hearing_date"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('home_staff.form4_not_print') }} </td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">
                                                        {{ $f4_not_print }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('onlineprocess.form4', ['status' => 35, 'branch' => $branch_staff, 'year' => date('Y')]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> {{ __('home_staff.discontinuous_notice') }}  </td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">
                                                        {{ $stop_notice_unprocessed }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('onlineprocess.stop_notice', ['status' => 26, 'branch' => $branch_staff, 'year' => date('Y')]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> {{ __('home_staff.set_aside_award') }}</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">
                                                        {{ $form12 }}
                                                    </a>
                                                </td>


                                                <td>
                                                    <a href="{{ route('onlineprocess.form12', ['status' => 24, 'branch' => $branch_staff, 'year' => date('Y')]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('home_staff.award_disobey') }}  </td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">
                                                        {{ $award_disobey_unprocessed }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('onlineprocess.award_disobey', ['status' => 28, 'branch' => $branch_staff, 'year' => date('Y')]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('home_staff.witness_summon') }}</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only red">
                                                        {{ $form11 }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('onlineprocess.form11', ['year' => date('Y')]) }}"
                                                       class="btn btn-sm btn-default">
                                                        <i class="fa fa-search"></i> {{ __('home_staff.view') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class='col-xs-12' style="padding-bottom: 15px">
                    <div class="portlet light calendar bordered">
                        <div class="portlet-title ">
                            <div class="caption">
                                <i class="icon-calendar font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase">{{ __('home_staff.hearing_calendar')}}</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
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


@endsection


@section('after_scripts')

    <script src="{{ URL::to('/assets/global/plugins/Chart.min.js') }}"></script>
    <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/fullcalendar/fullcalendar.min.js') }}"
            type="text/javascript"></script>
    @if(App::getLocale() == 'my')
        <script src="{{ URL::to('/assets/global/plugins/fullcalendar/lang/my.js') }}" type="text/javascript"></script>
    @endif
    <script>

      $('#calendar').fullCalendar({
        // put your options and callbacks here
        displayEventTime: false,
        buttonText: {
          today: '{{ __("new.today") }}',
          month: '{{ __("new.month") }}',
          week: '{{ __("new.week") }}',
          day: '{{ __("new.day") }}',
          list: '{{ __("new.list") }}'
        },
        events: [
          // events go here
		@foreach($hearings as $hearing)
          {
            title: '{{ $hearing->count }}',
            start: '{{ date("c", strtotime($hearing->hearing_date." ".$hearing->hearing_time)) }}'
          },
		@endforeach
        ],
        eventClick: function (event, jsEvent, view) {
          location.href = "{{ url('listing/hearing/date') }}/" + moment(event.start).format('YYYY-MM-DD') + '/' + moment(event.start).format('HH:mm:ss')
        },
        eventMouseover: function (event, element) {
          $(this).popover({
            title: moment(event.start).format('DD/MM/YYYY hh:mm A'),
            //content: "Date & Time: " ,
            html: true,
            container: 'body'
          })
          $(this).popover('show')
        },
        eventMouseout: function (event, element) {
          $(this).popover('hide')
        }

      })

      $('#modalperanan').on('hidden.bs.modal', function () {
        $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>')
      })

      function openAnnouncement(id) {
        $('#modalperanan').modal('show')
          .find('#modalbodyperanan')
          .load('{{ url("others/announcement") }}/' + id + '/view_dashboard')
      }
    </script>

    <script>
      var ctx = document.getElementById('myChart').getContext('2d')
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [
              @foreach( $months as $index => $month )
                "{{ $month->$month_lang }}",
              @endforeach
          ],
          datasets: [ {
            label: '{{ __("new.total_filings")}}',
            data: [
                @foreach( $months as $index => $month )
                <?php
                $filing = (clone $report_dashboard)->where('month', $month->month_id)->get();
                ?>
                {{ $filing->count() > 0 ? $filing->first()->total : 0 }},
                @endforeach
            ],
            backgroundColor: 'rgba(255, 99, 132, 1)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
          } ]
        },
        options: {
          'hover': {
            'animationDuration': 0
          },
          'animation': {
            'duration': 1,
            'onComplete': function () {
              var chartInstance = this.chart,
                ctx = chartInstance.ctx

              ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily)
              ctx.textAlign = 'center'
              ctx.textBaseline = 'bottom'

              this.data.datasets.forEach(function (dataset, i) {
                var meta = chartInstance.controller.getDatasetMeta(i)
                meta.data.forEach(function (bar, index) {
                  var data = dataset.data[ index ]
                  ctx.fillText(data, bar._model.x, bar._model.y - 5)
                })
              })
            }
          },
          legend: {
            'display': false
          },
          tooltips: {
            'enabled': false
          },
          scales: {
            yAxes: [ {
              scaleLabel: {
                display: true,
                labelString: '{{ __("new.total_filings")}}'
              },
              ticks: {
                beginAtZero: true,
                autoSkip: false
              }
            } ],
            xAxes: [ {
              stacked: false,
              beginAtZero: true,
              scaleLabel: {
                display: true,
                labelString: '{{ __("new.month")}}'
              },
              ticks: {
                stepSize: 1,
                min: 0,
                autoSkip: false
              }
            } ]
          }
        }
      })
    </script>
@endsection
