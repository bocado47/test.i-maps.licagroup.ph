<?php
$CI =& get_instance();
$CI->load->model('Dashboard_m');

$location=$CI->Dashboard_m->Location2();
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
<form class="row needs-validation" id="change_loc_form">
	<div class="col">
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="received_date" class="col-sm-12 col-form-label">Location:</label>
				<div class="col-sm-12">
          <select class="form-control" name="location" id="location">
              <option value="">Select Location</options>
                <?php foreach($location as $vl){ ?>
                  <?php if($vl->Location == $value->location){ ?>
                        <option value="<?php echo $vl->Location; ?>" selected><?php echo $vl->Location; ?></option>
                  <?php }else{ ?>
                        <option value="<?php echo $vl->Location; ?>"><?php echo $vl->Location; ?></option>
                  <?php } ?>
                <?php } ?>
          </select>
					<div class="invalid-feedback">
						Please provide a Location.
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('#location').select2({
      placeholder: "Select Location",
      width: "100%"
    });
  });
</script>
