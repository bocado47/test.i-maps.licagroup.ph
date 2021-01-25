<?php
$CI =& get_instance();
$CI->load->model('Dsar_m');

$dealer=$CI->Dsar_m->cm();
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
<form class="row needs-validation" id="report_form">
  <input type="hidden" name="csid" value="<?php echo $id; ?>"/>
  <input type="hidden" name="po_num" value="<?php echo $po_num; ?>"/>
  	<div class="col">
  		<div class="form-group row">
  			<div class="col-sm-12">
  				<label for="plant_sales_report" class="col-sm-12 col-form-label">Plant Sales Report To:</label>
  				<div class="col-sm-12">
            <select class="form-control" name="plant_sales_report" id="plant_sales_report" required>
                <option value="">Select Dealer</options>
                  <?php foreach($dealer as $vl){ ?>
                            <option value="<?php echo $vl->Company.'-'.$vl->Branch; ?>"><?php echo $vl->Company.'-'.$vl->Branch;  ?></option>
                  <?php } ?>
            </select>
  					<div class="invalid-feedback">
  						Please provide a Plant Sales Report To.
  					</div>
  				</div>
  			</div>
  		</div>
      <div class="form-group row">
  			<div class="col-sm-12">
  				<label for="plant_sales_month" class="col-sm-12 col-form-label">Plant Sales Month:</label>
  				<div class="col-sm-12">
            <input type="text" class="form-control form-control-1 input-sm montyr" name="plant_sales_month" id="psm"  required/>
  					<div class="invalid-feedback">
  						Please provide a Plant Sales Month.
  					</div>
  				</div>
  			</div>
  		</div>
      <div class="form-group row">
  			<div class="col-sm-12">
  				<label for="whole_sale_period" class="col-sm-12 col-form-label">Whole Sale Period:</label>
  				<div class="col-sm-12">
            <input type="text" class="form-control form-control-1 input-sm montyr" name="whole_sale_period" id="swp"  required/>
  					<div class="invalid-feedback">
  						Please provide a Whole Sale Period.
  					</div>
  				</div>
  			</div>
  		</div>
      <div class="form-group row">
  			<div class="col-sm-12">
  				<label for="whole_sale_period" class="col-sm-12 col-form-label">Accounting Sale Period:</label>
  				<div class="col-sm-12">
            <input type="text" class="form-control" name="accounting_sale_period" id="awp"
						value="<?php foreach($gp as $value) { echo $value->sales_period; } ?>"
						 required readonly/>
  					<div class="invalid-feedback">
  						Please provide a Accounting Sale Period.
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('#plant_sales_report').select2({
      placeholder: "Select Location",
      width: "100%"
    });
    $('.montyr').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
    });
  });
</script>
