@include('charts.chart',['box_title'=>$box_title])
@push('scripts')
    @include('charts.bar_chart_js',['url'=>$url,'canvas_id'=>$canvas_id])
@endpush