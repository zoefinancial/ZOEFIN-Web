@extends('charts.chart',['box_title'=>$box_title])
@section('aditional-'.$canvas_id)
    @if($overlay=1 or false)
        @include('layouts.overlay')
    @endif
@endsection
@push('scripts')
    @php
        $js_s = isset($js) ? $js : 'charts.js.bar_chart_js';
        $showTotal = isset($showTotal) ? $showTotal : 'false';
    @endphp
    @include($js_s,['url'=>$url,'canvas_id'=>$canvas_id,'showTotal'=>$showTotal])
@endpush