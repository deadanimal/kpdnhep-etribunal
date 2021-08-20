<div id="step_2" class="row step_item">

    <div class="col-md-12 ">
        <!-- Opponent Details-->

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase">{{ __('form1.opponent_info') }} </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="" class="fullscreen"></a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <div class="form-group form-md-line-input">
							 <button type="button" id="addPenentangBtn" class="btn btn-primary btn-circle" data-toggle="modal"
                                data-target="#opponentFormModal"
                                data-backdrop="static" data-keyboard="false"><i
                                    class="fa fa-plus"></i> {{ __('form1.create_opponent') }}</button>   
							<p id="createPenentangMsg" style="color:red;display:none;margin-top:20px;">** Hanya satu penentang sahaja yang dibenarkan untuk setiap tuntutan.</p>
                    </div>
                    <div class="form-group form-md-line-input">
                        <div class=hidden">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered" id="complaints_table">
                                        <thead>
                                        <tr>
                                            <th width="50px">No.</th>
                                            <th width="50%">{{ __('form1.name') }}</th>
                                            <th width="25%">{{ __('form1.identification_no_opponent') }}</th>
                                            <th width="150px">{{ __('form1.action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($case == null || $case->multiOpponents == null)
                                            <tr id="complaints_table_no_data">
                                                <td colspan="5">{{ __('new.no_data_found') }}</td>
                                            </tr>
                                        @else
											<?php echo count($case->mutliOpponents); ?>
                                            @foreach($case->multiOpponents as $i => $opponent)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td><b>{{ucfirst($opponent->opponent_address->name)}}</b></td>
                                                    <td>{{$opponent->opponent_address->identification_no}}</td>
                                                    <td>
                                                        <button type="button" onclick="removeOpponent({{$opponent->id}})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('claimcase.form1.steps.modalStep2')
    </div>
</div>