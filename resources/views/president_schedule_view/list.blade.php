@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('heading', 'Roles')


@section('content')
<div class="row margin-top-10">
  <div class="col-md-12">
    <div class="portlet light bordered">
          <div class="caption font-dark"> 
              <span class="caption-subject bold uppercase"><h3>{{ __('new.list_by_date')}}</h3></span>      
          </div>
      </div>
    </div>
 

@foreach ($hearings as $hearing)
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-dark"> 
              <h4 class="modal-title"><strong>{{ $hearing->president ?  $hearing->president->name : ''}}</strong></h4>
              <br>
             <span class="caption-subject bold uppercase">{{ $hearing->branch ? $hearing->branch->branch_name : '' }}</span>
             <br>     
             <span class="caption-subject bold uppercase">{{ $hearing->hearing_date ? date('d/m/Y', strtotime($hearing->hearing_date)) : '' }}</span>
             <br>
             <span class="caption-subject bold uppercase">{{ $hearing->hearing_time ? date('h:i a', strtotime($hearing->hearing_time)) : '' }}</span>
              <br>
             <span class="caption-subject bold uppercase">{{ $hearing->hearing_room ? $hearing->hearing_room->hearing_room : '' }}</span>
          </div>
          <div class="tools"> </div>
      </div>
      <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-responsive">
        <thead>
          <tr>
            <th width="3%">{{ trans('new.no') }}</th>
            <th>{{ __('new.claimcase')}}</th>
            <th>{{ __('new.claimant_name')}}</th>
            <th>{{ __('new.opponent_name')}}</th>
            <th style="width: 120px;">{{ trans('new.action') }}</th>
          </tr>
        </thead>
        <tbody>
      @if($hearing->form4)
        @foreach($hearing->form4 as $index=>$form4)
          @if($form4->case)
            <tr>
              <td>{{ $index+1 }}</td>
              <td>{{ $form4->case ? $form4->case->case_no : '' }}</td> 
              <td>{{ $form4->case->claimant ? $form4->case->claimant->name : '' }}</td> 
              <td>{{ $form4->case->opponent ? $form4->case->opponent->name : '' }}</td> 
              <td>
                @if($form4->case->form1_id)
                  <a href="{{ route('form1-view', ['id' =>  $form4->claim_case_id]) }}" class="btn btn-default">{{ __('form1.form1')}}</a>
                
                  @if($form4->claimCaseOpponent && $form4->claimCaseOpponent->form2)
                    <a href="{{ route('form2-view', ['id' => $form4->claim_case_opponent_id]) }}" class="btn btn-default">{{ __('form2.form2')}}</a>
                  
                    @if($form4->claimCaseOpponent->form2->form3)
                     <a href="{{ route('form3-view', ['id' => $form4->claim_case_opponent_id]) }}" class="btn btn-default">{{ __('form3.form3')}}</a>
                    @endif
                  @endif
                @endif

              </td>
              
            </tr>
          @endif
        @endforeach
      @endif
        </tbody>
        </table>
    </div>
  </div>
</div>

@endforeach

<div class="clearfix">
    <div class="col-md-offset-5 mv20">
        <button type="button" class="btn default" onclick="history.back()"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
    </div>
</div>


<div class="modal fade bs-modal-lg" id="modalperanan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('new.occupation_info') }}</h4>
            </div>
            <div class="modal-body" id="modalbodyperanan" style="padding: 0px;">
                <div style="text-align: center;"><div class="loader"></div></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
<!--end sweetalert -->
<script type="text/javascript">
$('body').on('click', '.btnModalPeranan', function(){
    $('#modalperanan').modal('show')
        .find('#modalbodyperanan')
        .load($(this).attr('value'));
});
$('#modalperanan').on('hidden.bs.modal', function(){
    $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>');
});
</script>
@endsection