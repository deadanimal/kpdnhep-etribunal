
@extends('layouts.app')
@section('after_styles')

<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="fa fa-cog font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('menu.settings') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#portlet_tab3" onclick='updatePage(3)' data-toggle="tab"> {{ __('new.general') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab4" onclick='updatePage(4)' data-toggle="tab"> {{ __('new.system') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab1" onclick='updatePage(1)' data-toggle="tab"> {{ __('new.database') }} </a>
                    </li>
                    <li>
                        <a href="#portlet_tab2" onclick='updatePage(2)' data-toggle="tab"> {{ __('new.email') }} </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane" id="portlet_tab1">
                        <form id="form_database" action="{{ route('settings.store') }}" method="post" class="form-horizontal ">
                            <div class="form-body">
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.database_type') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="type" name='DB_CONNECTION' value='{{ env("DB_CONNECTION") }}' unupper="unUpper" placeholder="mysql / sqlsrv / sqlite / pgsql">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.host') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="host" name='DB_HOST' value='{{ env("DB_HOST") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.port') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control numeric" id="port" name='DB_PORT' value='{{ env("DB_PORT") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.database_name') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="name" name='DB_DATABASE' value='{{ env("DB_DATABASE") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.username') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="user" name='DB_USERNAME' value='{{ env("DB_USERNAME") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.password') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="password" name='DB_PASSWORD' value='{{ env("DB_PASSWORD") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.backup_timeout') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="backup_timeout" name='DB_DUMP_TIMEOUT' value='{{ env("DB_DUMP_TIMEOUT") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="portlet_tab2">
                        <form id="form_email" action="{{ route('settings.store') }}" method="post" class="form-horizontal ">
                            <div class="form-body">
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.mail_driver') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="driver" name="MAIL_DRIVER" value='{{ env("MAIL_DRIVER") }}' unupper="unUpper" placeholder="sendmail / smtp / mailgun / mandrill / ses">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.host') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="host" name="MAIL_HOST" value='{{ env("MAIL_HOST") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.port') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="port" name="MAIL_PORT" value='{{ env("MAIL_PORT") }}' unupper="unUpper" placeholder="25 / 465 / 587 / 2525">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.username') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="username" name="MAIL_USERNAME" value='{{ env("MAIL_USERNAME") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.password') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="password" name="MAIL_PASSWORD" value='{{ env("MAIL_PASSWORD") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.sender_name') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="sender_name" name="MAIL_FROM_NAME" value='{{ env("MAIL_FROM_NAME") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.sender_email') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="sender_email" name="MAIL_FROM_ADDRESS" value='{{ env("MAIL_FROM_ADDRESS") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.encryption') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="sender_name" name="MAIL_ENCRYPTION" value='{{ env("MAIL_ENCRYPTION") }}' unupper="unUpper" placeholder="tls / ssl">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane active" id="portlet_tab3">
                        <form id="form_general" action="{{ route('settings.store') }}" method="post" class="form-horizontal ">
                            <div class="form-body">
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.website_name') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="website_name" name="APP_NAME" value='{{ env("APP_NAME") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.environment') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="environment" name="APP_ENV" value='{{ env("APP_ENV") }}' unupper="unUpper" placeholder="local / production">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.debug_mode') }} :</label>
                                    <div class="col-md-6">
                                        <!-- <input type="text" class="form-control" id="debug_mode" name="APP_DEBUG" value='{{ env("APP_DEBUG") ? "true" : "false" }}' unupper="unUpper" placeholder="true / false"> -->
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input id="debug_mode_yes" name="APP_DEBUG" class="md-checkboxbtn" @if(env("APP_DEBUG")) checked @endif type="radio" value="true">
                                                <label for="debug_mode_yes">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('form1.yes') }}
                                                </label>
                                            </div>
                                            <div class="md-radio">
                                                <input id="debug_mode_no" name="APP_DEBUG" class="checkboxbtn" @if(!env("APP_DEBUG")) checked @endif type="radio" value="false">
                                                <label for="debug_mode_no">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('form1.no') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.website_url') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="website_url" name="APP_URL" value='{{ env("APP_URL") }}' unupper="unUpper">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="portlet_tab4">
                        <form id="form_system" action="{{ route('settings.store') }}" method="post" class="form-horizontal ">
                            <div class="form-body">
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.fpx_enable') }} :</label>
                                    <div class="col-md-6">
                                        <!-- <input type="text" class="form-control" id="fpx" name="CONF_FPX_ENABLE" value='{{ env("CONF_FPX_ENABLE") ? "true" : "false" }}' unupper="unUpper" placeholder="true / false"> -->
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input id="fpx_yes" name="CONF_FPX_ENABLE" class="md-checkboxbtn" @if(env("CONF_FPX_ENABLE")) checked @endif type="radio" value="true">
                                                <label for="fpx_yes">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('form1.yes') }}
                                                </label>
                                            </div>
                                            <div class="md-radio">
                                                <input id="fpx_no" name="CONF_FPX_ENABLE" class="checkboxbtn" @if(!env("CONF_FPX_ENABLE")) checked @endif type="radio" value="false">
                                                <label for="fpx_no">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('form1.no') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.user_login_enable') }} :</label>
                                    <div class="col-md-6">
                                        <!-- <input type="text" class="form-control" id="host" name="CONF_USER_LOGIN_ENABLE" value='{{ env("CONF_USER_LOGIN_ENABLE") ? "true" : "false" }}' unupper="unUpper" placeholder="true / false"> -->
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input id="host_yes" name="CONF_USER_LOGIN_ENABLE" class="md-checkboxbtn" @if(env("CONF_USER_LOGIN_ENABLE")) checked @endif type="radio" value="true">
                                                <label for="host_yes">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('form1.yes') }}
                                                </label>
                                            </div>
                                            <div class="md-radio">
                                                <input id="host_no" name="CONF_USER_LOGIN_ENABLE" class="checkboxbtn" @if(!env("CONF_USER_LOGIN_ENABLE")) checked @endif type="radio" value="false">
                                                <label for="host_no">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>{{ __('form1.no') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.f1_matured_duration') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="port" name="CONF_F1_MATURED_DURATION" value='{{ env("CONF_F1_MATURED_DURATION") }}' unupper="unUpper" placeholder="{{ __('new.no_of_days') }}">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.f2_matured_duration') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="port" name="CONF_F2_MATURED_DURATION" value='{{ env("CONF_F2_MATURED_DURATION") }}' unupper="unUpper" placeholder="{{ __('new.no_of_days') }}">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.f3_matured_duration') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="port" name="CONF_F3_MATURED_DURATION" value='{{ env("CONF_F3_MATURED_DURATION") }}' unupper="unUpper" placeholder="{{ __('new.no_of_days') }}">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.hearing_alert_duration') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="port" name="CONF_HEARING_ALERT_DURATION" value='{{ env("CONF_HEARING_ALERT_DURATION") }}' unupper="unUpper" placeholder="{{ __('new.no_of_days') }}">
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="control-label col-md-4">{{ __('new.hearing_submission_duration') }} :</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="port" name="CONF_HEARING_SUBMISSION_DURATION" value='{{ env("CONF_HEARING_SUBMISSION_DURATION") }}' unupper="unUpper" placeholder="{{ __('new.no_of_days') }}">
                                        <div class="form-control-focus"> </div>
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
<div class="clearfix">
    <div class="col-md-offset-4 col-md-8 mv20">
        <button type="button" class="btn default"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
        <button type="button" onclick='submitForm()' class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.update') }}</button>
    </div>
</div>
@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script>
    var page = 3;

    function updatePage(id) {
        page = id;
        //console.log(page);
    }

    function submitForm() {

        if(page == 1)
            var form = $('#form_database');
        else if(page == 2)
            var form = $('#form_email');
        else if(page == 3)
            var form = $('#form_general');
        else if(page == 4)
            var form = $('#form_system');
        else
            return;

        form.submit();

        //console.log(page);
    }

    $("form").submit(function(e){
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: form.attr('method'),
            data: new FormData(form[0]),
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            beforeSend: function() {
                
            },
            success: function(data) {
                if(data.status=='ok'){
                    swal({
                        title: "{{ __('new.success') }}",
                        text: "{{ __('new.update_success') }}", 
                        type: "success"
                    },
                    function () {
                    });
                } else {
                    var inputError = [];

                    console.log(Object.keys(data.message)[0]);
                    if($("input[name='"+Object.keys(data.message)[0]+"']").is(':radio') || $("input[name='"+Object.keys(data.message)[0]+"']").is(':checkbox')){
                        var input = $("input[name='"+Object.keys(data.message)[0]+"']");
                    } else {
                        var input = $('#'+Object.keys(data.message)[0]);
                    }

                    $('html,body').animate(
                        {scrollTop: input.offset().top - 100},
                        'slow', function() {
                            //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                            input.focus();
                        }
                    );

                    $.each(data.message,function(key, data){
                        if($("input[name='"+key+"']").is(':radio') || $("input[name='"+key+"']").is(':checkbox')){
                            var input = $("input[name='"+key+"']");
                        } else {
                            var input = $('#'+key);
                        }
                        var parent = input.parents('.form-group');
                        parent.removeClass('has-success');
                        parent.addClass('has-error');
                        parent.find('.help-block').html(data[0]);
                        inputError.push(key);
                    });

                    $.each(form.serializeArray(), function(i, field) {
                        if ($.inArray(field.name, inputError) === -1)
                        {
                            if($("input[name='"+field.name+"']").is(':radio') || $("input[name='"+field.name+"']").is(':checkbox')){
                                var input = $("input[name='"+field.name+"']");
                            } else {
                                var input = $('#'+field.name);
                            }
                            var parent = input.parents('.form-group');
                            parent.removeClass('has-error');
                            parent.addClass('has-success');
                            parent.find('.help-block').html('');
                        }
                    });
                }
            },
            error: function(xhr){
                console.log(xhr.status);
            }
        });
        return false;
    });
</script>

@endsection