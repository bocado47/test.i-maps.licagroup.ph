<?php
$CI =& get_instance();
$CI->load->model('main_m');
$pay_mode=$CI->main_m->pay_mode();
$financier=$CI->main_m->financier();
$vehicle=$CI->main_m->vehicles();
$sales=$CI->main_m->salesperson();
$bank=$CI->main_m->bank();
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
<form class="row needs-validation" id="invoice_form">
	<!-- <input type="hidden"  class="form-control" name="csnum" value="<?php echo $csnum; ?>"/>
	<input type="hidden"  class="form-control" name="id" value="<?php echo $value->id; ?>"/> -->
	<div class="col">
		<div class="form-group row">
				<div class="col-sm-12">
					<label for="vehicle_id" class="col-sm-12 col-form-label">Vehicle CS Number:</label>
					<div class="col-sm-12">
						<select class="form-control" name="vehicle_id" required>
							<option value="">Select CS Number</option>
							<?php foreach($vehicle as $vhcle){ ?>
							<option value="<?php echo $vhcle->id; ?>,<?php echo $vhcle->cs_num; ?>"><?php echo $vhcle->cs_num; ?></option>
							<?php } ?>
						</select>
						<div class="invalid-feedback">
							Please provide a Vehicle ID.
						</div>
					</div>
				</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4">
				<label for="last_name" class="col-sm-12 col-form-label">Last Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="last_name" />
				</div>
			</div>	
			<div class="col-sm-4">
				<label for="first_name" class="col-sm-12 col-form-label">First Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="first_name" />
				</div>
			</div>
			<div class="col-sm-4">
				<label for="middle_name" class="col-sm-12 col-form-label">Middle Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="middle_name" />
				</div>
			</div>	
		</div>		
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="company_name" class="col-sm-12 col-form-label">Company Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="company_name" />
				</div>
			</div>	
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="inv_num" class="col-sm-12 col-form-label">Invoice Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="inv_num" />
				</div>
			</div>
			<div class="col-sm-6">
				<label for="inv_amt" class="col-sm-12 col-form-label">Invoice Amount:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control money" name="inv_amt" />
				</div>
			</div>		
		</div>	
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="inv_date" class="col-sm-12 col-form-label">Invoice Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="inv_date" />
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="salesperson" class="col-sm-12 col-form-label">Salesperson:</label>
				<div class="col-sm-12">
					<select name="salesperson" class="form-control">
						<option value="">Select Sales Person</option>
						<?php foreach ($sales as $values) { ?>
							<option value="<?php echo $values->name; ?>"><?php echo $values->name; ?></option> 
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="term" class="col-sm-12 col-form-label">Term:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="term" />
				</div>
			</div>
			<div class="col-sm-6">
				<label for="bank" class="col-sm-12 col-form-label">Bank:</label>
				<div class="col-sm-12">
					<select name="bank" class="form-control">
						<option value="">Select Bank</option>
						<?php foreach ($bank as $value) { ?>
							<option value="<?php echo $value->bank_names; ?>"><?php echo $value->bank_names; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="grp_lica" class="col-sm-12 col-form-label">Group lica:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="grp_lica" />
				</div>
			</div>
			<div class="col-sm-6">
				<label for="grp_plant" class="col-sm-12 col-form-label">Group Plant:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="grp_plant" />
				</div>
			</div>
		</div>
				<div class="form-group row">
			<div class="col-sm-6">
				<label for="pr_date" class="col-sm-12 col-form-label">Plant Released Month:</label>
				<div class="col-sm-12">
					 <input type="text" name="pr_date" class="form-control form-control-1 input-sm montyr" placeholder="Plant Released Month">
				</div>
			</div>
			<div class="col-sm-6">
				<label for="ar_date" class="col-sm-12 col-form-label">Actual Released Date:</label>
				<div class="col-sm-12">
					<input type="text" name="sr_date" class="form-control form-control-1 input-sm dates" placeholder="Actual Released Date">
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="sr_date" class="col-sm-12 col-form-label">System Released Month:</label>
				<div class="col-sm-12">
					<input type="text" name="sr_date" class="form-control form-control-1 input-sm montyr" placeholder="System Released Month">
				</div>
			</div>

		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
			$('.money').mask("#,##0.00", {reverse: true});
			var bUrl="<?php echo base_url(); ?>";
			$('.montyr').datepicker({
			    	format: "mm-yyyy",
				    viewMode: "months", 
				    minViewMode: "months",
				    autoclose: true,
				});
				$('.dates').datepicker({
					format: "dd-mm-yyyy",
					autoclose: true,
				}); 
		});
</script>