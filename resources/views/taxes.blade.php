@extends('app')
@section('content')
    <div class="row row-height" >
        @include('tables.table',['box_title'=>'Taxes detailed','url'=>'/user/taxes/detailed/2015','canvas_id'=>'taxes_table','total'=>'true'])
    </div>
@endsection
@section('javascript')
    <!-- ChartJS 2.2.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js"></script>
    @stack('scripts')
@endsection