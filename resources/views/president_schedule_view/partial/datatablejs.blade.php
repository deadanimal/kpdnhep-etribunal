
        var @if(!empty($customname)) {{$customname}} @else Datatable @endif =  $('{{ $table }}').DataTable({
            @if(!empty($destroy))
                "destroy": {{ $destroy }},
            @endif
            @if(!empty($processing))
                "processing": {{ $processing }},
            @endif
            @if(!empty($serverSide))
                "serverSide": {{ $serverSide }},
            @endif



            @if(!empty($ajax))
                "ajax": {
                "url": "{{ $ajax }}",
                @if(!empty($data))
                "data": {
                @foreach ($data as $datas)
                    "{{ $datas }}" : {{ $datas }},
                @endforeach
                }

                @endif
                },
            @endif
            @if(isset($ajaxRoute))
                "ajax": {{ $ajaxRoute }},
            @endif
            @if(!empty($deferRender))
                "deferRender": {{ $deferRender }},
            @endif
            @if(!empty($columns))
                "columns": [
                @if(!empty($no))
                    {data : 'no', name: 'no', orderable: false, searchable: false,class: 'not-export-col'},
                @endif
                    {data : null, orderable: false, searchable: false},
                @foreach ($columns as $data => $name)
                    {data : '{{ $data }}', @if(!empty($name))name : '{{ $name }}',@endif orderable: true, searchable: true},
                @endforeach


                ],
            @endif
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "processing": "<span class=\"font-md\">{{trans('datatable.process_data')}} </span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
                "emptyTable": "{{trans('datatable.no_data')}}",
                "info": "{{trans('datatable.show')}} _START_ {{trans('datatable.to')}} _END_ {{trans('datatable.from')}} _TOTAL_ {{trans('datatable.record')}}",
                "infoEmpty": "{{trans('datatable.no_record_found')}}",
                "infoFiltered": "({{trans('datatable.filter')}} _MAX_ {{trans('datatable.total')}})",
                "lengthMenu": "{{trans('datatable.show')}} _MENU_ {{trans('datatable.record')}}",
                "search": "{{trans('datatable.search')}}",
                "zeroRecords": "{{trans('datatable.no_record')}}",
                searchPlaceholder: "{{trans('datatable.key_word')}}"
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            buttons: [
            @if($buttons==true)
                @if(!empty($button))
                {
                @if(!empty($icon))
                text:"<i class=\"glyphicon glyphicon-ok margin-right-10\"></i>{{ $button['name'] }}", className:"{{ $button['class'] }}",
                @else
                text:"<i class=\"fa fa-plus margin-right-10\"></i>{{ $button['name'] }}", className:"{{ $button['class'] }}", action:function()
                    {
                        window.location.href = "{{ $button['route'] }}";
                        @if(!empty($remove))
                            sessionStorage.removeItem("form1q_id");
                        @endif
                    }
                @endif

                },
                @endif
                @if(!empty($button2))

                @foreach($button2 as $btn)
                    {
                    @if(!empty($icon))
                        text:"<i class=\"glyphicon glyphicon-ok margin-right-10\"></i>{{ $btn['name'] }}", className:"{{ $btn['class'] }}",
                    @elseif(!empty($btn['icon']))
                        text:"<i class=\"glyphicon {{$btn['icon']}} margin-right-10\"></i>{{ $btn['name'] }}", className:"{{ $btn['class'] }}",
                        text:"<i class=\"fa fa-plus margin-right-10\"></i>{{ $btn['name'] }}", className:"{{ $btn['class'] }}", action:function()
                        {
                            window.location.href = "{{ $btn['route'] }}";
                        }
                    @else
                    text:"<i class=\"fa fa-plus margin-right-10\"></i>{{ $btn['name'] }}", className:"{{ $btn['class'] }}", action:function()
                        {
                            window.location.href = "{{ $btn['route'] }}";
                            @if(!empty($remove))
                                sessionStorage.removeItem("form1q_id");
                            @endif
                        }
                    @endif

                    },
                @endforeach
                @endif
                {
                    extend: 'print',
                    @if(!empty($title))
                    title: '{{ $title }}',
                    @endif
                    className: 'btn dark btn-outline',
                    text:'<i class="fa fa-print margin-right-10"></i>{{trans('datatable.print')}}',
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)',
                        format: {
                            body: function (data, rowindex, colindex, node) {
                                // add row count to first column
                                return rowindex === 0? colindex + 1: data.replace(/<.*?>/ig, "");
                            }
                        }
                    },
                },
                {
                    extend: 'collection',
                    text: '<i class="fa fa-angle-down margin-right-10"></i>Export',
                    className:"btn red btn-outline",
                    buttons: [


                        { extend: 'copy',
                            className: 'btn green btn-outline',
                            text:'<i class="fa fa-files-o margin-right-10"></i>{{trans('datatable.copy')}}'
                        },
                        {
                            extend: 'pdf',
                            className: 'btn red btn-outline',
                            text:'<i class="fa fa-file-pdf-o margin-right-10"></i>PDF',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)',
                                format: {
                                    body: function (data, rowindex, colindex, node) {
                                        // add row count to first column
                                        return rowindex === 0? colindex + 1: data.replace(/<.*?>/ig, "");
                                    }
                                }
                            },
                        },
                        {
                            extend: 'excel',
                            className: 'btn green btn-outline',
                            text:'<i class="fa fa-file-excel-o margin-right-10"></i>EXCEL',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)',
                                format: {
                                    body: function (data, rowindex, colindex, node) {
                                        // add row count to first column
                                        return rowindex === 0? colindex + 1: data.replace(/<.*?>/ig, "");
                                    }
                                }
                            },
                        },
                        {
                            extend: 'csv',
                            className: 'btn purple btn-outline',
                            text:'<i class="fa fa-file-excel-o margin-right-10"></i>CSV',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)',
                                format: {
                                    body: function (data, rowindex, colindex, node) {
                                        // add row count to first column
                                        return rowindex === 0? colindex + 1: data.replace(/<.*?>/ig, "");
                                    }
                                }
                            },
                        },
                        {
                            extend: 'colvis',
                            className: 'btn dark btn-outline',
                            text: '<i class="fa fa-columns margin-right-10"></i>{{trans('datatable.column')}}'
                        },

                   ],
                   fade: true,
                },
            @endif
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: false,

            //"ordering": false, disable column ordering
            //"paging": false, disable pagination

            "order": [
                [{{$order}}, 'desc']
            ],

            "lengthMenu": [
                // [5, 10, 15, 20, 50],
                // [5, 10, 15, 20, "All"]

                [5, 10, 15, 20],
                [5, 10, 15, 20]
            ],
            // set the initial value
            "pageLength":@if(!empty($page)){{$page}},@else 10,@endif
            @if(!empty($dommodal))
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-12 col-sm-12'f>><'row'<'col-md-6 col-sm-12'><'col-md-6 col-sm-12'r>><'table-scrollable't><'row'<'col-md-4 col-sm-12'l><'col-md-4 col-sm-12'i><'col-md-4 col-sm-12'p>>", // modal datatable
            @else
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-12 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-4 col-sm-12'l><'col-md-2 col-sm-12'i><'col-md-6 col-sm-12'p>>", // horizobtal scrollable datatable
            @endif
            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
            // So when dropdowns used the scrollable div should be removed.
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });

        @if(!empty($customname) && !empty($number))
            {{$customname}}.on( "order.dt search.dt draw.dt", function () {
              var start = {{$customname}}.page.info().start;
              var info = {{$customname}}.page.info();
               {{$customname}}.column({{$number}}, {search:"applied", order:"applied"}).nodes().each( function (cell, i) {
                    cell.innerHTML = start+i+1;
                });
                });
        @elseif(!empty($customname))
            {{$customname}}.on( "order.dt search.dt draw.dt", function () {
              var start = {{$customname}}.page.info().start;
              var info = {{$customname}}.page.info();
               {{$customname}}.column(0, {search:"applied", order:"applied"}).nodes().each( function (cell, i) {
                    cell.innerHTML = start+i+1;
                });
                });
        @else
            @if(!empty($number))
                Datatable.on( "order.dt search.dt draw.dt", function () {
                  var start = Datatable.page.info().start;
                  var info = Datatable.page.info();
                   Datatable.column({{$number}}, {search:"applied", order:"applied"}).nodes().each( function (cell, i) {
                        cell.innerHTML = start+i+1;
                    });
                    });
            @else
                Datatable.on( "order.dt search.dt draw.dt", function () {
                  var start = Datatable.page.info().start;
                  var info = Datatable.page.info();
                   Datatable.column(0, {search:"applied", order:"applied"}).nodes().each( function (cell, i) {
                        cell.innerHTML = start+i+1;
                    });
                    });
            @endif
        @endif

