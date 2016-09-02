@php
    $s=(isset($style) ? $style : '');
@endphp
<div class="box box-success" style="{{ $s }}">
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
        <div class="chart">
            <canvas id="{{ $canvas_id }}" style="padding-left:10px; padding-right:10px; height: 400px;">
            </canvas>
        </div>
    </div>
</div>