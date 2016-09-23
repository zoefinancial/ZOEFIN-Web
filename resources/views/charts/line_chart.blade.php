@extends('charts.chart',['box_title'=>$box_title])
@section('aditional-'.$canvas_id)
    @if($overlay=1 or false)
        @include('layouts.overlay')
    @endif
@endsection
@push('scripts')
    @php
        $js_s = isset($js) ? $js : 'charts.js.line_chart_js';
    @endphp
    @include($js_s,['url'=>$url,'canvas_id'=>$canvas_id])
@endpush