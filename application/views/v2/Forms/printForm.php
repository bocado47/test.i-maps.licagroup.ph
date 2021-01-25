<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
     <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

<style type="text/css">/* Chart.js */
 table {
   border-collapse: collapse;
   font-size: 11px !important;
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
   font-size: 13px;
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
 .summary td{
   font-weight: bold;
   border-width: 2px;
 }
 #table2 tr, #table2 td, #table2 th{
   border:0px !important;

 }
 .center {
  margin-left: auto;
  margin-right: auto;
}
@media print {
  #print {
    display: none;
  }
}
</style>
</head>
  <body>
    <h2 style="text-align:center;"> <?php echo $Brand.' PURCHASE REQUEST'; ?> </h2>
    <input type="button" id="print" value="Print" onClick="window.print()" style="float:right;">
      </br>
    <table style="width:100%; margin-top:2% !important; border:0px !important;" id="table">
      <thead>
        <tr style="border:0px !important;">
          <th colspan="10" style="border:0px !important;">Pending Request</th>
        </tr>
        <tr>
          <th colspan="2"></th>
          <th colspan="6">PO AND Current Invtry</th>
          <th colspan="2">Financial Cover</th>
        </tr>
        <tr>
          <th>Variant</th>
          <th>Color</th>
          <th>PO</th>
          <th>Approved/in transit PO</th>
          <th>Stock On Hand</th>
          <th>For Release</th>
          <th>End Invtry</th>
          <th>Remarks</th>
          <th>Cost/Unit</th>
          <th>Total Cost</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($data as $value){ ?>
        <tr>
          <td><?php echo $value['model']; ?></td>
          <td><?php echo $value['color']; ?></td>
          <td><?php echo $value['PO']; ?></td>
          <td><?php echo $value['approved']; ?></td>
          <td><?php echo $value['onhand']; ?></td>
          <td><?php echo $value['forrealease']; ?></td>
          <td><?php echo $value['end']; ?></td>
          <td><?php echo $value['remarks']; ?></td>
          <td><?php echo number_format($value['cost'], 2); ?></td>
          <td><?php echo number_format($value['totalcost'], 2); ?></td>
        </tr>
        <?php } ?>
        <tr class="summary">
          <td>PO SUMMARY COUNT</td>
          <td></td>
          <td><?php echo $POT; ?></td>
          <td><?php echo $AT; ?></td>
          <td><?php echo $OHT; ?></td>
          <td><?php echo $FRT; ?></td>
          <td><?php echo $EIT; ?></td>
          <td></td>
          <td><?php echo number_format($COSTT, 2);  ?></td>
          <td><?php  echo number_format($TCOSTT, 2);  ?></td>
        </tr>
      </tbody>
    </table>
      <table style="width:100%; margin-top:2% !important; border:0px !important;" id="table">
        <thead>
          <tr style="border:0px !important;"><th style="border:0px !important;"><h3></h3></th></tr>
          <tr style="border:0px !important;"><th style="border:0px !important;"><h3></h3></th></tr>
          <tr style="border:0px !important;"><th style="border:0px !important;"><h3></h3></th></tr>
          <tr style="border:0px !important;"><th style="border:0px !important;"><h3></h3></th></tr>
          <tr style="border:0px !important;"><th style="border:0px !important;"><h3></h3></th></tr>
          <tr style="border:0px !important;">
            <th colspan="10" style="border:0px !important;">Requested Series Inventory Picture</th>
          </tr>
          <tr>
            <th colspan="2">Model Series</th>
            <th>PO</th>
            <th>Approved/in transit PO</th>
            <th>Stock On Hand</th>
            <th>For Release</th>
            <th >End Invtry</th>
            <th colspan="3">Total Cost</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($series as $vls) { ?>
          <tr>
            <td colspan="2"><?php echo $vls ['model_series']; ?></td>
            <td><?php echo $vls ['quantity']; ?></td>
            <td><?php echo $vls ['approved']; ?></td>
            <td><?php echo $vls ['onhand']; ?></td>
            <td><?php echo $vls ['forelease']; ?></td>
            <td ><?php echo $vls ['endInv']; ?></td>
            <td colspan="3"><?php echo number_format($vls ['totalcost'], 2);  ?></td>
          </tr>
        <?php } ?>
        <tr class="summary">
          <td colspan="2"><?php echo $Brand.' TOTAL'; ?></td>
          <td><?php echo $SQTotal; ?></td>
          <td><?php echo $SATotal; ?></td>
          <td><?php echo $OHTotal; ?></td>
          <td><?php echo $SFRTotal; ?></td>
          <td ><?php echo $SEITotal; ?></td>
          <td colspan="3"><?php  echo number_format($SCTotal, 2); ?></td>
        </tr>
      </tbody>
    </table>

    <div id="test" style="text-align:center;">
      <table style="width:80%; margin-top:1% !important; border:0px !important;" class="center" id="table2">
        <thead>
          <tr>
            <th>Prepared By:</th>
            <th>Checked For Fund:</th>
            <th>Reviewed By:</th>
            <th>Approved For PO:</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td colspan="4">  </td>
            </tr>
            <tr>
              <td colspan="4">  </td>
            </tr>
          <tr>
            <td>Central Admin</td>
            <td>Finance Manager</td>
            <td>Peachy Muli </br> Deputy CFO</td>
            <td>KKL / FKL / RKL </br> CorSec/Managing Directors</td>
          </tr>
        </tbody>
      </table>
      <table style="width:80%; margin-top:2% !important; border:0px !important;" class="center" id="table2">
        <tbody>
          <tr>
            <td></td>
            <th>Received by:</th>
            <th>Received Date:</th>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td>Jessica Bulahan <br/> Treasury Officer</td>
            <td>__________________</td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>

  </body>
</html>
