<?php
$CI =& get_instance();
$CI->load->model('main_m');
$pay_mode=$CI->main_m->pay_mode();
$financier=$CI->main_m->financier();
$sales=$CI->main_m->salesperson();
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
<?php foreach($info as $value) { ?>
<form class="row needs-validation" id="invoice_form">
	<div class="col">
		<div class="form-group row">

				<div class="col-sm-6">
					<label for="invoice_num" class="col-sm-12 col-form-label">Invoice Number:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="invoice_num" id="invoice_num" required/>
						<div class="invalid-feedback">
							Please provide a Invoice Number.
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="invoice_date" class="col-sm-12 col-form-label">Invoice Date:</label>
					<div class="col-sm-12">
						<input type="date"  class="form-control" name="invoice_date" id="invoice_date" required/>
						<div class="invalid-feedback">
							Please provide a Invoice Date.
						</div>
					</div>
				</div>


		</div>
		<div class="form-group row">
				<div class="col-sm-6">
					<label for="vehicle_id" class="col-sm-12 col-form-label">Vehicle CS Number:</label>
					<div class="col-sm-12">
						<input type="hidden"  class="form-control" name="vehicle_id" value="<?php echo $id; ?>"  readonly/>
						<input type="text"  class="form-control" name="cs_number" value="<?php echo $value->cs_num; ?>" required readonly/>
						<div class="invalid-feedback">
							Please provide a Vehicle ID.
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="cust_name" class="col-sm-12 col-form-label">Customer Name:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="cust_name" required/>
						<div class="invalid-feedback">
							Please provide a Customer Name.
						</div>
					</div>
				</div>
		</div>
		<div class="form-group row">
				<div class="col-sm-6">
					<label for="term" class="col-sm-12 col-form-label">Term:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="term"/>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="bank" class="col-sm-12 col-form-label">Bank:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="bank"/>
					</div>
				</div>
		</div>
		<div class="form-group row">
				<div class="col-sm-6">
					<label for="financier" class="col-sm-12 col-form-label">Financier:</label>
					<div class="col-sm-12">
						<select class="form-control" name="financier">
							<option >Select Financier</option>
							<?php foreach ($financier as $value) { ?>
							<option value="<?php echo $value->fin_name; ?>"><?php echo $value->fin_name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="fin_branch" class="col-sm-12 col-form-label">Financier Branch:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="fin_branch"/>
					</div>
				</div>
		</div>
		<div class="form-group row">
				<div class="col-sm-6">
					<label for="pay_mode" class="col-sm-12 col-form-label">Mode of Payment:</label>
					<div class="col-sm-12">
						<select class="form-control" name="pay_mode" required>
							<option value="">Select Mode Of Payment</option>
							<?php foreach ($pay_mode as $value) { ?>
							<option value="<?php echo $value->id; ?>"><?php echo $value->pay_mode; ?></option>
							<?php } ?>
						</select>
						<div class="invalid-feedback">
							Please provide a Payment Mode.
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="pay_amt" class="col-sm-12 col-form-label">Payment Amount:</label>
					<div class="col-sm-12">
						<input type="text"  min="0" class="form-control money" name="pay_amt" required/>
						<div class="invalid-feedback">
							Please provide a Payment amount.
						</div>
					</div>
				</div>
		</div>
		<div class="form-group row">
				<div class="col-sm-6">
					<label for="salesperson" class="col-sm-12 col-form-label">Sales Person:</label>
					<div class="col-sm-12">
						<select name="salesperson" class="form-control" required>
							<option value="">Select Sales Person</option>
							<?php foreach ($sales as $value) { ?>
							<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
							<?php } ?>
						</select>
						<div class="invalid-feedback">
							Please provide a Sales Person.
						</div>
					</div>
				</div>
		</div>
		<div class="form-group row">
				<div class="col-sm-6">
					<label for="grp_lica" class="col-sm-12 col-form-label">Group Lica:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="grp_lica"/>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="grp_plant" class="col-sm-12 col-form-label">Group Plant:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="grp_plant"/>
					</div>
				</div>
		</div>
		<div class="form-group row">
				<div class="col-sm-12">
					<label for="remarks" class="col-sm-12 col-form-label">Remarks:</label>
					<div class="col-sm-12">
						<textarea class="form-control" name="remarks"></textarea>
					</div>
				</div>
		</div>
		<div class="form-group row">
				<div class="col-sm-12" style="padding-top: 30px;">
					<label for=""></label>
					<div class="custom-control custom-checkbox">	
						<input type="checkbox" class="custom-control-input rlsd" name="release" id="cbOutos">	
						<label  class="custom-control-label" for="cbOutos" style="font-size: 18px;">Release Now</label>	
					</div>
				</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="pr_date" class="col-sm-12 col-form-label">Plant Released Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control release" name="pr_date" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="sr_date" class="col-sm-12 col-form-label">System Released Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control release" name="sr_date" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="ar_date" class="col-sm-12 col-form-label">Actual Released Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control release" name="ar_date" readonly/>
				</div>
			</div>
		</div>
	</div>
</form>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
			var bUrl="<?php echo base_url(); ?>";
			$('.money').mask("#,##0.00", {reverse: true});
			$('#invoice_num').on('change',function(){
	    		var invoicenum=$(this).val();
				$.ajax({
					url: bUrl+"Inventory/check_invoice_num?invoicenum="+invoicenum,
					type:"GET",
					dataType:"JSON",
					success:function(data)
					{
						console.log(data);
						if(data > 0)
						{
							 $.alert({
							 	type:'red',
	                            columnClass:"col-sm-6 col-sm-offset-4",
	                            title: '<h3 style="color:red;">Error</h3>',
	                             content: '<h5 style="color:red;">Invalid Invoice number.Your Invoice number is already exist, Thank you.</h5>',
							 });
							 $('#invoice_num').val("");
						}
					},
					error:function(){
						console.log('error');
					}
				});
			});
		$(".rlsd").on('change',function(){
			// alert($(this).val());
			// var val=$(this).val();
		
			if($(this).is(':checked')){
				$('#release_date').removeAttr('readonly');
			}else{
				$('#release_date').attr('readonly','readonly');
				$('#release_date').val("");
				// $('#release_date').attr('required','required');
			}	
		});
	});
</script>