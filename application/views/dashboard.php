<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $panelInit->settingsArray['siteTitle'] . " | " . $panelInit->language['dashboard'] ; ?></title>
    <base href="<?php echo $panelInit->baseURL; ?>/" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?php echo URL::asset('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL::asset('assets/bootstrap/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL::asset('assets/dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL::asset('assets/css/jquery.gritter.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL::asset('assets/plugins/fullcalendar/fullcalendar.min.css');?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo URL::asset('assets/dist/css/skins/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::asset('assets/css/intlTelInput.css'); ?>">
    <link href="<?php echo URL::asset('assets/css/schoex.css'); ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo URL::asset('assets/img/favicon.png'); ?>">
    <?php if($panelInit->isRTL == 1){ ?>
        <link href="<?php echo URL::asset('assets/css/rtl.css'); ?>" rel="stylesheet" type="text/css" />
    <?php } ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="hold-transition <?php echo $panelInit->defTheme; ?> sidebar-mini" ng-app="schoex" ng-controller="mainController">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="#/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->

          <span class="logo-mini"><?php echo $panelInit->settingsArray['siteTitle']; ?></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
              <?php
              if($panelInit->settingsArray['siteLogo'] == "siteName"){
                  echo $panelInit->settingsArray['siteTitle'];
              }elseif($panelInit->settingsArray['siteLogo'] == "text"){
                  echo $panelInit->settingsArray['siteLogoAdditional'];
              }elseif($panelInit->settingsArray['siteLogo'] == "image"){
                  echo "<img src='".URL::asset('assets/img/logo.png')."'/>";
              }
              ?>
          </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>




          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu navbar-right">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <?php
              if(isset($latestVersion)){ 
                  ?>
                  <!-- <li class="dropdown user user-menu"> 
                      <a href="#/upgrade" class="dropdown-toggle" data-toggle="dropdown">
                          <i class="glyphicon glyphicon-arrow-up"></i>
                          <span><?php //echo $panelInit->language['latestVersion']; ?> 
                                <?php //echo $latestVersion ?></span>
                      </a>
                  </li> -->
                  <?php
              }
              ?>
              <!-- <li class="dropdown user user-menu">
                <a href="#">
                 <b> {{currentAcademicYear.yearTitle}} Academy Year</b>
                </a>
              </li> -->
              <?php
              if($role == "admin"){
                  ?>
                  <li class="dropdown user user-menu">
                    <!-- Menu toggle button -->
                    <a ng-click="chgAcYearModal()">
                      <i class="fa fa-calendar-check-o"></i>
                      <b><span>{{currentAcademicYear.yearTitle}} Academy Year</span></b>
                    </a>
                  </li>
                  <?php
              }
              ?>

              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?php echo URL::to('/dashboard/profileImage/'.$users['id']); ?>" style="width:25px; height:25px;" class="user-image" alt="<?php echo $users['fullName']; ?>">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $users['fullName']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?php echo URL::to('/dashboard/profileImage/'.$users['id']); ?>" style="width:90px; height:90px;" class="img-circle" alt="<?php echo $users['fullName']; ?>">
                    <p>
                      <?php echo $users['fullName']; ?>
                      <small>UserName : <?php echo $users['username']; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                      <div class="col-xs-4 text-center">
                        <a href="#/accountSettings/profile"><?php echo $panelInit->language['ChgProfileData']; ?></a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#/accountSettings/email"><?php echo $panelInit->language['chgEmailAddress']; ?></a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#/accountSettings/password"><?php echo $panelInit->language['chgPassword']; ?></a>
                      </div>
                  </li>
                </ul> 
              </li>
              <li class="dropdown user user-menu">
                  <a target="_self" href="<?php echo URL::to('/logout'); ?>">
                      <i class="fa fa-fw fa-sign-out"></i>
                      <span><?php echo $panelInit->language['logout']; ?></span>
                  </a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo URL::to('/dashboard/profileImage/'.$users['id']); ?>" style="width:45px; height:45px;" class="img-circle" alt="<?php echo $users['fullName']; ?>">
            </div>
            <div class="pull-left info">
              <p><?php echo $users['fullName'];?></p>
            </div>
          </div>

          <!-- Sidebar Menu -->

          <ul class="sidebar-menu">
              <?php
              if($users->role == "admin" AND $users->customPermissionsType == "custom"){
                  $userPerm = $users->customPermissionsAsJson();
                  $performPermScan = true;
              }
              while (list($key, $value) = each($panelInit->panelItems)) {
                  if(isset($value['activated']) AND !strpos($panelInit->settingsArray['activatedModules'],$value['activated']) ){ continue;  }
                  if(!in_array($users->role, $value['permissions'])){
                      continue;
                  }
                  if(isset($performPermScan) AND isset($value['cusPerm']) AND $value['cusPerm'] != ""){
                      if(!in_array($value['cusPerm'],$userPerm)){
                          continue;
                      }
                  }
                  echo "<li ";
                  if(isset($value['children'])){
                      echo "class='treeview'";
                  }
                  echo ">";
                  echo "<a ";
                  if(!isset($value['children'])){
                      echo "class='aj'";
                  }
                  if(isset($value['url'])){
                      echo " href='".$value['url']."'";
                  }
                  echo ">";
                  echo "<i class='".$value['icon']."'></i><span>";
                  if(isset($panelInit->language[$value['title']])){
                      echo $panelInit->language[$value['title']];
                  }else{
                      echo $value['title'];
                  }
                  echo "</span>";
                  if(isset($value['children'])){
                      echo "<i class='fa fa-angle-left pull-right leftMenuExpand'></i>";
                  }
                  echo "</a>";
                  if(isset($value['children'])){
                      echo '<ul class="treeview-menu">';
                      while (list($key2, $value2) = each($value['children'])) {
                          if(isset($value2['activated']) AND !strpos($panelInit->settingsArray['activatedModules'],$value2['activated']) ){ continue;  }
                          if(!in_array($users->role, $value2['permissions'])){
                              continue;
                          }
                          if(isset($performPermScan) AND isset($value2['cusPerm']) AND $value2['cusPerm'] != ""){
                              if(!in_array($value2['cusPerm'],$userPerm)){
                                  continue;
                              }
                          }
                          echo "<li>";
                          echo "<a class='aj' href='".$value2['url']."'>";
                          echo "<i class='".$value2['icon']."'></i> ";
                          if(isset($panelInit->language[$value2['title']])){
                              echo $panelInit->language[$value2['title']];
                          }else{
                              echo $value2['title'];
                          }
                          echo "</a>";
                          echo "</li>";
                      }
                      echo "</ul>";
                  }

                  echo "</li>";
              }
              ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <div id='parentDBArea' class="content-wrapper" ng-view></div>
      <div id='overlay'>
            <div class="loading">
            	<div class="dot"></div>
            	<div class="dot2"></div>
            </div>
      </div>



      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <!-- Main Footer -->
    <footer class="main-footer">
      <strong><?php echo $panelInit->settingsArray['footer']; ?></strong> -  <a target="_BLANK" href="<?php echo URL::to('/terms'); ?>"><?php echo $panelInit->language['schoolTerms']; ?></a>
    </footer>
    <modal visible="chgAcYearModalShow">
        <div>
            <select class="form-control" id="selectedAcYear" ng-model="dashboardData.selectedAcYear">
              <option ng-selected="year.id == '<?php echo $panelInit->selectAcYear; ?>'" ng-repeat="year in $root.dashboardData.academicYear" value="{{year.id}}" ng-if="year.isDefault == '0'">{{year.yearTitle}}</option>
              <option ng-selected="year.id == '<?php echo $panelInit->selectAcYear; ?>'" ng-repeat="year in $root.dashboardData.academicYear" value="{{year.id}}" ng-if="year.isDefault == '1'">{{year.yearTitle}} - Default Year</option>
            </select>
            <br/>
            <a class="floatRTL btn btn-success btn-flat pull-right marginBottom15 ng-binding" ng-click="chgAcYear()"><?php echo $panelInit->language['chgYear']; ?></a>
            <div class="clearfix"></div>
        </div>
    </modal>
    <div ng-spinner-loader></div>

    <input type="hidden" id="rooturl" value="<?php echo URL::asset('/'); ?>"/>
    <input type="hidden" id="utilsScript" value="<?php echo URL::asset('assets/js/utils.js'); ?>"/>
    <script src="<?php echo URL::asset('assets/plugins/jQuery/jQuery-2.1.4.min.js'); ?>"></script>

    <script src="<?php echo URL::asset('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/dist/js/moment.min.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/plugins/humanize-duration/humanize-duration.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/plugins/fullcalendar/fullcalendar.min.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/plugins/fullcalendar/fullcalendar-lang-all.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/js/jquery.gritter.min.js'); ?>" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo URL::asset('assets/plugins/morris/morris.min.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/plugins/knob/jquery.knob.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/plugins/chartjs/Chart.min.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/plugins/ckeditor/ckeditor.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/js/jquery.colorbox-min.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/js/intlTelInput.min.js'); ?>"></script>

    <script src="<?php echo URL::asset('assets/dist/js/app.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/dist/js/demo.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/js/schoex.js'); ?>" type="text/javascript"></script>

    <script src="<?php echo URL::asset('assets/js/Angular/angular.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo URL::asset('assets/js/Angular/AngularModules.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo URL::asset('assets/js/Angular/app.js'); ?>"></script>
    <script src="<?php echo URL::asset('assets/js/Angular/routes.js'); ?>" type="text/javascript"></script>
</body>
</html>
