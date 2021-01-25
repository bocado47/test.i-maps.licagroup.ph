<?php
$CI =& get_instance();
$CI->load->model('Report_m');
$session_data = $CI->session->userdata('logged_in');
$datas=$session_data[0];
$type=$datas->type;
$id=$datas->id;
if($type == 1)
{
	$brand=$CI->Report_m->Brands();
}else{
	$brand=$CI->Report_m->Brands2($id);
}

?>
<style type="text/css">
	a.disabled {
   pointer-events: none;
   cursor: default;
}
</style>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
	<h1>Download Data</h1>
	<br/>
	<!--  -->
	<div class="col">
		<div class="form-group row">
				<div class="col-sm-4 col-md-4 col-lg-4">
					<div class="card" style="width: 24rem; ">
						<div class="card-header">
					    	<h4 class="card-title">Download Monthly Data</h4>
						</div>
					  <div class="card-body">
					  	<h5 class="card-title">Select Month:</h5>
              <form method="POST" action="<?php echo base_url(); ?>Inventory/download" name="form1">
					    <p class="card-text">
					    	<input type="text" name="Month" class="form-control form-control-1 input-sm montyr" placeholder="Month" required>
					    </p>
					    <button type="submit" class="btn btn-sm btn-success" style="float:right">Submit</button>
              </form>
					  </div>
					</div>
				</div>
		</div>
	</div>
  <div class="col">
		<div class="form-group row">
				<div class="col-sm-4 col-md-4 col-lg-4">
					<div class="card" style="width: 24rem; ">
						<div class="card-header">
					    	<h4 class="card-title">Download All Data</h4>
						</div>
					  <div class="card-body">
              <form method="POST" action="<?php echo base_url(); ?>Inventory/download2" name="form2">
					    <button type="submit" class="btn btn-sm btn-success" style="float:right">Download Now</button>
              </form>
					  </div>
					</div>
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
    $('.montyr').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
    });

	});
</script>
