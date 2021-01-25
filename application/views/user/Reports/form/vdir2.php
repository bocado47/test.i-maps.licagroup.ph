<html>
<head>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>

<style type="text/css">/* Chart.js */
 table {
   border-collapse: collapse;
 }

 table, th, td {
   border: 1px solid black;
   text-align: center;
   padding:2px;
 }
 @media print {
   #print {
     display: none;
   }
   #close {
     display: none;
   }
   #export {
     display: none;
   }
 }
 @page{
   size:auto;
   margin:1;
 }
 .button {
   background-color: #4CAF50; /* Green */
   border: none;
   color: white;
   padding: 15px 32px;
   text-align: center;
   text-decoration: none;
   display: inline-block;
   font-size: 16px;
 }
 .button2 {
   background-color: red; /* Green */
   border: none;
   color: white;
   padding: 15px 32px;
   text-align: center;
   text-decoration: none;
   display: inline-block;
   font-size: 16px;
 }
 .button3 {
   background-color: blue; /* Green */
   border: none;
   color: white;
   padding: 15px 32px;
   text-align: center;
   text-decoration: none;
   display: inline-block;
   font-size: 16px;
 }
</style>

 </head>
<body style="z-index:1px;">
<div>
 <button id="close" class="button2" style="float:right;padding: 10px; margin:10px; ">Close</button>
 <!-- <a href="<?php echo base_url();?>Report/download2?dealer=<?php echo $dealer; ?>" id="export" class="button3" style="float:right;padding: 10px; margin:10px;">Export</a> -->
 <button id="print" class="button" style="float:right;padding: 10px; margin:10px;">Print</button>
 <h2 style="text-align: center;">TEAM <?php echo $dealer; ?>  VIEW DAILY INVENTORY REPORT : <?php echo $status; ?></h2>
 <br>
 <h4 style="float:right;"><?php echo 'As of '.date('h:i a').', '.date('M d,Y'); ?></h4>
 <h4 style="float:left;">Total Units: <?php echo 'As of '.date('h:i a').', '.date('M d,Y'); ?></h4>
 <table style="width:100%;">
 </table>
