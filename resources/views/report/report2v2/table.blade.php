<table class="table table-bordered data">
    <thead>
    <tr>
        <th width="3%" rowspan="3"> {{ __('new.no') }} </th>
        <th rowspan="3"> {{ __('new.state') }}  </th>
        <th rowspan="3" class='fit'> {{ __('new.register') }} </th>
        <th colspan="2" class='fit'> {{ __('new.claim_type') }} </th>
        <th colspan="4" class='fit'> {{ __('new.form') }} </th>
        <th colspan="12"> {{ __('new.solution_method') }} </th>
        <th rowspan="3"> {!! __('new.total_completed') !!}  </th>
        <th rowspan="3"> {{ __('new.reminder') }} </th>
    </tr>
    <tr>
        <th rowspan="2" class='fit'> B</th>
        <th rowspan="2" class='fit'> P</th>
        <th rowspan="2" class='fit'> B2</th>
        <th rowspan="2" class='fit'> B3</th>
        <th rowspan="2" class='fit'> B11</th>
        <th rowspan="2" class='fit'> B12</th>
        <th rowspan="2"> {!! __('new.stop_notice_r2') !!} </th>
        <th rowspan="2"> TB</th>
        <th rowspan="2"> {{ __('new.revoked_cancel')}} </th>
        <th colspan="2"> {{ __('new.negotiation') }} </th>
        <th colspan="7"> {{ __('new.hearing') }} </th>
    </tr>
    <tr>
        <th> B6</th>
        <th> B9</th>
        <th> B5</th>
        <th> B7</th>
        <th> B8</th>
        <th> B10</th>
        <th> B10K</th>
        <th> B10T</th>
        <th> B10B</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data_final as $i => $datum)
        @if($i != 'total')
            <tr>
                <td>{{$i}}</td>
                <td>{{$states[$i]}}</td>
                <td>
                    <a href="{{route('onlineprocess.form1',[
                         'status' => 17,
                         'branch'=>$branches[$i],
                         'date_start'=>$input['date_start'],
                         'date_end' => $input['date_end']])}}" target="_blank">
                        {{$datum['case']}}
                    </a>
                </td>
                <td>
                    <a href="{{route('onlineprocess.form1',[
                        'status' => 17,
                        'branch'=>$branches[$i],
                        'date_start'=>$input['date_start'],
                        'date_end' => $input['date_end'],
                        'class_cat' => '1'])}}" target="_blank">
                        {{$datum['type']['b']}}
                    </a>
                </td>
                <td>
                    <a href="{{route('onlineprocess.form1',[
                        'status' => 17,
                        'branch'=>$branches[$i],
                        'date_start'=>$input['date_start'],
                        'date_end' => $input['date_end'],
                        'class_cat' => '2'])}}" target="_blank">
                        {{$datum['type']['p']}}
                    </a>
                </td>
                <td>{{$datum['form']['2']}}</td>
                <td>{{$datum['form']['3']}}</td>
                <td>{{$datum['form']['11']}}</td>
                <td>{{$datum['form']['12']}}</td>
                <td>{{$datum['stop_notice']}}</td>
                <td>{{$datum['pull_out']}}</td>
                <td>{{$datum['canceled']}}</td>
                <td>{{$datum['deal']['6']}}</td>
                <td>{{$datum['deal']['9']}}</td>
                <td>{{$datum['hearing']['5']}}</td>
                <td>{{$datum['hearing']['7']}}</td>
                <td>{{$datum['hearing']['8']}}</td>
                <td>{{$datum['hearing']['10']}}</td>
                <td>{{$datum['hearing']['10k']}}</td>
                <td>{{$datum['hearing']['10t']}}</td>
                <td>{{$datum['hearing']['10b']}}</td>
                <td>{{$datum['completed']}}</td>
                <td>{{$datum['not_completed']}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2">{{ strtoupper(__('new.total')) }}</td>
        <td>{{$data_final['total']['case']}}</td>
        <td>{{$data_final['total']['type']['b']}}</td>
        <td>{{$data_final['total']['type']['p']}}</td>
        <td>{{$data_final['total']['form']['2']}}</td>
        <td>{{$data_final['total']['form']['3']}}</td>
        <td>{{$data_final['total']['form']['11']}}</td>
        <td>{{$data_final['total']['form']['12']}}</td>
        <td>{{$data_final['total']['stop_notice']}}</td>
        <td>{{$data_final['total']['pull_out']}}</td>
        <td>{{$data_final['total']['canceled']}}</td>
        <td>{{$data_final['total']['deal']['6']}}</td>
        <td>{{$data_final['total']['deal']['9']}}</td>
        <td>{{$data_final['total']['hearing']['5']}}</td>
        <td>{{$data_final['total']['hearing']['7']}}</td>
        <td>{{$data_final['total']['hearing']['8']}}</td>
        <td>{{$data_final['total']['hearing']['10']}}</td>
        <td>{{$data_final['total']['hearing']['10k']}}</td>
        <td>{{$data_final['total']['hearing']['10t']}}</td>
        <td>{{$data_final['total']['hearing']['10b']}}</td>
        <td>{{$data_final['total']['completed']}}</td>
        <td>{{$data_final['total']['not_completed']}}</td>
    </tr>
    <tr>
        <td colspan="2">{{ strtoupper(__('new.percentage')) }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['case'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['type']['b'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['type']['p'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['form']['2'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['form']['3'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['form']['11'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['form']['12'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['stop_notice'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['pull_out'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['canceled'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['deal']['6'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['deal']['9'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['5'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['7'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['8'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['10'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['10k'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['10t'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['10b'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['completed'], $data_final['total']['case'], 1, '%') }}</td>
        <td>{{ \App\Helpers\NumberFormatHelper::calculatePercentage($data_final['total']['not_completed'], $data_final['total']['case'], 1, '%') }}</td>
    </tr>
    </tfoot>
</table>
       