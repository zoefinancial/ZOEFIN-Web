<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ $url }}"
        }).then(function(ajaxData) {
            $("#{{ $canvas_id }}_loading").get(0).className = "hidden";

            var row,col,row_object;


            var total='{{ $total or 'false'}}';



            var newLine;
            var count,titles;
            var totals=[];


            count=0;
            titles='';
            for ( row in ajaxData){
                newLine='';
                row_object=ajaxData[row];
                for(col in row_object){
                    newLine+='<td>'+row_object[col]+'</td>'
                    if(count==0){
                        titles+='<th>'+col+'</th>';
                    }
                    if (typeof totals[col] == "undefined"){
                        totals.push(col);
                    }
                    totals[col]+row_object[col];
                }
                if(count==0){
                    $("#{{ $canvas_id }}").append('<thead><tr>'+titles+'</tr></thead>');
                }
                $("#{{ $canvas_id }}").append('<tr>'+newLine+'</tr>');
                count++;
            }
            if(total=='true'){
                newLine='';
                for(col in totals){
                    newLine+='<tf>'+totals[col]+'</tf>'
                }
                $("#{{ $canvas_id }}").append('<tfoot><tr>'+newLine+'</tr></tfoot>');
            }
        });
    } );
</script>