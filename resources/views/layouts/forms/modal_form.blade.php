@extends('layouts.modal_dialog')
@section('modal-body-'.$id)
    <form action="{{ $url }}" method="post" id="{{ $id }}_form">
    @foreach( $inputs as $input )
        @if( $input['type']=='radio' )
            <label for="{{ $input['id'] }}">{{ $input['label'] or $input['id'] }}:</label>
            @foreach( $input['options'] as $option)
                <div class="radio">
                    <label>
                        <input type="radio" name="{{ $input['id'] }}" id="{{ $input['id'] }}_{{ $option['id'] }}" value="{{ $option['value'] or $option['id'] }}" {{ $option['checked'] or '' }}>
                        {{ $option['label'] or $option['id'] }}
                    </label>
                </div>
            @endforeach
        @else
            <div class="form-group">
                <label for="{{ $input['id'] }}">{{ $input['label'] or $input['id'] }}:</label>
                <input type="{{ $input['type'] }}" class="form-control" id="{{ $input['id'] }}" name="{{ $input['id'] or '' }}">
            </div>
        @endif
    @endforeach
        {{ csrf_field() }}
    </form>
    @php
        unset($inputs);
        unset($url);
    @endphp
@endsection

@section('modal-footer-'.$id)
    <button type="button" id="{{ $id or '' }}_submit_button" class="btn" >{{ $submit_button_label or 'Submit' }}</button>
@endsection

@push('scripts')
<script>
    $('#{{ $id or '' }}_submit_button').on('click', function (e) {
        f_{{ $id }}();
    });

    function f_{{ $id }}() {
        var action = $('#{{ $id or '' }}_form').attr("action");
        $.post(action, $('#{{ $id or '' }}_form').serialize()).done(function (data) {
            var str='';
            for(var dataItem in data){
                str+=(dataItem+':'+data[dataItem])+'\n';
            }
            $('#{{ $id or '' }}').modal('toggle');
            $('#{{ $id or '' }}').find('form').trigger('reset');

            document.getElementById('info_modal_description').innerHTML=str;
            $('#info_modal').modal('toggle');
        })
        .fail(function(response) {
            document.getElementById('info_modal_description').innerHTML=response.Text;
            $('#info_modal').modal('toggle');
        });
        return true;
    }
</script>
@endpush
