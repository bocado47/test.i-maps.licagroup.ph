<?php
$CI =& get_instance();
$CI->load->model('main_m');

?>
<style type="text/css">
	.jconfirm-content{
		overflow: hidden !important;
	}
	.jconfirm{
		z-index:1000;
	}
	textarea{
		resize: none;
	}
	.select2-container--default .select2-selection--single
	{
		height: calc(2.25rem + 2px) !important;
	}
</style>
<form class="row needs-validation" id="veh_update">
	<div class="col">
		<div class="form-group row">
			<input type="hidden" name="vehicle_id" value="<?php echo $id; ?>"/>
			<label for="veh_received" class="col-sm-12 col-form-label">Vehicle Release Date:</label>
			<div class="col-sm-12">
				<input type="date" class="form-control" id="veh_release" name="veh_received"/>
			</div>
		</div>
	</div>
</form>