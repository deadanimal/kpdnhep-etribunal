{{ Form::open(['route' => ['public.change.password', $user->user_id], 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}

{{ textInput($errors, 'password', NULL, 'password', trans('new.password'), true) }}

{{ textInput($errors, 'password', NULL, 'password_confirmation', trans('new.confirm_password'), true) }}

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-4 col-md-6">
            <button type="submit" class="btn green">{{ trans('button.submit') }}</button>
            <button type="button" class="btn default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
        </div>
    </div>
</div>

{{ Form::close() }}
<script type="text/javascript">
$.fn.message = function(alert, message) {
    this.prepend('<div id="message" class="alert '+alert+' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'+message+'</div>');
    return this;
};

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
            form.find('#message').remove();
            form.prepend('<div id="message" class="text-center mt15 mb15"><img class="mr10" src="{{ URL::to('/assets/global/img/loading-spinner-grey.gif') }}"> {{ trans("swal.process_data")}} </div>');
        },
        success: function(data) {
            if(data.status=='ok'){
                form.find('#message').remove();
                form.message('alert-success', '<span class="sbold">{{ trans("swal.success") }}!</span>'+data.message);
                
            } else {
                form.find('#message').remove();
                form.message('alert-danger', '<span class="sbold">{{ trans("swal.fail") }}! </span>'+data.message[Object.keys(data.message)[0]]);

                var inputError = [];

                console.log(data.message[Object.keys(data.message)[0]]);
                if($("input[name='"+Object.keys(data.message)[0]+"']").is(':radio') || $("input[name='"+Object.keys(data.message)[0]+"']").is(':checkbox')){
                    var input = $("input[name='"+Object.keys(data.message)[0]+"']");
                } else {
                    var input = $('#'+Object.keys(data.message)[0]);
                }

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