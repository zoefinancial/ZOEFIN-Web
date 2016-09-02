<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ $url }}"
        }).then(function(ajaxData) {
            $("#{{ $canvas_id }}_loading").get(0).className = "hidden";

            var row;
            var object_row;

            for ( row in ajaxData){
                object_row=ajaxData[row];

                $("#{{ $canvas_id }}").append('<tr><td>'+row+'</td>' +
                        '<td>'+object_row['Marginal Tax Rate']+'</td>' +
                        '<td>'+object_row['Effective Tax Rate']+'</td>' +
                        '<td>'+humanReadableMoney(object_row['Tax Amount'],0)+'</td>' +
                        '</tr>');
            }
        });
    } );
</script>