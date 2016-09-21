@extends('layouts.modal_dialog',['style'=>'width:768px !important'])
@section('modal-body-'.$id)
<div class="embed-responsive embed-responsive-4by3">
    <iframe class="embed-responsive-item" id={{ $iframe_id }} src=""></iframe>
</div>
@endsection
@push('scripts')
<script>
    $('#{{ $button_id }}').on('click', function (e) {
        f_{{ $iframe_id }}();
    });

    function f_{{ $iframe_id }}() {
        $('#{{ $iframe_id }}').attr('src','');
         $.ajax({
            url: "/user/quovo_iframe"
        }).then(function(ajaxData) {
            $('#{{ $iframe_id }}').attr('src','https://www.quovo.com/index.php?action=remoteauth&u='+ajaxData['user_id']+'&k='+ajaxData['token']);
        });
        $('#{{ $id }}').modal('toggle');
        return true;
    }
</script>
@endpush