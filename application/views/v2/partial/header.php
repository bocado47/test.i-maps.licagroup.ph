<?php
$PO=base_url()."Inventory/Purchase";
$Vehicle=base_url()."Inventory/Vehicle";
$Help=base_url()."Inventory/help";
$inventory_d=base_url()."Dashboard/inventory_d";
$pull_out=base_url()."Dashboard/for_pull_out_D";
$receive=base_url()."Dashboard/receive_D";
$available=base_url()."Dashboard/available_D";
$allocated=base_url()."Dashboard/allocated_D";
$invoiced=base_url()."Dashboard/invoiced_D";
$reported=base_url()."Dashboard/reported_D";
$released=base_url()."Dashboard/released_D";
$download=base_url()."Inventory/downloaddb";
$report=base_url()."Report/Dashboard";
// $report2=base_url()."Report/VDIR_D";
$log=base_url()."Inventory/IELog";
$closedpo=base_url()."Inventory/closedpo";
$tboard=base_url()."Inventory/Tdashboard";
$location=base_url()."Dashboard/Clocation";
// $tboard="#";

$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
// v2
$Search=base_url()."Dashboard/SearchDashboard";
$Request=base_url()."Dashboard/requestDashboard";
$ForApproval=base_url()."Dashboard/forApprovalDashboard";
$Approved=base_url()."Dashboard/ApprovedDashboard";
// v2
?>

<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="cache-control" content="no-cache">
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/xmaslogo.png">

    <title>Vehicle Inventory</title>

    <!-- Bootstrap core CSS -->
    <!--CSS-->
      <link href="<?php echo base_url(); ?>assets/bootstrap-4.2.1-dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- <link href="<?php echo base_url(); ?>assets/css/signin.css" rel="stylesheet"> -->
      <link href="<?php echo base_url(); ?>assets/css/jquery-confirm.min.css" rel="stylesheet">
      <link  rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css"/>
      <link  rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css"/>
      <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/css/datepicker.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <!-- CSS END -->

      <!-- JS -->
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-confirm.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>

      <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

      <script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.js"></script>

     <!--  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->
      <script src="<?php echo base_url(); ?>assets/js/bootstrap-notify-master/bootstrap-notify.min.js"></script>

      <!-- JS END -->

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/css/dashboard.css" rel="stylesheet">
  	<style type="text/css">/* Chart.js */

    .btn-sm{
  padding:.3rem 0.3rem !important;
  font-size: .775rem !important;
  line-height: 1 !important;
  border-radius: .2rem !important;
}
	@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}
  .sticky-top{
        z-index: 900 !important;
  }
  #apo{
    margin-right: 10px;
  }
  [data-notify="progressbar"] {
  margin-bottom: 0px;
  position: absolute;
  bottom: 0px;
  left: 0px;
  width: 100%;
  height: 5px;
}
#snowflakesCanvas{
  z-index: -1;
}
canvas#snowflakesCanvas{
  display:block;
}
canvas{
  position:fixed;
}
.xmas{
  color:#fff; font-weight:bold;
}
.xmasbtn{
  background-color: #002e5f !important;
  border-color: #ecf5ff important;
}
nav{
  background:linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 65%, rgba(0,212,255,1) 100%);
}
nav ul a{
  color:#fff !important;
}

.sidebar{
  z-index: 0 !important;
}
.sidebar .nav-link .feather {
    margin-right: 5px;
    color: #fff !important;
}
.hidden-un{
  /* display: none; */
  margin-left: 15px;
}
.hidden-is{
  /* display: none; */
  margin-left: 15px;
}
.hidden-as{
  /* display: none; */
  margin-left: 15px;
}
.hidden-an{
  /* display: none; */
  margin-left: 15px;
}
.hidden-tn{
  display: none;
  margin-left: 15px;
}
	</style>
	</head>

  <body>

    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><h4>I-MAPS</h4></a>
      <ul class="navbar-nav px-3 asp">
        <li class="nav-item text-nowrap">
          <button class="btn btn-primary" id="profile"><span data-feather="user"></span> Profile</button>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="display: block !important;">
          <canvas id=""></canvas>
          <div class="sidebar-sticky">

            <ul class="nav flex-column">
              <!-- <canvas id="snowflakesCanvas"></canvas> -->
          <?php if($datas->type == 1 ){ ?>
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <a href="#" id="UN"><span>User's Navigation</span></a>
                <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
              </h6>
              <li class="nav-item hidden-un">
                <a class="nav-link" href="<?php echo $Search; ?>">
                   <span data-feather="search"></span>
                    Search Dashboard
                </a>
              </li>
              <li class="nav-item hidden-un">
                <a class="nav-link" href="<?php echo $PO; ?>">
                  <span data-feather="shopping-cart"></span>
                  Purchase Order
                </a>
              </li>
              <li class="nav-item hidden-un">
                <a class="nav-link" href="<?php echo $location; ?>">
                   <span data-feather="map-pin"></span>
                  Change Location
                </a>
              </li>
              <li class="nav-item hidden-un">
                <a class="nav-link" href="<?php echo $report; ?>">
                   <span data-feather="book"></span>
                  Reports
                </a>
              </li>
              <li class="nav-item hidden-un">
                <a class="nav-link" href="<?php echo $log; ?>">
                  <span data-feather="x-square"></span>
                  Import Error Log
                </a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" href="<?php echo $pull_out; ?>">
                   <span data-feather="external-link"></span>
                  For Pull-out
                </a>
              </li> -->
              <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"> -->
                <!-- <a href="#" id="UN"><span>Reports Navigation</span></a> -->
                <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
              <!-- </h6> -->
              <!-- <li class="nav-item hidden-un">
                <a class="nav-link" href="<?php echo $report2; ?>">
                   <span data-feather="book"></span>
                  View Daily Inventory Report
                </a>
              </li> -->

              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <a href="#" id="UN"><span>Requestor's Navigation</span></a>
                <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
              </h6>
              <li class="nav-item hidden-un">
                <a class="nav-link" href="<?php echo $Request; ?>">
                   <span data-feather="phone-call"></span>
                    Request Dashboard
                </a>
              </li>
              <li class="nav-item hidden-un">
                <a class="nav-link" href="<?php echo $ForApproval; ?>">
                   <span data-feather="check-square"></span>
                    Request For Approval
                </a>
              </li>
              <li class="nav-item hidden-un">
                <a class="nav-link" href="<?php echo $Approved; ?>">
                   <span data-feather="check-circle"></span>
                    Approved Request
                </a>
              </li>

              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <a href="#" id="IS"><span>Status Category</span></a>
                <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
              </h6>
              <li class="nav-item hidden-is">
                <a class="nav-link" href="<?php echo $inventory_d; ?>">
                   <span  data-feather="log-out"></span>
                    Inventory Dashboard
                </a>
              </li>
              <li class="nav-item hidden-is">
                <a class="nav-link" href="<?php echo $receive; ?>">
                   <span data-feather="log-in"></span>
                   Accounting Dashboard
                </a>
              </li>


              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <a href="#" id="AN"><span>Admins Navigation</span></a>
              </h6>
              <li class="nav-item hidden-an">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/user_table">
                  <span data-feather="users"></span>
                  Users Table
                </a>
              </li>
              <li class="nav-item hidden-an">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/ModelsTable">
                  <span data-feather="database"></span>
                  Models Table
                </a>
              </li>
              <li class="nav-item hidden-an">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/ColorTable">
                  <span data-feather="aperture"></span>
                  Model Color Table
                </a>
              </li>
              <li class="nav-item hidden-an">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/LocationTable">
                  <span data-feather="aperture"></span>
                  Location Table
                </a>
              </li>
          <?php }else if($datas->type == 2) { ?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <a href="#" id="UN"><span>User's Navigation</span></a>
              <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
            </h6>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $Search; ?>">
                 <span data-feather="search"></span>
                  Search Dashboard
              </a>
            </li>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $PO; ?>">
                <span data-feather="shopping-cart"></span>
                Purchase Order
              </a>
            </li>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $location; ?>">
                 <span data-feather="map-pin"></span>
                Change Location
              </a>
            </li>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $report; ?>">
                 <span data-feather="book"></span>
                Reports
              </a>
            </li>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $log; ?>">
                <span data-feather="x-square"></span>
                Import Error Log
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="<?php echo $pull_out; ?>">
                 <span data-feather="external-link"></span>
                For Pull-out
              </a>
            </li> -->

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <a href="#" id="UN"><span>Requestor's Navigation</span></a>
              <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
            </h6>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $Request; ?>">
                 <span data-feather="phone-call"></span>
                  Request Dashboard
              </a>
            </li>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $ForApproval; ?>">
                 <span data-feather="check-square"></span>
                  Request For Approval
              </a>
            </li>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $Approved; ?>">
                 <span data-feather="check-circle"></span>
                  Approved Request
              </a>
            </li>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <a href="#" id="IS"><span>Inventory Status</span></a>
              <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
            </h6>
            <li class="nav-item hidden-is">
              <a class="nav-link" href="<?php echo $pull_out; ?>">
                 <span  data-feather="log-out"></span>
                Pull-Out
              </a>
            </li>
            <li class="nav-item hidden-is">
              <a class="nav-link" href="<?php echo $receive; ?>">
                 <span data-feather="log-in"></span>
                Receive
              </a>
            </li>
            <li class="nav-item hidden-is">
              <a class="nav-link" href="<?php echo $released; ?>">
                 <span data-feather="truck"></span>
                Released
              </a>
            </li>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <a href="#" id="AS"><span>Accounting Status</span></a>
              <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
            </h6>
            <li class="nav-item hidden-as">
              <a class="nav-link" href="<?php echo $available; ?>">
                 <span  data-feather="check-circle"></span>
                Available
              </a>
            </li>
            <li class="nav-item hidden-as">
              <a class="nav-link" href="<?php echo $allocated; ?>">
                 <span data-feather="link"></span>
                Allocated
              </a>
            </li>
            <li class="nav-item hidden-as">
              <a class="nav-link" href="<?php echo $invoiced; ?>">
                 <span data-feather="file-text"></span>
                Invoiced
              </a>
            </li>
            <li class="nav-item hidden-as">
              <a class="nav-link" href="<?php echo $reported; ?>">
                 <span data-feather="file-plus"></span>
                Reported
              </a>
            </li>


            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <a href="#" id="AN"><span>Admins Navigation</span></a>
              <a class="d-flex align-items-center text-muted" href="#"></a>
            </h6>
            <li class="nav-item hidden-an">
              <a class="nav-link" href="<?php echo base_url(); ?>Admin/ModelsTable">
                <span data-feather="database"></span>
                Models Table
              </a>
            </li>
            <li class="nav-item hidden-an">
              <a class="nav-link" href="<?php echo base_url(); ?>Admin/ColorTable">
                <span data-feather="aperture"></span>
                Model Color Table
              </a>
            </li>
          <?php }else if($datas->type == 3 OR $datas->type == 4) { ?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <a href="#" id="UN"><span>User's Navigation</span></a>
              <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
            </h6>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $Search; ?>">
                 <span data-feather="search"></span>
                  Search Dashboard
              </a>
            </li>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <a href="#" id="UN"><span>Requestor's Navigation</span></a>
              <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
            </h6>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $Request; ?>">
                 <span data-feather="phone-call"></span>
                  Request Dashboard
              </a>
            </li>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $ForApproval; ?>">
                 <span data-feather="check-square"></span>
                  Request For Approval
              </a>
            </li>
            <li class="nav-item hidden-un">
              <a class="nav-link" href="<?php echo $Approved; ?>">
                 <span data-feather="check-circle"></span>
                  Approved Request
              </a>
            </li>
          <?php } ?>
              <!--  <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Super Admin's Navigation</span>
                <a class="d-flex align-items-center text-muted" href="#"></a>
              </h6>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/config">
                  <span data-feather="settings"></span>
                  Config
                </a>
              </li> -->
            </ul>



          </div>
        </nav>
      </div>
      <div class="row">
