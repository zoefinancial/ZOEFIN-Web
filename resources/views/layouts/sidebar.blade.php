@php
    function formatMoney($number, $fractional=false) {
        $label='';
        if($number>999999){
            $number=$number/1000000;
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

    $side_bar_active_item = $side_bar_active_item ? $side_bar_active_item:'dashboard';

    $dasboard_active = $side_bar_active_item=='dashboard'? 'active':'';
    $investments_active = $side_bar_active_item=='investments'? 'active':'';
    $taxes_active = $side_bar_active_item=='taxes'? 'active':'';
    $budgeting_active = $side_bar_active_item=='budgeting'? 'active':'';
    $insurance_active = $side_bar_active_item=='insurance'? 'active':'';


    $homeTypesSelect = array();
    $homeTypes = App\HomeType::select('id', 'description')->get();

    foreach ($homeTypes as $key => $homeType) {
        $homeTypesSelect[] = [
                                'value'=> $homeType['attributes']['id'],
                                'label' => $homeType['attributes']['description']
                            ];

        }
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
                    <li class="treemenu"><a>Add Information Manually</a>
                        <ul class="treeview-menu">
                            {{-- Plaid integration form and JS--}}
                            {{--  <li class="treemenu" ><a>@include('layouts.forms.modal_plaid_form')</a></li>--}}
                            <li class="treemenu"><a title="What i own">Assets</a>
                                <ul class="treeview-menu">
                                    <li data-toggle="modal" data-target="#modal_home_form"><a><i class="fa fa-home"></i> Home</a></li>
                                    <li data-toggle="modal" data-target="#modal_car_form"><a><i class="fa fa-car"></i> Car</a></li>
                                    <li data-toggle="modal" data-target="#modal_cash_form"><a><i class="fa fa-money"></i> Cash</a></li>
                                </ul>
                            </li>
                            <li class="treemenu"><a title="What i owe">Liabilities</a>
                                <ul class="treeview-menu">
                                    <li data-toggle="modal" data-target="#modal_mortgage_form"><a><i class="fa fa-home"></i> Mortgage</a></li>
                                    <li data-toggle="modal" data-target="#modal_car_loan_form"><a><i class="fa fa-car"></i> Car Loan</a></li>
                                    <li data-toggle="modal" data-target="#modal_student_loan_form"><a><i class="fa fa-book"></i> Student Loan</a></li>
                                    <li data-toggle="modal" data-target="#modal_credit_card_form"><a><i class="fa fa-credit-card"></i> Credit Card</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="treemenu active"><a title="What i own">Assets</a>
                        <div class="box box-default">
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
                        </div>
                        <ul class="treeview-menu">
                            @php
                                $i=0;
                            @endphp
                            @foreach(Auth::user()->getHomes() as $home)
                                @php
                                    $i++;
                                @endphp
                                <li class="active row">
                                    <a><span><i class="fa fa-home"></i> Home <span class="label label-info" title="${{  titleMoney($home->current_value) }}">${{ formatMoney($home->current_value) }}</span></span>
                                        <span class="pull-right hover-btn">
                                            <span id="e_h_{{ $i }}" class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                            <span id="d_h_{{ $i }}" class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                        </span>
                                    </a>
                                </li>
                                @push('scripts')
                                <script>
                                    $('#d_h_{{ $i }}').on('click', function (e) {deleteHome('{{ base64_encode($home->id) }}');});
                                </script>
                                @endpush
                            @endforeach
                            @foreach(Auth::user()->getCars() as $car)
                                <li class="active row">
                                    <a><span><i class="fa fa-car"></i> Car <span class="label label-info" title="${{  titleMoney($car->current_value) }}">${{ formatMoney($car->current_value) }}</span></span>
                                        <span class="pull-right hover-btn">
                                            <span class="label label-primary" title="Edit" data-toggle="modal" data-target="#modal_car_form"><i class="fa fa-edit"></i></span>
                                            <span class="label label-danger" title="Delete" data-toggle="modal" data-target="#modal_car_form"><i class="fa fa-trash"></i></span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="treemenu active"><a title="What i owe">Liabilities</a>
                        <ul class="treeview-menu">
                            @foreach(Auth::user()->getLoans() as $loan)
                                <li class="active row">
                                    <a>{{ $loan->getLoanType->description }}
                                        <span class="label label-warning" title="${{  titleMoney($loan->amount) }}">${{ formatMoney($loan->amount) }}</span>
                                        <span class="pull-right">
                                            <span class="pull-right hover-btn">
                                                <span class="label label-primary" title="Edit"><i class="fa fa-edit"></i></span>
                                                <span class="label label-danger" title="Delete"><i class="fa fa-trash"></i></span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar user panel (optional) -->
        {{--<div class="user-panel">
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
        --}}
        <!-- /.search form -->

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
@include('layouts.forms.modal_quovo_iframe',['id'=>'quovo_modal','button_id'=>'quovo_button_id','iframe_id'=>'quovo_iframe_id','header'=>'Quovo'])

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

@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_car_form',
        'header'=>'Create Car',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Car description','id'=>'car_name','type'=>'text'],
            ['label'=>'Current Value','id'=>'car_current_value','type'=>'number']
        ],
        'submit_button_label'=>'Create Car','url'=>'/test/forms'
    ))

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

@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_credit_card_form',
        'header'=>'Create Credit Card',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Bank Name','id'=>'credit_card_bank','type'=>'text'],
            ['label'=>'Credit Card Name','id'=>'credit_card_name','type'=>'text'],
            ['label'=>'Current Balance','id'=>'credit_card_current_balance','type'=>'number']
        ],
        'submit_button_label'=>'Create Credit Card','url'=>'/test/forms'
    ))

@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_mortgage_form',
        'header'=>'Create Mortgage',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Bank Name','id'=>'mortgage_bank','type'=>'text'],
            ['label'=>'Mortgage Name','id'=>'mortgage_name','type'=>'text'],
            ['label'=>'Current Balance','id'=>'mortgage_current_balance','type'=>'number']
        ],
        'submit_button_label'=>'Create Mortgage','url'=>'/test/forms'
    ))

@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_student_loan_form',
        'header'=>'Create Student Loan',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Student Loan Name','id'=>'student_loan_name','type'=>'text'],
            ['label'=>'Current Balance','id'=>'student_loan_current_balance','type'=>'number']
        ],
        'submit_button_label'=>'Create Student Loan','url'=>'/test/forms'
    ))

@include('layouts.forms.modal_form',
    array(
        'id'=>'modal_car_loan_form',
        'header'=>'Create Car Loan',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Car Loan Name','id'=>'car_loan_name','type'=>'text'],
            ['label'=>'Current Balance','id'=>'car_loan_current_balance','type'=>'number']
        ],
        'submit_button_label'=>'Create Car Loan','url'=>'/test/forms'
    ))

@include('layouts.forms.modal_form',
       array(
           'id'=>'delete_home_form',
           'header'=>'Delete home',
           'description'=>'',
           'cancel_button_label'=>'Cancel',
           'inputs'=>[
               ['label'=>'','id'=>'delete_home_id','type'=>'hidden']
           ],
           'submit_button_label'=>'Delete home','url'=>'/api/home/delete',
       ))
@endpush

@push('scripts')
<script>
    function deleteHome(home_id_encode){
        $('#delete_home_id').attr('value',home_id_encode);
        $('#description_delete_home_form').html('Are you sure than you want to delete this Home?');
        $('#delete_home_form').modal('toggle');
        return true;
    }
</script>
@endpush