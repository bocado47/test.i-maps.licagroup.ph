<?php
$CI =& get_instance();
$CI->load->model('main_m');
// $PO_num=$CI->main_m->purchase_order_num();
$location=$CI->main_m->location();
$bank=$CI->main_m->bank();

$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$id=$datas->id;
$access=$this->Main_m->m_access($id);
$type=$datas->type;
$paymodes=$CI->main_m->paymodes();
if($type == 1)
{
	// $sales=$CI->main_m->salesperson();
	$dealer=$CI->main_m->dealer();
	$dealer2=$CI->main_m->dealer();
}else{
	// $sales=$CI->main_m->salesperson3($access);
	$dealer=$CI->main_m->dealer2($id);
	$dealer2=$CI->main_m->dealer2($id);
}

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
$po_num='';
$year='';

$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$id=$datas->id;
$type=$datas->type;
$access=$this->Main_m->m_access($id);
// if($type == 1)
// {
// 	$sales=$CI->main_m->salesperson();
// }else{
// 	$sales=$CI->salesperson5;
// }
// print_r($info);

foreach($info as $value){
$model=$value->model;
$year=$value->model_yr;
$locations=$value->location;
$newloc = explode('^', $locations);
$po_id=$value->purchase_order;
$PO_num=$CI->main_m->purchase_order_num2();
$csnum=$value->cs_num;
 $deal=$CI->main_m->getdealer($csnum);
 $prdate=$value->plant_release_date;
 if($prdate == '0000-00-00')
 {
 	$prdate='';
 }else{
 	$prdate=date("m-Y", strtotime($value->plant_release_date));
 }
 $sr_date=$value->system_release_date;
 if($sr_date == '0000-00-00')
 {
 	$sr_date='';
 }else{
 	$sr_date=date("m-Y", strtotime($value->system_release_date));
 }
 $w_date=$value->whole_sale_period;
 if($w_date == '0000-00-00')
 {
 	$w_date='';
 }else{
 	$w_date=date("m-Y", strtotime($value->whole_sale_period));
 }
    // $dealer='';
    // foreach ($deal as $vale) {
    //  	$dealer.=$vale->dealer;
    //  }

	// $sales=$CI->main_m->salesperson2($dealer);

?>
<form class="row needs-validation" id="info_vechile_form">
	<div class="col">
		<input type="hidden"  class="form-control" name="veh_id" id="veh_id" value=" <?php echo $value->vehicle_id; ?>" />
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="cs_num" class="col-sm-12 col-form-label">CS Number:</label>
				<?php if($type == 1){ ?>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="cs_num" id="cs_num" value="<?php echo $value->cs_num; ?>" />
					<div class="invalid-feedback">
						Please provide a C.S Number.
					</div>
				</div>
				<?php  }else{ ?>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="cs_num" id="cs_num" value="<?php echo $value->cs_num; ?>" readonly/>
					<div class="invalid-feedback">
						Please provide a C.S Number.
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-sm-6">
				<label for="color" class="col-sm-12 col-form-label">location:</label>
				<div class="col-sm-12">
					<select class="form-control" name="location" id="location">
						<option value="">Select Location</option>
						<?php foreach ($dealer as $val) { ?>
							<?php if($value->dealer == $val->id){ ?>
								<option value="<?php echo $val->Company; ?>" selected><?php echo $val->Company; ?></option>
							<?php }else{ ?>
								<option value="<?php echo $val->Company; ?>"><?php echo $val->Company; ?></option>
							<?php } ?>

						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<br/>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="purchase_order" class="col-sm-12 col-form-label">Purchase Order Number:</label>
				<div class="col-sm-12">
					<select class="form-control" name="purchase_order" id="purchase_order" required>
						<option value="">Select Purchase Order Number</option>
						<?php foreach($PO_num as $dlr) {
							if($dlr->id == $value->purchase_order){
								$dealer=$dlr->dealer; $po_num=$dlr->po_num;
							 ?>
							<option value="<?php echo $dlr->po_num.','.$dlr->dealer.','.$dlr->id; ?>" selected> <?php echo $dlr->po_num; ?></option>
								<?php }else{
									if($dlr->has_vehicle == 0){ ?>
									<option value="<?php echo $dlr->po_num.','.$dlr->dealer.','.$dlr->id; ?>"> <?php echo $dlr->po_num; ?></option>
								<?php } ?>
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
					<input type="text"  min="0"  class="form-control money" name="cost" id="cost" value="<?php echo number_format((float)$value->cost,2,'.',''); ?>"/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="vvr_num" class="col-sm-12 col-form-label">Reference Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="vvr_num" value="<?php echo $value->vrr_num; ?>"/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="received_date" class="col-sm-12 col-form-label">Vehicle Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="received_date" value="<?php echo $value->veh_received; ?>" />
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="csr_date" class="col-sm-12 col-form-label">CSR Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="csr_date" value="<?php echo $value->veh_received; ?>"/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="paid_date" class="col-sm-12 col-form-label">Paid Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="paid_date" value="<?php echo $value->paid_date; ?>"/>
				</div>
			</div>
		</div>
		<br/>
		<h4>Vehicle Details :</h4>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="model" class="col-sm-12 col-form-label">Model:</label>
				<div class="col-sm-12">
					<select class="form-control" name="model" id="model">
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
					<select class="form-control" name="color" id="color" required>
						<option value="">Select Color</option>
						<!-- <option value="">Select Color</option> -->
							<?php foreach($color as $vls) { ?>
									<?php if($vls->color == $value->color) { ?>
										<option value="<?php echo $vls->color; ?>" selected><?php echo $vls->color; ?></option>
									<?php }else{ ?>
										<option value="<?php echo $vls->color; ?>"><?php echo $vls->color; ?></option>
									<?php } ?>
							<?php } ?>
					</select>
					<!-- <input type="text"  class="form-control" name="color" value="<?php echo $value->color; ?>"/> -->
				</div>
			</div>
			<div class="col-sm-6">
				<label for="vin_num" class="col-sm-12 col-form-label">VIN Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="vin_num" value="<?php echo $value->vin_num; ?>"/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Engine Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="eng_num" value="<?php echo $value->engine_num; ?>"/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Prod Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="prod_num" value="<?php echo $value->prod_num; ?>"/>
				</div>
			</div>
		</div>
		<br/>
		<h4>Sales Info :</h4>
		<div class="form-group row">
			<div class="col-sm-4">
				<label for="last_name" class="col-sm-12 col-form-label">Last Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="last_name" readonly/>
				</div>
			</div>
			<div class="col-sm-4">
				<label for="first_name" class="col-sm-12 col-form-label">First Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="first_name" readonly/>
				</div>
			</div>
			<div class="col-sm-4">
				<label for="middle_name" class="col-sm-12 col-form-label">Middle Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="middle_name" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="company_name" class="col-sm-12 col-form-label">Company Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="company_name" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="inv_num" class="col-sm-12 col-form-label">Invoice Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="inv_num" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="inv_amt" class="col-sm-12 col-form-label">Invoice Amount:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control money" name="inv_amt" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="inv_date" class="col-sm-12 col-form-label">Invoice Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="inv_date"readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="alloc_date" class="col-sm-12 col-form-label">Allocation Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="alloc_date" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="subsidy" class="col-sm-12 col-form-label">Subsidy:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="subsidy" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="salesperson" class="col-sm-12 col-form-label">Salesperson:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="salesperson" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="term" class="col-sm-12 col-form-label">Pay Modes:</label>
				<div class="col-sm-12">
						<input type="text"  class="form-control" name="paymodes" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="bank" class="col-sm-12 col-form-label">Bank:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="bank" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="grp_lica" class="col-sm-12 col-form-label">(Lica) Sale Report To:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="grp_lica" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="grp_plant" class="col-sm-12 col-form-label">(Plant) Sale Report To:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="grp_plant" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="pr_date" class="col-sm-12 col-form-label">Plant Released Month:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control montyr" name="pr_date" readonly />
				</div>
			</div>
			<div class="col-sm-6">
				<label for="ar_date" class="col-sm-12 col-form-label">Actual Released Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="ar_date" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="sr_date" class="col-sm-12 col-form-label">Accounting Sale Period:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control montyr" name="sr_date" readonly />
				</div>
			</div>
			<div class="col-sm-6">
				<label for="posted_date" class="col-sm-12 col-form-label">Whole Sale Period:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control montyr" name="posted_date" readonly />
				</div>
			</div>
		</div>
		<br/>
		<h4>Other Details :</h4>
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
<script type="text/javascript">
		$(document).ready(function() {
				var bUrl="<?php echo base_url(); ?>";
				var po_num="<?php echo $value->purchase_order; ?>";
				var sp="<?php echo $value->salesperson; ?>";

				$.ajax({
					url: bUrl+"Inventory/salesperson5?po_num="+po_num,
							type: "GET",
							dataType: "JSON",
							success: function (data) {
								console.log(data);
							 var tmp='';
							 if(sp.length > 0){
								  tmp+='<option value="'+sp+'"selected>'+sp+'</option>';
							 }else{
								  tmp+='<option value="">Select Sales Person</option>';
							 }


								$.each(data, function( index, value ) {
									var str1=value.Fname;
									var str2=value.Lname;
									var str3=value.Mname;
									var fstr=str1.concat(' ',str2,' ',str3);
									tmp +="<option value='"+fstr+"'>"+fstr+"</option>";
					});
					$('#salesperson').html(tmp);
							},
							error: function() {
									console.log('error');
							}
				});
		});
</script>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		var bUrl="<?php echo base_url(); ?>";
		var po_num='<?php echo $po_num; ?>';
			var dealer='<?php echo $dealer; ?>';
			var model ='<?php echo $model; ?>';
			var year ='<?php echo $year; ?>';
			console.log(model);

		$.ajax({
			url: bUrl+"Inventory/Model?dealer="+dealer,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
					 var tmp='';
					 tmp+='<option value="" >Select Model</option>';
						$.each(data, function( index, value ) {
							if(value.id == model)
							{
								tmp +="<option value='"+value.id+"' selected>"+value.Product+"</option>";
							}else{
								tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
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

		$("#paymodes").on('change',function(){
				var paymode=$(this).val();

				if(paymode == 'company po' || paymode == 'cash')
				{
					$('#bank').attr('disabled','disabled');
					// $('#bankrow').hide();
				}else{
					$('#bank').attr('disabled',false);
					// $('#bankrow').show();
				}
		});
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

					$('#model').on('change',function(){
						var po=$('#purchase_order').val();
							var spo=po.split(',');
							var po_num=spo[0];
							var model=spo[1];
							var mdl=$(this).val();
							var nmdl=mdl.split(',');
							var model_id=nmdl[1];
							$.ajax({
									url: bUrl+"Inventory/model_color?model_id="+model_id,
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


			$('.money').mask("#,##0.00", {reverse: true});
			// $('.money').mask('000.000.000.000.000,00', {reverse: true});
	    	$('select').select2();
	    	$('#location').select2({
    	placeholder: "Select Location",
      width: "100%"
    });
	 var lastcs=$('#cs_num').val();
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
							 $('#cs_num').val(lastcs);
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
				<?php foreach($info as $value){ ?>
					var prod="<?php echo $value->model; ?>";
				<?php } ?>
	    		$.ajax({
	    			url: bUrl+"Inventory/Model?dealer="+dealer,
		            type: "GET",
		            dataType: "JSON",
		            success: function (data) {
			           var tmp='';
			           tmp+='<option >Select Model</option>';
		              $.each(data, function( index, value ) {
		              	if(prod == value.Product){
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
	    	});

	    	for (i = new Date().getFullYear()+4; i >= 1990; i--)
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
