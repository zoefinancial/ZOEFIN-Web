<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
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

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- <li class="header">HEADER</li> -->
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="#"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
            <li><a href="#"><i class="fa fa-signal"></i><span>Investments</span></a></li>
            <li><a href="#"><i class="fa fa-pencil-square-o"></i><span>Taxes</span></a></li>
            <li><a href="#"><i class="fa fa-usd "></i><span>Budgeting</span></a></li>
            <li><a href="#"><i class="fa fa-umbrella"></i><span>Insurance</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>