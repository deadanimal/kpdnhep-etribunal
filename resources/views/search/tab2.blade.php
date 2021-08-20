<div class="portlet">
    <div class="portlet-body form">
        <form id="question" method="get" action="{{ route('search.tab2') }}" class="form-horizontal">
            <div class="form-body">
                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.question_no') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="question_no" name="question_no">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.claimant_name') }} :</label>
                    <div class="col-md-6">
                        <input type="text" id="claim_name" name="claim_name" class="form-control">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.claimant_ic') }} :</label>
                    <div class="col-md-6">
                        <input id="claim_identity" name="claim_identity" type="text" class="form-control" >
                        <div class="form-control-focus"> </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.opponent') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="responder_name" name="responder_name">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.opponent_ic') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="responder_company" name="responder_company">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.question_details') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="question_detail" name="question_detail">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <div class="col-md-offset-4 col-md-8 mv20">
                    <button type="button" class="btn default" onclick="history.back()"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
                    <button type="button" class="btn green" onclick='submitQuestion()'><i class="fa fa-paper-plane mr10"></i>{{ trans('button.search') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
