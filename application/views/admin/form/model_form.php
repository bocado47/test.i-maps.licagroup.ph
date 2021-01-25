<?php
$CI =& get_instance();
$CI->load->model('Admin_m');
$brands=$CI->Admin_m->brands();
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
<form class="row needs-validation" id="model_form">
	<div class="col">
		<div class="form-group row">
			<label for="password" class="col-sm-12 col-form-label">Brand:</label>
			<div class="col-sm-12">
				<select class="form-control" name="brand" id="brand" required>
					<option value="">Select Brand</option>
					<?php foreach ($brands as $value) { ?>
					<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
					<?php } ?>
				</select>
				<div class="invalid-feedback">
				        Please provide a Type.
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="name" class="col-sm-12 col-form-label">New Model Name:</label>
			<div class="col-sm-12">
				<input type="text"  class="form-control" name="model" required/>
				<div class="invalid-feedback">
				        Please provide a Model Name.
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="name" class="col-sm-12 col-form-label">Series Name:</label>
			<div class="col-sm-12">
				<input type="text"  class="form-control" name="model_series" required/>
				<div class="invalid-feedback">
				        Please provide a Series Name.
				</div>
			</div>
		</div>
	</div>
</form>
