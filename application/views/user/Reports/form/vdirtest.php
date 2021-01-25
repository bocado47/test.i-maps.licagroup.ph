<html>
<head>
     <!-- JS -->
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>

     <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>

<style type="text/css">/* Chart.js */
 table {
   border-collapse: collapse;
 }
 h3{
   font-weight: normal;
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
<?php
$invStatus='';
$accStatus='';
foreach($report as $value) {
  $invStatus = $value['Inv_stats'];
  $accStatus = $value['Acc_stats'];
break;
}
?>
<body style="z-index:1px;">
<div>
 <button id="close" class="button2" style="float:right;padding: 10px; margin:10px; ">Close</button>

 <a href="<?php echo base_url();?>Report/download2?dealer=<?php echo $dealer; ?>&inv_status=<?php echo $invStatus; ?>&acc_status=<?php echo  $accStatus;?>" id="export" class="button3" style="float:right;padding: 10px; margin:10px;">Export</a>

 <button id="print" class="button" style="float:right;padding: 10px; margin:10px;">Print</button>
 <h2 style="text-align: center;">TEAM <?php echo $dealer; ?>  VIEW DAILY INVENTORY REPORT</h2>
 <h3 style="text-align: center;"><b>Accounting Status:</b> <u><?php echo $acc_status;?></u> <b>Inventory Status:</b> <u><?php echo $inv_status;?></u></h3>
 <br>
 <h4 style="float:right;"><?php echo 'As of '.date('h:i a').', '.date('M d,Y'); ?></h4>

 <h3 style="float:left; padding-left:50px;">Total Units: <u><?php echo $counts; ?></u></h3>
 <table style="width:100%;">
   <thead></thead>
   <tbody>
     <?php foreach($report as $value) {
       $info=$value['Info'];
       $count=0;
     ?>
     <?php if($accStatus == 'Available' OR $accStatus == 'All') { ?>
       <tr>
         <td colspan="12"><h3><?php echo ucfirst(strtolower($dealer)).' '.$value['Model']; ?></h3></td>
       </tr>
     <tr>
       <td>CS NUM</td>
       <td>COLOR</td>
       <td>YEAR</td>
       <td>PO DATE</td>
       <td>RECEIVED DATE</td>
       <td>PO NUM</td>
       <td>VIN NUM</td>
       <td>LOCATION</td>
       <td>PLANT SALE REPORTED</td>
       <td>PLANT SALE MONTH</td>
       <td>AGING</td>
       <td>REMARKS</td>
     </tr>
  <?php }else if($accStatus == 'Allocated') { ?>
    <tr>
      <td colspan="10"><h3><?php echo ucfirst(strtolower($dealer)).' '.$value['Model']; ?></h3></td>
    </tr>
     <tr>
       <td>ALLOCATION DATE</td>
       <td>ALLOCATION DEALER</td>
       <td>CS NUM</td>
       <td>COLOR</td>
       <td>YEAR</td>
       <td>AGING</td>
       <td>ALLOCATED AGE</td>
       <td>PLANT SALE REPORTED</td>
       <td>PLANT SALE MONTH</td>
       <td>REMARKS</td>
     </tr>
  <?php }else if($accStatus == 'Invoiced' || $accStatus == 'Reported') { ?>
    <tr>
      <td colspan="18"><h3><?php echo ucfirst(strtolower($dealer)).' '.$value['Model']; ?></h3></td>
    </tr>
     <tr>
       <td>ALLOCATION DATE</td>
       <td>ALLOCATION DEALER</td>
       <td>ACCOUNT NAME</td>
       <td>CS NUM</td>
       <td>COLOR</td>
       <td>YEAR</td>
       <td>AGING</td>
       <td>ALLOCATED AGE</td>
       <td>INVOICED AGE</td>
       <td>INVOICE NUMBER</td>
       <td>INVOICE DATE</td>
       <td>PAYMENT MODE</td>
       <td>AGENT</td>
       <td>MANAGER</td>
       <td>GROUP</td>
       <td>PLANT SALE REPORTED</td>
       <td>PLANT SALE MONTH</td>
       <td>REMARKS</td>
     </tr>
   <?php } ?>
     <?php foreach($info as $val){ $count++; ?>
     <?php if($accStatus == 'Available' OR $accStatus == 'All') { ?>
       <tr>
         <td><?php echo $val['cs_num']; ?></td>
         <td><?php echo $val['color']; ?></td>
         <td><?php echo $val['dlr']; ?></td>
         <td><?php echo $val['mth_d_f_o']; ?></td>
         <td><?php echo $val['received']; ?></td>
         <td><?php echo $val['po_num']; ?></td>
         <td><?php echo $val['vin']; ?></td>
         <td><?php echo $val['loc']; ?></td>
         <td><?php echo $val['psr']; ?></td>
         <td><?php echo $val['psd']; ?></td>
         <td><?php echo $val['aging']; ?></td>
         <td><?php echo $val['Remarks']; ?></td>
       </tr>
   <?php }else if($accStatus == 'Allocated') { ?>
       <tr>
         <td><?php echo $val['alloc_date']; ?></td>
         <td><?php echo $val['alloc_dealer']; ?></td>
         <td><?php echo $val['cs_num']; ?></td>
         <td><?php echo $val['color']; ?></td>
         <td><?php echo $val['dlr']; ?></td>
         <td><?php echo $val['aging']; ?></td>
         <td><?php echo $val['allocatedAge']; ?></td>
         <td><?php echo $val['psr']; ?></td>
         <td><?php echo $val['psd']; ?></td>
         <td><?php echo $val['Remarks']; ?></td>
       </tr>
    <?php }else if($accStatus == 'Invoiced' || $accStatus == 'Reported') { ?>
      <tr>
        <td><?php echo $val['alloc_date']; ?></td>
        <td><?php echo $val['alloc_dealer']; ?></td>
        <td><?php echo $val['accName']; ?></td>
        <td><?php echo $val['cs_num']; ?></td>
        <td><?php echo $val['color']; ?></td>
        <td><?php echo $val['dlr']; ?></td>
        <td><?php echo $val['aging']; ?></td>
        <td><?php echo $val['allocatedAge']; ?></td>
        <td><?php echo $val['invoicedAge']; ?></td>
        <td><?php echo $val['invNumber']; ?></td>
        <td><?php echo $val['invDate']; ?></td>
        <td><?php echo strtoupper(str_replace('_', ' ', $val['paymentMode'])); ?></td>
        <td><?php echo $val['agent']; ?></td>
        <td><?php echo $val['manager']; ?></td>
        <td><?php echo $val['group']; ?></td>
        <td><?php echo $val['psr']; ?></td>
        <td><?php echo $val['psd']; ?></td>
        <td><?php echo $val['Remarks']; ?></td>
      </tr>
     <?php } ?>
       <tr>
   <?php } ?>
   <?php if($accStatus == 'Available' OR $accStatus == 'All') { ?>
     <td colspan="11" style="text-align: right !important;">
       <?php echo ucfirst(strtolower($dealer)).' '.$value['Model']; ?> :
     </td>
     <td><?php echo $count; ?></td>
   <?php }else if($accStatus == 'Allocated') { ?>
     <td colspan="9" style="text-align: right !important;">
       <?php echo ucfirst(strtolower($dealer)).' '.$value['Model']; ?> :
     </td>
     <td><?php echo $count; ?></td>
   <?php }else if($accStatus == 'Invoiced' || $accStatus == 'Reported') { ?>
     <td colspan="17" style="text-align: right !important;">
       <?php echo ucfirst(strtolower($dealer)).' '.$value['Model']; ?> :
     </td>
     <td><?php echo $count; ?></td>
   <?php } ?>

       </tr>
     <?php } ?>
   </tbody>
 </table>
</div>
</body>
</html>
<script type="text/javascript">
 $(document).ready(function() {
   var bUrl="<?php echo base_url(); ?>";
   $("#print").on('click',function(){
     window.print();
   });
   $('#close').on('click',function(){
      window.location.href=bUrl+'Report/Dashboard';
   });

 });
</script>
