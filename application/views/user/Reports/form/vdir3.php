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
</style>
</head>
<body>
  <!-- <input type="hidden" id="dealer" value="<?php foreach($value['report']  as $value) {  echo $value['Dealer']; break; } ?>"/> -->
  <!-- <h1 style="text-align:center"><?php foreach($report as $value) { echo $value['Dealer']; break; } ?></h1> -->
  <button id="btnExport" class="btn btn-success btn-sm button" style="float:right">EXPORT REPORT</button>
  <table style="width:100%; margin-top:10% !important" id="table">
    <thead>
      <tr>
        <?php foreach($newreport as $vl) { ?>
          <?php foreach($vl['report'] as $value) { ?>
            <th rowspan="2">Model</th>
            <th rowspan="2">Beginning Count</th>
            <?php foreach($value['Counts'] as $vl) { ?>
              <th colspan="3"><?php echo $vl['Month']; ?> </th>
            <?php } ?>
                <?php break; ?>
          <?php } ?>
            <?php break; ?>
        <?php } ?>
      </tr>
      <tr>
        <?php foreach($newreport as $vl) { ?>
          <?php foreach($vl['report']  as $value) { ?>
            <?php foreach($value['Counts'] as $vl) { ?>
              <th><?php echo 'Recieved'; ?> </th>
              <th><?php echo 'Release'; ?> </th>
              <th><?php echo 'End Count'; ?> </th>
            <?php } ?>
                <?php break; ?>
          <?php } ?>
          <?php break; ?>
        <?php } ?>
      </tr>
    </thead>

    <tbody>
      <?php foreach($newreport as $vl) { ?>
        <?php $series=$vl['Series']; ?>
        <?php $BeginCount=$vl['BeginCount'];  ?>
        <?php $count=$vl['Counts'];?>
        <tr   style="color:white; background-color:black;">
           <td style="font-size:16px;"><B><?php echo $series; ?><b/></td>
           <td><B><?php echo $BeginCount;?><b/></td>
             <?php foreach($count as $vls) { ?>
               <td><?php echo $vls['Purchase']; ?> </td>
               <td><?php echo $vls['Release']; ?> </td>
               <td><?php echo $vls['Total']; ?> </td>
             <?php } ?>
        </tr>
        <?php foreach($vl['report']  as $value) {
          $count=count($value['Counts']);?>
          <tr  id="sampletable">
            <td><B><?php echo $value['model']; ?><b/></td>
            <td><?php echo $value['BeginCount']; ?></td>
            <?php foreach($value['Counts'] as $vl) { ?>
              <td><?php echo $vl['Purchase']; ?> </td>
              <td><?php echo $vl['Release']; ?> </td>
              <td><?php echo $vl['Total']; ?> </td>
            <?php } ?>
          </tr>
        <?php } ?>

      <?php } ?>
      <?php if($count > 2){ ?>
      <tr  style="color:white; background-color:black;">
        <td style="font-size:16px;"><b>End Count</b></td>
        <td id="Beggining" style="font-weight: bold;"></td>
        <td id="rv1" style="font-weight: bold;"></td>
        <td id="rl1" style="font-weight: bold;"></td>
        <td id="test" style="font-weight: bold;"></td>
        <td id="rv2" style="font-weight: bold;"></td>
        <td id="rl2" style="font-weight: bold;"></td>
        <td id="test2" style="font-weight: bold;"></td>
        <td id="rv3" style="font-weight: bold;"></td>
        <td id="rl3" style="font-weight: bold;"></td>
        <td id="test3" style="font-weight: bold;"></td>
      </tr>
      <?php }else if($count < 2){ ?>
        <tr  style="color:white; background-color:black;">
          <td style="font-size:16px;"><b>End Count</b></td>
          <td id="Beggining" style="font-weight: bold;"></td>
          <td id="rv1" style="font-weight: bold;"></td>
          <td id="rl1" style="font-weight: bold;"></td>
          <td id="test" style="font-weight: bold;"></td>
        </tr>
      <?php } else { ?>
        <tr  style="color:white; background-color:black;">
          <td style="font-size:16px;"><b>End Count</b></td>
          <td id="Beggining" style="font-weight: bold;"></td>
          <td id="rv1" style="font-weight: bold;"></td>
          <td id="rl1" style="font-weight: bold;"></td>
          <td id="test" style="font-weight: bold;"></td>
          <td id="rv2" style="font-weight: bold;"></td>
          <td id="rl2" style="font-weight: bold;"></td>
          <td id="test2" style="font-weight: bold;"></td>
        </tr>
       <?php } ?>
    </tbody>

  </table>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function() {
    $('#btnExport').each(function(){
      var $this = $(this);
      var t = $this.text();
      $this.html(t.replace('&lt','<').replace('&gt', '>'));
    });
    var Dealer = $("#dealer").val();
    var Beggining=0;
    var sum = 0;
    var sum2 = 0;
    var sum3= 0;
    var rv1= 0;
    var rl1= 0;
    var rv2= 0;
    var rl2= 0;
    var rv3= 0;
    var rl3= 0;
    $("#sampletable td:nth-child(2)").each(function(){
        Beggining += parseInt($(this).text());
    });
    $("#sampletable td:nth-child(3)").each(function(){
        rv1 += parseInt($(this).text());
    });
    $("#sampletable td:nth-child(4)").each(function(){
        rl1 += parseInt($(this).text());
    });
    $("#sampletable td:nth-child(5)").each(function(){
        sum += parseInt($(this).text());
    });
    $("#sampletable td:nth-child(6)").each(function(){
        rv2 += parseInt($(this).text());
    });
    $("#sampletable td:nth-child(7)").each(function(){
        rl2 += parseInt($(this).text());
    });
    $("#sampletable td:nth-child(8)").each(function(){
        sum2 += parseInt($(this).text());
    });
    $("#sampletable td:nth-child(9)").each(function(){
        rv3 += parseInt($(this).text());
    });
    $("#sampletable td:nth-child(10)").each(function(){
        rl3 += parseInt($(this).text());
    });
    $("#sampletable td:nth-child(11)").each(function(){
        sum3 += parseInt($(this).text());
    });
    $("#Beggining").text(Beggining);
    $("#test").text(sum);
    $("#test2").text(sum2);
    $("#test3").text(sum3);
    $("#rv1").text(rv1);
    $("#rl1").text(rl1);
    $("#rv2").text(rv2);
    $("#rl2").text(rl2);
    $("#rv3").text(rv3);
    $("#rl3").text(rl3);
    // console.log(sum);

    $("#btnExport").click(function() {
       let table = document.getElementsByTagName("table");
       TableToExcel.convert(table[0], { // html code may contain multiple tables so here we are refering to 1st table tag
          name: `po_runningcount_`+Dealer+`.xlsx`, // fileName you could use any name
          sheet: {
             name: 'Sheet 1' // sheetName
          }
       });
   });
  });
</script>
