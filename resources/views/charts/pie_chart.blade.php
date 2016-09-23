@extends('charts.chart',['box_title'=>$box_title,'canvas_id'=>$canvas_id])
@section('aditional-'.$canvas_id)
    @if($overlay=1 or false)
        @include('layouts.overlay')
    @endif
@endsection
@push('scripts')
    @include('charts.js.pie_chart_js',['url'=>$url,'canvas_id'=>$canvas_id])
@endpush