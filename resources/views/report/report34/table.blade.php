<table class="table table-bordered">
          <thead>
            <tr>
              <th>{{__('base.counter')}}</th>
              <th>{{__('suggestion.subject')}}</th>
              <th>{{__('suggestion.suggestion')}}</th>
              <th>{{__('suggestion.response')}}</th>
              <th>{{__('suggestion.responded_by_user')}}</th>
              <th>{{__('suggestion.email')}}</th>
              <th>{{__('suggestion.created_at')}}</th>
            </tr>
          </thead>
          <tbody>
               @foreach($suggestions as $i => $suggestion)
            <tr>
                <td>{{$i+1}}</td>
                <td>{{$suggestion->subject}}</td>
                <td>{{($suggestion->suggestion)}}</td>
                <td>{{($suggestion->response)}}</td> 
                <td>{{$suggestion->created_by->name}}</td>  
                <td>{{$suggestion->created_by->email}}</td>  
                <td>{{$suggestion->created_at->todatestring()}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
       