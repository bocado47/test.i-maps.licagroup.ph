<?php
$PO=base_url()."Inventory/Purchase";
$Vehicle=base_url()."Inventory/Vehicle";
$Help=base_url()."Inventory/help";
$pull_out=base_url()."Inventory/pull_out";
$available=base_url()."Inventory/available";
$allocated=base_url()."Inventory/allocated";
$invoiced=base_url()."Inventory/invoiced";
$released=base_url()."Inventory/released";
$download=base_url()."Inventory/downloaddb";
$report=base_url()."Report/Dashboard";
$log=base_url()."Inventory/IELog";
$closedpo=base_url()."Inventory/closedpo";
$tboard=base_url()."Inventory/Tdashboard";
// $tboard="#";

$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
?>

<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/lica_ico.png">

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
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
          <?php if($datas->type == 1 ){ ?>
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>User's Navigation</span>
                <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
              </h6>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo $Vehicle; ?>">
                   <span data-feather="truck"></span>
                  Vehicle Inventory
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $PO; ?>">
                  <span data-feather="shopping-cart"></span>
                  Purchase Order
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $pull_out; ?>">
                   <span data-feather="external-link"></span>
                  For Pull-out
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $available; ?>">
                   <span  data-feather="check-circle"></span>
                  Available
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $allocated; ?>">
                   <span data-feather="link"></span>
                  Allocated
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $invoiced; ?>">
                   <span data-feather="file-text"></span>
                  Invoiced
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $released; ?>">
                   <span data-feather="truck"></span>
                  Released
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $closedpo; ?>">
                   <span data-feather="x-square"></span>
                  Closed P.O
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $Help; ?>">
                   <span data-feather="phone"></span>
                  Help
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $download; ?>">
                   <span data-feather="download"></span>
                  Download
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $report; ?>">
                   <span data-feather="book"></span>
                  Reports
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $log; ?>">
                  <span data-feather="x-square"></span>
                  Import Error Log
                </a>
              </li>

              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Admins Navigation</span>
                <a class="d-flex align-items-center text-muted" href="#"></a>
              </h6>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/user_table">
                  <span data-feather="users"></span>
                  Users Table
                </a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/FinancierTable">
                  <span data-feather="bar-chart"></span>
                  Financiers Table
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/PModeTable">
                  <span data-feather="dollar-sign"></span>
                  Payment modes Table
                </a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/LocationTable">
                  <span data-feather="map-pin"></span>
                  Locations Table
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/ModelsTable">
                  <span data-feather="database"></span>
                  Models Table
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/ColorTable">
                  <span data-feather="aperture"></span>
                  Model Color Table
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Admin/BankTable">
                  <span data-feather="trello"></span>
                  Bank Table
                </a>
              </li>
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                   <span>Treasury Navigation</span>
                 </h6>
               <li class="nav-item">
                 <a class="nav-link" href="<?php echo $tboard; ?>">
                     <span data-feather="gift"></span>
                     Treasury Dashboard
                 </a>
               </li>
          <?php }else if($datas->type == 2) { ?>
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>User's Navigation</span>
                <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
              </h6>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo $Vehicle; ?>">
                   <span data-feather="truck"></span>
                  Vehicle Inventory
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $PO; ?>">
                  <span data-feather="shopping-cart"></span>
                  Purchase Order
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $pull_out; ?>">
                   <span data-feather="external-link"></span>
                  For Pull-out
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $available; ?>">
                   <span  data-feather="check-circle"></span>
                  Available
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $allocated; ?>">
                   <span data-feather="link"></span>
                  Allocated
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $invoiced; ?>">
                   <span data-feather="file-text"></span>
                  Invoiced
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $released; ?>">
                   <span data-feather="truck"></span>
                  Released
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $closedpo; ?>">
                   <span data-feather="x-square"></span>
                  Closed P.O
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $Help; ?>">
                   <span data-feather="phone"></span>
                  Help
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $download; ?>">
                   <span data-feather="download"></span>
                  Download
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $report; ?>">
                   <span data-feather="book"></span>
                  Reports
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $log; ?>">
                  <span data-feather="x-square"></span>
                  Import Error Log
                </a>
              </li>
          <?php }else if($datas->type == 3) { ?>
             <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>User's Navigation</span>
                  <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
                </h6>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $PO; ?>">
                    <span data-feather="shopping-cart"></span>
                    Purchase Order
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo $download; ?>">
                   <span data-feather="download"></span>
                  Download
                </a>
              </li>
          <?php }else if($datas->type == 4){ ?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                 <span>Treasury Navigation</span>
                 <!-- <a class="d-flex align-items-center text-muted" href="#"></a> -->
               </h6>
             <li class="nav-item">
               <a class="nav-link" href="<?php echo $PO; ?>">
                   <span data-feather="gift"></span>
                   Treasury Dashboard
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
