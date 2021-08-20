<?php
$locale = App::getLocale();
$title_lang = "title_".$locale;
$description_lang = "description_".$locale;
$type_lang = "announcement_type_".$locale;
$display_name = "display_name_".$locale;
?>

@extends('layouts.app')

@section('after_styles')
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
.btn-box {
    transition: all .1s ease-in-out;
}

.btn-box:hover { transform: scale(1.1); }
</style>
@endsection

@section('content')
<!-- BEGIN PAGE TITLE-->
<div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
    <h1 class="page-title" style="margin: 0;  padding-bottom: 25px;">
        {{ __('login.welcome') }}&nbsp;
        <small>{{ __('home_user.logged_in') }} @if(Auth::user()->user_type_id == 1){{ trans('home_admin.user_admin') }} @endif</small>
    </h1>

    <div style="padding-bottom: 25px;">
        <button onclick="location.href='{{ route('form1-create')}}'" style="font-weight: normal;" class="btn btn-default btn-circle pull-right"><i class="glyphicon glyphicon-plus "></i> {{ __('home_user.file_claim') }}</button>
        <button onclick="location.href='{{ route('inquiry.create')}}'" style="margin-right: 5px; font-weight: normal;" class="btn btn-success btn-circle pull-right"><i class="glyphicon glyphicon-plus "></i>{{ __('home_user.open_inquiry') }}</button>
    </div>
</div>
<!-- END PAGE TITLE-->

<div class="row">
    <!-- above -->
    
    <div class="col-md-6 col-md-push-6">
        <div class="col-md-6 col-xs-6" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 default" href="{{ route('ttpm') }}">
                <div class="visual">
                    <i class="fa fa-user-secret"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="1349">{{ $ttpm }}</span>
                    </div>
                    <div class="desc"> {{ __('home_admin.ttpm_user')}} </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xs-6" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 default" href="{{ route('public') }}">
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">                                       
                    <div class="number">
                        <span data-counter="counterup" data-value="1349">{{ $citizen }}</span>
                    </div>
                    <div class="desc"> {{ __('home_admin.citizen')}} </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xs-6" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 default" href="{{ route('public') }}">
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="1349">{{ $noncitizen }}</span>
                    </div>
                    <div class="desc"> {{ __('home_admin.non_citizen')}} </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xs-6" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 default" href="{{ route('public') }}">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="1349">{{ $company }}</span>
                    </div>
                    <div class="desc"> {{ __('home_admin.company')}} </div>
                </div>
            </a>
        </div>
        <div class="col-md-12 col-xs-12" style="padding-left: 0px;">
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
                                <span class='font-grey-salt child' style="cursor: default;">{{ trans('home_user.no_available_announcement') }}</span>
                            </div>
                        @else

                        @foreach($announcements as $announcement)
                        <div class="item clickme" onclick='openAnnouncement({{ $announcement->announcement_id }})'>
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

                                        <span style='font-size: smaller' class="item-label font-green-sharp">{{ __('home_user.by') }} {{ $announcement->created_by->roleuser->first()->role->$display_name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="item-body" style="font-size: small">{{ substr($announcement->$description_lang,0,150) }}...</div>
                        </div>
                        @endforeach

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-md-pull-6" style="padding-right: 0px;">

        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="{{ route('onlineprocess.inquiry', ['branch' => 0]) }}">
                <div class="visual">
                    <i class="fa fa-question" style="opacity: .2"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $inquiry }}">{{ $inquiry }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.inquiry') }} </div>
                </div>
            </a>
        </div>
        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 yellow-lemon" href="{{ route('onlineprocess.form1', ['branch' => 0]) }}">
                <div class="visual">
                    <i class="fa fa-files-o" style="opacity: .2"></i>
                </div>
                <div class="details">                                       
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form1 }}">{{ $form1 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 1 </div>
                </div>
            </a>
        </div>
        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 red-pink" href="{{ route('onlineprocess.form2', ['branch' => 0, 'status' => 14]) }}">
                <div class="visual">
                    <i class="fa fa-files-o" style="opacity: .2"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form2 }}">{{ $form2 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 2 </div>
                </div>
            </a>
        </div>
        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 green-jungle" href="{{ route('onlineprocess.form3', ['branch' => 0, 'status' => 19]) }}">
                <div class="visual">
                    <i class="fa fa-files-o" style="opacity: .2"></i>
                </div>
                <div class="details">                                       
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form3 }}">{{ $form3 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 3 </div>
                </div>
            </a>
        </div>

        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="{{ route('onlineprocess.form4', ['branch' => 0, 'status' => 31]) }}">
                <div class="visual">
                    <i class="fa fa-files-o" style="opacity: .2"></i>
                </div>
                <div class="details">                                       
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form4 }}">{{ $form4 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 4 </div>
                </div>
            </a>
        </div>

        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 grey-silver" href="#">
                <div class="visual">
                    <i class="fa fa-gavel" style="opacity: .2"></i>
                </div>
                <div class="details">                                       
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form5 }}">{{ $form5 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}5 </div>
                </div>
            </a>
        </div>

        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 red-pink" href="#">
                <div class="visual">
                    <i class="fa fa-gavel" style="opacity: .2"></i>
                </div>
                <div class="details">                                       
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form6 }}">{{ $form6 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}6 </div>
                </div>
            </a>
        </div>

        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 red-haze" href="#">
                <div class="visual">
                    <i class="fa fa-gavel" style="opacity: .2"></i>
                </div>
                <div class="details">                                       
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form7 }}">{{ $form7 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}7 </div>
                </div>
            </a>
        </div>

        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 red-mint" href="#">
                <div class="visual">
                    <i class="fa fa-gavel" style="opacity: .2"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form8 }}">{{ $form8 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}8 </div>
                </div>
            </a>
        </div>

        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-gavel" style="opacity: .2"></i>
                </div>
                <div class="details">                                       
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form9 }}">{{ $form9 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}9 </div>
                </div>
            </a>
        </div>

        <div class="btn-box col-md-42 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 blue-sharp" href="#">
                <div class="visual">
                    <i class="fa fa-gavel" style="opacity: .2"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form10 }}">{{ $form10 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('new.award') }} {{ __('new.form_short') }}10 </div>
                </div>
            </a>
        </div>

        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 white" href="{{ route('onlineprocess.form11', ['branch' => 0]) }}">
                <div class="visual">
                    <i class="fa fa-files-o" style="opacity: .2"></i>
                </div>
                <div class="details">                                       
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form11 }}">{{ $form11 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 11 </div>
                </div>
            </a>
        </div>

        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 white" href="{{ route('onlineprocess.form12', ['branch' => 0, 'status' => 24]) }}">
                <div class="visual">
                    <i class="fa fa-files-o" style="opacity: .2"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $form12 }}">{{ $form12 }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('home_staff.form') }} 12 </div>
                </div>
            </a>
        </div>
        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 yellow-crusta" href="{{ route('others.suggestion') }}">
                <div class="visual">
                    <i class="fa fa-lightbulb-o" style="opacity: .2"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $suggestion }}">{{ $suggestion }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('menu.suggestion') }}</div>
                </div>
            </a>
        </div>
        <div class="btn-box col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
            <a class="dashboard-stat dashboard-stat-v2 dark-blue" href="{{ route('form4-transfer-list') }}">
                <div class="visual">
                    <i class="fa fa-exchange" style="opacity: .2"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $transfer }}">{{ $transfer }}</span>
                    </div>
                    <div class="desc bold" style="text-shadow: 1px 1px #909090;"> {{ __('menu.transfer') }}</div>
                </div>
            </a>
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
                <div style="text-align: center;"><div class="loader"></div></div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('after_scripts')
<script>
console.log($( window ).width());

$(".sidebar-toggler span").trigger( "click" );

$('#modalperanan').on('hidden.bs.modal', function(){
    $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>');
});

function openAnnouncement(id) {
    $('#modalperanan').modal('show')
        .find('#modalbodyperanan')
        .load('{{ url("others/announcement") }}/'+id+'/view_dashboard');
}
</script>

@endsection