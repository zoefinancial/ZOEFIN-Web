@include('charts.chart',['box_title'=>'Cash Flow','canvas_id'=>'cashFlowChart'])
@push('scripts')
    @include('charts.bar_chart_js')
@endpush