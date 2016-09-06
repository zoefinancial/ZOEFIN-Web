<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ $url }}"
        }).then(function(ajaxData) {
            $("#{{ $canvas_id }}_loading").get(0).className = "hidden";

            var row_object;

            var total={{ $total or 'false'}};

            var moneyFormat=['{{ $moneyFormat or '' }}'];

            var newLine;
            var count,titles;
            var totals=[];

            count=0;
            titles='';
            for ( var row in ajaxData){
                newLine='';
                row_object=ajaxData[row];
                for(var col in row_object){
                    if(isNaN(row_object[col])){
                        newLine+='<td>'+row_object[col]+'</td>';
                    }else{
                        if(moneyFormat.contains(col)){
                            newLine+='<td title="$'+tableMoneyFormat(row_object[col],0)+'">'+humanReadableMoney(row_object[col])+'</td>';
                        }else{
                            newLine+='<td>'+row_object[col]+'</td>';
                        }
                    }
                    if(count==0){
                        titles+='<th>'+col+'</th>';
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
                    if(isNaN(totals[col])){
                        newLine+='<td>-</td>';
                    }else{
                        if(moneyFormat.contains(col)){
                            newLine+='<td title="$'+tableMoneyFormat(totals[col],0)+'">'+humanReadableMoney(totals[col])+'</td>';
                        }else{
                            newLine+='<td>'+totals[col]+'</td>';
                        }
                    }
                }
                $("#{{ $canvas_id }}").append('<tfoot><tr>'+newLine+'</tr></tfoot>');
            }
        });
    } );
</script>