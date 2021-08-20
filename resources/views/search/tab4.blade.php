<div class="portlet">
    <div class="portlet-body form">
        <form id="form1" method="get" action="{{ route('search.tab4') }}" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-4" style="text-align: right;">{{ __('new.f1_no') }} :</label>
                    <div class="col-md-6" style="display: inline-flex;">
                        <label class="control-label" style="margin-right: 7px;">B1 - </label>

                        <select onchange='resetBranch()' class="form-control input-xsmall" style="margin-right: 7px;" name="branch_code">
                            @foreach($branches as $i=>$branch)
                                <option value="{{ $branch->branch_code }}">{{ $branch->branch_code }}</option>
                            @endforeach
                        </select>
                        <label class="control-label" style="margin-right: 7px;"> - </label>
                        <input onchange='resetBranch()' class="form-control input-xsmall numeric" type="text" name="case_no" style="margin-right: 7px;">
                        <label class="control-label" style="margin-right: 7px;"> - </label>
                        <input onchange='resetBranch()' class="form-control input-xsmall numeric" type="text" name="case_no_2" value="{{ date('Y') }}" style="margin-right: 7px;">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" style="text-align: right;"> {{ __('new.branch') }} :</label>
                    <div class="col-md-6">
                        <select id="branch_id_4" class="form-control" name="branch_id" style="margin-right: 10px;">
                            <option value="0" selected>-- {{ __('form1.all_branch') }} --</option>
                            @foreach($branches as $i=>$branch)
                                <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="clearfix" >
                <div style="text-align: center;">
                    <button type="submit" class="btn default" onclick="history.back()" style="padding-left: 5px">
                        <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
                    </button>
                    <button type="submit" class="btn green" onclick="submitForm1()">
                        <i class="fa fa-paper-plane mr10"></i>{{ trans('button.search') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>