@extends('layouts.app')
@section('content')
    <div class="row">

        <div class="col-lg-12">
            <!-- NET WORTH CHART -->
            @include('charts.net_worth_barchart',['box_title'=>'Net Worth','url'=>'/user/net_worth/detailed','canvas_id'=>'netWorthChart','showTotalLine'=>false])
            {{-- @include('charts.net_worth_barchart',['box_title'=>'Net Worth','url'=>'/user/detailed/net_worth','canvas_id'=>'netWorthChart']) --}}
        </div>
        <div class="col-lg-6">
            <!-- CASH FLOW CHART -->
            {{-- @include('charts.cash_flow_barchart',['url'=>'/user/cash_flow','canvas_id'=>'cashFlowChart'])--}}
            @include('charts.bar_chart',['box_title'=>'Cash Flow','url'=>'/api/cash_flow','js'=>'charts.js.stackable_bar_chart_js','canvas_id'=>'cashFlowChart','overlay'=>'1'])
        </div>

        <div class="col-lg-6">
            <!-- INVESTMENTS CHART -->
            @include('charts.pie_chart',['box_title'=>'Investment','url'=>'/api/investment/taxable','canvas_id'=>'taxes_chart','overlay'=>'1'])
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 col-md-12">
                    <!-- INSURANCE TABLE -->
                    @include('tables.insurance_table',['box_title'=>'Current Insurance Summary','canvas_id'=>'insurance_summary_table','url'=>'/user/insurance/summary'])
                </div>
                <div class="col-lg-6 col-md-12">
                    <!-- TAX TABLE -->
                    @include('tables.taxes_table',['box_title'=>'Taxes','canvas_id'=>'tax_table','url'=>'/user/taxes/summary'])
                </div>
            </div>
        </div>
    </div> <!-- /row -->
@endsection