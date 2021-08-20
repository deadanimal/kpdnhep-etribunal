<?php
$locale = App::getLocale();
$category_lang = "category_" . $locale;
$classification_lang = "classification_" . $locale;
$offence_lang = "offence_description_" . $locale;
$status_lang = "status_" . $locale;
$race = "race_" . $locale;
$work = "occupation_" . $locale;

if (Auth::user()->hasRole('ks') || Auth::user()->hasRole('psu'))
    if (Auth::user()->ttpm_data->branch_id == $claim_case->branch_id)
        $allow = true;
    else $allow = false;
else $allow = true;
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

        .row {
            margin: 0px;
        }

        .page-content {
            padding: 0px !important;
        }

        .form-group div {
            font-size: 13px;
            padding: 10px !important;
        }

        .camelcase {
            text-transform: capitalize !important;
        }

    </style>
@endsection

@section('heading', 'Roles')

@section('content')

    <div class="row" style="margin: 0px">

        <div class="col-xs-12" style="text-align: right; margin-top: 15px;">

            <a class='btn default pull-left' href='{{ route("form1-list") }}'>{{ __('button.back_to_list') }}</a>

            <div id='buttonDiv' class="btn-group">

                @if($claim_case->form1_id)
                    @if($allow)
                        @if($is_staff || (!$is_staff && $claim_case->form1->form_status_id == 13 && $claim_case->claimant_user_id == Auth::id()) )
                            <a class="btn green-meadow"
                               href="{{ route('form1-edit', ['id' => $claim_case->claim_case_id]) }}"
                               style='margin-bottom: 10px; margin-left: 5px;'>
                                <i class="fa fa-edit"></i> {{ trans('button.edit') }}
                            </a>
                        @endif
                        @if($is_staff && $claim_case->form1->form_status_id != 17)
                            <a class="btn purple" href="javascript:;"
                               onclick='processForm1({{ $claim_case->claim_case_id }})'
                               style='margin-bottom: 10px; margin-left: 5px;'>
                                <i class="fa fa-spinner"></i> {{ trans('button.process') }}
                            </a>
                        @endif
                    @endif
                    @if($claim_case->form1->form_status_id == 17)
                        <div class="btn-group pull-right">
                            <a class="btn yellow" href="javascript:;" style='margin-bottom: 10px; margin-left: 5px;'
                               data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-download"></i> {{ trans('form1.download') }}
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:;" onclick="exportPDF('{{ $claim_case->claim_case_id }}')">
                                        <i class="fa fa-file-pdf-o"></i> PDF
                                    </a>
                                </li>
                                @if($is_staff)
                                    <li>
                                        <a href="javascript:;" onclick="exportDOCX('{{ $claim_case->claim_case_id }}')">
                                            <i class="fa fa-file-text-o"></i> DOCX
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                @else
                    <a class="btn green-meadow" href="{{ route('form1-edit', ['id' => $claim_case->claim_case_id]) }}"
                       style='margin-bottom: 10px; margin-left: 5px;'>
                        <i class="fa fa-edit"></i> {{ trans('button.edit') }}
                    </a>
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
            @if($claim_case->form1_id) @if($payments)
                @include('claimcase.payment_info')
            @endif @endif
            @if($attachments)
                @if($attachments->count() > 0)
                    @include('claimcase.document_info')
                @endif
            @endif
            @include('claimcase.hearing_info')
            @if($claim_case->form1_id) @if($claim_case->form1->form_status_id == 17)
                @include('claimcase.process_info')
            @endif @endif
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
        location.href = "{{ url('') }}/form1/" + id + '/export/pdf'
      }

      function exportDOCX(id) {
        location.href = "{{ url('') }}/form1/" + id + '/export/docx'
      }

      function processForm1(id) {
        $('#modalDiv').load("{{ url('/') }}/form1/" + id + '/process')
      }

    </script>

@endsection
