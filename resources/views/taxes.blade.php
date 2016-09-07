@extends('app')
@section('content')
    <div class="row row-height" >
        <div class="col-lg-6 col-md-12">
        @include('tables.table',['box_title'=>'Taxes detailed 2015','url'=>'/user/taxes/detailed/2015','canvas_id'=>'taxes_table_2015','total'=>'true','moneyFormat'=>'Tax Amount'])
        </div>
        <div class="col-lg-6 col-md-12">
            @include('tables.table',['box_title'=>'Taxes detailed E2016','url'=>'/user/taxes/detailed/2016','canvas_id'=>'taxes_table_2016','total'=>'true','moneyFormat'=>'Tax Amount'])
        </div>
        <div class="col-lg-6 col-md-12">
            @include('charts.pie_chart',['box_title'=>'Total Taxes E2016','url'=>'/user/taxes/total/2016','canvas_id'=>'taxes_chart_2016'])
        </div>
        <div class="col-lg-6 col-md-12">
            @include('charts.line_chart',['box_title'=>'Taxes Comparison','url'=>'/user/taxes/comparison','canvas_id'=>'taxes_comparison'])
        </div>
    </div>
@endsection
@section('javascript')
    <!-- ChartJS 2.2.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js"></script>
    @stack('scripts')
@endsection