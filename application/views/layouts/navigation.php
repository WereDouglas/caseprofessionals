<?php
$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
$param1 = $this->uri->segment(3);
$param2 = $this->uri->segment(4);
?>

<div class="wrapper">
    
      <header class="main-header">
        <!-- Logo -->
        <a href="<?=base_url('/')?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"> CC Analysis </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?=base_url('dist/img/user2-160x160.jpg')?>" class="user-image" alt="User Image">
                  <span class="hidden-xs">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?=base_url('dist/img/user2-160x160.jpg')?>" class="img-circle" alt="User Image">
                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2012</small>
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->

            </ul>
          </div>
        </nav>
      </header>
           
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!--<li class="header">MAIN NAVIGATION</li>-->
            <li class="<?=("$controller/$action" == 'dashboard/index')?'active':''?>">
              <a href="<?=base_url('dashboard')?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="<?=("$param1" == 'tracking')?'active':''?> treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i>
                <span>Tacking</span><i class="fa fa-angle-left pull-right"></i>
                <!--<span class="label label-primary pull-right">4</span>-->
              </a>
              <ul class="treeview-menu">
                <li class="<?=("$controller/$action/$param1" == 'dashboard/sms/tracking')?'active':''?>">
                  <a href="<?=base_url('dashboard/sms/tracking')?>"><i class="fa fa-comment"></i> SMS</a>
                </li>
                <li class="<?=("$controller/$action/$param1" == 'dashboard/accounts/tracking')?'active':''?>">
                  <a href="<?=base_url('dashboard/accounts/tracking')?>"><i class="fa fa-dollar"></i> Accounts</a>
                </li>
                <li class="<?=("$controller/$action/$param1" == 'dashboard/qa/tracking')?'active':''?>">
                  <a href="<?=base_url('dashboard/qa/tracking')?>"><i class="fa fa-line-chart"></i> Qualitative Analysis</a>
                </li>
              </ul>
            </li>
            <li class="<?=("$param1" == 'trends')?'active':''?> treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Trends</span><i class="fa fa-angle-left pull-right"></i>
                <!--<span class="label label-primary pull-right">4</span>-->
              </a>
              <ul class="treeview-menu">
                <li class="<?=("$controller/$action/$param1" == 'dashboard/sms/trends')?'active':''?>">
                  <a href="<?=base_url('dashboard/sms/trends')?>"><i class="fa fa-comment"></i> SMS</a>
                </li>
                <li class="<?=("$controller/$action/$param1" == 'dashboard/accounts/trends')?'active':''?>">
                  <a href="<?=base_url('dashboard/accounts/trends')?>"><i class="fa fa-dollar"></i> Accounts</a>
                </li>
                <li class="<?=("$controller/$action/$param1" == 'dashboard/qa/trends')?'active':''?>">
                  <a href="<?=base_url('dashboard/qa/trends')?>"><i class="fa fa-line-chart"></i> Qualitative Analysis</a>
                </li>
              </ul>
            </li>
            <li class="<?=("$controller" == 'settings')?'active':''?> treeview">
              <a href="#">
                <i class="fa fa-cog"></i>
                <span>Settings</span><i class="fa fa-angle-left pull-right"></i>
                <!--<span class="label label-primary pull-right">4</span>-->
              </a>
              <ul class="treeview-menu">
                <li class="<?=("$controller/$action" == 'settings/servers')?'active':''?>">
                  <a href="<?=base_url('settings/servers')?>"><i class="fa fa-database"></i> Data Sources</a>
                </li>
                <li class="<?=("$controller/$action" == 'settings/clinics')?'active':''?>">
                  <a href="<?=base_url('settings/clinics')?>"><i class="fa fa-stethoscope"></i> Clinics</a>
                </li>
              </ul>
            </li>

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
                  