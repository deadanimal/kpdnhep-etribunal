<?php
$locale = App::getLocale();
$month_lang = "month_".$locale;
$category_lang ="category_".$locale;
?>


@extends('layouts.app')

@section('after_styles')

<style type="text/css">
    .data th,td {
        text-align: center;
        text-transform: uppercase;
        font-size: smaller !important;
    }

    .data th {
        vertical-align: middle !important;
        background-color: #428bca !important;
        color: #ffffff;
    }

    tfoot {
        vertical-align: middle !important;
        background-color: #428bca;
        color: #ffffff;
    }
       
</style>
@endsection

@section('content')
<!-- #start -->

<!-- BEGIN PAGE TITLE-->


<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">

        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-list"></i>
                    <span class="caption-subject bold uppercase">{{ trans('new.report29') }} </span>
                </div>
                <div class="tools"> </div>
            </div>
            <div style="margin-bottom: 20px;">
                <form method='get' action=''>
                    <div id="search-form" class="form-inline">
                        <div class="form-group mb10">
                            <label for="year">{{ trans('hearing.year') }} </label>
                            <select id="year" class="form-control" name="year">
                                @foreach($years as $i=>$year)
                                <option @if(Request::get('year') == $year) selected 
                                @elseif ($year == date('Y')) selected 
                                @endif value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="form-group mb10">
                            <label for="state">{{__('new.state')}} </label>
                            <select id="state" class="form-control" name="state">
                                <option value=" " selected >-- {{ __('new.all_state')}} --</option>
                                @foreach($states as $i=>$state)
                                <option @if(Request::get('state') == $state->state_id) selected 
                                @endif value="{{ $state->state_id }}">{{ $state->state }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="form-group mb10">
                            <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="portlet-body">
                <div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}<br>
{{ __('new.report29') }} <br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></div>

                <table class="table table-bordered table-hover data">
                    <thead>
                        <tr>
                            <th rowspan="2"> {{ __('new.district') }} </th>
                            <th colspan="{{ count($masterclaimcategories) }}"> {{ __('new.category') }} </th>
                            <th rowspan="2"> {{ __('new.total') }} </th>
                        </tr>
                        <tr style="text-transform: uppercase;">
                            @foreach($masterclaimcategories as $categories)
                            <th> {{ $categories->$category_lang }} </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($districts as $district)
                            <?php 
                                $claimcase = (clone $claimcases)->where('district_id', $district->district_id);
                                dd($claimcase);
                            ?>
                        <tr>
                            <td style="text-align: left; text-transform: uppercase;"> {{ $district->district }}</td>
                            @foreach($masterclaimcategories as $index => $mce)
                            <?php
                                $case = (clone $claimcases)->where('district_id', $district->district_id)->where('category_id', $mce->claim_category_id);
                            ?>
                            <td> {{ count($case) }} </td>
                            @endforeach
                            <td>{{ count($claimcase) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>{{__('new.total')}}</td>
                            @foreach($masterclaimcategories as $mce)
                            <?php
                                $claimcase = (clone $claimcases)->where('category_id', $mce->claim_category_id);
                            ?>
                            <td> {{ count($claimcase) }} </td>
                            @endforeach
                            <td>{{ count($claimcases) }}</td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">
        <a type="button" class="btn default" href='{{ route("report.list", ["page" => 3]) }}'>
            <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
        </a>
        <button type="button" class="btn purple btn-outline" onclick="exportExcel()"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
    </div>
</div>
@endsection

@section('after_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->

<script>
function exportExcel() {
    location.href = "{{ url('') }}/report/report29/export/excel?{!! http_build_query(request()->input()) !!}";
}

var myDataTables = $('table').DataTable( {
    dom: 'Bfrtip',
    ordering: false,
    processing: false,
    serverSide: false,
    searching: false,
    bInfo : false,
    paging: false,
    buttons: [
        {
            extend: 'excel',
            className: 'btn yellow btn-outline hidden',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: $('#title').html().replace( /<br>/g, " " ),
            text:'<i class="fa fa-file-excel-o margin-right-5"></i> Excel'
        },
        {
            extend: 'pdfHtml5',
            className: 'btn green btn-outline hidden',
            orientation: 'landscape',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: '',
            text:'<i class="fa fa-file-pdf-o margin-right-5"></i> Print As PDF',
            customize: function ( doc ) {
                // Splice the image in after the header, but before the table
                doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 12 ],
                    alignment: 'center',
                    text: $('#title').html().replace( /<br>/g, " " ),
                } );
                // Data URL generated by http://dataurl.net/#dataurlmaker
            }
        },
    ],
    language: {
        "aria": {
            "sortAscending": ": {{ trans('new.sort_asc') }}",
            "sortDescending": ": {{ trans('new.sort_desc') }}"
        },
        "processing": "<span class=\"font-md\">{{ trans('new.process_data') }}</span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
        "emptyTable": "{{ trans('new.empty_table') }}",
        "info": "{{ trans('new.info_data') }}",
        "infoEmpty": "{{ trans('new.no_data_found') }}",
        "infoFiltered": "{{ trans('new.info_filtered') }}",
        "lengthMenu": "{{ trans('new.length_menu') }}",
        "search": "{{ trans('new.search') }}",
        "zeroRecords": "{{ trans('new.zero_record') }}"
    },

} );

function exportTo(buttonSelector){
    $(".buttons-"+buttonSelector).click();
}
</script>
@endsection