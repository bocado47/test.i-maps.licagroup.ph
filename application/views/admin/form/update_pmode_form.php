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
<form class="row needs-validation" id="pmode2">
	<div class="col">
		<div class="form-group row">
			<label for="name" class="col-sm-12 col-form-label">Payment Mode Name:</label>
			<div class="col-sm-12">
				<input type="hidden"  class="form-control" name="id"  value="<?php echo $id; ?>" required/>
				<input type="text"  class="form-control" name="name" value="<?php foreach($name as $val){ echo $val->pay_mode; }  ?>" required/>
				<div class="invalid-feedback">
				        Please provide a Name.
				</div>
			</div>
		</div>
	</div>
</form>
