@php
    $s=($style ? $style : '');
@endphp
@include('charts.chart',['style'=> $s ])
@push('scripts')
    {{--@include('charts.net_worth_barchart_js')--}}
    @include('charts.detailed_net_worth_bar_chart_js')
@endpush
