<?php
$CI =& get_instance();
$CI->load->model('Admin_m');
$CI->load->model('main_m');
$access=$CI->Admin_m->access();
$brands=$CI->main_m->brands();
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
	#admin
	{
		display:none;
	}
</style>
<form class="row needs-validation" id="location_form">
	<div class="col">
		<div class="form-group row">
			<label for="Brand" class="col-sm-6 col-form-label">Brand:</label>
			<label for="Location" class="col-sm-6 col-form-label">Location:</label>
			<div class="col-sm-6">
				<select class="form-control" name="Brand">
					<option value="">Select Brand</option>
					<?php foreach($brands as $value){ ?>
						<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
					<?php } ?>
				</select>
				<div class="invalid-feedback">
				        Please provide a Brand.
				</div>
			</div>
			<div class="col-sm-6">
				<input type="text"  class="form-control" name="Location" required/>
				<div class="invalid-feedback">
				        Please provide a Brand.
				</div>
			</div>
		</div>
	</div>
</form>
