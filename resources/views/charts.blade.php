@extends('dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-12">
        <!-- NET WORTH CHART -->
            {{-- @include('charts.net_worth_barchart',['url'=>'/user/net_worth','canvas_id'=>'netWorthChart']) --}}
            @include('charts.net_worth_barchart',['box_title'=>'Net Worth','url'=>'/user/net_worth','canvas_id'=>'netWorthChart'])
        <!-- /.box -->
        </div>
        <div class="col-lg-4 col-md-6">
            <!-- CASH FLOW CHART -->
            {{-- @include('charts.cash_flow_barchart',['url'=>'/user/cash_flow','canvas_id'=>'cashFlowChart'])--}}
            <!-- /.box -->
            @include('charts.bar_chart',['box_title'=>'Cash Flow','url'=>'/user/cash_flow','canvas_id'=>'cashFlowChart'])
        </div>
        <div class="col-lg-4 col-md-6">
            <!-- INVESTMENTS CHART -->
            @include('charts.invesments_chart',['box_title'=>'Investments'])
            <!-- /.box -->
        </div>
    </div>
@endsection

@section('javascript')
    <!-- ChartJS 2.2.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js"></script>
    <script>
        @stack('scripts')
    </script>
@endsection