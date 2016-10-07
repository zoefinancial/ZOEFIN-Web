@extends('layouts.modal_dialog',['style'=>'width:768px !important'])
@section('modal-body-'.$id)
<div class="well">
    <div class="embed-responsive embed-responsive-4by3">
        <iframe class="embed-responsive-item" id={{ $iframe_id }} src=""></iframe>
    </div>
</div>
@endsection
@push('modals')
@include('layouts.modal_dialog',
    ['id'=>$id.'_info_modal',
        'header'=>'Information',
        'description'=>'',
        'cancel_button_label'=>'Ok'])
@endpush
@push('scripts')
<script>
    $('#{{ $button_id }}').on('click', function (e) {
        f_{{ $iframe_id }}();
    });

    function f_{{ $iframe_id }}() {
        $('#{{ $iframe_id }}').attr('src','');
         $.ajax({
            url: "/api/quovo_iframe"
        }).then(function(ajaxData) {
            $('#{{ $iframe_id }}').attr('src','https://www.quovo.com/index.php?action=remoteauth&u='+ajaxData['user_id']+'&k='+ajaxData['token']);
        });
        $('#{{ $id }}').modal('toggle');
        $('#{{ $id }}').unbind('hidden.bs.modal');

        $('#{{ $id }}').on('hidden.bs.modal', function () {
            $('#{{ $id or '' }}_info_modal').modal('toggle');
            $.ajax({
                url: "/api/quovo_sync"
            }).then(function(ajaxData) {
                var str='';
                for(var dataItem in ajaxData){
                    str+=(dataItem+':'+ajaxData[dataItem])+'\n';
                }

                document.getElementById('{{ $id }}_info_modal_description').innerHTML=str;
                $('#{{ $id or '' }}_info_modal').modal('toggle');
            });
        });
        return true;
    }
</script>
@endpush