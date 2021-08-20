<?php
if (Auth::user()->hasRole('ks') || Auth::user()->hasRole('psu'))
    if (Auth::user()->ttpm_data->branch_id == $claim_case->branch_id)
        $allow = true;
    else $allow = false;
else $allow = true;

$locale = App::getLocale();
$category_lang = "category_" . $locale;
$classification_lang = "classification_" . $locale;
$offence_lang = "offence_description_" . $locale;
$status_lang = "status_" . $locale;
$race = "race_" . $locale;
$work = "occupation_" . $locale;
?>

@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet"
          type="text/css"/>
    <style>

        .control-label-custom {
            padding-top: 15px !important;
        }

    </style>
@endsection

@section('heading', 'Roles')


@section('content')

    <div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
        <h3>{{ __('form2.form2_details') }}</h3>
        <span> {{ trans('form2.form2_view') }} </span>
    </div>
    <div class="row">
        <div class="col-xs-12" style="text-align: right;">
            <div id='buttonDiv' class="btn-group">
                @if($claim_case_oppo->form2)
                    @if($claim_case->claimant_user_id == $userid || $is_staff )
                        @if($claim_case->case_status_id == 4 && $allow && $claim_case_oppo->form2->counterclaim_id)
                            <a class="btn green-sharp"
                               href="{{ route('form3-create', ['claim_case_id'=>$claim_case_oppo->id]) }}"
                               style='margin-bottom: 10px; margin-left: 5px;'>
                                <i class="fa fa-add"></i>{{ trans('button.file_form3') }}
                            </a>
                        @endif
                    @endif
                    @if($claim_case->case_status_id > 5)
                        @if($claim_case_oppo->form2->form3)
                            <a class="btn green-sharp"
                               href="{{ route('form3-view', ['claim_case_id'=>$claim_case_oppo->id]) }}"
                               style='margin-bottom: 10px; margin-left: 5px;'>
                                <i class="fa fa-search"></i>{{ trans('home_user.view_f3') }}
                            </a>
                        @endif
                    @endif
                    @if($allow)
                        @if($is_staff || (!$is_staff && $claim_case_oppo->form2->form_status_id == 18 && $claim_case_oppo->opponent_user_id == Auth::id()) )
                            <a class="btn green-meadow btn-outline"
                               href="{{ route('form2-edit', ['id' => $claim_case_oppo->id]) }}"
                               style='margin-bottom: 10px; margin-left: 5px;'>
                                <i class="fa fa-edit"></i> {{ trans('button.edit') }}
                            </a>
                        @endif
                        @if($is_staff && $claim_case_oppo->form2->form_status_id != 22)
                            <a class="btn purple btn-outline" href="javascript:;"
                               onclick='processForm2({{ $claim_case_oppo->id }})'
                               style='margin-bottom: 10px; margin-left: 5px;'>
                                <i class="fa fa-spinner"></i> {{ trans('button.process') }}
                            </a>
                        @endif
                    @endif
                    @if($claim_case_oppo->form2->form_status_id == 22)
                        <div class="btn-group pull-right">
                            <a class="btn yellow btn-outline" href="javascript:;"
                               style='margin-bottom: 10px; margin-left: 5px;' data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-download"></i> {{ trans('form2.download') }}
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:;" onclick="exportPDF('{{ $claim_case_oppo->id }}')">
                                        <i class="fa fa-file-pdf-o"></i> PDF
                                    </a>
                                </li>
                                @if(!Auth::user()->hasRole('user'))
                                    <li>
                                        <a href="javascript:;" onclick="exportDOCX('{{ $claim_case_oppo->id }}')">
                                            <i class="fa fa-file-text-o"></i> DOCX
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('claimcase.form1_info')
            @include('claimcase.claimant_info')
            @include('claimcase.opponent_info')
            @include('claimcase.transaction_info')
            @include('claimcase.claim_info')
            @if($claim_case_oppo->form2->form2_id) @if($payments)
                @include('claimcase.payment_info')
            @endif @endif
            @if($attachments) @if($attachments->count() > 0)
                @include('claimcase.document_info')
            @endif @endif
            @include('claimcase.defence_counter_info')
            @include('claimcase.hearing_info')
            @if($claim_case_oppo->form2->form2_id) @if($claim_case_oppo->form2->form_status_id == 22)
                @include('claimcase.process_info')
            @endif @endif
        </div>
    </div>
    <div class='row'>
        <div class="col-md-12" style="text-align: center;">
            <a class='btn default' href='{{ route("form2-list") }}'>{{ __('button.back_to_list') }}</a>
        </div>
    </div>
@endsection

@section('after_scripts')
    <script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script type="text/javascript">

      $('#opponent_info').slideUp(0)
      $('#claimant_info').slideUp(0)

      function toggleOpponentInfo(counter) {
        $('#opponent_info_' + counter).slideToggle()
      }

      function toggleClaimantInfo() {
        $('#claimant_info').slideToggle()
      }

      function exportPDF(id) {
        location.href = "{{ url('') }}/form2/" + id + '/export/pdf'
      }

      function exportDOCX(id) {
        location.href = "{{ url('') }}/form2/" + id + '/export/docx'
      }

      function processForm2(id) {
        $('#modalDiv').load("{{ url('/') }}/form2/" + id + '/process')
      }

    </script>

@endsection