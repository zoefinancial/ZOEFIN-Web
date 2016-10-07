@php
    function formatMoney($number, $fractional=false) {
        $label='';
        if(abs($number)>999999){
            $number=round($number/1000000,1);
            $label = 'M';
        }else{
            if(abs($number)>999){
                $number=round($number/1000,1);
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

   /* $side_bar_active_item = $side_bar_active_item ? $side_bar_active_item:'dashboard';

    $dashboard_active = $side_bar_active_item=='dashboard'? 'active':'';
    $investments_active = $side_bar_active_item=='investments'? 'active':'';
    $taxes_active = $side_bar_active_item=='taxes'? 'active':'';
    $budgeting_active = $side_bar_active_item=='budgeting'? 'active':'';
    $insurance_active = $side_bar_active_item=='insurance'? 'active':'';*/

    //initialize arrays for options select
    $homeTypesSelect = array();
    $banksSelect = array();
    $accountTypesSelect = array();
    $accountStatusSelect = array();
    $individualSelect = array();
    $vehicleSelect = array();
    $investCompanySelect = array();
    //query to parameters
    $individuals = Auth::user()->getFamilyMembers();
    $homeTypes = App\HomeType::select('id', 'description')->get();
    $banks = App\Bank::select('id','name')->get();
    $accountStatus = App\AccountStatus::select('id','description')->get();
    $accountTypes = App\AccountType::select('id','description')->get();
    $interestRateTypes = \App\InterestRateType::select('id','description')->get();
    $investmentVehicle = App\InvestmentVehicle::select('id','description')->get();
    $investmentCompany = App\InvestmentCompany::select('id', 'name')->get();

    //populate array with parameters
    $individualSelect = selectParameters($individuals, ['value' => 'id','label' => 'name']);
    $homeTypesSelect = selectParameters($homeTypes,['value' => 'id','label' => 'description']);
    $banksSelect = selectParameters($banks,['value' => 'id','label' => 'name']);
    $accountStatusSelect = selectParameters($accountStatus,['value' => 'id','label' => 'description']);
    $accountTypesSelect = selectParameters($accountTypes,['value' => 'id','label' => 'description']);
    $typeOfInterestRateSelect = selectParameters($interestRateTypes,['value' => 'id','label' => 'description']);
    $vehicleSelect = selectParameters($investmentVehicle,['value' => 'id','label' => 'description']);
    $investCompanySelect = selectParameters($investmentCompany,['value' => 'id','label' => 'name']);

    //query to assets
    $userHomes = App\Http\Controllers\HomeController::getHome(Auth::user()->id);
    $userBankingAccounts = App\Http\Controllers\BankingAccountController::getBankingAccount(Auth::user()->id);
    $userInvestments = App\Http\Controllers\InvestmentController::getInvestment(Auth::user()->id);

@endphp
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treemenu">
                <a href="#"><i class="fa fa-info"></i><span>My Accounts</span>
                    <span class="pull-right">
                        <span id="manual_account_add" class="label" title="Add manually"><i class="fa fa-edit"></i></span>
                        <span id="quovo_button_id" class="label" title="Link your accounts"><i class="fa fa-plus" style="font-size: 2em;"></i></span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="unstyled-list"><a title="What i own">Assets</a>
                        <ul class="">
                            @php
                                $i=0;
                            @endphp
                            <li>
                            <div class="box box-primary collapsed-box box-solid bg-transparent">
                                <div class="box-header">
                                    <h3 class="box-title">Homes</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" id="c_h_{{ $i }}" title="Add home manually"><i class="fa fa-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                                @push('scripts')
                                <script>
                                    $('#c_h_{{ $i }}').on('click', function (e) {createHome();});
                                </script>
                                @endpush
                                <div class="box-body no-border">
                                @foreach($userHomes as $home)
                                    @php
                                        $i++;
                                    @endphp
                                        <div class="info-box bg-aqua row-hidden">
                                            <span class="info-box-icon"><i class="fa fa-home"></i></span>
                                            <span class="pull-right hover-btn">
                                                <span id="e_h_{{ $i }}" class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                                <span id="d_h_{{ $i }}" class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Home</span>
                                                <span class="info-box-number" title="${{  titleMoney($home->current_value) }}">${{ formatMoney($home->current_value) }}</span>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: 100%" ></div>
                                                </div>
                                                <span class="progress-description"></span>
                                            </div>
                                        </div>
                                    @push('scripts')
                                    <script>
                                        $('#e_h_{{ $i }}').on('click', function (e) {editHome('{{ base64_encode($home->id) }}','{{ $home->getHomeType->id }}','{{ $home->address }}','{{ $home->state }}','{{ $home->city }}','{{ $home->zip }}','{{ $home->current_value }}');});
                                        $('#d_h_{{ $i }}').on('click', function (e) {deleteHome('{{ base64_encode($home->id) }}');});
                                    </script>
                                    @endpush
                                @endforeach
                                </div>
                            </div>
                            </li>
                            <li>
                                <div class="box box-primary collapsed-box box-solid bg-transparent">
                                    <div class="box-header">
                                        <h3 class="box-title">Cars</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" id="c_c_{{ $i }}" title="Add car manually"><i class="fa fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-angle-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @push('scripts')
                                    <script>
                                        $('#c_c_{{ $i }}').on('click', function (e) {createCar();});
                                    </script>
                                    @endpush
                                    <div class="box-body no-border">
                                        @foreach(Auth::user()->getCars() as $car)
                                            @php
                                                $i++;
                                            @endphp
                                            <div class="info-box bg-aqua row-hidden">
                                                <span class="info-box-icon" title="{{ $car->additional_details }}"><i class="fa fa-car"></i></span>
                                                <span class="pull-right hover-btn">
                                                <span id="e_c_{{ $i }}" class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                                <span id="d_c_{{ $i }}" class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                            </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Car</span>
                                                    <span class="info-box-number" title="${{ titleMoney($car->current_value) }}">${{ formatMoney($car->current_value) }}</span>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: 100%" ></div>
                                                    </div>
                                                    <span class="progress-description"></span>
                                                </div>
                                            </div>
                                            @push('scripts')
                                            <script>
                                                $('#e_c_{{ $i }}').on('click', function (e) {editCar('{{ base64_encode($car->id) }}','{{ $car->current_value }}','{{ $car->additional_details }}');});
                                                $('#d_c_{{ $i }}').on('click', function (e) {deleteCar('{{ base64_encode($car->id) }}');});
                                            </script>
                                            @endpush
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="box box-primary collapsed-box box-solid bg-transparent">
                                    <div class="box-header">
                                        <h3 class="box-title">Cash account</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" id="c_b_{{ $i }}" title="Add banking account manually"><i class="fa fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-angle-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @push('scripts')
                                    <script>
                                        $('#c_b_{{ $i }}').on('click', function (e) {createBankingAccount();});
                                    </script>
                                    @endpush
                                    <div class="box-body no-border">
                                        @foreach($userBankingAccounts as $bankingAccount)
                                            @php
                                                $i++;
                                            @endphp
                                            <div class="info-box bg-aqua row-hidden">
                                                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                                                <span class="pull-right hover-btn">
                                                <span id="e_b_{{ $i }}" class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                                <span id="d_b_{{ $i }}" class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                            </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text" title="{{ $bankingAccount->number }}">Banking account</span>
                                                    <span class="info-box-number" title="${{ titleMoney($bankingAccount->current_balance) }}">${{ formatMoney($bankingAccount->current_balance) }}</span>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: 100%" ></div>
                                                    </div>
                                                    <span class="progress-description"></span>
                                                </div>
                                            </div>
                                            @push('scripts')
                                            <script>
                                                $('#e_b_{{ $i }}').on('click', function (e) {editBankingAccount('{{ base64_encode($bankingAccount->id) }}','{{ $bankingAccount->banks_id }}','{{ $bankingAccount->account_types_id }}','{{ $bankingAccount->account_status_id }}','{{ $bankingAccount->number }}','{{ $bankingAccount->current_balance }}');});
                                                $('#d_b_{{ $i }}').on('click', function (e) {deleteBankingAccount('{{ base64_encode($bankingAccount->id) }}');});
                                            </script>
                                            @endpush
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            {{-- Investments--}}
                            <li>
                                <div class="box box-primary collapsed-box box-solid bg-transparent">
                                    <div class="box-header">
                                        <h3 class="box-title">Investment account</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" id="c_in_{{ $i }}" title="Add Investment manually"><i class="fa fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-angle-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @push('scripts')
                                    <script>
                                        $('#c_in_{{ $i }}').on('click', function (e) {createInvestment();});
                                    </script>
                                    @endpush
                                    <div class="box-body no-border">
                                        @foreach($userInvestments as $investment)
                                            @php
                                                $i++;
                                            @endphp
                                            <div class="info-box bg-aqua row-hidden">
                                                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                                                <span class="pull-right hover-btn">
                                                <span id="e_in_{{ $i }}" class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                                <span id="d_in_{{ $i }}" class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                            </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">{{ $investment->investmentVehicle->description }}</span>
                                                    <span class="info-box-number" title="${{ titleMoney($investment->total_balance) }}">${{ formatMoney($investment->total_balance) }}</span>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: 100%" ></div>
                                                    </div>
                                                    <span class="progress-description"></span>
                                                </div>
                                            </div>
                                            @push('scripts')
                                            <script>
                                                $('#e_in_{{ $i }}').on('click', function (e) {editInvestment('{{ base64_encode($investment->id) }}','{{ $investment->individuals_id }}','{{ $investment->investment_vehicles_id }}','{{ $investment->investment_companies_id }}','{{ $investment->employer }}','{{ $investment->total_balance }}','{{ $investment->initial }}','{{ $investment->end }}');});
                                                $('#d_in_{{ $i }}').on('click', function (e) {deleteInvestment('{{ base64_encode($investment->id) }}');});
                                            </script>
                                            @endpush
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        {{-- End --}}
                        </ul>
                    </li>
                    <li class="unstyled-list"><a title="What i owe">Liabilities</a>
                        <ul class="">
                            @foreach(\App\LoanType::all() as $loanType)
                                <li>
                                    <div class="box box-warning collapsed-box box-solid bg-transparent">
                                        <div class="box-header">
                                            <h3 class="box-title">{{$loanType->description}}</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" id="c_l_{{ $i }}" title="Add {{ $loanType->description }} manually"><i class="fa fa-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-angle-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body no-border">
                                            @push('scripts')
                                            <script>
                                                function create{{ str_replace('-','',str_replace(' ','',str_slug($loanType->description))) }}(){
                                                    $('#modal_{{  str_replace('-','',str_replace(' ','',str_slug($loanType->description))) }}_form').modal('toggle');
                                                    return true;
                                                }
                                                $('#c_l_{{ $i }}').on('click', function (e) {create{{ str_replace('-','',str_replace(' ','',str_slug($loanType->description))) }}();});
                                            </script>
                                            @endpush
                                            @push('modals')
                                            @if($loanType->description=='Mortgage')
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
                                                        ['label'=>'Type of interest rate', 'name' => 'details','id'=>str_replace('-','',str_replace(' ','',str_slug($loanType->description))).'_details','type'=>'select', 'options' => $typeOfInterestRateSelect],
                                                        ['label'=>'Comments','id'=>'comments','type'=>'text'],
                                                    ],
                                                    'submit_button_label'=>'Add','url'=>'/api/loan'
                                                ))
                                            @else
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
                                            @endif
                                            @endpush
                                            @foreach(Auth::user()->getLoansByType($loanType->id) as $loan)
                                                @php
                                                    $i++;
                                                @endphp
                                                @push('scripts')
                                                <script>
                                                    @if($loanType->description=='Mortgage')
                                                        $('#e_l_{{ $i }}').on('click', function (e) {editMortgage('{{ base64_encode($loan->id) }}','{{ $loanType->id }}','{{ $loan->amount }}','{{ $loan->interest_rate }}','{{ $loan->comments }}','{{ $loan->details }}');});
                                                    @else
                                                        $('#e_l_{{ $i }}').on('click', function (e) {editLoan('{{ base64_encode($loan->id) }}','{{ $loanType->id }}','{{ $loan->amount }}','{{ $loan->interest_rate }}','{{ $loan->comments }}','{{ $loan->details }}');});
                                                    @endif
                                                    $('#d_l_{{ $i }}').on('click', function (e) {deleteLoan('{{ base64_encode($loan->id) }}');});
                                                </script>
                                                @endpush
                                                <div class="info-box bg-orange row-hidden">
                                                    <span class="info-box-icon"><i class="{{$loanType->icon}}"></i></span>
                                                    <span class="pull-right hover-btn">
                                                <span id="e_l_{{ $i }}" class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                                <span id="d_l_{{ $i }}" class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                                </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text" title="{{$loan->comments}}">{{$loanType->description}}</span>
                                                        <span class="info-box-number" title="${{ titleMoney($loan->amount) }}">${{ formatMoney($loan->amount) }}</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%" ></div>
                                                        </div>
                                                        <span class="progress-description"></span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
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
                        ['label'=>'Current Value','id'=>'current_value', 'name'=>'current_value', 'type'=>'money']
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
                        ['label'=>'Current Value','id'=>'edit_home_current_value', 'name'=>'current_value', 'type'=>'money']
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
            'method'=>'delete',
            'inputs'=>[
                ['label'=>'','id'=>'delete_home_id','type'=>'hidden']
            ],
            'submit_button_label'=>'Delete home','url'=>'/api/home/',
    ))


{{-- Create car form --}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_car_form',
        'header'=>'Create Car',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Current value','id'=>'current_value','type'=>'money'],
            ['label'=>'Additional details','id'=>'additional_details','type'=>'text']
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
            ['label'=>'Current Value','id'=>'edit_car_current_value','name'=>'current_value','type'=>'money'],
            ['label'=>'Additional details','id'=>'edit_car_additional_details','name'=>'additional_details','type'=>'text']
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
            'submit_button_label'=>'Delete car','url'=>'/api/car',
            ))

{{--Create Banking account form--}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_banking_account_form',
        'header'=>'Create Bank Account',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Bank Name', 'name' => 'banks_id','id'=>'banks-id','type'=>'select', 'options' => $banksSelect],
            ['label'=>'Account Type', 'name' => 'account_types_id','id'=>'account-types-id','type'=>'select', 'options' => $accountTypesSelect],
            ['label'=>'Account Status', 'name' => 'account_status_id','id'=>'account-status-id','type'=>'select', 'options' => $accountStatusSelect],
            ['label'=>'Account Number', 'name' => 'number','id'=>'number','type'=>'text'],
            ['label'=>'Current Balance', 'name' => 'current_balance','id'=>'current-balance','type'=>'money'],
        ],
        'submit_button_label'=>'Create Bank Account','url'=>'/api/bankingaccount'
    ))

{{-- Edit banking account form --}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_edit_banking_account_form',
        'header'=>'Edit Bank Account',
        'description'=>'',
        'method'=>'put',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Bank Name', 'name' => 'banks_id','id'=>'banks-id','type'=>'select', 'options' => $banksSelect],
            ['label'=>'Account Type', 'name' => 'account_types_id','id'=>'account-types-id','type'=>'select', 'options' => $accountTypesSelect],
            ['label'=>'Account Status', 'name' => 'account_status_id','id'=>'account-status-id','type'=>'select', 'options' => $accountStatusSelect],
            ['label'=>'Account Number', 'name' => 'number','id'=>'number','type'=>'text'],
            ['label'=>'Current Balance', 'name' => 'current_balance','id'=>'current-balance','type'=>'money'],
        ],
        'submit_button_label'=>'Edit Bank Account','url'=>'/api/bankingaccount'
    ))

{{-- Delete banking account form --}}
@include('layouts.forms.modal_form',
    array(
            'id'=>'delete_banking_account_form',
            'header'=>'Delete Bank Account',
            'description'=>'',
            'cancel_button_label'=>'Cancel',
            'method'=>'delete',
            'inputs'=>[
                ['label'=>'','id'=>'delete_banking_account_id','type'=>'hidden']
            ],
            'submit_button_label'=>'Delete Bank Account','url'=>'/api/bankingaccount/',
    ))


{{--Create Investmente form--}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_investment_form',
        'header'=>'Create Investment',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Individual', 'name' => 'individuals_id','id'=>'individuals-id','type'=>'select', 'options' => $individualSelect],
            ['label'=>'Investment vehicles', 'name' => 'investment_vehicles_id','id'=>'investment-vehicles-id','type'=>'select', 'options' => $vehicleSelect],
            ['label'=>'Investment companies', 'name' => 'investment_companies_id','id'=>'investment-companies-id','type'=>'select', 'options' => $investCompanySelect],
            ['label'=>'employer', 'name' => 'employer','id'=>'employer','type'=>'text'],
            ['label'=>'total balance', 'name' => 'total_balance','id'=>'total-balance','type'=>'money'],
            ['label'=>'initial', 'name' => 'initial','id'=>'initial','type'=>'date'],
            ['label'=>'end', 'name' => 'end','id'=>'end','type'=>'date'],
        ],
        'submit_button_label'=>'Create Investment','url'=>'/api/investment'
    ))

{{-- Edit Investment form --}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_edit_investment_form',
        'header'=>'Edit Investment',
        'description'=>'',
        'method'=>'put',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Individual', 'name' => 'individuals_id','id'=>'individuals-id','type'=>'select', 'options' => $individualSelect],
            ['label'=>'Investment vehicles', 'name' => 'investment_vehicles_id','id'=>'investment-vehicles-id','type'=>'select', 'options' => $vehicleSelect],
            ['label'=>'Investment companies', 'name' => 'investment_companies_id','id'=>'investment-companies-id','type'=>'select', 'options' => $investCompanySelect],
            ['label'=>'employer', 'name' => 'employer','id'=>'employer','type'=>'text'],
            ['label'=>'total balance', 'name' => 'total_balance','id'=>'total-balance','type'=>'money'],
            ['label'=>'initial', 'name' => 'initial','id'=>'initial','type'=>'date'],
            ['label'=>'end', 'name' => 'end','id'=>'end','type'=>'date'],
        ],
        'submit_button_label'=>'Edit Investment','url'=>'/api/investment'
    ))

{{-- Delete Investment form --}}
@include('layouts.forms.modal_form',
    array(
        'id'=>'delete_investment_form',
        'header'=>'Delete Investment',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'method'=>'delete',
        'inputs'=>[
            ['label'=>'','id'=>'delete_banking_account_id','type'=>'hidden']
        ],
        'submit_button_label'=>'Delete Investment','url'=>'/api/investment',
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
                    ['label'=>'Amount','id'=>'edit_loan_amount','name'=>'amount','type'=>'money'],
                    ['label'=>'Interest rate','id'=>'edit_loan_interest_rate','name'=>'interest_rate','type'=>'percentage'],
                    ['label'=>'Comments','id'=>'edit_loan_comments','name'=>'comments','type'=>'text'],
                    ['label'=>'Detail','id'=>'edit_loan_detail','name'=>'details','type'=>'text']
                ],
                'submit_button_label'=>'Edit Loan','url'=>'/api/loan'
            ))

{{--Edit Loan--}}
@include('layouts.forms.modal_form',
            array(
                'id'=>'modal_edit_mortgage_form',
                'header'=>'Edit Mortgage',
                'description'=>'',
                'method'=>'put',
                'cancel_button_label'=>'Cancel',
                'inputs'=>[
                    ['label'=>'','id'=>'edit_mortgage_id','name'=>'id','type'=>'hidden'],
                    ['label'=>'','id'=>'edit_mortgage_loan_types_id','name'=>'loan_types_id','type'=>'hidden'],
                    ['label'=>'Amount','id'=>'edit_mortgage_amount','name'=>'amount','type'=>'money'],
                    ['label'=>'Interest rate','id'=>'edit_mortgage_interest_rate','name'=>'interest_rate','type'=>'percentage'],
                    ['label'=>'Type of interest rate','id'=>'edit_mortgage_details','name'=>'details','type'=>'select','options'=>$typeOfInterestRateSelect],
                    ['label'=>'Comments','id'=>'edit_mortgage_comments','name'=>'comments','type'=>'text'],

                ],
                'submit_button_label'=>'Edit Mortgage','url'=>'/api/loan'
            ))

@endpush

@push('scripts')
<script>

    function createHome(){
        $('#modal_home_form').modal('toggle');
        return true;
    }

    function createCar(){
        $('#modal_car_form').modal('toggle');
        return true;
    }

    function createBankingAccount() {
        $('#modal_banking_account_form').modal('toggle');
        return true;
    }

    function createInvestment() {
        $('#modal_investment_form').modal('toggle');
        return true;
    }

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

    function deleteBankingAccount(banking_account_id_encode){
        $('#delete_banking_account_id').attr('value',banking_account_id_encode);
        $('#description_delete_banking_account_form').html('Are you sure than you want to delete this banking account?');
        $('#delete_banking_account_form').modal('toggle');
        return true;
    }

    function deleteInvestment(investment_id_encode){
        $('#delete_banking_account_id').attr('value',investment_id_encode);
        $('#description_delete_car_form').html('Are you sure than you want to delete this investment?');
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

    function editCar(car_id_encode,value,additional_details){
        $('#edit_car_id').attr('value',car_id_encode);
        $('#edit_car_current_value').attr('value',value);
        $('#edit_car_additional_details').attr('value',additional_details);
        $('#modal_edit_car_form').modal('toggle');
        return true;
    }

    function editBankingAccount(banking_account_id_encode,banks_id,account_types_id,account_status_id,number,current_value){
        $('#edit_banking_account_id').attr('value',banking_account_id_encode);
        $('#edit_banking_account_bank').val(banks_id);
        $('#edit_banking_account_account_type').val(account_types_id);
        $('#edit_banking_account_account_status').val(account_status_id);
        $('#edit_banking_account_number').attr('value',number);
        $('#edit_banking_account_current_value').attr('value',current_value);
        $('#modal_edit_banking_account_form').modal('toggle');
        return true;
    }

    function editInvestment(investment_id_encode, individuals_id, investment_vehicles_id, investment_companies_id, employer, total_balance, initial, end){
        $('#edit_investment_id').attr('value',investment_id_encode);
        $('#edit_investment_individuals_id').val(individuals_id);
        $('#edit_investment_investment_vehicles_id').val(investment_vehicles_id);
        $('#edit_investment_investment_companies_id').val(investment_companies_id);
        $('#edit_investment_employer').attr('value',employer);
        $('#edit_investment_total_balance').attr('value',total_balance);
        $('#edit_investment_initial').attr('value',initial);
        $('#edit_investment_end').attr('value',end);
        $('#modal_edit_banking_account_form').modal('toggle');
        return true;
    }

    function editLoan(loan_id_encode,loan_types_id,amount,interest_rate,comments,details){
        $('#edit_loan_loan_id').attr('value',loan_id_encode);
        $('#edit_loan_loan_types_id').attr('value',loan_types_id);
        $('#edit_loan_amount').attr('value',amount);
        $('#edit_loan_interest_rate').attr('value',interest_rate);
        $('#edit_loan_comments').attr('value',comments);
        $('#edit_loan_details').attr('value',details);
        $('#modal_edit_loan_form').modal('toggle');
        return true;
    }

    function editMortgage(loan_id_encode,loan_types_id,amount,interest_rate,comments,details){
        $('#edit_mortgage_id').attr('value',loan_id_encode);
        $('#edit_mortgage_loan_types_id').attr('value',loan_types_id);
        $('#edit_mortgage_amount').attr('value',amount);
        $('#edit_mortgage_interest_rate').attr('value',interest_rate);
        $('#edit_mortgage_comments').attr('value',comments);
        $('#edit_loan_details').val(details);
        $('#modal_edit_mortgage_form').modal('toggle');
        return true;
    }
</script>
@endpush