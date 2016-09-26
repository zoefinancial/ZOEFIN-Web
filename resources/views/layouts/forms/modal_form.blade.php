@extends('layouts.modal_dialog')
@section('modal-body-'.$id)
    <form action="{{ $url }}" method="post" id="{{ $id }}_form">
    @foreach( $inputs as $input )
        @if( $input['type']=='radio' or $input['type']=='radio-inline' )
            <div class="form-group" id="{{ $id }}_{{ $input['id'] }}_div">
            <label for="{{ $input['id'] }}">{{ $input['label'] or $input['id'] }}:</label>
            @foreach( $input['options'] as $option)
                    <label class="{{ $input['type'] }}">
                        <input type="radio" name="{{ $input['name'] or $input['id'] or '' }}" id="{{ $input['id'] }}_{{ $option['id'] }}" value="{{ $option['value'] or $option['id'] }}" {{ $option['checked'] or '' }}>
                        {{ $option['label'] or $option['id'] }}
                    </label>

            @endforeach
                <span class="help-block" id="{{ $id }}_{{ $input['id'] }}_help">{{ $input['help'] or '' }}</span>
            </div>
        @else
            @if( $input['type']=='hidden' )
                    <input type="{{ $input['type'] }}" class="form-control" id="{{ $input['id'] }}" name="{{ $input['name'] or $input['id'] or '' }}">
            @else
                <div class="form-group" id="{{ $id }}_{{ $input['id'] }}_div">
                    <label for="{{ $input['id'] }}">{{ $input['label'] or $input['id'] }}:</label>
                    <input type="{{ $input['type'] }}" class="form-control" id="{{ $input['id'] }}" name="{{ $input['id'] or '' }}">
                    <span class="help-block" id="{{ $id }}_{{ $input['id'] }}_help">{{ $input['help'] or '' }}</span>
                </div>
            @endif
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

            document.getElementById('{{ $id }}_{{ $callback_modal or 'info_modal' }}_description').innerHTML=str;
            $('#{{ $id or '' }}_info_modal').modal('toggle');
        })
        .fail(function(response) {

            @foreach( $inputs as $input )
                document.getElementById('{{ $id }}_{{ $input['id'] }}_div').setAttribute('class','form-group');
            @endforeach

            var data = JSON.parse(response.responseText);
            var str='';
            for(var dataItem in data){
                str+=(dataItem+':'+data[dataItem])+'<br/>';

                document.getElementById('{{ $id }}_'+dataItem+'_div').setAttribute('class','form-group has-error');
                document.getElementById('{{ $id }}_'+dataItem+'_help').innerHTML=data[dataItem];
            }
            document.getElementById('{{ $id }}_info_modal_description').innerHTML=str;
            $('#{{ $id or '' }}').modal('toggle');

            $('#{{ $id or '' }}_info_modal').modal('toggle');

            $('#{{ $id or '' }}_info_modal').unbind('hidden.bs.modal');

            $('#{{ $id or '' }}_info_modal').on('hidden.bs.modal', function () {
                $('#{{ $id or '' }}').modal('toggle');
            })
        });
        return true;
    }
</script>
@endpush

@push('modals')
@include('layouts.modal_dialog',
    ['id'=>$id.'_info_modal',
        'header'=>'Information',
        'description'=>'',
        'cancel_button_label'=>'Ok'])
@endpush