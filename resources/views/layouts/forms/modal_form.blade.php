@extends('layouts.modal_dialog')
@section('modal-body-'.$id)
    <form action="{{ $url }}" method="post" id="{{ $id }}_form">
        @foreach( $inputs as $input )
            @if( in_array($input['type'], ['radio','radio-line','select']))
                <label for="{{ $input['id'] }}"> {{ $input['label'] or $input['id'] }}:</label>
                    @if( in_array($input['type'], ['radio','radio-line']))
                        @foreach( $input['options'] as $option)
                                <label class="{{ $input['type'] }}">
                                    <input type="radio" name="{{ $input['name'] or $input['id'] }}" id="{{ $input['id'] }}_{{ $option['id'] }}" value="{{ $option['value'] or $option['id'] }}" {{ $option['checked'] or '' }}>
                                    {{ $option['label'] or $option['id'] }}
                                </label>
                        @endforeach
                    @else
                        <select name="{{$input['name']}}" id="{{$input['id']}}">
                        @foreach( $input['options'] as $option)
                                <option value="{{ $option['value'] }}">{{$option['label']}}</option>
                        @endforeach
                        </select>
                    @endif
            @elseif( $input['type']=='hidden' )
                        <input type="{{ $input['type'] }}" class="form-control" id="{{ $input['id'] }}" name="{{ $input['name'] or $input['id'] }}">
            @elseif( $input['type']=='text' )
                    <div class="form-group">
                        <label for="{{ $input['id'] }}">{{ $input['label'] or $input['id'] }}:</label>
                        <input type="{{ $input['type'] }}" class="form-control" id="{{ $input['id'] }}" name="{{ $input['name'] or $input['id'] }}">
                    </div>

            @endif
        @endforeach
        {{ csrf_field() }}
    </form>
@endsection

@section('modal-footer-'.$id)
    <button type="button" id="{{ $id or '' }}_submit_button" class="btn btn-primary" >{{ $submit_button_label or 'Submit' }}</button>
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

            document.getElementById('{{ $callback_modal or 'info_modal' }}_description').innerHTML=str;
            $('#{{ $callback_modal or 'info_modal' }}').modal('toggle');
        })
        .fail(function(response) {
            document.getElementById('{{ $callback_modal or 'info_modal' }}_description').innerHTML=response.Text;
            $('#{{ $callback_modal or 'info_modal' }}').modal('toggle');
        });
        return true;
    }
</script>
@endpush