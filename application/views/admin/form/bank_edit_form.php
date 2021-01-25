<?php
$CI =& get_instance();
$CI->load->model('Admin_m');
$access=$CI->Admin_m->access();
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
<form class="row needs-validation" id="bank_form2">
	<div class="col">
		<input type="hidden" value="<?php echo $id; ?>" name="id" />
		<?php foreach($bank as $value) { ?>
			<div class="form-group row">
				<label for="name" class="col-sm-12 col-form-label">Bank Code:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="bank_code"  value="<?php echo $value->bank_code; ?>" required/>
					<div class="invalid-feedback">
					        Please provide a Bank Code.
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label for="name" class="col-sm-12 col-form-label">Bank Description:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="Description" value="<?php echo $value->Description; ?>" required/>
					<div class="invalid-feedback">
					        Please provide a Bank Description.
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</form>
