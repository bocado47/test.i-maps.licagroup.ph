<?php
$CI =& get_instance();
$CI->load->model('main_m');
$CI->load->model('Dsar_m');



$bank=$CI->main_m->bank();
$ps='';
foreach($podata as $poval)
{
	$ps=$poval->id;
	$nmodel=$poval->model;
	$ncolor=$poval->color;
	$nyr=$poval->model_yr;
}

$paymodes=$CI->main_m->paymodes();
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$id=$datas->id;
$ids=$datas->id;
$type=$datas->type;
$access=$this->Main_m->m_access($id);


if($type == 1)
{
	$dealer=$CI->Dsar_m->dealer();
	$alloc_dealer=$CI->Dsar_m->cm();
	$location=$CI->main_m->location();
}else{
	$accessdealer=$CI->Admin_m->getaccess($ids);
	if(count($accessdealer) >= 1)
	{
		$dealer=$CI->Dsar_m->dealer2($accessdealer);
		$location=$CI->main_m->location2($accessdealer);
	}else{
		$dealer=$CI->Dsar_m->dealer();
	}
}
$PO_num=$CI->main_m->purchase_order_num();
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

<form class="row needs-validation" id="vechile_form2">
	<?php foreach($PO_num as $value) { ?>
		<input type="hidden" name="po_num" value="<?php echo $value->po_num; ?>" />
 <?php } ?>
	<div class="col">
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="cs_num" class="col-sm-12 col-form-label">CS Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="cs_num" id="cs_num" pattern="[a-zA-Z0-9\s]+" required/>
					<div class="invalid-feedback">
						Please provide a C.S Number.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="color" class="col-sm-12 col-form-label">Location:</label>
				<div class="col-sm-12">
					<select class="form-control" name="location" id="location" required>
						<option value="">Select Location</option>
						<?php foreach ($location as $value) { ?>
							<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Please provide a location.
					</div>
				</div>
			</div>
		</div>
		<br/>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="purchase_order" class="col-sm-12 col-form-label">Purchase Order Number:</label>
				<div class="col-sm-12">
					<?php foreach($PO_num as $value) {
						if($value->id == $ps) {
					?>
					<input type="text"  class="form-control" name="purchase_order2" id="purchase_order2" pattern="[a-zA-Z0-9\s]+" value="<?php echo $value->po_num; ?>" disabled/>
						<?php }else{  ?>
					<!-- <input type="text"  class="form-control" name="purchase_order2" id="purchase_order2" pattern="[a-zA-Z0-9\s]+" value="<?php echo $value->po_num; ?>" disabled/> -->
						<?php } ?>
					<?php } ?>
					<select class="form-control" name="purchase_order" id="purchase_order" style="display:none !important;">
						<option value="">Select Purchase Order Number</option>
						<?php foreach($PO_num as $value) {
							if($value->id == $ps) {
						?>
							<option value="<?php echo $value->po_num.','.$value->dealer.','.$value->id; ?>" selected><?php echo $value->po_num; ?></option>
						<?php }else{  ?>
							<!-- <option value="<?php echo $value->po_num.','.$value->dealer.','.$value->id; ?>"><?php echo $value->po_num; ?></option> -->
							<?php } ?>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Please provide a Purchase Order Number.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="cost" class="col-sm-12 col-form-label">Cost:</label>
				<div class="col-sm-12">
					<input type="text"  min="0"  class="form-control money"  value="<?php foreach($podata as $poval){ ?><?php echo number_format((float)$poval->cost,2,'.',''); } ?>" name="cost" id="cost" readonly/>
					<div class="invalid-feedback">
						Please provide a Cost.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="vvr_num" class="col-sm-12 col-form-label">VRR number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control s" name="vvr_num" pattern="[a-zA-Z0-9\s]+"/>
					<div class="invalid-feedback">
						Please provide a Vehicle Receipt Report.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="received_date" class="col-sm-12 col-form-label">Vehicle Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control s" name="received_date" min='1990-01-01' id="received_date"/>
					<div class="invalid-feedback">
						Please provide a  Valid Vehicle Received Date
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="csr_date" class="col-sm-12 col-form-label">CSR Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="csr_date" min='1990-01-01'/>
					<div class="invalid-feedback">
						Please provide a  CSR Received Date
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="paid_date" class="col-sm-12 col-form-label">Paid Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="paid_date" min='1990-01-01' />
					<div class="invalid-feedback">
						Please provide a Valid Paid Date:.
					</div>
				</div>
			</div>
		</div>
		<br/>
		<h4>Vehicle Details :</h4>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="model" class="col-sm-12 col-form-label">Model:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="model2" id="model2" readonly/>
					<select class="form-control" name="model" id="model"  style="display:none;">
						<option value="">Select Model</option>
					</select>
					<div class="invalid-feedback">
						Please provide a Model.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="model_yr" class="col-sm-12 col-form-label">Year Model:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="model_yr2" id="model_yr2" readonly/>
					<select class="form-control" name="model_yr" id="model_yr" style="display:none;" ><option value="">Select Year</option></select>
					<div class="invalid-feedback">
						Please provide a Year Model.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="color" class="col-sm-12 col-form-label">Color:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="color2" id="color2" readonly/>
					<select class="form-control" name="color" id="color" style="display:none;">
						<option value="">Select Color</option>
					</select>
					<!-- <input type="text"  class="form-control" name="color" pattern="[a-zA-Z0-9\s]+" required/> -->
					<div class="invalid-feedback">
						Please provide a Color.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="vin_num" class="col-sm-12 col-form-label">VIN Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="vin_num" pattern="[a-zA-Z0-9\s]+" />
					<div class="invalid-feedback">
						Please provide a VIN Number.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Engine Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="eng_num" pattern="[a-zA-Z0-9\s]+" />
					<div class="invalid-feedback">
						Please provide a ENG Number.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Prod Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="prod_num" pattern="[a-zA-Z0-9\s]+" />
					<div class="invalid-feedback">
						Please provide a Prod Number.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Subsidy Claiming:</label>
				<div class="col-sm-12">
					<input type="text" min="0"  class="form-control money" name="subsidy_claiming"/>
					<div class="invalid-feedback">
						Please provide a Subsidy Claiming.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Subsidy (Outright):</label>
				<div class="col-sm-12">
					<input type="text" min="0"  class="form-control money" name="subsidy_claimed" />
					<div class="invalid-feedback">
						Please provide a Subsidy (Outright)
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Allocation Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="alloc_date" pattern="[a-zA-Z0-9\s]+" />
					<div class="invalid-feedback">
						Please provide a Allocation Date.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Allocation Dealer:</label>
				<div class="col-sm-12">
					<select class="form-control" name="alloc_dealer" id="alloc_dealer" >
						<option value="">Select Allocation Dealer</option>
						<?php foreach ($alloc_dealer as $value) { ?>
							<option value="<?php echo $value->Company.'-'.$value->Branch; ?>"><?php echo $value->Company.'-'.$value->Branch; ?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Please provide a Dealer.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Plant Sales Report:</label>
				<div class="col-sm-12">
					<select class="form-control" name="plant_sales_report" id="plant_sales_report" >
						<option value="">Select Plant Sales Report</option>
						<?php foreach ($dealer as $value) { ?>
							<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Please provide a Plant Sales Report.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Plant Sales Month:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control form-control-1 input-sm montyr" name="plant_sales_month" id="psm"  />
					<div class="invalid-feedback">
						Please provide a Plant Sales Month.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Whole Sale Period:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control form-control-1 input-sm montyr" name="whole_sale_period" id="wsp" />
					<div class="invalid-feedback">
						Please provide a Whole Sale Period.
					</div>
				</div>
			</div>
		</div>
		<br/>
		<!-- <div id="salebut">Do you want to Enable Sales Information? <a href="#" id="one">Click Here</a></div> -->
		<!-- <div id="salebut2" style="display:none;">Do you want to Disable Sales Information? <a href="#" id="two">Click Here</a></div> -->
		<br/>

		<h4>Other Details :</h4>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="remarks" class="col-sm-12 col-form-label">Remarks:</label>
				<div class="col-sm-12">
					<textarea class="form-control" name="remarks"></textarea>
				</div>
			</div>
		</div>
	</div>
</form>
	<script type="text/javascript">
		$(document).ready(function() {
			var bUrl="<?php echo base_url(); ?>";
			var pomodel="<?php echo $nmodel; ?>";
			var pomodelcolor="<?php echo $ncolor; ?>";
			var pomodelyr="<?php echo $nyr; ?>";

			if(pomodel.length > 0)
			{
				var mdl=pomodel;
				$.ajax({
						url: bUrl+"Inventory/model_color?model_id="+mdl,
								type: "GET",
								dataType: "JSON",
								success: function (data) {
								 var tmp='';
								 var val='';
								 tmp+='<option >Select Color</option>';
									$.each(data, function( index, value ) {
										if(pomodelcolor == value.color)
										{
											tmp +="<option value='"+value.color+"' selected>"+value.color+"</option>";
											val=value.color;
										}else{
											tmp +="<option value='"+value.color+"'>"+value.color+"</option>";
										}

									});
						$('#color').html(tmp);
						$('#color2').val(val)
						// $('#Color').prop('disabled',false);
								},
								error: function() {
										console.log('error');
								}
					});
					for (i = new Date().getFullYear()+4; i >= 1990; i--)
					{
						if(pomodelyr == i)
						{
							$('#model_yr').append($('<option selected />').val(i).html(i));
							$('#model_yr2').val(i);
						}else{
							$('#model_yr').append($('<option />').val(i).html(i));
						}

					}
			}else{
				for (i = new Date().getFullYear()+4; i >= 1990; i--)
				{
						$('#model_yr').append($('<option />').val(i).html(i));
				}
			}
			$('#one').on('click',function(){
				$('.dis').prop("disabled", false);
				$(".dis").attr("required", true);
				$(".s").attr("required", true);
				$('#salebut').hide();
				$('#salebut2').show();
				if($('#location').val() == "")
				{
					$('#salesperson').prop("disabled", true);
				}
			});
			$('#two').on('click',function(){
				$('.dis').prop("disabled", true);
				$(".dis").attr("required", false);
				$(".s").attr("required", false);
				$('#salebut').show();
				$('#salebut2').hide();
			});
			$('input[name=inv_num]').keyup(function(){
			  if($(this).val().length){
			  	if($('input[name=alloc_date]').val().length)
			  	{
			  		$("input[name=sr_date]").attr("readonly", false);
			     	$("input[name=ar_date]").attr("readonly", false);
			     	$("input[name=pr_date]").attr("readonly", false);
			     	$("input[name=sr_date]").attr("required", true);
			     	$("input[name=ar_date]").attr("required", true);
			     	$("input[name=pr_date]").attr("required", true);
			  	}else{
			  		$("input[name=sr_date]").attr("readonly", true);
				    $("input[name=ar_date]").attr("readonly", true);
				    $("input[name=pr_date]").attr("readonly", true);
				    $("input[name=sr_date]").attr("required", false);
			     	$("input[name=ar_date]").attr("required", false);
			     	$("input[name=pr_date]").attr("required", false);
			  	}
			  }else{
			  	$("input[name=sr_date]").attr("readonly", true);
			    $("input[name=ar_date]").attr("readonly", true);
			    $("input[name=pr_date]").attr("readonly", true);
			  }
			});
			$('input[name=alloc_date]').on('change',function(){
				if($(this).val().length){
				  	if($('input[name=inv_num]').val().length)
				  	{
				  		$("input[name=sr_date]").attr("readonly", false);
				     	$("input[name=ar_date]").attr("readonly", false);
				     	$("input[name=pr_date]").attr("readonly", false);
				     	$("input[name=sr_date]").attr("required", true);
				     	$("input[name=ar_date]").attr("required", true);
				     	$("input[name=pr_date]").attr("required", true);
				  	}else{
				  		$("input[name=sr_date]").attr("readonly", true);
					    $("input[name=ar_date]").attr("readonly", true);
					    $("input[name=pr_date]").attr("readonly", true);
					     $("input[name=sr_date]").attr("required", false);
				     	$("input[name=ar_date]").attr("required", false);
				     	$("input[name=pr_date]").attr("required", false);
				  	}
				  }else{
				  	$("input[name=sr_date]").attr("readonly", true);
				    $("input[name=ar_date]").attr("readonly", true);
				    $("input[name=pr_date]").attr("readonly", true);
				    $("input[name=sr_date]").attr("required", false);
				     	$("input[name=ar_date]").attr("required", false);
				     	$("input[name=pr_date]").attr("required", false);
				  }
			});
			$('.montyr').datepicker({
		    	format: "mm-yyyy",
			    viewMode: "months",
			    minViewMode: "months",
			    autoclose: true
			});
			$('.dates').datepicker({
				format: "dd-mm-yyyy",
				autoclose: true,
			});
			$('.money').mask("#,##0.00", {reverse: true});

	    	$('#plant_sales_report, #alloc_dealer, #location').select2();
	    	$('#location').select2({
		    	placeholder: "Select Location",
		      width: "100%"
		    });
		   		var po=$('#purchase_order').val();
	    		var spo=po.split(',');
	    		var po_num=spo[0];
	    		var dealer=spo[1];
	    		console.log(dealer);1

	    		$.ajax({
	    			url: bUrl+"Inventory/Model?dealer="+dealer,
		            type: "GET",
		            dataType: "JSON",
		            success: function (data) {
			           var tmp='';
								 var val='';
			           tmp+='<option value="">Select Model</option>';

		              $.each(data, function( index, value ) {
										if(pomodel == value.id)
										{
											tmp +="<option value='"+value.id+"' selected>"+value.Product+"</option>";
											val=value.Product;
										}else{
											tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
										}

					  			});
					  $('#model').html(tmp);
					  $('#model2').val(val);
					  $('#model').prop('disabled',false);
					  $('#model_yr').prop('disabled',false);
		            },
		            error: function() {
		                console.log('error');
		            }
	    		});
	    	$('#cs_num').on('change',function(){
	    		var csnum=$(this).val();
					$.ajax({
						url: bUrl+"Inventory/check_cs_num?csnum="+csnum,
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
		                            content: '<h5 style="color:red;">Invalid CS number.Your CS number is already exist, Thank you.</h5>',
								 });
								 $('#cs_num').val("");
								 // $('.btnSubmit').attr("disabled","disabled");
								 return false;
							}
						},
						error:function(){
							console.log('error');
						}
					});
				});

	    	$('#purchase_order').on('change',function(){
	    		var po=$(this).val();
	    		var spo=po.split(',');
	    		var po_num=spo[0];
	    		var dealer=spo[1];
	    		$('#model').find('option').remove();
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
		            },
		            error: function() {
		                console.log('error');
		            }
	    		});
	    	});
				$('#model').on('change',function(){
					var po=$('#purchase_order').val();
						var spo=po.split(',');
						var po_num=spo[0];
						var model=spo[1];
						var mdl=$(this).val();
						// var nmdl=mdl.split(',');
						// var model_id=nmdl[1];
						$.ajax({
								url: bUrl+"Inventory/model_color?model_id="+mdl,
										type: "GET",
										dataType: "JSON",
										success: function (data) {
										 var tmp='';
										 tmp+='<option >Select Color</option>';
											$.each(data, function( index, value ) {
												tmp +="<option value='"+value.color+"'>"+value.color+"</option>";
								});
								$('#color').html(tmp);
								// $('#Color').prop('disabled',false);
										},
										error: function() {
												console.log('error');
										}
							});

				});
				$('#location').on('change',function(){
					var location=$(this).val();
					$.ajax({
	    			url: bUrl+"Inventory/salesperson4?dealer="+dealer+"&location="+location,
		            type: "GET",
		            dataType: "JSON",
		            success: function (data) {
									console.log(data);
			           var tmp='';
			           tmp+='<option value="">Select Sales Person</option>';
		              $.each(data, function( index, value ) {
										var str1=value.Fname;
										var str2=value.Lname;
										var str3=value.Mname;
										var fstr=string.concat(str1,str2,str3);
		              	tmp +="<option value='"+fstr+"'>"+fstr+"</option>";
					  });
						$('#salesperson').html(tmp);
		            },
		            error: function() {
		                console.log('error');
		            }
	    		});
				});

	 	});
	</script>
