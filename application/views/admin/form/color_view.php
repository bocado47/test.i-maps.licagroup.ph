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
<form class="row needs-validation" id="color_form_e">
  <?php foreach($model as $vals) { ?>
	<div class="col">
		<!-- <div class="form-group row">
			<label for="brand" class="col-sm-12 col-form-label">Brand:</label>
			<div class="col-sm-12">
        <input type="hidden" name="id" value="<?php echo $vals->id; ?>" />
				<select class="form-control" name="brand" id="brand" required>
					<option value="">Select Brand</option>
					<?php foreach ($brands as $value) { ?>
              <?php if($vals->Company == $value->Company){ ?>
					           <option value="<?php echo $value->Company; ?>" selected><?php echo $value->Company; ?></option>
               <?php }else{ ?>
					            <option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
               <?php } ?>
          <?php } ?>
				</select>
				<div class="invalid-feedback">
				        Please provide a Type.
				</div>
			</div>
		</div> -->
		<div class="form-group row">
			<label for="name" class="col-sm-12 col-form-label">New Color Name:</label>
			<div class="col-sm-12">
				<input type="text"  class="form-control" name="color"  value="<?php echo $vals->color; ?>" required/>
				<input type="hidden"  class="form-control" name="model"  value="<?php echo $vals->model_id; ?>" required/>
				<input type="hidden"  class="form-control" name="last_color"  value="<?php echo $vals->color; ?>" required/>
				<input type="hidden"  class="form-control" name="id"  value="<?php echo $vals->id; ?>" required/>
				<div class="invalid-feedback">
				        Please provide a Color Name.
				</div>
			</div>
		</div>
	</div>
  <?php } ?>
</form>
