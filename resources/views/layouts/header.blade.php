<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x65 pixels -->
        <span class="logo-mini"><b>Zoe</b>Fin</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Zoe</b>Financial</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#" data-toggle="modal" data-target="#modal_home_form">Add</a></li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <!-- <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="user-image" alt="User Image"/> -->                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <i class="fa fa-user"></i>
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <!-- <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" /> -->
                            <i class="fa fa-user"></i>
                            <p>
                                {{ Auth::user()->name }}
                                <small>Member since {{ Auth::user()->created_at->format('F, Y') }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Both</a>
                            </div>
                            @foreach  (Auth::user()->getFamilyMembers() as $profile)
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ $profile['name'] }}</a>
                                </div>
                            @endforeach
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

@push('modals')
    @include('layouts.forms.modal_form',
        [
            'id'=>'modal_home_form',
            'header'=>'Create Home',
            'description'=>'Creating a home...',
            'inputs'=>[
                ['label'=>'Home name','id'=>'home_name','type'=>'text'],
                ['label'=>'Home current value','id'=>'home_current_value','type'=>'number'],
                ['label'=>'Home ZIPCODE','id'=>'home_zip','type'=>'number'],
                ['label'=>'Home owner','id'=>'home_owner','type'=>'radio',
                    'options'=>[
                        ['id'=>'0','value'=>'0','label'=>'Both','checked'=>'checked'],
                        ['id'=>'1','value'=>'1','label'=>'John'],
                        ['id'=>'2','value'=>'2','label'=>'Melissa']
                    ]
                ]
            ],
            'submit_button_label'=>'Create Home','url'=>'/test/forms'])
@endpush