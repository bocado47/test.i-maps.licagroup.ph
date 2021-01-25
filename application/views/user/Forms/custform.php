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
<form class="row needs-validation" id="cust_form">
	<div class="col">
		<div class="form-group row">
			<input type="hidden" name="invoice_id" value="<?php echo $id; ?>"/>
			<label for="cancel_reason" class="col-sm-12 col-form-label">Customer Name:</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" name="cust_name" id="cust_name"/>
			</div>
		</div>
		<div class="form-group row">
			<label for="alloc_date" class="col-sm-12 col-form-label">Alloc Date:</label>
			<div class="col-sm-12">
				<input type="date" class="form-control" name="alloc_date" id="alloc_date"/>
			</div>
		</div>
	</div>
</form>