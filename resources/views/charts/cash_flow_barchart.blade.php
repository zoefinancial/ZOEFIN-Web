@include('charts.chart',['box_title'=>'Cash Flow','canvas_id'=>'cashFlowChart'])
@push('scripts')
    @include('charts.js.bar_chart_js')
@endpush