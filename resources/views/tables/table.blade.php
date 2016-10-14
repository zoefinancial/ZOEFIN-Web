<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $box_title }}</h3>
        <div class="box-tools pull-right">
            <i id="{{ $canvas_id }}_loading" class="fa fa-spinner fa-pulse fa-fw"></i>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="display">
            <table id="{{ $canvas_id }}" class="" width="100%">
            </table>
        </div>
    </div>
    @if($overlay=1 or false)
        @include('layouts.overlay')
    @endif
</div>
@php
if(!isset($nowrap)){
    $nowrap = array();
}

if(!isset($selectColumns)){
    $selectColumns = array();
}

if(!isset($hiddenColumns)){
    $hiddenColumns = array();
}
if(!isset($searching)){
    $searching = 'false';
}
if(!isset($paging)){
    $paging = 'false';
}
if(!isset($info)){
   $info = $paging;
}

@endphp

@push('scripts')
    @include('tables.js.table_js',['canvas_id'=>$canvas_id,
        'nowrap'=>$nowrap,
        'selectColumns'=>$selectColumns,
        'hiddenColumns'=>$hiddenColumns,
        'searching'=>$searching,
        'paging'=>$paging,
        'info'=>$info,])
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        load_{{ $canvas_id }}("{{ $url }}");
    });
</script>
@endpush