@include('charts.chart',['box_title'=>$box_title])
@push('scripts')
    @php
        $js_s = isset($js) ? $js : 'charts.js.bar_chart_js';
    @endphp
    @include($js_s,['url'=>$url,'canvas_id'=>$canvas_id])
@endpush