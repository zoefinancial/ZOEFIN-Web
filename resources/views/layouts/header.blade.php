@php
    $individuals=Auth::user()->getFamilyMembers();
@endphp
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

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <!-- <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="user-image" alt="User Image"/> -->                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <i class="fa fa-user"></i>
                        <span class="hidden-xs">{{ $individuals[0]->name }} {{ $individuals[0]->lastname }}</span>
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
                        @if(count($individuals)>1)
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Both</a>
                            </div>
                            @foreach  ($individuals as $profile)
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ $profile['name'] }}</a>
                                </div>
                            @endforeach
                        </li>
                        @endif
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