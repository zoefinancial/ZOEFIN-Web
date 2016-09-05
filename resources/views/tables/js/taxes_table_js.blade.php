<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ $url }}"
        }).then(function(ajaxData) {
            $("#{{ $canvas_id }}_loading").get(0).className = "hidden";

            var row;
            var object_row;

            var newLine="";
            var year;
            var estimated,estimated_class,estimated_title;

            for ( row in ajaxData){

                newLine="";

                object_row=ajaxData[row];

                year=row;

                estimated='';

                if (typeof object_row['Estimated'] != "undefined") {
                    if(object_row['Estimated']=='true') {
                        estimated = 'E';
                        estimated_class = 'info';
                        estimated_title='title="We forecasted your '+year+' taxes using your current income, investments and expenditures"'
                    }
                }else{
                    estimated='';
                    estimated_class = '';
                    estimated_title = '';
                }

               newLine+='<td>'+estimated+row+'</td>' +
                '<td>'+object_row['Marginal Tax Rate']+'</td>' +
                '<td>'+object_row['Effective Tax Rate']+'</td>' +
                '<td>'+humanReadableMoney(object_row['Taxes Paid'],0)+'</td>';

                $("#{{ $canvas_id }}").append('<tr class="'+estimated_class+'" '+estimated_title+'>'+newLine+'</tr>');

            }

        });
    } );
</script>