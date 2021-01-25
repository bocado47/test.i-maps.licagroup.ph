<?php
$CI =& get_instance();
$CI->load->model('main_m');
// $color=$CI->main_m->color_cat();
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
$color=$CI->Dashboard_m->color();
	if($type == 1)
	{
		$brand=$CI->Dashboard_m->brand();
	}else{
		$accessdealer=$CI->Admin_m->getaccess($ids);

		if(count($accessdealer) >= 1)
		{
			$brand=$CI->Dashboard_m->brand2($accessdealer);
		}else{
			$brand=$CI->Dashboard_m->brand();
		}

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
	#request_form .select2-container--default .select2-selection--single {
	  display: block;
	  width: 100% !important;
	  height: calc(2.25rem + 2px);
	  padding: 3px;
	  font-size: 1rem;
	  font-weight: 400;
	  line-height: 1.5;
	  color: #495057;
	  background-color: #fff;
	  background-clip: padding-box;
	  border: 1px solid #ced4da;
	  border-radius: .25rem;
	  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
	#request_form .select2-container{
	width: 100% !important;
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
	th{
	  text-align: center;
	}
	.tablebtn{
	  line-height: 24.5px !important;
	}
	textarea {
  resize: none;
	}
.testqty {
		width: 130px !important;
}
</style>

<!-- <form class="row" class="needs-validation" id="request_form">
  <div class="col">
    <div class="form-group row">
      <div class="col-sm-12">
        <label for="po_num" class="col-sm-12 col-form-label">User Name:</label>
        <div class="col-sm-12">
          <input type="text"  class="form-control" name="user" id="user"  value="<?php echo $datas->name; ?>"  disabled/>
          <input type="hidden"  class="form-control" name="userid" id="userid"  value="<?php echo $datas->id; ?>"  readonly/>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-6">
        <label for="po_num" class="col-sm-12 col-form-label">Brand:</label>
        <div class="col-sm-12">
	        <select class="form-control Brand" id="Brand" name="Brand" required>
						<option value="">Select Brand </option>
						<?php foreach($brand as $value){ ?>
								<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
						<?php }?>
					</select>
					<div class="invalid-feedback">
					 Please provide a Brand.
				 	</div>
        </div>
      </div>
      <div class="col-sm-6">
        <label for="po_num" class="col-sm-12 col-form-label">Variant:</label>
        <div class="col-sm-12">
	        <select class="form-control variant" id="variant" name="variant" required>
						<option value="">Select Variant</option>'
					</select>
					<div class="invalid-feedback">
					 Please provide a Variant.
				 	</div>
        </div>
      </div>
    </div>
    <div class="form-group row">
			<div class="col-sm-6">
        <label for="po_num" class="col-sm-12 col-form-label">Color:</label>
        <div class="col-sm-12">
	        <select class="form-control color" id="color" name="color" required>
						<option value="">Select Color</option>
					</select>
					<div class="invalid-feedback">
					 Please provide a Color.
					</div>
        </div>
      </div>
      <div class="col-sm-6">
        <label for="po_num" class="col-sm-12 col-form-label">Quantity:</label>
        <div class="col-sm-12">
        	<input type="number" class="form-control" id="quantity" name="quantity" min="1" required/>
					<div class="invalid-feedback">
					 Please provide a Quantity minimum of 1.
					</div>
        </div>
      </div>
    </div>
		<div class="form-group row">
			<div class="col-sm-12">
        <label for="po_num" class="col-sm-12 col-form-label">Justification:</label>
        <div class="col-sm-12">
					<textarea class="form-control" id="justification" name="justification"></textarea>
        </div>
      </div>
		</div>

  </div>
</form> -->
<div class="alert m-0" role="alert" id="ermsg" style="display: block;"> </div>
<div class="new-wrap" style="display: none;">
	<div class="form-group row  test">
			<div class="col-sm-3 t">
						<label for="variant" class="col-sm-12 col-form-label">Variant:</label>
						<div class="col-sm-12 s">
							<select class="form-control variant select"  name="variant[]" required>
								<option value="">Select Variant</option>
							</select>
						</div>
		 </div>
		 <div class="col-sm-2">
						<label for="color" class="col-sm-12 col-form-label">Color:</label>
						<div class="col-sm-12">
								<select class="form-control color select" name="color[]" required></select>
						</div>
		 </div>
		 <div class="col-sm-2">
						<label for="quantity" class="col-sm-12 col-form-label">Quantity:</label>
						<div class="col-sm-12">
							<input type="number" class="form-control clear" name="quantity[]" min="1" required/>
						</div>
		</div>
		<div class="col-sm-3">
						<label for="justification" class="col-sm-12 col-form-label">Justification:</label>
						<div class="col-sm-12">
							<textarea class="form-control" name="justification[]" rows="4"></textarea>
						</div>
		</div>
		<div class="col-sm-2">
						<label for="justification" class="col-sm-12 col-form-label">cost:</label>
						<div class="col-sm-12">
							<input type="text"  class="form-control money"  name="cost[]" id="cost" required/>
						</div>
		</div>
	</div>
</div>
<form class="row" class="needs-validation" id="request_form">
	<div class="col">
    <div class="form-group row">
      <div class="col-sm-6">
        <label for="po_num" class="col-sm-12 col-form-label">User Name:</label>
        <div class="col-sm-12">
          <input type="text"  class="form-control" name="user" id="user"  value="<?php echo $datas->name; ?>"  disabled/>
          <input type="hidden"  class="form-control" name="userid" id="userid"  value="<?php echo $datas->id; ?>"  readonly/>
        </div>
      </div>
			<div class="col-sm-6">
        <label for="po_num" class="col-sm-12 col-form-label">Brand:</label>
        <div class="col-sm-12">
	        <select class="form-control Brand" id="Brand" name="Brand" required>
						<option value="">Select Brand </option>
						<?php foreach($brand as $value){ ?>
								<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
						<?php }?>
					</select>
					<div class="invalid-feedback">
					 Please provide a Brand.
				 	</div>
        </div>
      </div>
    </div>
		<div class="form-group row">
			<div class="col-sm-8"></div>
			<div class="col-sm-4 buttontable" style="display:none;">
					<button type="button" class="btn btn-md btn-success" id="add" >add</button>
					<button type="button" class="btn btn-md btn-danger" id="remove" >remove</button>
			</div>
		</div>


		<div class="main"  style="display: none;">
			<div class="form-group row  test " id="set0">
					<div class="col-sm-3 t">
								<label for="variant" class="col-sm-12 col-form-label">Variant:</label>
				        <div class="col-sm-12 s">
					        <select class="form-control variant select" name="variant[]" required>
										<option value="">Select Variant</option>
									</select>
								</div>
				 </div>
				 <div class="col-sm-2">
								<label for="color" class="col-sm-12 col-form-label">Color:</label>
				        <div class="col-sm-12">
					        <select class="form-control color select" name="color[]" required></select>
								</div>
				 </div>
				 <div class="col-sm-2">
								<label for="quantity" class="col-sm-12 col-form-label">Quantity:</label>
				        <div class="col-sm-12">
					        <input type="number" class="form-control clear"  name="quantity[]" min="1" required/>
								</div>
				</div>
				<div class="col-sm-2">
								<label for="justification" class="col-sm-12 col-form-label">cost:</label>
								<div class="col-sm-12">
									<input type="text"  class="form-control money"  name="cost[]" id="cost" required/>
								</div>
				</div>
				<div class="col-sm-3">
								<label for="justification" class="col-sm-12 col-form-label">Justification:</label>
				        <div class="col-sm-12">
									<textarea class="form-control"  name="justification[]" rows="4"></textarea>
								</div>
				</div>
			</div>
	  </div>


	</div>
</form>
<script type="text/javascript">
function selectRefresh() {
  $('.main .test .select').select2({
    //-^^^^^^^^--- update here
    tags: true,
    allowClear: true,
    width: '100%'
  });
}
$(document).ready(function(){
	var dealer='';
	$("#Brand").select2();
	$('.money').mask("#,##0.00", {reverse: true});
		$('select').select2();
		$('#location').select2({
			placeholder: "Select Location",
			width: "100%"
		});
	// $(".variant").select2();
	// $(".color").select2();
	var testarray=[];
	$("#Brand").on('change',function(){
	  dealer=$(this).val();
		$(".buttontable").show();
		$(".main").show();
		$.ajax({
				url: bUrl+"Dashboard/Model2?dealer="+dealer,
						type: "GET",
						dataType: "JSON",
						success: function (data) {
						 var tmp='<option value="">Select Variant</option>';
							$.each(data, function( index, value ) {
									tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
							});
							$('.variant').html(tmp);
						},
						error: function() {
								console.log('error');
						}
			});
	});
	var count=0;

	$('#add').on('click',function (event) {
		count++;
		var testto='<div class="form-group row  test" id="set'+count+'"><div class="col-sm-3 t"><label for="variant" class="col-sm-12 col-form-label">Variant:</label><div class="col-sm-12 s"><select class="form-control variant select"  name="variant[]" required>	<option value="">Select Variant</option></select></div></div><div class="col-sm-2"><label for="color" class="col-sm-12 col-form-label">Color:</label><div class="col-sm-12"><select class="form-control color select" name="color[]" required></select></div></div><div class="col-sm-2"><label for="quantity" class="col-sm-12 col-form-label">Quantity:</label><div class="col-sm-12"><input type="number" class="form-control clear" name="quantity[]" min="1" required/></div></div>	<div class="col-sm-2"><label for="justification" class="col-sm-12 col-form-label">cost:</label><div class="col-sm-12"><input type="text"  class="form-control money"  name="cost[]" id="cost" required/></div></div><div class="col-sm-3"><label for="justification" class="col-sm-12 col-form-label">Justification:</label><div class="col-sm-12"><textarea class="form-control" name="justification[]" rows="4"></textarea></div></div></div>';
			 $('.main').append(testto);
			$.ajax({
					url: bUrl+"Dashboard/Model2?dealer="+dealer,
							type: "GET",
							dataType: "JSON",
							beforeSend: function() {
								 // setting a timeout
								 $('#add').attr('disabled',true);
						 },
							success: function (data) {
								 $('#add').attr('disabled',false);
							 var tmp='<option value="">Select Variant</option>';
								$.each(data, function( index, value ) {
										tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
								});
							$('.main .test').last().find('.variant').html(tmp);
							},
							error: function() {
									console.log('error');
							}
				});
		// $('.main .test').last().attr('id','set'+count);
	 selectRefresh();
	});
	$('#remove').click(function(){
		count--;
		// var color=$('#table2').find('tr:last .color').val();
		// var model_id=$('#table2').find('tr:last .variant').val();
		testarray.pop();
		$('.main .test').last().remove();
        // $('#table2 tr:last').remove();
				console.log(testarray);
  });
	$(document).on('change','.variant',function(){
	var test='#'+$(this).parent().parent().parent().attr('id');
	var model_id=$(this).val();

	$.ajax({
			url: bUrl+"Dashboard/model_color?model_id="+model_id,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
					 var tmp='<option value="">Select Color</option>';
						$.each(data, function( index, value ) {
								tmp +="<option value='"+value.color+"'>"+value.color+"</option>";
						});
					$(test).find('.color').html(tmp);
					},
					error: function() {
							console.log('error');
					}
		});
});
});
$(document).ready(function() {
  selectRefresh();
});
</script>
