<?php
$CI =& get_instance();
$CI->load->model('Admin_m');
$access=$CI->Admin_m->access();
$ids=$id;
$dealer=$CI->Admin_m->branch2($ids);
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
<?php foreach($userprofile as $value) { ?>
<form class="row needs-validation" id="user_edit_form">
	<div class="col">
		<div class="form-group row">
			<label for="name" class="col-sm-12 col-form-label">Name:</label>
			<div class="col-sm-12">
				<input type="text"  class="form-control" name="name" id="name"  value="<?php echo $value->name; ?>" required/>
				<div class="invalid-feedback">
				    Please provide a Name.
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="email" class="col-sm-12 col-form-label">Email:</label>
			<div class="col-sm-12">
				<input type="text"  class="form-control" name="email" id="email" value="<?php echo $value->email; ?>" required/>
				<div class="invalid-feedback">
				    Please provide a Email.
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="type" class="col-sm-12 col-form-label">Type:</label>
			<div class="col-sm-12">
				<select class="form-control" name="type" id="type">
					<option value="">Select Type</option>
					<?php if($value->type == 1) { ?>
						<option value="1" selected>Admin</option>
						<option value="2" >Sales</option>
					<?php }else if($value->type == 2){ ?>
						<option value="1" >Admin</option>
						<option value="2" selected>Sales</option>
				<?php }else if($value->type == 3){ ?>
						<option value="1" >Admin</option>
						<option value="2" >Sales</option>
						<option value="3" selected>Treasury</option>
					<?php } ?>
				</select>
				<div class="invalid-feedback">
				        Please provide a Type.
				</div>
			</div>
		</div>
	</div>
</form>
<?php }?>
