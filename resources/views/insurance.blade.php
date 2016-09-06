@extends('app')
@section('content')
    <div class="row row-height" >
        @php
            $url='/user/insurance/prediction';
            $familyMember=Auth::user()->getFamilyMembers();

        @endphp
        @foreach ($familyMember as $member)
        <div class="col-md-6">
            @include('charts.bar_chart',['js'=>'charts.js.stackable_bar_chart_js','box_title'=>'Insurance information ('.$member['name'].')','url'=>$url.'/'.$member['id'],'canvas_id'=>'insurance_prediction_'.$member['id']])
        </div>
        @endforeach
    </div>
@endsection
@section('javascript')
    <!-- ChartJS 2.2.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.min.js"></script>
    @stack('scripts')
@endsection