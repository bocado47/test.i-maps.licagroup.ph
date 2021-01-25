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
<form class="row needs-validation" id="receive_form">
<?php foreach($info as $val){ ?>
<input type="hidden" name="csnum" value="<?php echo $val->cs_num;; ?>"/>
	<div class="col">
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="vvr_num" class="col-sm-12 col-form-label">Reference number:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="vvr_num" value="<?php echo $val->vrr_num; ?>" />
					<div class="invalid-feedback">
						Please provide a Vehicle Receipt Report.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="received_date" class="col-sm-12 col-form-label">Vehicle Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="received_date" min='1990-01-01' value="<?php echo $val->veh_received; ?>" required/>
					<div class="invalid-feedback">
						Please provide a Vehicle Received Date.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="csr_date" class="col-sm-12 col-form-label">CSR Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="csr_date" min='1990-01-01' value="<?php echo $val->csr_received; ?>"/>
					<div class="invalid-feedback">
						Please provide a CSR Received Date.
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<?php } ?>
