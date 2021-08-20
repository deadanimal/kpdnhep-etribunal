@if($scriptTag==true)<script type="text/javascript">@endif
// $('{{ $hearing_id }}').attr('disabled', 'disabled');
$('{{ $state_id }}').on('change', function(e){
    console.log(e);
    var hearing = e.target.value;

    $.get('{{  URL::to('hearingroom?state_id=') }}' + hearing, function(data) {
        var $hearing = $('{{ $hearing_id }}');

        $hearing.find('option').remove().end();
        $hearing.removeAttr("disabled").end();
        $hearing.append('<option value="" disabled selected>---</option>');

        $.each(data, function(index, hearing) {
            $hearing.append('<option value="' + hearing.hearing_room_id + '">' + hearing.hearing_room + '</option>');
        });
        @if(!empty($inputEmpty))
        var hearing_room_id = {{ $inputEmpty }};
        $hearing.val(hearing_room_id).find('option[value="' + hearing_room_id +'"]').attr('selected', true);
        @endif
    });
}).change();
@if($scriptTag==true)</script>@endif