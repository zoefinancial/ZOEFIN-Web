@extends('app')
@section('content')
    <div class="row row-height" >
        <div class="col-md-6">
            @include('charts.bar_chart',['js'=>'charts.stackable_bar_chart_js','box_title'=>'Insurance information','url'=>'/user/insurance/prediction','canvas_id'=>'insurance_prediction'])
        </div>
    </div>
@endsection
@section('javascript')
    <!-- ChartJS 2.2.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js"></script>
    @stack('scripts')
@endsection