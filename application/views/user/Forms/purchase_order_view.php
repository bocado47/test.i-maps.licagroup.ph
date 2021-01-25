<?php
$CI =& get_instance();
$CI->load->model('main_m');
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;

$deal='';
if($type == 1)
{
	$dealer=$CI->main_m->branch();
}else{
	$dealer=$CI->main_m->branch2($ids);
}
$location=$CI->main_m->location();
$emodel='';
$ecolor='';
$eyear='';
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
</style>

<?php foreach($info as  $value) {
	$deal=$value->dealer;
	$emodel=$value->model;
	$ecolor=$value->color;
	$eyear=$value->model_yr;
	?>
    <form class="row" class="needs-validation" id="poeditform">
			<div class="col">
				<div class="form-group row">
					<input type="hidden" value="<?php echo $id; ?>" name='poid'/>
				    <label for="po_num" class="col-sm-2 col-form-label">P.O. Number:</label>
				    <div class="col-sm-4">
				      <input type="text"  class="form-control" name="po_num" id="po_num" value="<?php echo $value->po_num; ?>" readonly required/>
				       <div class="invalid-feedback">
				        Please provide a P.O. number.
				      	</div>
				    </div>
				    <label for="po_date" class="col-sm-2 col-form-label">P.O. Date:</label>
				    <div class="col-sm-4">
				      <input type="date"  class="form-control" name="po_date" id="po_date2" value="<?php echo $value->po_date; ?>" required>
				       <div class="invalid-feedback">
				        Please provide a P.O. date.
				      	</div>
				    </div>
			  	</div>
			  	<div class="form-group row">
			  		<label for="dealer" class="col-sm-2 col-form-label">PO Dealer:</label>
				    <div class="col-sm-10">
							<input type="text" name="podealer" id="podealer" class="form-control" value="<?php foreach($info2 as $vl){ echo $vl->dealer; } ?>" readonly/>
							<input type="hidden" name="dealer" id="podealer2" class="form-control" value="<?php echo $deal; ?>" readonly/>
				       <div class="invalid-feedback">
				        Please select a dealer.
				       </div>
				    </div>
			  	</div>
					<div class="form-group row">
							<label for="po_num" class="col-sm-2 col-form-label">Model</label>
							<div class="col-sm-4">
								<input type="text" name="model2" id="model2" class="form-control" readonly/>
								<select class="form-control" name="model" id="model" style="display:none;">
									<option value="">Select Model</option>
								</select>
								<div class="invalid-feedback">
									Please provide a Model.
								</div>
							</div>
							<label for="po_date" class="col-sm-2 col-form-label">Model Year:</label>
							<div class="col-sm-4">
								<input type="text" name="model_yr2" id="model_yr2" class="form-control" readonly/>
								<select class="form-control" name="model_yr" id="model_yr" style="display:none;"><option value="">Select Year</option></select>
								<div class="invalid-feedback">
									Please provide a Year Model.
								</div>
							</div>
						</div>
						<div class="form-group row">
							<input type="hidden" value="<?php echo $id; ?>" name='poid'/>
								<label for="po_num" class="col-sm-2 col-form-label">Color</label>
								<div class="col-sm-4">
									<input type="text" name="color22" id="color2" class="form-control" readonly/>
									<select class="form-control" name="color" id="color" style="display:none;">
										<option value="">Select Color</option>
									</select>
									<!-- <input type="text"  class="form-control" name="color" pattern="[a-zA-Z0-9\s]+" required/> -->
									<div class="invalid-feedback">
										Please provide a Color.
									</div>
								</div>
								<label for="po_date" class="col-sm-2 col-form-label">Cost:</label>
								<div class="col-sm-4">
									<input type="text"  class="form-control money" name="cost" id="Cost" value="<?php echo number_format((float)$value->cost, 2, '.', ''); ?>" required>
									 <div class="invalid-feedback">
										Please provide a P.O. date.
										</div>
								</div>
							</div>
			  	<div class="form-group row">
			  		<label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>
				    <div class="col-sm-10">
				      <textarea class="form-control" name="remarks" value="<?php echo $value->remarks; ?>" ><?php echo $value->remarks; ?></textarea>
				    </div>
			  	</div>
					<div class="form-group row">
							<div class="col-sm-8" >
							</div>
							<div class="col-sm-1" style="text-align: right;">
								<input type="checkbox" name="conf_order" id="exampleCheck1" style="width: 50px;" >

							</div>
							<div class="col-sm-3" style="padding-left: 0px !important;">
								<h5 style="line-height: 0.5;">Confirmed Order</h5>
							</div>
					</div>

			</div>
	</form>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
    // var select=$('select').select2();
		$('.money').mask("#,##0.00", {reverse: true});
    var bUrl="<?php echo base_url(); ?>";
		var po="<?php echo $deal; ?>";
		var model="<?php echo $emodel; ?>";
		var color="<?php echo $ecolor; ?>";
		var model_yr="<?php echo $eyear; ?>";
		for (i = new Date().getFullYear()+4; i >= 1990; i--)
		{
			if(model_yr == i)
			{
				$('#model_yr').append($('<option selected />').val(i).html(i));
				$('#model_yr2').val(i);
			}else{
				$('#model_yr').append($('<option />').val(i).html(i));
			}

		}
		$.ajax({
				url: bUrl+"Inventory/model_color?model_id="+model,
						type: "GET",
						dataType: "JSON",
						success: function (data) {
							console.log(data);
						 var tmps='';
						 tmps+='<option value="" >Select Color</option>';
							$.each(data, function( index, value ) {
								if(color == value.color)
								{
									tmps+="<option value='"+value.color+"' selected>"+value.color+"</option>";
									$("#color2").val(value.color);
								}else{
									tmps+="<option value='"+value.color+"'>"+value.color+"</option>";
								}

							});
				$('#color').html(tmps);
				// $('#Color').prop('disabled',false);
						},
						error: function() {
								console.log('error');
						}
			});
		$.ajax({
			url: bUrl+"Inventory/Model?dealer="+po,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
					 var tmp='';
					 tmp+='<option >Select Model</option>';
						$.each(data, function( index, value ) {
							if(model == value.id)
							{
								tmp +="<option value='"+value.id+"' selected>"+value.Product+"</option>";
								$("#model2").val(value.Product);
							}else{
								tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
							}

						});
			$('#model').html(tmp);
					},
					error: function() {
							console.log('error');
					}
		});

			$('#po_num').on('change',function(){
	    		var ponum=$(this).val();
				$.ajax({
					url: bUrl+"Inventory/check_po_num?ponum="+ponum,
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
	                             content: '<h5 style="color:red;">Invalid Purchase Order number.Your Purchase Order number is already exist, Thank you.</h5>',
							 });
							 $('#po_num').val("");
						}
					},
					error:function(){
						console.log('error');
					}
				});
			});
			$('#model').on('change',function(){
					var mdl=$(this).val();
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

			});
	});
</script>
