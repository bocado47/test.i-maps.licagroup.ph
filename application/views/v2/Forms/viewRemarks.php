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
<?php foreach($getRemarks as $vl) { ?>
<form class="row needs-validation" id="remarksEdit">
	<div class="col">
		<div class="form-group row">
			<input type="hidden" name="rt_id" value="<?php echo $vl->rt_id; ?>"/>
			<label for="cancel_reason" class="col-sm-12 col-form-label">Remarks / Justification</label>
			<div class="col-sm-12">
				<input type="text" class='form-control' id="justification" name="justification" value="<?php echo $vl->justification; ?>" readonly/>
				<div class="invalid-feedback">
				        Please provide a Justifcation.
				</div>
			</div>
		</div>
	</div>
</form>
<?php } ?>
