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
<form class="row needs-validation" id="release_form">
  <input type="hidden" name="cs_num" value="<?php echo $cs_num; ?>"/>
  <input type="hidden" name="po_num" value="<?php echo $po_num; ?>"/>
  <input type="hidden" name="csid" value="<?php echo $id; ?>"/>
	<div class="col">
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="received_date" class="col-sm-12 col-form-label">(IMAPS) Actual Release Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="imaps_release" min='1990-01-01' value="" required/>
					<div class="invalid-feedback">
						Please provide a IMAPS Actual Release Date.
					</div>
				</div>
			</div>
		</div>
    <div class="form-group row">
			<div class="col-sm-12">
				<label for="received_date" class="col-sm-12 col-form-label">(GP) Actual Release Date:</label>
				<div class="col-sm-12">

            <input type="date"  class="form-control" name="gp_release" min='1990-01-01' value="<?php foreach($gp as $vl){  echo $vl->released_date;  }?>" required readonly/>

					<div class="invalid-feedback">
						Please provide a GP Actual Release Date
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
