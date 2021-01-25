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
	<div class="col">
		<div class="form-group row">
      <input type="hidden" name="po_num" value="<?php echo $po_num; ?>"/>
      <input type="hidden" name="csid" value="<?php echo $id; ?>"/>
			<div class="col-sm-12">
				<label for="received_date" class="col-sm-12 col-form-label">Vehicle Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="received_date" min='1990-01-01' value="" required/>
					<div class="invalid-feedback">
						Please provide a Vehicle Received Date.
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
