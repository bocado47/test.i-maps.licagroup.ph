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
	width: 378.75px !important;
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
</style>
<?php foreach($request_data as $rd) {  ?>
<form class="row" class="needs-validation" id="request_view_form">
  <div class="col">
    <div class="form-group row">
      <div class="col-sm-12">
        <label for="po_num" class="col-sm-12 col-form-label">User Name:</label>
        <div class="col-sm-12">
          <input type="text"  class="form-control" name="user" id="user"  value="<?php echo $datas->name; ?>"  disabled/>
          <input type="hidden"  class="form-control" name="userid" id="userid"  value="<?php echo $datas->id; ?>"  readonly/>
          <input type="hidden"  class="form-control" name="requestid" id="requestid"  value="<?php echo $rd->rt_id; ?>"  readonly/>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-6">
        <label for="po_num" class="col-sm-12 col-form-label">Brand:</label>
        <div class="col-sm-12">
          <input type="text" value="<?php echo $rd->brand; ?>" class="form-control Brand" id="Brand" name="Brand" readonly/>

					<div class="invalid-feedback">
					 Please provide a Brand.
				 	</div>
        </div>
      </div>
      <div class="col-sm-6">
        <label for="po_num" class="col-sm-12 col-form-label">Variant:</label>
        <div class="col-sm-12">
          <input type="hidden" value="<?php echo $rd->variant; ?>" class="form-control variant" id="variantEV" name="variant" readonly/>
          <input type="text" value="" class="form-control variant" id="variant" name="variant" readonly/>
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
          <input type="text" value="<?php echo $rd->color; ?>"  class="form-control color" id="color" name="color"  readonly/>
					<div class="invalid-feedback">
					 Please provide a Color.
					</div>
        </div>
      </div>
      <div class="col-sm-6">
        <label for="po_num" class="col-sm-12 col-form-label">Quantity:</label>
        <div class="col-sm-12">
        	<input type="number" class="form-control" id="quantity" name="quantity" min="1" value="<?php echo $rd->quantity; ?>" required/>
					<div class="invalid-feedback">
					 Please provide a Quantity minimum of 1.
					</div>
        </div>
      </div>
    </div>
		<div class="form-group row">
			<div class="col-sm-6">
							<label for="justification" class="col-sm-12 col-form-label">cost:</label>
							<div class="col-sm-12">
								<input type="text"  class="form-control money"  name="cost" id="cost" value="<?php echo  number_format((float)$rd->cost,2,'.',''); ?>"required/>
							</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
        <label for="po_num" class="col-sm-12 col-form-label">Justification:</label>
        <div class="col-sm-12">
					<textarea class="form-control" id="justification" name="justification" ><?php echo $rd->justification; ?></textarea>
        </div>
      </div>
		</div>

  </div>
</form>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
	var select = $("#request_view_form select").select2();
  var dealer=$("#Brand").val();
  var variantEV=$("#variantEV").val();
	$('.money').mask("#,##0.00", {reverse: true});
  // var colorEV=$("#colorEV").val();


  $.ajax({
      url: bUrl+"Dashboard/Model2?dealer="+dealer,
          type: "GET",
          dataType: "JSON",
          success: function (data) {
            $.each(data, function( index, value ) {
              if(variantEV == value.id){
                $("#variant").val(value.Product);
              }
            });
          },
          error: function() {
              console.log('error');
          }
    });
  // $.ajax({
  //       url: bUrl+"Dashboard/model_color?model_id="+variantEV,
  //           type: "GET",
  //           dataType: "JSON",
  //           success: function (data) {
  //            var tmp='<option value="">Select Color</option>';
  //             $.each(data, function( index, value ) {
  //               if(colorEV == value.color){
  //                 tmp +="<option value='"+value.color+"' selected>"+value.color+"</option>";
  //               }else{
  //                 tmp +="<option value='"+value.color+"'>"+value.color+"</option>";
  //               }
  //
  //             });
  //             $('#color').html(tmp);
  //           },
  //           error: function() {
  //               console.log('error');
  //           }
  //     });

	$("#Brand").on('change',function(){
		var dealer=$(this).val();
		$.ajax({
				url: bUrl+"Dashboard/Model2?dealer="+dealer,
						type: "GET",
						dataType: "JSON",
						success: function (data) {
						 var tmp='<option value="">Select Variant</option>';
						 var tmp2='<option value="">Select Color</option>';
							$.each(data, function( index, value ) {
									tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
							});
							$('#variant').html(tmp);
							$('#color').html(tmp2);
						},
						error: function() {
								console.log('error');
						}
			});
	});


	$("#variant").on('change',function(){
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
							$('#color').html(tmp);
						},
						error: function() {
								console.log('error');
						}
			});
	});
});
</script>
