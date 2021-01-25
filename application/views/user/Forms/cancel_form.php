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
<form class="row needs-validation" id="invoice_form_cancel">
	<div class="col">
		<div class="form-group row">
			<input type="hidden" name="invoice_id" value="<?php echo $id; ?>"/>
			<label for="cancel_reason" class="col-sm-12 col-form-label">Reason for Cancellation:</label>
			<div class="col-sm-12">
				<textarea class="form-control" name="cancel_reason" required></textarea>
				<div class="invalid-feedback">
				        Please provide a Reason to Cancel.
				</div>
			</div>
		</div>
	</div>
</form>
