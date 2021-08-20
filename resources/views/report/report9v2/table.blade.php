<table class="table table-bordered table-hover data">
    <thead>
    <tr>
        <th rowspan="2"> {{ __('new.state') }} </th>
        <th colspan="12"> {{ __('new.month') }} </th>
        <th rowspan="2"> {{ __('new.total') }} </th>
    </tr>
    <tr style="text-transform: uppercase;">
        @foreach($months as $month)
            <th> {{ $month->$month_lang }} </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($states as $state)
        @if(($input['state_id'] != '' && $input['state_id'] == $state->state_id) || ($input['state_id'] == ''))
            <?php
            $visitor_state = (clone $data_final)->get()->where('state_id', $state->state_id);
            $total_state += count($visitor_state);
            ?>
            <tr>
                <td style="text-align: left; text-transform: uppercase;"> {{ $state->state }}</td>
                @foreach($months as $month)
                    <?php
                    $visitor_state_month = (clone $data_final)->whereMonth('visitor_datetime', $month->month_id)->get()->where('state_id', $state->state_id);

                    ?>
                    <td>
                        <a onclick="viewdrilldown({{ $state->state_id }}, {{ $month->month_id }})">
                            {{ count($visitor_state_month) }}
                        </a>
                    </td>
                @endforeach
                <td> {{ count($visitor_state) }} </td>
            </tr>
        @endif
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td>{{__('new.total')}}</td>
        @foreach($months as $month)
            <?php
            $visitor_month = (clone $data_final)->whereMonth('visitor_datetime', $month->month_id)->get();
            ?>
            <td> {{ count($visitor_month) }}</td>
        @endforeach
        <td> {{ $total_state }} </td>
    </tr>
    </tfoot>
</table>
