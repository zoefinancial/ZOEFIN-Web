@extends('layouts.modal_dialog')
@section('modal-body-'.$id)
    <form action="{{ $url }}" method="post" id="{{ $id }}_form">
        @foreach( $inputs as $input )
            <div class="form-group" id="{{ $id }}_{{ $input['id'] }}_div">
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
            @else
                    <label for="{{ $input['id'] }}">{{ $input['label'] or $input['id'] }}:</label>
                    <input type="{{ $input['type'] }}" class="form-control" id="{{ $input['id'] }}" name="{{ $input['name'] or $input['id'] }}">

            @endif
                <span class="help-block" id="{{ $id }}_{{ $input['id'] }}_help">{{ $input['help'] or '' }}</span>
            </div>
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

    $('#{{ $id or '' }}').on('submit', function (e) {
        f_{{ $id }}();
    });

    function f_{{ $id }}() {

        $('#{{ $id or '' }}_overlay').get(0).className='overlay';

        var action = $('#{{ $id or '' }}_form').attr("action");
        $.post(action, $('#{{ $id or '' }}_form').serialize()).done(function (data) {
            var str='';
            for(var dataItem in data){
                str+=(dataItem+':'+data[dataItem])+'\n';
            }
            $('#{{ $id or '' }}').modal('toggle');
            $('#{{ $id or '' }}').find('form').trigger('reset');
            $('#{{ $id or '' }}_overlay').get(0).className='hidden';

            document.getElementById('{{ $id }}_{{ $callback_modal or 'info_modal' }}_description').innerHTML=str;
            $('#{{ $id or '' }}_info_modal').modal('toggle');
            $('#{{ $id or '' }}_info_modal').unbind('hidden.bs.modal');

            $('#{{ $id or '' }}_info_modal').on('hidden.bs.modal', function () {
                location.reload();
            })
        })
        .fail(function(response) {
            $('#{{ $id or '' }}_overlay').get(0).className='hidden';
            @foreach( $inputs as $input )
                document.getElementById('{{ $id }}_{{ $input['id'] }}_div').setAttribute('class','form-group');
            @endforeach

            var data = null;

            try{
                data=JSON.parse(response.responseText);
                for(var dataItem in data){
                    document.getElementById('{{ $id }}_'+dataItem+'_div').setAttribute('class','form-group has-error');
                    document.getElementById('{{ $id }}_'+dataItem+'_help').innerHTML=data[dataItem];
                }
            }catch(e){
                document.getElementById('{{ $id }}_info_modal_description').innerHTML="Ups! Something was wrong";
                $('#{{ $id or '' }}_info_modal').unbind('hidden.bs.modal');

                $('#{{ $id or '' }}_info_modal').on('hidden.bs.modal', function () {
                    $('#{{ $id or '' }}').modal('toggle');
                })
            }
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