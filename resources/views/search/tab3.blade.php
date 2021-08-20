<div class="portlet">
    <div class="portlet-body form">
        <form id="filings" method="get" action="{{ route('search.tab3.index') }}" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-4" style="text-align: right;">{{ __('new.claim_no') }} :</label>
                    <div class="col-md-8" style="display: inline-flex;">
                        <label class="control-label" style="text-align: left;margin-right: 7px;">TTPM - </label>
                        <select class="form-control input-xsmall" name="branch_code" style="margin-right: 7px;">
                            @foreach($branches as $i=>$branch)
                                <option value="{{ $branch->branch_code }}">{{ $branch->branch_code }}</option>
                            @endforeach
                        </select>
                        <label class="control-label" style="margin-right: 7px;"> - ( </label>
                        <select class="form-control input-xsmall" style="margin-right: 7px;" name="category_code">
                            @foreach($claimcategory as $i=>$cat)
                                <option value="{{ $cat->category_code }}">{{ $cat->category_code }}</option>
                            @endforeach
                        </select>
                        <label class="control-label" style="margin-right: 7px;"> ) - </label>
                        <input class="form-control input-xsmall" type="text" name="serial_no" style="margin-right: 7px;">
                        <label class="control-label" style="margin-right: 7px;"> - </label>
                        <input class="form-control input-xsmall" type="text" name="year" value="{{ date('Y') }}" style="margin-right: 7px;">
                    </div>
                </div>

                <div id="row_branch" class="form-group">
                    <label class="control-label col-md-4">{{ __('new.branch') }} :</label>
                    <div class="col-md-6">
                        <select id="branch_id" class="form-control" name="branch_id" style="margin-right: 3px;">
                            <option value="" >-- {{ __('form1.all_branch') }} --</option>
                            @foreach($branches as $i=>$branch)
                                <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.claimant_name') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="cname" name="claimant_name">
                        <div class="form-control-focus"></div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.claimant_ic') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="ic_no" name="claimant_no">
                        <div class="form-control-focus"></div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.opponent_name') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="responder_name" name="opponent_name">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.opponent_ic') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="oic" name="opponent_no">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">{{ __('new.hearing_award') }} :</label>
                    <div class="col-md-8">
                        <div class="input-group input-large date-picker input-daterange" data-date-format="dd/mm/yyyy" >
                            <input type="text" class="form-control" name="hearing_start_date" id="start_date" >
                            <span class="input-group-addon"> {{ __('new.to') }} </span>
                            <input type="text" class="form-control" name="hearing_end_date" id="end_date"} >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">{{ __('new.filing_date') }} :</label>
                    <div class="col-md-8">
                        <div class="input-group input-large date-picker input-daterange" data-date-format="dd/mm/yyyy" >
                            <input type="text" class="form-control" value="{{\Carbon\Carbon::parse()->subYears(10)->startOfYear()->format('d/m/Y')}}" name="filing_start_date" id="start_date" >
                            <span class="input-group-addon"> {{ __('new.to') }} </span>
                            <input type="text" class="form-control" value="{{\Carbon\Carbon::parse()->endOfYear()->format('d/m/Y')}}" name="filing_end_date" id="end_date">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">{{ __('new.claim_category') }} :</label>
                    <div class="col-md-6">
                        <select id="claim_category" onchange="loadClassification()" class="form-control" name="category" style="margin-right: 10px;">
                            <option value="0" >-- {{ __('new.all') }} --</option>
                            @foreach($claimcategory as $i=>$category)
                                <option value="{{ $category->claim_category_id }}">{{ $category->$category_lang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ __('new.claim_classification') }} :</label>
                    <div class="col-md-6">
                        <select id="claim_classification" class="form-control" name="classification" style="margin-right: 10px;">
                            <option value="0" >-- {{ __('new.all') }} --</option>
                        </select>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.particular_claim') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="claim_details">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>

                {{-- <!-- <div class="form-group">
                    <label class="control-label col-md-4">{{ __('new.district') }} :</label>
                    <div class="col-md-6">
                        <select id="district" class="form-control" name="district" style="margin-right: 10px;">
                            <option value="" selected >{{ __('new.all') }}</option>
                            @foreach($district as $i=>$district)
                            <option value="{{ $district->district_id }}">{{ $district->district }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --> --}}

                <div id="claimant_nationality" class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.claimant_nationality') }} :</label>
                    <div class="col-md-6">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input id="is_hq_yes" name="is_claimant_citizen" value="1" class="md-checkboxbtn" type="radio">
                                <label for="is_hq_yes" >
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('new.citizen') }}
                                </label>
                            </div>
                            <div class="md-radio">
                                <input id="is_hq_no" id="is_hq_no" name="is_claimant_citizen" value="0" class="md-checkboxbtn" type="radio">
                                <label for="is_hq_no">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('new.non_citizen') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="opponent_nationality" class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.opponent_nationality') }} :</label>
                    <div class="col-md-6">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input id="is_citizen_yes" name="is_opponent_citizen" value="1" class="md-checkboxbtn" type="radio">
                                <label for="is_citizen_yes" >
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('new.citizen') }}
                                </label>
                            </div>
                            <div class="md-radio">
                                <input id="is_citizen_no" id="is_citizen_no" name="is_opponent_citizen" value="0" class="md-checkboxbtn" type="radio">
                                <label for="is_citizen_no">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('new.non_citizen') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.online_purchased') }} :</label>
                    <div class="col-md-6">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input id="is_online_yes" name="is_online" value="1" class="md-checkboxbtn" type="radio">
                                <label for="is_online_yes" >
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('new.s_yes') }}
                                </label>
                            </div>
                            <div class="md-radio">
                                <input id="is_online_no" name="is_online" value="0" class="md-checkboxbtn" type="radio">
                                <label for="is_online_no">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('new.s_no') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <div class="col-md-offset-4 col-md-8 mv20">
                    <button type="submit" class="btn default" onclick="history.back()"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
                    <button type="submit" class="btn green" onclick='submitFilings()'><i class="fa fa-paper-plane mr10"></i>{{ trans('button.search') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>