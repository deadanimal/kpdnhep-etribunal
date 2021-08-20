@extends('layouts.app')

@section('after_styles')

@endsection

@section('content')
<style>
th, input { 
    text-align: center;
    font-weight:normal;
}

th,td {
    text-align: center;
    text-transform: uppercase;
    font-size: smaller !important;
}

th {
    vertical-align: middle !important;
    background-color: #428bca !important;
    color: #ffffff;
}
</style>
        

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span id='title' class="caption-subject uppercase bold">{{ __('new.record_seminar') }} {{ __('new.year') .' '.$year }}</span> 
        </div>
        <div class="tools"> 
            <a href="" class="collapse"></a>
            <a href="" class="fullscreen"></a>
        </div>
    </div>
    <div style="margin-bottom: 20px;">
        <form method='get' action=''>
            <div id="search-form" class="form-inline">
                <div class="form-group mb10">
                    <label for="year">{{ trans('hearing.year') }} </label>
                    <select id="year" class="form-control" name="year" style="margin-right: 10px;">
                        @foreach($years as $i=>$year)
                        <option
                        @if(Request::get('year') == $year) selected 
                        @elseif(date('Y') == $year) selected
                        @endif
                        value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb10">
                    <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                </div>
            </div>
        </form>
    </div> 
    {{ Form::open(['route' => 'report13-update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
    <input type='hidden' name='year' value='{{ Request::has('year') ? Request::get('year') : date('Y') }}'/>
    
    <div class="portlet-body">
        <table id="report10" class="table table-striped table-bordered table-hover table-responsive table-export">
        <thead align="center">
            <th>{{ __('new.state') }} / {{ __('new.branch') }} </th>
            <th>{{ __('new.total_seminar') }}</th>
            <th>{{ __('new.total_participant') }}</th>
        </thead>
        <tbody align="center">
            @foreach( $states as $state )

            <?php
                // dapatkan value bagi curren
                $val = (clone $record_seminar)->where('state_id', $state->state_id);
            ?>

             <tr align="center">
                <td>{{ $state->state_name }}</td>
                <td><input type="text" class="form-control input-xsmall center-block numeric" name="seminar_{{ $state->state_id }}" placeholder="" 
                @if($val->get()->count() > 0)
                    value="{{ $val->first()->total_seminar }}"
                @else
                    value="0"
                @endif
                ></td>
                <td><input type="text" class="form-control input-xsmall center-block numeric" name="participant_{{ $state->state_id }}" placeholder="" 
                @if($val->get()->count() > 0)
                    value="{{ $val->first()->total_participant }}"
                @else
                    value="0"
                @endif
                ></td>
   
            </tr>
            @endforeach
        </tbody>

        </table>
        <div class="clearfix">
            <div class="col-md-offset-4 mv20">
                <a type="button" class="btn default" href='{{ route("report.list", ["page" => 2]) }}'>
                    <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
                </a>
                <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.save') }}</button>
                <button type="button" class="btn purple btn-outline"  onclick="exportExcel()"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
                <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i class="fa fa-print mr10"></i>{{ trans('button.print') }}</button>
            </div>

        </div>
    </div>
</div>
{{ Form::close() }}

@endsection

@section('after_scripts')

<!--end sweetalert -->
<script type="text/javascript">

function exportPDF() {
    location.href = "{{ url('') }}/report/report13/export/pdf?{!! http_build_query(request()->input()) !!}";
}
function exportExcel() {
    location.href = "{{ url('') }}/report/report13/export/excel?{!! http_build_query(request()->input()) !!}";
}

$("#submitForm").submit(function(e){

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
                    //window.location.href = "{{ route('report.list') }}";
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

<script>
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

    $("table input").each(function() {
        $( this ).addClass('hidden');
        var value = $( this ).val();
        $( this ).parent().append( value );
    });

    myDataTables.destroy();

    myDataTables = $('table').DataTable( {
        dom: 'Bfrtip',
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

    $(".buttons-"+buttonSelector).click();

    $("table input").each(function() {
        $( this ).removeClass('hidden');
        var value = $( this ).clone();
        $( this ).parent().html( value );
    });
}
</script>

@endsection