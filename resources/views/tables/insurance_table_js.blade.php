<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ $url }}"
        }).then(function(ajaxData) {
            $("#{{ $canvas_id }}_loading").get(0).className = "hidden";

            var row;
            var index;

            var table = $("#{{ $canvas_id }}").get(0);

            for ( row in ajaxData){

                $("#{{ $canvas_id }}").append('<tr><td>'+row+'</td>' +
                        '<td>'+ajaxData[row]['Coverage']+'</td>' +
                        '<td>'+ajaxData[row]['Type']+'</td>' +
                        '<td>'+ajaxData[row]['Years coverage']+'</td>' +
                        '<td>'+ajaxData[row]['Annual Payment']+'</td>' +
                        '</tr>');
            }
        });
    } );
</script>