@php
    function formatMoney($number, $fractional=false) {
        $label='';
        if($number>999999){
            $number=round($number/1000000,1);
            $label = 'M';
        }else{
            if($number>999){
                $number=$number/1000;
                $label = 'K';
            }
        }
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number.' '.$label;
    }

    function titleMoney($number, $fractional=false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }

    function selectParameters($values, $params)
    {
        $Select = array();
        foreach ($values as $key => $value) {
        $Select[] = [
                        'value' => $value['attributes'][$params['value']],
                        'label' => $value['attributes'][$params['label']]
                    ];

        }
        return $Select;
    }

    $side_bar_active_item = $side_bar_active_item ? $side_bar_active_item:'dashboard';

    $dasboard_active = $side_bar_active_item=='dashboard'? 'active':'';
    $investments_active = $side_bar_active_item=='investments'? 'active':'';
    $taxes_active = $side_bar_active_item=='taxes'? 'active':'';
    $budgeting_active = $side_bar_active_item=='budgeting'? 'active':'';
    $insurance_active = $side_bar_active_item=='insurance'? 'active':'';


    $homeTypesSelect = array();
    $banksSelect = array();
    $accountTypesSelect = array();
    $accountStatusSelect = array();
    $homeTypes = App\HomeType::select('id', 'description')->get();
    $banks = App\Bank::select('id','name')->get();
    $accountStatus = App\AccountStatus::select('id','description')->get();
    $accountTypes = App\AccountType::select('id','description')->get();

    $homeTypesSelect = selectParameters($homeTypes,['value' => 'id','label' => 'description']);
    $banksSelect = selectParameters($banks,['value' => 'id','label' => 'name']);
    $accountStatusSelect = selectParameters($accountStatus,['value' => 'id','label' => 'description']);
    $accountTypesSelect = selectParameters($accountTypes,['value' => 'id','label' => 'description']);

    $userHomes = App\Http\Controllers\HomeController::getHome(Auth::user()->id);


@endphp

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treemenu active">
                <a href="#"><i href="#" class="fa fa-info"></i><span>Information</span></a>
                <ul class="treeview-menu">
                    <li class="treemenu"><a href="#" id="quovo_button_id">Link your accounts</a>
                    <li class="treemenu" ><a href="#">Add Information Manually</a>
                        <ul class="treeview-menu">
                            {{-- Plaid integration form and JS--}}
                            {{--  <li class="treemenu" ><a>@include('layouts.forms.modal_plaid_form')</a></li>--}}
                            <li class="treemenu" ><a href="#" title="What i own">Assets</a>
                                <ul class="treeview-menu">
                                    <li data-toggle="modal" data-target="#modal_home_form"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                                    <li data-toggle="modal" data-target="#modal_car_form"><a href="#"><i class="fa fa-car"></i> Car</a></li>
                                    <li data-toggle="modal" data-target="#modal_cash_form"><a href="#"><i class="fa fa-money"></i> Cash</a></li>
                                </ul>
                            </li>
                            <li class="treemenu" ><a title="What i owe" href="#">Liabilities</a>
                                <ul class="treeview-menu">
                                    @foreach(\App\LoanType::all() as $loanType)
                                        <li data-toggle="modal" data-target="#modal_{{ str_replace('-','',str_replace(' ','',str_slug($loanType->description))) }}_form"><a><i class="{{ $loanType->loan_icon }}"></i> {{ $loanType->description }}</a></li>
                                        @push('modals')
                                        @include('layouts.forms.modal_form',
                                            array(
                                                'id'=>'modal_'.str_replace('-','',str_replace(' ','',str_slug($loanType->description))).'_form',
                                                'header'=>$loanType->description,
                                                'description'=>'',
                                                'cancel_button_label'=>'Cancel',
                                                'inputs'=>[
                                                    ['label'=>$loanType->id,'id'=>'loan_types_id','type'=>'hidden','value'=>$loanType->id],
                                                    ['label'=>'Amount','id'=>'amount','type'=>'money'],
                                                    ['label'=>'Interest rate','id'=>'interest_rate','type'=>'percentage'],
                                                    ['label'=>'Comments','id'=>'comments','type'=>'text'],
                                                    ['label'=>'Detail','id'=>'detail','type'=>'text'],
                                                ],
                                                'submit_button_label'=>'Add','url'=>'/api/loan'
                                            ))
                                        @endpush
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="treemenu active"><a title="What i own">Assets</a>
                        {{--<div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Homes</h3>
                                <div class="box-tools pull-right">
                                    <span class="badge">{{ count($userHomes) }}</span>
                                </div><!-- /.box-tools -->
                            </div>
                            @foreach($userHomes as $home)
                                <span class="info-box-text">{{ $home->getHomeType->description }}</span>
                                <address>
                                    Current Value: <strong>${{  titleMoney($home->current_value) }}</strong><br>
                                    {{  $home->address }}<br>
                                </address>
                            @endforeach
                        </div>--}}
                        <ul class="treeview-menu">
                            @php
                                $i=0;
                            @endphp
                            @foreach(Auth::user()->getHomes() as $home)
                                @php
                                    $i++;
                                @endphp
                                <li class="active row-hidden">
                                    <a><span><i class="fa fa-home"></i> Home <span class="label label-info" title="${{  titleMoney($home->current_value) }}">${{ formatMoney($home->current_value) }}</span></span>
                                        <span class="pull-right hover-btn">
                                            <span id="e_h_{{ $i }}" class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                            <span id="d_h_{{ $i }}" class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                        </span>
                                    </a>
                                </li>
                                @push('scripts')
                                <script>
                                    $('#e_h_{{ $i }}').on('click', function (e) {editHome('{{ base64_encode($home->id) }}','{{ $home->getHomeType->id }}','{{ $home->address }}','{{ $home->state }}','{{ $home->city }}','{{ $home->zip }}','{{ $home->current_value }}');});
                                    $('#d_h_{{ $i }}').on('click', function (e) {deleteHome('{{ base64_encode($home->id) }}');});
                                </script>
                                @endpush
                            @endforeach
                            @foreach(Auth::user()->getCars() as $car)
                                @php
                                    $i++;
                                @endphp
                                <li class="active row-hidden">
                                    <a><span><i class="fa fa-car"></i> Car <span class="label label-info" title="${{  titleMoney($car->current_value) }}">${{ formatMoney($car->current_value) }}</span></span>
                                        <span class="pull-right hover-btn">
                                            <span id="e_c_{{ $i }}" class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                            <span id="d_c_{{ $i }}" class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                        </span>
                                    </a>
                                </li>
                                @push('scripts')
                                <script>
                                    $('#e_c_{{ $i }}').on('click', function (e) {editCar('{{ base64_encode($car->id) }}','{{ $car->current_value }}');});
                                    $('#d_c_{{ $i }}').on('click', function (e) {deleteCar('{{ base64_encode($car->id) }}');});
                                </script>
                                @endpush
                            @endforeach
                        </ul>
                    </li>
                    <li class="treemenu active"><a title="What i owe">Liabilities</a>
                        <ul class="treeview-menu">
                            @foreach(Auth::user()->getLoans() as $loan)
                                @php
                                    $i++;
                                @endphp
                                <li class="active row-hidden">
                                    <a>{{ $loan->getLoanType->description }}
                                        <span class="label label-warning" title="${{  titleMoney($loan->amount) }}">${{ formatMoney($loan->amount) }}</span>
                                        <span class="pull-right">
                                            <span class="pull-right hover-btn">
                                                <span id="e_l_{{ $i }}" class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                                <span id="d_l_{{ $i }}" class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                @push('scripts')
                                <script>
                                    $('#e_l_{{ $i }}').on('click', function (e) {editLoan('{{ base64_encode($loan->id) }}','{{ $loan->loan_types_id }}','{{ $loan->amount }}','{{ $loan->comments }}','{{ $loan->details }}');});
                                    $('#d_l_{{ $i }}').on('click', function (e) {deleteLoan('{{ base64_encode($loan->id) }}');});
                                </script>
                                @endpush
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        {{--<!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <!--<img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" /> -->
                <i class="fa fa-user"></i>
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        --}}
        {{--
        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                    <span class="input-group-btn">
                      <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
            </div>
        </form>

        <!-- /.search form -->
           --}}
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- <li class="header">HEADER</li> -->
            <!-- Optionally, you can add icons to the links -->

            <li class="{{ $dasboard_active }}"><a href="/dashboard"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
            <li class="{{ $investments_active }}"><a href="#"><i class="fa fa-line-chart"></i><span>Investments</span></a></li>
            <li class="{{ $taxes_active }}"><a href="taxes"><i class="fa fa-pencil-square-o"></i><span>Taxes</span></a></li>
            <li class="{{ $budgeting_active }}"><a href="/budgeting"><i class="fa fa-usd "></i><span>Budgeting</span></a></li>
            <li class="{{ $insurance_active }}"><a href="/insurance"><i class="fa fa-umbrella"></i><span>Insurance</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
@push('modals')
{{-- Quovo form --}}
@include('layouts.forms.modal_quovo_iframe',['id'=>'quovo_modal','button_id'=>'quovo_button_id','iframe_id'=>'quovo_iframe_id','header'=>'Quovo'])

{{-- Create home form --}}
@include('layouts.forms.modal_form',array(
        'id'=>'modal_home_form',
        'header'=>'Create Home',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
                        ['label'=>'Home type','id'=>'home_type','type'=>'select','name'=>'home_types_id' ,
                            'options'=> $homeTypesSelect
                        ],
                        ['label'=>'Address','id'=>'address', 'name'=>'address', 'type'=>'text'],
                        ['label'=>'State','id'=>'state','name'=>'state', 'type'=>'text'],
                        ['label'=>'City','id'=>'city', 'name'=> 'city', 'type'=>'text'],
                        ['label'=>'Zip Code','id'=>'zip', 'name'=> 'zip', 'type'=>'text'],
                        ['label'=>'Current Value','id'=>'current_value', 'name'=>'current_value', 'type'=>'number']
                    ],
        'submit_button_label'=>'Create Home','url'=>'/api/home'
    ))

{{-- Edit home form --}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_edit_home_form',
        'header'=>'Edit Home',
        'description'=>'',
        'method'=>'put',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
                        ['label'=>'Address','id'=>'edit_home_id', 'name'=>'id', 'type'=>'hidden'],
                        ['label'=>'Home type','id'=>'edit_home_type','type'=>'select','name'=>'home_types_id' ,
                            'options'=> $homeTypesSelect
                        ],
                        ['label'=>'Address','id'=>'edit_home_address', 'name'=>'address', 'type'=>'text'],
                        ['label'=>'State','id'=>'edit_home_state','name'=>'state', 'type'=>'text'],
                        ['label'=>'City','id'=>'edit_home_city', 'name'=> 'city', 'type'=>'text'],
                        ['label'=>'Zip Code','id'=>'edit_home_zip', 'name'=> 'zip', 'type'=>'text'],
                        ['label'=>'Current Value','id'=>'edit_home_current_value', 'name'=>'current_value', 'type'=>'number']
                    ],
        'submit_button_label'=>'Edit Home','url'=>'/api/home'
    ))

{{--Delete home form--}}
@include('layouts.forms.modal_form',
    array(
            'id'=>'delete_home_form',
            'header'=>'Delete home',
            'description'=>'',
            'cancel_button_label'=>'Cancel',
            'inputs'=>[
                ['label'=>'','id'=>'delete_home_id','type'=>'hidden']
            ],
            'submit_button_label'=>'Delete home','url'=>'/api/home/delete',))


{{--Create Banking account form--}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_cash_form',
        'header'=>'Create Banking Account',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Bank Name', 'name' => 'banks_id','id'=>'banks-id','type'=>'select', 'options' => $banksSelect],
            ['label'=>'Account Type', 'name' => 'account_types_id','id'=>'account-types-id','type'=>'select', 'options' => $accountTypesSelect],
            ['label'=>'Account Status', 'name' => 'account_status_id','id'=>'account-status-id','type'=>'select', 'options' => $accountStatusSelect],
            ['label'=>'Account Number', 'name' => 'number','id'=>'number','type'=>'text'],
            ['label'=>'Current Balance', 'name' => 'current_balance','id'=>'current-balance','type'=>'number'],
        ],
        'submit_button_label'=>'Create Cash Account','url'=>'/api/bankingaccount'
    ))

{{-- Create car form --}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_car_form',
        'header'=>'Create Car',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Current Value','id'=>'current_value','type'=>'number']
        ],
        'submit_button_label'=>'Create Car','url'=>'/api/car'
    ))

{{-- Edit car form --}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_edit_car_form',
        'header'=>'Edit Car',
        'description'=>'',
        'method'=>'put',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'id','id'=>'edit_car_id','name'=>'id','type'=>'hidden'],
            ['label'=>'Current Value','id'=>'edit_car_current_value','name'=>'current_value','type'=>'number']
        ],
        'submit_button_label'=>'Edit Car','url'=>'/api/car'
    ))

{{-- Delete car form--}}
@include('layouts.forms.modal_form',
        array(
            'id'=>'delete_car_form',
            'header'=>'Delete car',
            'method'=>'delete',
            'description'=>'',
            'cancel_button_label'=>'Cancel',
            'inputs'=>[
                ['label'=>'','id'=>'delete_car_id','type'=>'hidden']
            ],
            'submit_button_label'=>'Delete car','url'=>'/api/car',))

{{-- Create cash form --}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_cash_form',
        'header'=>'Create Cash Account',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Bank Name','id'=>'cash_bank','type'=>'text'],
            ['label'=>'Current Balance','id'=>'cash_current_balance','type'=>'number']
        ],
        'submit_button_label'=>'Create Cash Account','url'=>'/test/forms'
    ))

{{-- Delete loan form--}}
@include('layouts.forms.modal_form',
        array(
            'id'=>'delete_loan_form',
            'header'=>'Delete loan',
            'description'=>'',
            'method'=>'delete',
            'cancel_button_label'=>'Cancel',
            'inputs'=>[
                ['label'=>'','id'=>'delete_loan_id','type'=>'hidden']
            ],
            'submit_button_label'=>'Delete loan','url'=>'/api/loan/',))

{{--Edit Loan--}}
@include('layouts.forms.modal_form',
            array(
                'id'=>'modal_edit_loan_form',
                'header'=>'Edit Loan',
                'description'=>'',
                'method'=>'put',
                'cancel_button_label'=>'Cancel',
                'inputs'=>[
                    ['label'=>'Loan type id','id'=>'edit_loan_loan_id','name'=>'id','type'=>'hidden'],
                    ['label'=>'Loan type id','id'=>'edit_loan_loan_types_id','name'=>'loan_types_id','type'=>'hidden'],
                    ['label'=>'Amount','id'=>'edit_loan_amount','name'=>'amount','type'=>'number'],
                    ['label'=>'Comments','id'=>'edit_loan_comments','name'=>'comments','type'=>'text'],
                    ['label'=>'Detail','id'=>'edit_loan_detail','name'=>'details','type'=>'text']
                ],
                'submit_button_label'=>'Edit Loan','url'=>'/api/loan'
            ))

@endpush

@push('scripts')
<script>
    function deleteHome(home_id_encode){
        $('#delete_home_id').attr('value',home_id_encode);
        $('#description_delete_home_form').html('Are you sure than you want to delete this home?');
        $('#delete_home_form').modal('toggle');
        return true;
    }

    function deleteCar(car_id_encode){
        $('#delete_car_id').attr('value',car_id_encode);
        $('#description_delete_car_form').html('Are you sure than you want to delete this car?');
        $('#delete_car_form').modal('toggle');
        return true;
    }

    function deleteLoan(loan_id_encode){
        $('#delete_loan_id').attr('value',loan_id_encode);
        $('#description_delete_loan_form').html('Are you sure than you want to delete this loan?');
        $('#delete_loan_form').modal('toggle');
        return true;
    }

    function editHome(home_id_encode,home_types_id,address,state,city,zip,value){
        $('#edit_home_id').attr('value',home_id_encode);
        $('#edit_home_type').val(home_types_id);
        $('#edit_home_address').attr('value',address);
        $('#edit_home_state').attr('value',state);
        $('#edit_home_city').attr('value',city);
        $('#edit_home_zip').attr('value',zip);
        $('#edit_home_current_value').attr('value',value);
        $('#modal_edit_home_form').modal('toggle');
        return true;
    }

    function editCar(car_id_encode,value){
        $('#edit_car_id').attr('value',car_id_encode);
        $('#edit_car_current_value').attr('value',value);
        $('#modal_edit_car_form').modal('toggle');
        return true;
    }

    function editLoan(loan_id_encode,loan_types_id,amount,comments,details){
        $('#edit_loan_loan_id').attr('value',loan_id_encode);
        $('#edit_loan_loan_types_id').attr('value',loan_types_id);
        $('#edit_loan_amount').attr('value',amount);
        $('#edit_loan_comments').attr('value',comments);
        $('#edit_loan_details').attr('value',details);
        $('#modal_edit_loan_form').modal('toggle');
        return true;
    }
</script>
@endpush