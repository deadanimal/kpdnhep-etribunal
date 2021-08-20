{{ Html::style(URL::to('/assets/global/plugins/dropify/css/dropify.min.css')) }}
<style>

    .control-label-custom  {
        padding-top: 15px !important;
    }

    .clickme {
        cursor: pointer !important;
    }

</style>

<div id="modalSuggestion" class="modal fade" id="full" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ __('others.add_suggestion') }}</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(['route' => 'others.suggestion.store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
                <div>
                    <div id="subject" class="form-group form-md-line-input">
                        <label for="subject" id="subject" class="control-label col-md-4">{{ __('new.subject')}} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <input type='text' id='subject' name='subject' class="form-control">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div id="suggestion" class="form-group form-md-line-input">
                        <label for="suggestion" id="suggestion" class="control-label col-md-4">{{ __('new.comments')}} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <textarea id="suggestion" name="suggestion" class="form-control" rows="5" placeholder=""></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label class="control-label col-md-4">{{ __('form1.supporting_docs')}} :
                            <span>&nbsp;&nbsp;</span>
                        </label>
                        <div class="col-md-6">
                            <div class="m-heading-1 border-green m-bordered">
                                {!! __('new.dropify_msg') !!}
                            </div>
                            <div style="display: flex; flex-wrap: wrap;">
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_1" name="attachment_1" class="dropify" @if($attachments) @if($attachments->get(0))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(0)->attachment_id, 'filename' => $attachments->get(0)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_2" name="attachment_2" class="dropify" @if($attachments) @if($attachments->get(1))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(1)->attachment_id, 'filename' => $attachments->get(1)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_3" name="attachment_3" class="dropify" @if($attachments) @if($attachments->get(2))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(2)->attachment_id, 'filename' => $attachments->get(2)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_4" name="attachment_4" class="dropify" @if($attachments) @if($attachments->get(3))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(3)->attachment_id, 'filename' => $attachments->get(3)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_5" name="attachment_5" class="dropify" @if($attachments) @if($attachments->get(4))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(4)->attachment_id, 'filename' => $attachments->get(4)->attachment_name])}}"@endif @endif data-max-file-size="2M" data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{ __('button.cancel') }}</button>
                <button type="button" onclick='submitForm()' class="btn green">{{ __('button.submit') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}
<script>
    $("#modalSuggestion").modal('show');


    $('.dropify').dropify({
        messages: {
            'default': '',
            'replace': '',
            'remove': '{!! __("new.dropify_msg_remove") !!}',
            'error': '{!! __("new.dropify_msg_error") !!}'
        },
        error: {
            'fileSize': '{!! __("new.dropify_error_fileSize") !!}',
            'imageFormat': '{!! __("new.dropify_error_imageFormat") !!}'
        }
    });

    function submitForm() {
        $("#submitForm").submit();
    }
    //////////////////////file//////////////////////////////
    var file1_info = 0, file2_info = 0, file3_info = 0, file4_info = 0, file5_info = 0;
    @if($attachments)
        @if($attachments->get(0))
            file1_info = 1;
        @endif
        @if($attachments->get(1))
            file2_info = 1;
        @endif
        @if($attachments->get(2))
            file3_info = 1;
        @endif
        @if($attachments->get(3))
            file4_info = 1;
        @endif
        @if($attachments->get(4))
            file5_info = 1;
        @endif
    @endif

    // Add events. Grab the files and set them to our variable
    $('#attachment_1').on('change', function(event){
        file1_info = 2;
    });

    $('#attachment_2').on('change', function(event){
        file2_info = 2;
    });

    $('#attachment_3').on('change', function(event){
        file3_info = 2;
    });

    $('#attachment_4').on('change', function(event){
        file4_info = 2;
    });

    $('#attachment_5').on('change', function(event){
        file5_info = 2;
    });

     $('.dropify-clear').on('click', function(){
        $(this).siblings('input').trigger('change');
        console.log('remove button clicked!');
    });

     ////////////////////file///////////////////////
    
    //alert();

   $("#submitForm").on('submit',function(e){
        
        e.preventDefault();
        //////////////////////////////////////
        var form = $("#submitForm");
        var data = new FormData(form[0]);
        data.append('file1_info', file1_info);
        data.append('file2_info', file2_info);
        data.append('file3_info', file3_info);
        data.append('file4_info', file4_info);
        data.append('file5_info', file5_info);
        //////////////////////////////////////
        $.ajax({
            url: form.attr('action'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: form.attr('method'),
            data: data,
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
                        text: data.message, 
                        type: "success"
                    },
                    function () {
                        $("#modalSuggestion").modal('hide');
                    });
                } else {
                    var inputError = [];

                    console.log(Object.keys(data.message)[0]);
                    if($("input[name='"+Object.keys(data.message)[0]+"']").is(':radio') || $("input[name='"+Object.keys(data.message)[0]+"']").is(':checkbox')){
                        var input = $("input[name='"+Object.keys(data.message)[0]+"']");
                    } else {
                        var input = $('#'+Object.keys(data.message)[0]);
                    }

                    $('#modalDiv #modalSuggestion').animate(
                        {scrollTop: input.offset().top - 100},
                        'slow', function() {
                            //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                            input.focus();
                        }
                    );

                    $.each(data.message,function(key, data){
                        if($("#modalSuggestion input[name='"+key+"']").is(':radio') || $("input[name='"+key+"']").is(':checkbox')){
                            var input = $("#modalSuggestion input[name='"+key+"']");
                        } else {
                            var input = $('#modalSuggestion #'+key);
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
                            if($("#modalSuggestion input[name='"+field.name+"']").is(':radio') || $("input[name='"+field.name+"']").is(':checkbox')){
                                var input = $("#modalSuggestion input[name='"+field.name+"']");
                            } else {
                                var input = $('#modalSuggestion #'+field.name);
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