<?php
$CI =& get_instance();
$CI->load->model('Report_m');
$session_data = $CI->session->userdata('logged_in');
$datas=$session_data[0];
$type=$datas->type;
$id=$datas->id;
$ids=$datas->id;
if($type == 1)
{
	$brand=$CI->Dsar_m->Brands();
}else{
	$accessdealer=$CI->Admin_m->getaccess($ids);
	if(count($accessdealer) >= 1)
	{
		$brand=$CI->Dsar_m->Brands2($accessdealer);
	}else{
		$brand=$CI->Dsar_m->Brands();
	}
}

?>
<style type="text/css">
	a.disabled {
   pointer-events: none;
   cursor: default;
}
</style>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    </style>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
	<h1>Reports</h1>
	<br/>
	<!--  -->
	<div class="row">
	<div class="col">
		<div class="form-group row">
			<form action="<?php echo base_url(); ?>Report/VDIR2" method="GET" target="_blank">
				<div class="col-sm-4">
					<div class="card" style="width: 24rem; ">
						<div class="card-header">
					    	<h4 class="card-title">View Daily Inventory Report</h4>
						</div>
					  <div class="card-body">
					  	<h5 class="card-title">Select Dealer:</h5>
					    <p class="card-text">
					    	<select class="form-control" id="dealer" name="dealer" required>
					    		<option value="">Select Dealer</option>
					    		<?php foreach($brand as $value) { ?>
					    		<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
					    		<?php } ?>
					    	</select>
					    </p>
							<h5 class="card-title">Select  Inventory Status:</h5>
					    <p class="card-text">
					    	<select class="form-control" id="istatus" name="inv_status" required>
					    		<option value="">Select Inventory Status</option>
									<option value="For Pull Out">For Pull Out</option>
									<option value="Received">Receive</option>
									<option value="Released">Released</option>
									<option value"all">All</option>
					    	</select>
					    </p>
							<h5 class="card-title">Select  Accounting Status:</h5>
					    <p class="card-text">
					    	<select class="form-control" id="astatus" name="acc_status" required>
					    		<option value="">Select Accounting Status</option>
									<option value="Available">Available</option>
									<option value="Allocated">Allocated</option>
									<option value="Invoiced">Invoiced</option>
									<option value="Reported">Reported</option>
									<option value"all">All</option>
					    	</select>
					    </p>
							<input type="submit" class="btn btn-primary" value="Submit" />
					  </div>
					</div>
				</div>
				</form>
			</div>
	</div>
		<div class="col">
		<div class="form-group row">
			<form action="<?php echo base_url(); ?>Report/PRCR"  method="GET" target="_blank">
				<div class="col-sm-4">
					<div class="card" style="width: 24rem; ">
						<div class="card-header">
					    	<h4 class="card-title">View PO Running Count Report</h4>
						</div>
					  <div class="card-body">
					  	<h5 class="card-title">Select Dealer:</h5>
					    <p class="card-text">
					    	<select class="form-control" id="dealer" name="dealer" required>
					    		<option value="">Select Dealer</option>
					    		<?php foreach($brand as $value) { ?>
					    		<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
					    		<?php } ?>
					    	</select>
					    </p>
							<h5 class="card-title">Date:</h5>
							 <p class="card-text">
    						<input name="startDate" id="startDate" class="date-picker form-control" autocomplete="off" required/>
							 </p>
							<input type="submit" class="btn btn-primary" value="View Report"/>
					  </div>
					</div>
				</div>
				</form>
			</div>
	</div>
</div>

</main>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var bUrl="<?php echo base_url(); ?>";
		$('select').select2();
		$('#status').on('change',function(){
			 $dealer=$('#dealer').val();
			 $value=$(this).val();

			 // $vrval=$('#viewreport').val($value);

			 if($value == "" || $dealer =="")
			 {
			 	$('#viewreport').addClass("disabled");
			 	$("#viewreport").attr("href", "#");
			 }else{
			 	$('#viewreport').removeClass("disabled");
			 	$("#viewreport").attr("href", bUrl+"Report/VDIR?dealer="+$dealer+"&status="+$value);
			 }

		});
		$('.date-picker').datepicker({
				format: "mm-yyyy",
				viewMode: "months",
				minViewMode: "months",
				autoclose: true
		});
	});
</script>
