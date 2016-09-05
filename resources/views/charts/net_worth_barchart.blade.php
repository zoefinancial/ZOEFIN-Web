@php
    $s=(isset($style) ? $style : '');
@endphp
@include('charts.chart',['style'=> $s ])
@push('scripts')
    {{--@include('charts.net_worth_barchart_js')--}}
    {{--@include('charts.js.detailed_net_worth_bar_chart_js')--}}
    @include('charts.js.stackable_bar_chart_js')
@endpush
