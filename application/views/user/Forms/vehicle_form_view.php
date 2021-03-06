<?php
$CI =& get_instance();
$CI->load->model('main_m');
$PO_num=$CI->Main_m->purchase_order_num();
$location=$CI->main_m->location();
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
<?php 

$model='';
$dealer='';
$po_num='';
$year='';
foreach($info as  $value) { 
$model=$value->model;	
$year=$value->model_yr;
$locations=$value->location;
$newloc = explode('^', $locations);

// print_r($newloc);
// // echo $dirs;
// foreach($location as $values) { 
// 	foreach($newloc as $val) {
// 		if($values->location_name == $val){

// 		echo $val;
// 		}
// 	}
// }
foreach($infoInvoice as $valueInv)
{


?>
<form class="row needs-validation" id="vechile_form_view" >
			<div class="col">
				<div class="form-group row">
					<input type="hidden" value="<?php echo $value->id; ?>" name="vechile_id"/>
					<input type="hidden" value="<?php echo $valueInv->id; ?>" name="invoice_id"/>
					<div class="col-sm-6">
						<label for="cs_num" class="col-sm-12 col-form-label">CS Number:</label>
						<div class="col-sm-12">
							<input type="text"  class="form-control" name="cs_num" id="cs_num" value="<?php echo $value->cs_num; ?>" required readonly/>
						</div>
					</div>
				    <div class="col-sm-6">
				     	<label for="purchase_order" class="col-sm-12 col-form-label">Purchase Order Number:</label>
				     	<div class="col-sm-12">
					      	<select class="form-control" name="purchase_order" id="purchase_order">
						      	<?php foreach($PO_num as $values) { ?>
						      		<?php if($values->id == $value->purchase_order){ 
						      			$dealer=$values->dealer; $po_num=$values->po_num; ?>
						      			<option value="<?php echo $values->po_num.','.$values->dealer.','.$values->id; ?>" selected>
						      		<?php }else{ ?>
						      			<option value="<?php echo $values->po_num.','.$values->dealer.','.$values->id; ?>">
						      		 <?php } ?>
						      			<?php echo $values->po_num; ?></option>
						      	<?php } ?> 
					      	</select>
				      	</div>
				    </div>
			  	</div>
			  	<div class="form-group row">
			  		<input type="hidden" id="model_hidden" value="<?php echo $value->model; ?>"/>
			  		<input type="hidden" id="model_yr_hidden" value="<?php echo $value->model_yr; ?>"/>
			  		<div class="col-sm-6">
			  			<label for="model" class="col-sm-12 col-form-label">Model:</label>
			  			<div class="col-sm-12">
			  				<select class="form-control" name="model"  id="model">
			  					<option value="">Select Model</option>
			  				</select>
			  			</div>
			  		</div>
			  		<div class="col-sm-6">
			  			<label for="model_yr" class="col-sm-12 col-form-label">Year Model:</label>
			  			<div class="col-sm-12">
			  				<select class="form-control" name="model_yr" id="model_yr"></select>
			  			</div>
			  		</div>
			  	</div>
			  	<div class="form-group row">
			  		<div class="col-sm-6">
			  			<label for="color" class="col-sm-12 col-form-label">Color:</label>
			  			<div class="col-sm-12">
			  				<input type="text"  class="form-control" name="color" value="<?php echo $value->color; ?>" />
			  			</div>
			  		</div>
			  		<div class="col-sm-6">
			  			<label for="color" class="col-sm-12 col-form-label">location:</label>
			  			<div class="col-sm-12">
			  				<select class="form-control" name="location" id="location" >
			  					<?php foreach($newloc as $val) {
			  						foreach($location as $values) { ?>
			  						<?php if($values->location_name === $val) { ?>
				  						<option value="<?php echo $values->location_name; ?>" selected><?php echo $values->location_name; ?></option>
				  						<?php }else{ ?>
				  						<option value="<?php echo $values->location_name; ?>">
				  							<?php echo $values->location_name; ?></option>
				  						<?php } ?>
			  						<?php } ?>	
								<?php } ?> 
			  				</select>
			  			</div>
			  		</div>
			  	</div>
			  	<div class="form-group row">
			  		<div class="col-sm-6">
			  			<label for="vvr_num" class="col-sm-12 col-form-label">VRR Number (Vechile Receipt Report Number):</label>
			  			<div class="col-sm-12">
			  				<input type="text"  class="form-control" value="<?php echo $value->vrr_num; ?>" name="vvr_num" />
			  			</div>
			  		</div>
			  		<div class="col-sm-6">
			  			<label for="vvr_date" class="col-sm-12 col-form-label">VRR Date (Vechile Receipt Report Date):</label>
			  			<div class="col-sm-12">
			  				<input type="date"  class="form-control" value="<?php echo $value->vrr_date; ?>" name="vvr_date" id="vvr2" />
			  			</div>
			  		</div>
			  	</div>
			  	<div class="form-group row">
			  		<div class="col-sm-6">
			  			<label for="vin_num" class="col-sm-12 col-form-label">VIN Number:</label>
			  			<div class="col-sm-12">
			  				<input type="text"  class="form-control" name="vin_num" value="<?php echo $value->vin_num; ?>" />
			  			</div>
			  		</div>
			  		<div class="col-sm-6">
			  			<label for="eng_num" class="col-sm-12 col-form-label">Engine Number:</label>
			  			<div class="col-sm-12">
			  				<input type="text"  class="form-control" name="eng_num" value="<?php echo $value->engine_num; ?>" />
			  			</div>
			  		</div>
			  	</div>
			  	<div class="form-group row">
			  		<div class="col-sm-6">
			  			<label for="cost" class="col-sm-12 col-form-label">Cost:</label>
			  			<div class="col-sm-12">
			  				<input type="text" min="0"  class="form-control money" name="cost"  value="<?php echo $value->cost; ?>" required/>
			  			</div>
			  		</div>
			  		<div class="col-sm-6">
			  			<label for="cust_name" class="col-sm-12 col-form-label">Customer Name:</label>
			  			<div class="col-sm-12">
			  				<input type="text"  class="form-control" name="cust_name" value="<?php echo $valueInv->cust_name; ?>" />
			  			</div>
			  		</div>
			  	</div> 
			  	<div class="form-group row">
					<div class="col-sm-6">
						<label for="csr_date" class="col-sm-12 col-form-label">CSR Received Date:</label>
						<div class="col-sm-12">
							<input type="date"  class="form-control" name="csr_date" value="<?php echo $value->csr_received; ?>"/>
						</div>
					</div>
					<div class="col-sm-6">
						<label for="received_date" class="col-sm-12 col-form-label">Vehicle Received Date:</label>
						<div class="col-sm-12">
							<input type="date"  class="form-control" name="received_date" value="<?php echo $value->veh_received; ?>"/>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label for="prod_num" class="col-sm-12 col-form-label">Prod Number:</label>
						<div class="col-sm-12">
							<input type="text"  class="form-control" name="prod_num" value="<?php echo $value->prod_num; ?>"/>
						</div>
					</div>
					<div class="col-sm-6">
						<label for="subsidy" class="col-sm-12 col-form-label">Subsidy:</label>
						<div class="col-sm-12">
							<input type="text"  class="form-control" name="subsidy" value="<?php echo $value->subsidy; ?>"/>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label for="paid_date" class="col-sm-12 col-form-label">Paid Date:</label>
						<div class="col-sm-12">
							<input type="date" class="form-control" name="paid_date" value="<?php echo $value->paid_date; ?>"/>
						</div>
					</div>
					<div class="col-sm-6">
						<label for="posted_date" class="col-sm-12 col-form-label">Posted Date:</label>
						<div class="col-sm-12">
							<input type="date" class="form-control" name="posted_date" value="<?php echo $value->posted_date; ?>"/>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label for="inv_num" class="col-sm-12 col-form-label">Invoice Number:</label>
						<div class="col-sm-12">
							<input type="text"  class="form-control" name="inv_num" value="<?php echo $valueInv->invoice_num; ?>"/>
						</div>
					</div>	
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label for="pr_date" class="col-sm-12 col-form-label">Plant Released Month:</label>
						<div class="col-sm-12">
							 <input type="text" name="pr_date" class="form-control form-control-1 input-sm montyr" placeholder="Plant Released Date">
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
				<div class="form-group row">
					<div class="col-sm-12">
						<label for="remarks" class="col-sm-12 col-form-label">Remarks:</label>
						<div class="col-sm-12">
							<textarea class="form-control" name="remarks"><?php echo $value->remarks; ?></textarea>
						</div>
					</div>
				</div>
			</div>
</form>
<?php  } } ?>
<script type="text/javascript">
		$(document).ready(function() {
			$('.money').mask("#,##0.00", {reverse: true});
			var bUrl="<?php echo base_url(); ?>";
			$('#cs_num').on('change',function(){
	    		var csnum=$(this).val();
				$.ajax({
					url: bUrl+"Inventory/check_cs_num?csnum="+csnum,
					type:"GET",
					success:function(data)
					{
						console.log(data);
						if(data > 0)
						{
							 $.alert({
							 	type:'red',
	                            columnClass:"col-sm-6 col-sm-offset-4",
	                            title: '<h3 style="color:red;">Error</h3>',
	                            content: '<h5 style="color:red;">Invalid CS number.Your CS number is already exist, Thank you.</h5>',
							 });
							 $('#cs_num').val("");
						}
					},
					error:function(){
						console.log('error');
					}
				});
			});
	    	$('select').select2();
	    	$('#location').select2({
    	placeholder: "Select Location",
      width: "100%"
    });
	    		var po_num='<?php echo $po_num; ?>';
	    		var dealer='<?php echo $dealer; ?>';
	    		var model ='<?php echo $model; ?>';
	    		var year ='<?php echo $year; ?>';

	    		$.ajax({
	    			url: bUrl+"Inventory/Model?dealer="+dealer,
		            type: "GET",
		            dataType: "JSON",
		            success: function (data) {  
			           var tmp='';
			           tmp+='<option value="" >Select Model</option>';
		              $.each(data, function( index, value ) {
		              	if(value.Product == model)
		              	{
		              		tmp +="<option value='"+value.Product+"' selected>"+value.Product+"</option>";
		              	}else{
		              		tmp +="<option value='"+value.Product+"'>"+value.Product+"</option>";
		              	}
		              	
					  });
					  $('#model').html(tmp);
					  $('#model').prop('disabled',false);
					  $('#model_yr').prop('disabled',false);
		            },
		            error: function() {
		                console.log('error');
		            }
	    		});
	    	$('#purchase_order').on('change',function(){
	    		var po=$(this).val();
	    		var spo=po.split(',');
	    		var po_num=spo[0];
	    		var dealer=spo[1];
	    		var id=spo[2];

	    		$.ajax({
	    			url: bUrl+"Inventory/Model?dealer="+dealer,
		            type: "GET",
		            dataType: "JSON",
		            success: function (data) {  
			           var tmp='';
			           tmp+='<option value="">Select Model</option>';
		              $.each(data, function( index, value ) {
		              	tmp +="<option value='"+value.Product+"'>"+value.Product+"</option>";
					  });
					  $('#model').html(tmp);
					  $('#model').prop('disabled',false);
					  $('#model_yr').prop('disabled',false);
					  console.log(data);
		            },
		            error: function() {
		                console.log('error');
		            }
	    		});
	    	});

	    	for (i = new Date().getFullYear(); i >= 1990; i--)
			{
				if(i == year)
				{
					$('#model_yr').append($('<option />').val(i).html(i).attr('selected','selected')); 
				}else{
					$('#model_yr').append($('<option />').val(i).html(i));
				}
			    
			}
	 	});
	</script>