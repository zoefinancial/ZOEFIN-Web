@php
    $individuals=Auth::user()->getFamilyMembers();
@endphp
<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="/dashboard" class="logo bootstro" id="zoefin">
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
        <div class="collapse navbar-collapse pull-left">
            <ul class="nav navbar-nav">
                <!-- <li class="header">HEADER</li> -->
                <!-- Optionally, you can add icons to the links -->
                <li><a class="faa-parent animated-hover" href="{{ url('investment') }}"><i class="fa fa-line-chart faa-vertical"></i> <span>Investments</span></a></li>
                <li><a class="faa-parent animated-hover" href="/taxes" id="taxes-header-item" class="bootstro"><i class="fa fa-pencil-square-o faa-vertical"></i> <span>Taxes</span></a></li>
                <li><a class="faa-parent animated-hover" href="/budgeting"><i class="fa fa-usd faa-vertical"></i> <span>Budgeting</span></a></li>
                <li><a class="faa-parent animated-hover" href="/insurance" id="insurance-header-item" class="bootstro"><i class="fa fa-umbrella faa-vertical"></i> <span>Insurance</span></a></li>
            </ul>
        </div>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu pull-right">
            <ul class="nav navbar-nav">
                <li ><a id="bootstro_start" style="font-size: 1.5em;height: 51px;"><i class="fa fa-question faa-tada animated"></i></a></li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        @php
                            $path = env('S3_ENV','dev').'/'.Auth::user()->id.'_'.str_slug(Auth::user()->email).'/profile/ProfilePicture.png';
                            if(!Storage::disk('s3')->exists($path)){
                                $path = env('S3_ENV','dev').'/'.Auth::user()->id.'_'.str_slug(Auth::user()->email).'/profile/ProfilePicture.jpg';
                                if(!Storage::disk('s3')->exists($path)){
                                    $path = env('S3_ENV','dev').'/'.Auth::user()->id.'_'.str_slug(Auth::user()->email).'/profile/ProfilePicture.jpeg';
                                    if(!Storage::disk('s3')->exists($path)){
                                        $path = env('S3_ENV','dev').'/default/ProfilePicture.png';
                                    }
                                }
                            }
                        @endphp
                        <img src="/getFile?f={{ base64_encode($path) }}" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">{{ $individuals[0]->name }} {{ $individuals[0]->lastname }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header bg-white">
                            <div class="box box-widget widget-user">
                            <div class="widget-user-header bg-black" style="background: url('{{ asset("/bower_components/AdminLTE/dist/img/photo1.png") }}') center center;">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since {{ Auth::user()->created_at->format('F, Y') }}</small>
                                </p>
                            </div>
                            <div class="widget-user-image">
                                <img src="/getFile?f={{ base64_encode($path) }}" class="img-circle" alt="User Image" />
                            </div>
                            </div>
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
                                <a data-toggle="modal" data-target="#modal_profile_form" class="btn btn-default btn-flat" >Profile image</a>
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
    array(
        'id'=>'modal_profile_form',
        'header'=>'Change profile image',
        'description'=>'',
        'cancel_button_label'=>'Cancel',
        'inputs'=>[
            ['label'=>'Image file','id'=>'imageFileName','type'=>'file'],
        ],
        'submit_button_label'=>'Send','url'=>'/profileUpload',
        'hasFiles'=>'1',
        'callback'=>'nothing'
    ))
@endpush