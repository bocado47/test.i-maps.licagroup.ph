<?php
$CI =& get_instance();
$CI->load->model('Admin_m');
$access=$CI->Admin_m->access2();
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
	#admin
	{
		display:none;
	}
</style>
<form class="row needs-validation" id="model_c_form">
	<div class="col">
		<div class="form-group row">
			<label for="brand" class="col-sm-12 col-form-label">Select Brand:</label>
			<div class="col-sm-12">
        <select name="brand" id="brand" class="form-control" required>
          <option value="">Select Brand</option>
          <?php foreach($access as $value){ ?>
            <option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
          <?php } ?>
        </selecT>
			</div>
		</div>
    <div class="form-group row">
			<label for="model" class="col-sm-12 col-form-label">Select Model:</label>
			<div class="col-sm-12">
        <select name="model" id="model" class="form-control" required>
          <option value="">Select Model</option>
        </selecT>
			</div>
		</div>
    <div class="form-group row">
			<label for="color" class="col-sm-12 col-form-label">Color:</label>
			<div class="col-sm-12">
        <input type="text" id="color" name="color" class="form-control" required/>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
  var bUrl="<?php echo base_url(); ?>";
  $('select').select2();

  $('#brand').on('change',function(){
    var brand=$(this).val();
    $.ajax({
        url: bUrl+"Admin/v_models?brand="+brand,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
             var tmp='';
             tmp+='<option value="">Select Model</option>';
              $.each(data, function( index, value ) {
                tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
        });
        $('#model').html(tmp);
        // $('#brand').prop('disabled',false);
            },
            error: function() {
                console.log('error');
            }
      });
  });
});
</script>
