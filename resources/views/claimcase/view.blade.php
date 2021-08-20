<?php
$locale = App::getLocale();
$status_lang = "hearing_status_" . $locale;
$race = "race_" . $locale;
$work = "occupation_" . $locale;
?>
@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <style>

        .control-label-custom {
            padding-top: 15px !important;
        }

        .m-b-5 {
            margin-bottom: 5px;
        }

        .tabbable-line > .nav-tabs > li {
            background-color: #f3f8f8 !important
        }

        .tabbable-line > .nav-tabs > li.active {
            background-color: #daecee !important
        }

    </style>
@endsection

@section('content')
    <div class="m-heading-1 border-green m-bordered margin-top-10 margin-bottom-10">
        <h3>{{ __('form4.claim_case_info') }} <b>{{ $claim_case->case_no }}</b></h3>
        <span> {{ __('form4.claim_case_details') }} </span>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('claimcase.form1_info')
            @include('claimcase.document_info')
            @include('claimcase.claim_info')
            @include('claimcase.hearing_info')
            @include('claimcase.claimant_info')
            @include('claimcase.opponent_info')
        </div>
    </div>
    <div class='row'>
        <div class="col-md-12" style="text-align: center;">
            <a class='btn default' onclick='history.back()'>{{ __('button.back_to_list') }}</a>
        </div>
    </div>
@endsection

@section('after_scripts')
    <script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
            type="text/javascript"></script>

    <script type="text/javascript">
      $('#table_hearings').DataTable({

        'language': {
          'aria': {
            'sortAscending': ": {{ trans('new.sort_asc') }}",
            'sortDescending': ": {{ trans('new.sort_desc') }}"
          },
          'processing': "<span class=\"font-md\">{{ trans('new.process_data') }}</span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
          'emptyTable': "{{ trans('new.empty_table') }}",
          'info': "{{ trans('new.info_data') }}",
          'infoEmpty': "{{ trans('new.no_data_found') }}",
          'infoFiltered': "{{ trans('new.info_filtered') }}",
          'lengthMenu': "{{ trans('new.length_menu') }}",
          'search': "{{ trans('new.search') }}",
          'zeroRecords': "{{ trans('new.zero_record') }}"
        }

      })
    </script>

    <script>

      $('#opponent_info').slideUp(0)
      $('#claimant_info').slideUp(0)

      function toggleOpponentInfo(counter) {
        $('#opponent_info_' + counter).slideToggle()
      }

      function toggleClaimantInfo() {
        $('#claimant_info').slideToggle()
      }

      @if(Session::has('form2_url'))

      swal({
          title: "{{ trans('swal.reminder') }}!",
          text: "{{ trans('swal.form2_not_filed') }}",
          type: 'warning',
          showCancelButton: true,
          closeOnConfirm: true,
          closeOnCancel: true,
          allowOutsideClick: true,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: "{{ trans('swal.file_f2') }}",
          cancelButtonText: "{{ trans('button.proceed_anyway') }}"
        },
        function (isConfirm) {
          if (isConfirm) {
            location.href = "{!! Session::get('form2_url')[0] !!}"
          } else {
            location.href = "{!! route('form12-create', ['form4_id' => Session::get('form2_url')[1], 'forced' => 'yes' ]) !!}"
          }
        })
        @endif

    </script>

@endsection