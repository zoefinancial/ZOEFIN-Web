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
                        '<td>'+humanReadableMoney(object_row['Coverage'],0)+'</td>' +
                        '<td>'+object_row['Type']+'</td>' +
                        '<td>'+object_row['Years coverage']+'</td>' +
                        '<td>$'+object_row['Annual Payment']+'</td>' +
                        '</tr>');
            }
            $("#{{ $canvas_id }}").tablesorter();
        });
    } );
</script>