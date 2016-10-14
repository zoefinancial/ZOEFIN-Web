@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css")}}">
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Filters</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Date range:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="daterange">
                            <input type="hidden" id="from">
                            <input type="hidden" id="to">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-default">Reset filters</button>
                    <button type="button" class="btn btn-info pull-right" id="applyFiltersButton">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu4">Transactions</a></li>
            <li><a data-toggle="tab" href="#home">Expenses time line by category</a></li>
            <li><a data-toggle="tab" href="#menu1">Expenses time line by account</a></li>
            <li><a data-toggle="tab" href="#menu2">Expenses by category</a></li>
            <li><a data-toggle="tab" href="#menu3">Expenses by account</a></li>

        </ul>
        <div class="row">
            <div class="tab-content">
                <div id="menu4" class="tab-pane fade in active">
                    <div class="col-lg-12">
                        @php
                            $expenseTypes = \App\ExpenseType::select('id','description')->get();
                            $expenseSubtypes = \App\ExpenseSubtype::select('id','description')->get();
                        @endphp
                        @include('tables.table',['box_title'=>'Transactions',
                            'url'=>'/api/budgeting/expenses/',
                            'canvas_id'=>'transactionTable',
                            'total'=>'false',
                            'nowrap'=>['Date','Account type'],
                            'hiddenColumns'=>['id'],
                            'selectColumns'=>[
                                'Expense category'=>['options'=>$expenseTypes,'url'=>'/test/forms'],
                                'Expense subtype'=>['options'=>$expenseSubtypes,'url'=>'/test/forms']
                            ],/*'completeMoneyFormat'=>'Value',*/'overlay'=>'1','searching'=>'false','paging'=>'true','info'=>'true'])
                    </div>
                </div>
                <div id="home" class="tab-pane fade">
                    <div class="col-lg-12">
                        <!-- Annual Expenses -->
                        @include('charts.bar_chart',['showTotal'=>'false','box_title'=>'Expenses time line by category','url'=>'/api/expenses/dates/','js'=>'charts.js.stackable_bar_chart_js','canvas_id'=>'ExpensesOverTime','overlay'=>'1'])
                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="col-lg-12">
                        <!-- Annual Expenses -->
                        @include('charts.bar_chart',['showTotal'=>'false','box_title'=>'Expenses time line by account','url'=>'/api/expenses/dates/accounts/','js'=>'charts.js.stackable_bar_chart_js','canvas_id'=>'ExpensesTimeLineByAccounts','overlay'=>'1'])
                    </div>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <div class="col-lg-12">
                    @include('charts.pie_chart',['box_title'=>'Expenses by category','url'=>'/api/expenses/categorization/','canvas_id'=>'ExpensesCategorization','overlay'=>'1'])
                    </div>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <div class="col-lg-12">
                        @include('charts.pie_chart',['box_title'=>'Expenses by account','url'=>'/api/expenses/accounts/','canvas_id'=>'ExpensesPieByAccounts','overlay'=>'1'])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset ("/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js")}}"></script>
<script>
    $(function(){
        var startDate = moment().subtract(29,'days');
        var endDate =  moment();

        $('#from').val(startDate.format('YYYY-MM-DD'));
        $('#to').val(endDate.format('YYYY-MM-DD'));

        $('#daterange').daterangepicker({
                    startDate: moment().subtract(29,'days'),
                    endDate: moment(),
                   /* minDate: '01/01/2012',
                    maxDate: '12/31/2014',*/
                    /*dateLimit: { days: 365 },*/
                    showDropdowns: true,
                    showWeekNumbers: true,
                    timePicker: false,
                    timePickerIncrement: 1,
                    timePicker12Hour: true,
                    ranges: {
                        'Today': [moment(), moment()],
                        //'Yesterday': [moment().subtract(1,'days'), moment().subtract(1,'days')],
                        'Last 7 Days': [moment().subtract(6,'days'), moment()],
                        'Last 30 Days': [moment().subtract(29,'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1,'month').startOf('month'), moment().subtract(1,'month').endOf('month')],
                        'Year to date': [moment().startOf('year'), moment()]
                    },
                    opens: 'left',
                    buttonClasses: ['btn btn-default'],
                    applyClass: 'btn-small btn-primary',
                    cancelClass: 'btn-small',
                    format: 'DD/MM/YYYY',
                    separator: ' to ',
                    locale: {
                        applyLabel: 'Select range',
                        fromLabel: 'From',
                        toLabel: 'To',
                        customRangeLabel: 'Custom Range',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        firstDay: 1
                    }
                },
                function(start, end) {
                    startDate = start;
                    endDate = end;
                    $('#from').val(start.format('YYYY-MM-DD'));
                    $('#to').val(end.format('YYYY-MM-DD'));
                });
    });

    $('#applyFiltersButton').on('click',function (e){
        to=$('#to').attr("value");
        from=$('#from').attr("value");
        load_ExpensesOverTime('/api/expenses/dates/'+from+'/'+to);
        load_ExpensesTimeLineByAccounts('/api/expenses/dates/accounts/'+from+'/'+to);
        load_ExpensesCategorization('/api/expenses/categorization/'+from+'/'+to);
        load_ExpensesPieByAccounts('/api/expenses/accounts/'+from+'/'+to);
        load_transactionTable('/api/budgeting/expenses/'+from+'/'+to);
    });
</script>
@endpush
