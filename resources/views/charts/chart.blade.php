@php
    $s=(isset($style) ? $style : '');
@endphp
<style>
    #{{ $canvas_id }}_tooltip {
        opacity: 0;
        position: absolute;
        background: rgba(0, 0, 0, .7);
        color: white;
        padding: 3px;
        border-radius: 3px;
        -webkit-transition: all .1s ease;
        transition: all .1s ease;
        pointer-events: none;
        -webkit-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
    }
</style>
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
<div id="{{ $canvas_id }}_tooltip" class=""></div>