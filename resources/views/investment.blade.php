@extends('layouts.app')
@section('content')
    <div class="row row-height" >
        <div class="col-lg-6 col-md-12">
            @include('tables.table',$investmentTable)
        </div>
        <div class="col-lg-6 col-md-12">
            @include('charts.pie_chart',$chart_taxes)
        </div>

    </div>
@endsection
