@if($scriptTag==true)<script type="text/javascript">@endif
$('{{ $district_id }}').attr('disabled', 'disabled');
$('{{ $state_id }}').on('change', function(e){
    console.log(e);
    var state = e.target.value;

    $.get('{{  URL::to('state?state_id=') }}' + state, function(data) {
        var $district = $('{{ $district_id }}');

        $district.find('option').remove().end();
        $district.removeAttr("disabled").end();
        $district.append('<option value="" disabled selected>---</option>');

        $.each(data, function(index, district) {
            $district.append('<option value="' + district.district_id + '">' + district.district + '</option>');
        });
        @if(!empty($inputEmpty))
        var district_id = {{ $inputEmpty }};
        $district.val(district_id).find('option[value="' + district_id +'"]').attr('selected', true);
        @endif
    });
}).change();
@if($scriptTag==true)</script>@endif