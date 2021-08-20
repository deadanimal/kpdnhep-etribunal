<div class="portlet">
    <div class="portlet-body form">
        <form id="suggestion" method="get" action="{{ route('search.tab1') }}" class="form-horizontal">
            <div class="form-body">
                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.name') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="name" name="name">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.ic') }} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="username" name="username">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="control-label col-md-4">{{ __('new.suggestion_details')}} :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="suggestion" name="suggestion">
                        <div class="form-control-focus"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <div class="col-md-offset-4 col-md-8 mv20">
                    <button type="button" class="btn default" onclick="history.back()">
                        <i class="fa fa-reply mr10"></i>{{ trans('new.back')}}
                    </button>
                    <button type="button" class="btn green" onclick='submitSuggestion()'>
                        <i class="fa fa-paper-plane mr10"></i>{{ trans('button.search') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
