<?php
$CI =& get_instance();
$CI->load->model('main_m');
// $color=$CI->main_m->color_cat();
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
if($type == 1)
{
	$dealer=$CI->Dsar_m->cm();
}else{
	$accessdealer=$CI->Admin_m->getaccess($ids);
	if(count($accessdealer) >= 1)
	{
		$dealer=$CI->Dsar_m->cm3($accessdealer);
	}else{
		$dealer=$CI->Dsar_m->cm();
	}

}
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
	input {
  display: block;
  width: 150px;
}
#exampleCheck1{
	-ms-transform: scale(2); /* IE */
 -moz-transform: scale(2); /* FF */
 -webkit-transform: scale(2); /* Safari and Chrome */
 -o-transform: scale(2); /* Opera */
 transform: scale(2);
 padding: 5px;
}

</style>
    <form class="row" class="needs-validation" id="poform">
			<div class="col">
				<div class="form-group row">
					<div class="col-sm-6">
					    <label for="po_num" class="col-sm-12 col-form-label">P.O. Number:</label>
					    <div class="col-sm-12">
					      <input type="text"  class="form-control" name="po_num" id="po_num" pattern="^[a-zA-Z0-9]+$" required/>
					       <div class="invalid-feedback">
					        Please provide a P.O. number.
					      </div>
					    </div>
				    </div>
				    <div class="col-sm-6">
					    <label for="po_date" class="col-sm-12 col-form-label">P.O. Date:</label>
					    <div class="col-sm-12">
					      <input type="text"  class="form-control" name="po_date" id="po_date" placeholder="mm/dd/yyyy" required/>
					      <div class="invalid-feedback">
					        Please provide a P.O. Date.
					      </div>
					    </div>
				    </div>
			  	</div>
			  	<div class="form-group row">
			  		<div class="col-sm-6">
				  		<label for="dealer" class="col-sm-12 col-form-label">P.O. Dealer:</label>
					    <div class="col-sm-12">
					      <select class="form-control" name="dealer" id="dealer" required>
					      	<option value="">Select Dealer</option>
					      	<?php foreach($dealer as $dlr){ ?>
						      	<option value="<?php echo $dlr->id; ?>"> <?php echo $dlr->Company.' '.$dlr->Branch; ?> </option>
					      	<?php } ?>
					      </select>
					      <div class="invalid-feedback">
					        Please select a dealer.
					      </div>
					    </div>
				    </div>
				    <div class="col-sm-6">
				    	<label for="model" class="col-sm-12 col-form-label">Whole Sale Period:</label>
						<div class="col-sm-12">
					 		<input type="text" name="whole_sale_period" id="wsp" class="form-control" placeholder="Whole Sale Period" readonly>
					 		 <div class="invalid-feedback">
						        Please select a Whole Sale Period.
						      </div>
						</div>
				    </div>
			  	</div>
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
							<label for="cost" class="col-sm-12 col-form-label">P.O. AMOUNT:</label>
							<div class="col-sm-12">
								<input type="text"  class="form-control money"  name="cost" id="cost" required/>
								<div class="invalid-feedback">
									Please provide a cost minimum of 300,000 and maximum of 5,000,000.
								</div>
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
<script type="text/javascript">
	$(document).ready(function() {

		// var dateInputs = document.querySelectorAll('[type="date"]');
		//
		// for(var i = 0;i < dateInputs.length;i++)
		// {
		//   dateInputs[i].addEventListener("dblclick", function() {
		//     this.type = "text";
		//     this.select();
		// 		console.log(dateInputs);
		//   });
		//
		//   dateInputs[i].addEventListener("focusout", function() {
		//    this.type = "date";
		//
		//   })
		// }
		$('.money').mask("#,##0.00", {reverse: true});
			$('select').select2();
			$('#location').select2({
				placeholder: "Select Location",
				width: "100%"
			});
			$("#po_date").datepicker({
    dateFormat: 'dd/mm/yy'
}).on("changeDate", function (e) {
	$('#po_date').datepicker('hide');
	var val=$(this).val();
	const d = new Date(val)
	const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d)
	const mo = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(d)
	const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d)
$("#wsp").val(`${mo}-${ye}`);

});
// 		$('#po_date').datepicker({
//     format: 'mm/dd/yyyy',
//     startDate: '-3d',
// 		onSelect: function(dateText) {
// 			alert('aws');
// 	 }
// }).on('change',function(event){
// 	var newd=$(this).val();
// 	alert('aw');
//
// 	const d = new Date(newd)
// 	const dtf = new Intl.DateTimeFormat('en', { year: 'numeric', month: 'short', day: '2-digit' })
// 	const [{ value: mo },,{ value: da },,{ value: ye }] = dtf.formatToParts(d)
// 	console.log('${mo}-${ye}');
// 	$("#wsp").val('${mo}-${ye}');
// });
    	var select=$('select').select2();

    	var bUrl="<?php echo base_url(); ?>";

    	$('.montyr').datepicker({
		    	format: "mm-yyyy",
			    viewMode: "months",
			    minViewMode: "months",
			    autoclose: true,
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
			$('#dealer').on('change',function(){
	    		var po=$(this).val();

	    		var spo=po.split(',');
	    		var po_num=spo[0];
	    		var dealer=spo[1];
	    		$.ajax({
	    			url: bUrl+"Inventory/Model?dealer="+po,
		            type: "GET",
		            dataType: "JSON",
		            success: function (data) {
			           var tmp='';
			           tmp+='<option >Select Model</option>';
		              $.each(data, function( index, value ) {
		              	tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
					  		});
					  $('#model').html(tmp);
		            },
		            error: function() {
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
				for (i = new Date().getFullYear()+4; i >= 1990; i--)
			{
					$('#model_yr').append($('<option />').val(i).html(i));
			}
	});
</script>
