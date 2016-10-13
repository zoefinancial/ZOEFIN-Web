@foreach($selectColumns as $selectColumn => $configuration)
    @push('scripts')
        <script>
        var $dd_{{ str_replace('-','_',str_slug($selectColumn)) }} = $("#contextMenu_{{ str_replace('-','_',str_slug($selectColumn)) }}");

        $('.actionButton_{{ str_replace('-','_',str_slug($selectColumn)) }}').on('click',function() {

            //get row ID
            //var id = $(this).closest("tr").children().first().html();

            //move dropdown menu
            $(this).after($dd_{{ str_replace('-','_',str_slug($selectColumn)) }});

            //update links
            //$dd_{{ str_replace('-','_',str_slug($selectColumn)) }}.find(".payLink").attr("href", "/transaction/pay?id="+id);
            //$dd_{{ str_replace('-','_',str_slug($selectColumn)) }}.find(".delLink").attr("href", "/transaction/delete?id="+id);

            //show dropdown
            $(this).dropdown();
        });
        </script>
    @endpush
    @push('modals')
    <ul id="contextMenu_{{ str_replace('-','_',str_slug($selectColumn)) }}" class="dropdown-menu" role="menu" >
        <li><a tabindex="-1" href="#" class="payLink">Pay</a></li>
        <li><a tabindex="-1" href="#" class="delLink">Delete</a></li>
    </ul>
    @endpush
@endforeach


<script>
    function load_{{ $canvas_id }}(url) {
        $.ajax({
            url: url
        }).then(function(ajaxData) {
            $("#{{ $canvas_id }}_loading").get(0).className ="fa fa-spinner fa-pulse fa-fw";

            var row_object;

            var total={{ $total or 'false'}};

            var moneyFormat=['{{ $moneyFormat or '' }}'];
            var completeMoneyFormat=['{{ $completeMoneyFormat or '' }}'];

            var newLine;
            var count,titles;
            var totals=[];

            count=0;
            titles='';

            var nowrap=[@foreach($nowrap as $nw)
                   '{{ $nw }}',
            @endforeach];
            var selectColumns=[];
            var selectColumnsOptions=[];
            var options;
            var hiddenColumns = [
                @foreach($hiddenColumns as $h)
                    '{{ $h }}',
                @endforeach
            ];
            var slugColumnsName = [];






            @foreach($selectColumns as $selectColumn => $configuration)
                selectColumns.push('{{ $selectColumn }}');
                slugColumnsName['{{ $selectColumn }}']='{{ str_replace('-','_',str_slug($selectColumn)) }}'
                options=new Array();
                @foreach($configuration['options'] as $option)
                        var optionDetails = new Array();
                        optionDetails['description']='{{ $option->description }}';
                        optionDetails['id']='{{ $option->id }}';
                        optionDetails['urlEncode']='{{ hash('ripemd160',$configuration['url']) }}';
                        options.push(optionDetails);
                @endforeach
                selectColumnsOptions['{{ $selectColumn }}']=options;

            @endforeach

            var nw='';
            var sc_open='';
            var sc_close='';
            var td_class;
            var dropdown;
            var colDefs=[];
            var hiddenColIndex=[];


            $("#{{ $canvas_id }}").empty();
            var colIndex=0
            for ( var row in ajaxData){
                newLine='';
                row_object=ajaxData[row];
                for(var col in row_object){

                    if(nowrap.contains(col)){
                        nw='nowrap';
                    }else{
                        nw='';
                    }

                    dropdown='';
                    td_class=''

                    if(selectColumns.contains(col)){
                        td_class='dropdopwn'
                        //sc_open='<div class="btn-group" role="group"><a href="#" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">';
                        //sc_close='<span class="caret"></span> </a>';
                        sc_open='<a class="btn btn-default actionButton_'+slugColumnsName[col]+'" data-toggle="dropdown" href="#">';
                        sc_close=' </a>';
                        /*dropdown='<ul class="dropdown-menu">';
                        for(var option in selectColumnsOptions[col]){
                            dropdown+='<li><a href="#" onclick="sendForm_'+selectColumnsOptions[col]['urlEncode']+'("'+row['id']+'_'+col+'","'+row['id']+'_'+col+'","'+selectColumnsOptions[col][option]['id']+'")">'+selectColumnsOptions[col][option]['description']+'</a></li>';
                        }
                        dropdown+='</ul></div><form id="'+row_object['id']+'_'+col+'"><input type="hidden" name="id" value="'+row['id']+'"><input type="hidden" id="'+row['id']+'_'+col+'" name="'+col+'" value=""></form>';*/
                    }else{
                        sc_open='';
                        sc_close='';
                    }
                    if(isNaN(row_object[col])){
                        newLine+='<td class="'+td_class+'" '+nw+' style="max-width:100px;text-overflow: ellipsis"><div>'+sc_open+row_object[col]+sc_close+dropdown+'</div></td>';
                    }else{
                        if(moneyFormat.contains(col)){
                            newLine+='<td class="'+td_class+'" '+nw+' title="$'+tableMoneyFormat(row_object[col],0)+'">'+sc_open+humanReadableMoney(row_object[col])+sc_close+dropdown+'</td>';
                        }else{
                            if(completeMoneyFormat.contains(col)){
                                newLine+='<td class="'+td_class+'" '+nw+' title="$'+tableMoneyFormat(row_object[col],0)+'">'+sc_open+tableMoneyFormat(row_object[col])+sc_close+dropdown+'</td>';
                            }else {
                                newLine += '<td class="'+td_class+'" '+nw+'>' +sc_open+ row_object[col] +sc_close+dropdown+'</td>';
                            }
                        }
                    }
                    if(count==0){
                        if(tooltips.containsKey(col)){
                            titles+='<th title="'+tooltips[col]+'>'+col+'</th>';
                        }else{
                            titles+='<th>'+col+'</th>';
                        }
                        var hide=hiddenColumns.contains(col)
                        if(hide){
                            hiddenColIndex.push(colIndex)
                        }
                        colIndex++;
                    }
                    if (typeof totals[col] != "undefined"){
                    }else{
                        totals[col]=0;
                    }
                    totals[col]+=Number(row_object[col]);
                }
                if(count==0){
                    $("#{{ $canvas_id }}").append('<thead><tr>'+titles+'</tr></thead>');
                }
                $("#{{ $canvas_id }}").append('<tr>'+newLine+'</tr>');
                count++;
            }
            if(total){
                newLine='';
                for(var col in totals){
                    if(typeof col != "function"){
                        if(isNaN(totals[col])){
                            newLine+='<td><b>TOTAL</b></td>';
                        }else{
                            if(moneyFormat.contains(col)){
                                newLine+='<td title="$'+tableMoneyFormat(totals[col],0)+'"><b>'+humanReadableMoney(totals[col])+'</b></td>';
                            }else{
                                newLine+='<td><b>'+totals[col]+'</b></td>';
                            }
                        }
                    }
                }
                $("#{{ $canvas_id }}").append('<tfoot><tr>'+newLine+'</tr></tfoot>');
            }

            {{--$("#{{ $canvas_id }}")
                    .tablesorter({widthFixed: true, widgets: ['zebra']})
                    .tablesorterPager({container: $("#pager_{{ $canvas_id }}")});--}}


            colDefs.push(
                {

                }
            );

            $("#{{ $canvas_id }}").DataTable({
                "searching": {{ $searching or 'false' }},
                "paging": {{ $paging or 'false' }},
                "info": {{ $info or 'false'}},
                "columnDefs": [{"targets":  hiddenColIndex ,
                "visible": false,
                "searchable": false}],
            });

            $("#{{ $canvas_id }}_loading").get(0).className = "hidden";
        });
    }
</script>