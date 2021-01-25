<?php
$CI =& get_instance();
$CI->load->model('main_m');
$pay_mode=$CI->main_m->pay_mode();
$financier=$CI->main_m->financier();
$vehicle=$CI->main_m->vehicles2();
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
<?php foreach($info as $val){ ?>
<form class="row needs-validation" id="invoice_form_update">
	<div class="col">
		<div class="form-group row">
			<input type="hidden" name="id" value="<?php echo $id; ?>"/>
			<div class="col-sm-6">
				<label for="invoice_num" class="col-sm-12 col-form-label">Invoice Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="invoice_num"  id="invoice_num" value="<?php echo $val->invoice_num; ?>" required disabled/>
					<div class="invalid-feedback">
						Please provide a Invoice Number.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="invoice_date" class="col-sm-12 col-form-label">Invoice Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="invoice_date" id="invoice_date_3" value="<?php echo $val->invoice_date; ?>" required disabled/>
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
					<!-- <input type="text"  class="form-control" name="cust_name" value="<?php echo  $val->vehicle_id; ?>" required disabled/> -->
					<select class="form-control" name="vehicle_id" required disabled>
						<option >Select CS Number</option>
						<?php foreach($vehicle as $vhcle){ ?>
						<?php if($vhcle->id == $val->vehicle_id){ ?> 
						<option value="<?php echo $vhcle->id; ?>" selected><?php echo $vhcle->cs_num; ?>
							<?php }else{ ?>
							<option value="<?php echo $vhcle->id; ?>"><?php echo $vhcle->cs_num; ?>
								<?php }?>
							</option>
							<?php } ?>
						</select>
						<div class="invalid-feedback">
							Please provide a Vehicle ID.
						</div>
				</div>
			</div>
			<div class="col-sm-6">
					<label for="cust_name" class="col-sm-12 col-form-label">Customer Name:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="cust_name" value="<?php echo  $val->cust_name; ?>" required disabled/>
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
						<input type="text"  class="form-control" name="term" value="<?php echo  $val->term; ?>" disabled/>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="bank" class="col-sm-12 col-form-label">Bank:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="bank" value="<?php echo  $val->bank; ?>" disabled/>
					</div>
				</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="financier" class="col-sm-12 col-form-label">Financier:</label>
				<div class="col-sm-12">
					<select class="form-control" name="financier" disabled>
						<option >Select Financier</option>
						<?php foreach ($financier as $value) { ?>
							<?php if($value->fin_name == $val->financier){ ?> 
							<option value="<?php echo $value->fin_name; ?>" selected>
							<?php }else{ ?>
							<option value="<?php echo $value->fin_name; ?>">
							<?php }?><?php echo $value->fin_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="fin_branch" class="col-sm-12 col-form-label">Financier Branch:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="fin_branch" value="<?php echo  $val->fin_branch; ?>" disabled/>
			 	</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="pay_mode" class="col-sm-12 col-form-label">Mode of Payment:</label>
				<div class="col-sm-12">
					<select class="form-control" name="pay_mode" required disabled>
						<option >Select Mode Of Payment</option>
						<?php foreach ($pay_mode as $value) { ?>
							<?php if($value->id == $val->pay_mode){ ?> 
							<option value="<?php echo $value->id; ?>" selected><?php echo $value->pay_mode; ?>
							<?php }else{ ?>
							<option value="<?php echo $value->id; ?>"><?php echo $value->pay_mode; ?>
							<?php }?>
							</option>
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
					<input type="text"  class="form-control money" name="pay_amt"  value="<?php echo  $val->pay_amt; ?>" required readonly disabled/>
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
					<select name="salesperson" class="form-control" required disabled>
						<option >Select Sales Person</option>
						<?php foreach ($sales as $value) { ?>
							<?php if($value->id == $val->salesperson){ ?> 
							<option value="<?php echo $value->id; ?>" selected>
							<?php }else{ ?>
							<option value="<?php echo $value->id; ?>">
							<?php }?><?php echo $value->name; ?></option>
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
						<input type="text"  class="form-control" name="grp_lica" value="<?php echo $val->grp_lica; ?>" disabled/>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="grp_plant" class="col-sm-12 col-form-label">Group Plant:</label>
					<div class="col-sm-12">
						<input type="text"  class="form-control" name="grp_plant" value="<?php echo $val->grp_plant; ?>" disabled/>
					</div>
				</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="remarks" class="col-sm-12 col-form-label">Remarks:</label>
				<div class="col-sm-12">
					<textarea class="form-control" name="remarks" disabled><?php echo  $val->remarks; ?></textarea>
				</div>
			</div>
		</div>
		<?php $cancel=strlen($val->cancelled_by);
			if($cancel > 0)
			{
				$id=$val->cancelled_by;
				$name=$this->Main_m->userCancel($id);
		?>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="canceled_date" class="col-sm-12 col-form-label">Cancelled Date:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="canceled_date"  id="canceled_date"  value="<?php echo $val->cancel_date; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="canceled_date" class="col-sm-12 col-form-label">Cancelled By:</label>
				<div class="col-sm-12">
				<input type="text" class="form-control" name="cancelled_by"  id="cancelled_by"  value="<?php foreach($name as $vals){ echo $vals->name; } ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="cr" class="col-sm-12 col-form-label">Reason For Cancellation:</label>
				<div class="col-sm-12">
					<textarea class="form-control" name="cr" disabled><?php echo $val->cancel_reason; ?></textarea>
				</div>
			</div>
		</div>
		<?php	
			}else{
				$id=$val->release_by;
				$names=$this->Main_m->userCancel($id);
		?>
			<div class="form-group row">
			<div class="col-sm-6">
				<label for="release_date" class="col-sm-12 col-form-label">Released Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="release_date"  id="release_date" value="<?php echo $val->release_date; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="release_by" class="col-sm-12 col-form-label">Released By:</label>
				<div class="col-sm-12">
				<input type="text" class="form-control" name="release_by"  id="release_by"  value="<?php foreach($names as $valss){ echo $valss->name; } ?>" readonly/>
				</div>
			</div>
		</div>
		<?php	
			}
		 ?>
		
	</div>
</form>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
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
			}	
		});
	});
</script>