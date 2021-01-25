<?php
$CI =& get_instance();
$CI->load->model('main_m');
$PO_num=$CI->main_m->purchase_order_num();
$location=$CI->main_m->location();
$bank=$CI->main_m->bank();
$paymodes=$CI->main_m->paymodes();


$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$id=$datas->id;
$type=$datas->type;

$access=$this->Main_m->m_access($id);
if($type == 1)
{
	$dealer=$CI->main_m->dealer();
}else{
	$dealer=$CI->main_m->dealer2($id);
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
	.ui-datepicker-calendar {
    display: none;
    }
</style>
<form class="row needs-validation" id="vechile_form">
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
				<label for="location" class="col-sm-12 col-form-label">Location:</label>
				<div class="col-sm-12">
					<select class="form-control" name="location" id="location">
						<option value="">Select Location</option>
						<?php foreach ($dealer as $value) { ?>
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
					<select class="form-control" name="purchase_order" id="purchase_order" required>
						<option value="">Select Purchase Order Number</option>
						<?php foreach($PO_num as $value) {
						?>
							<option value="<?php echo $value->po_num.','.$value->dealer.','.$value->id; ?>"><?php echo $value->po_num; ?></option>
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
					<input type="text"  min="0"  class="form-control money"  name="cost" id="cost" required/>
					<div class="invalid-feedback">
						Please provide a Cost.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="vvr_num" class="col-sm-12 col-form-label">Reference number:</label>
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
					<input type="date"  class="form-control s" name="received_date" min='1990-01-01'/>
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
					<input type="date" class="form-control" name="paid_date" min='1990-01-01'/>
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
					<select class="form-control" name="model" id="model" required>
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
					<select class="form-control" name="model_yr" id="model_yr" required><option value="">Select Year</option></select>
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
					<select class="form-control" name="color" id="color" required>
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
			  	}else{
			  		$("input[name=sr_date]").attr("readonly", true);
				    $("input[name=ar_date]").attr("readonly", true);
				    $("input[name=pr_date]").attr("readonly", true);
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
				  	}else{
				  		$("input[name=sr_date]").attr("readonly", true);
					    $("input[name=ar_date]").attr("readonly", true);
					    $("input[name=pr_date]").attr("readonly", true);
				  	}
				  }else{
				  	$("input[name=sr_date]").attr("readonly", true);
				    $("input[name=ar_date]").attr("readonly", true);
				    $("input[name=pr_date]").attr("readonly", true);
				  }
			});
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
				$('.money').mask("#,##0.00", {reverse: true});
		    	$('select').select2();
		    	$('#location').select2({
			    	placeholder: "Select Location",
			      width: "100%"
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
						}
					},
					error:function(){
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
					var nmdl=mdl.split(',');
					var model_id=nmdl[1];
					$.ajax({
		    			url: bUrl+"Inventory/model_color?model_id="+mdl,
			            type: "GET",
			            dataType: "JSON",
			            success: function (data) {
										console.log(data);
				           var tmps='';
				           tmps+='<option value="" >Select Color</option>';
			              $.each(data, function( index, value ) {
			              	tmps+="<option value='"+value.color+"'>"+value.color+"</option>";
						  });
						  $('#color').html(tmps);
						  // $('#Color').prop('disabled',false);
			            },
			            error: function() {
			                console.log('error');
			            }
		    		});
				$.ajax({
	    			url: bUrl+"Inventory/salesperson?dealer="+model,
		            type: "GET",
		            dataType: "JSON",
		            success: function (data) {
			           var tmp='';
			           tmp+='<option >Select Salesperson</option>';
		              $.each(data, function( index, value ) {
		              	tmp+="<option value='"+value.id+"'>"+value.Name+"</option>";
					  });
					  $('#salesperson').html(tmp);
					  $('#salesperson').prop('disabled',false);
		            },
		            error: function() {
		                console.log('error');
		            }
	    		});
			});

	    	$('#purchase_order').on('change',function(){
	    		var po=$(this).val();
	    		var spo=po.split(',');
	    		var po_num=spo[0];
	    		var dealer=spo[1];

	    		$.ajax({
	    			url: bUrl+"Inventory/Model?dealer="+dealer,
		            type: "GET",
		            dataType: "JSON",
		            success: function (data) {
			           var tmp='';
			           tmp+='<option value="">Select Model</option>';
		              $.each(data, function( index, value ) {
		              	tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
					  });
					  $('#model').html(tmp);
		            },
		            error: function() {
		                console.log('error');
		            }
	    		});
					$('#location').on('change',function(){
						var location=$(this).val();
						var po=$('#purchase_order').val();
						var spo=po.split(',');
						var po_num=spo[0];
						var dealer=spo[1];
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
	    		$.ajax({
	    			url: bUrl+"Inventory/check_po?po_num="+po_num,
		            type: "GET",
		            dataType: "JSON",
		            success: function (data) {
			            if(data == 'car')
			            {

			            }
		            },
		            error: function() {
		                console.log('error');
		            }
	    		});
	    	});

	    	for (i = new Date().getFullYear()+4; i >= 1990; i--)
			{
			    $('#model_yr').append($('<option />').val(i).html(i));
			}
	 	});
	</script>
