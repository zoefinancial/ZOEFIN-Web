@include('charts.chart',['box_title'=>$box_title,'canvas_id'=>$canvas_id])
@push('scripts')
    @include('charts.js.pie_chart_js',['url'=>$url,'canvas_id'=>$canvas_id])
@endpush