<?php
$CI =& get_instance();
$CI->load->model('main_m');
$color=$CI->main_m->color_cat();
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
if($type == 1)
{
	$dealer=$CI->main_m->branch();
}else{
	$dealer=$CI->main_m->branch2($ids);
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
tr th{
  text-align:center;
}
tr td{
  text-align:center;
}
</style>
    <form class="row" class="needs-validation" id="poform">
			<div class="col">
				<div class="form-group row">
					<form id="addFC" method="POST">
            <div class="col-sm-4">
              <label for="bank" class="col-sm-12 col-form-label">Bank:</label>
              <div class="col-sm-12">
                 <select name="bank" class="form-control" required>
									 <option value=''>Select Bank</option>
									 <?php foreach($bank as $value){ ?>
									 <option value="<?php echo $value->bank_names; ?>"><?php echo $value->bank_names; ?></option>
									 <?php } ?>
								 </select>
                  <div class="invalid-feedback">
                    Please provide a Bank.
                  </div>
              </div>
            </div>
						<div class="col-sm-4">
							<label for="bank" class="col-sm-12 col-form-label">FC Number:</label>
              <div class="col-sm-12">
                 <input type="text" name="fc_number" value="<?php echo $fcnumber; ?>" class="form-control" readonly/>
              </div>
						</div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
              <label for="date" class="col-sm-12 col-form-label">Date:</label>
              <div class="col-sm-12">
                 <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly/>
              </div>
            </div>
            <div class="col-sm-5">
              <label for="ponum" class="col-sm-12 col-form-label">Choose P.O.:</label>
              <div class="col-sm-12">
                 <select name="ponum" id="po_num" class="form-control">
								 </select>
                  <div class="invalid-feedback">
                    Please provide a P.O numebr.
                  </div>
              </div>
            </div>
            <div class="col-sm-3">
              <button type="button" class="btn btn-primary btnaddpo" style="margin-top:30px;">Add</button>
            </div>
					</form>
			  </div>
        <div class="form-group row">
          <div class="col-sm-12">
            <h4 style="text-align:left;"> Selected P.O's:</h4>
            <table class="table table-striped table-sm" id="mytable" width="100%">
                  <thead>
                    <tr>
                      <th>P.O.#</th>
                      <th>Model</th>
                      <th>Color</th>
                      <th>P.O. Date</th>
                      <th>Cost</th>
											<th>Action</th>
                    </tr>
                  </thead>
									<tbody>
									</tbody>
            </table>
          </div>
        </div>
		<input type="hidden" name="fc_numbers" value="<?php echo $fcnumber; ?>" class="form-control" readonly/>
				<div class="form-group row">
          <div class="col-sm-9">
					</div>
					<div class="col-sm-3">
						<label>Total:</label>
						<input type="text" id="total" name="total" class="form-control" readonly/>
					</div>
				</div>
     </div>
	 </form>

<script type="text/javascript">
	$(document).ready(function() {
		var total=0;
		$('#total').val(total);
		$('select').select2();
		$.ajax({
			type:'post',
			url:'<?php echo base_url(); ?>Inventory/po_nums',
			dataType:'JSON',
			success:function(data)
			{
				$('#po_num').append('<option value="">Select P.O Number</option>');
				$.each(data, function( index, value ){
					$('#po_num').append('<option value="'+value.id+'">'+value.po_num+'</option>');
				});
			}
		});
		$('.btnaddpo').on('click',function(){
			$.ajax({
					type:'post',
					url:'<?php echo base_url(); ?>Inventory/addfc',
					dataType:'JSON',
					data:$('#poform').serialize(),
					beforeSend:function(){
						$('.btnaddpo').text('Adding');
						$('.btnaddpo').attr('disabled','disabled');
					},
					success:function(data){
						console.log(data);
						$('.btnaddpo').text('Add');
						$('.btnaddpo').attr('disabled',false);
						var po_num=$('#po_num').val();
							if(data == 'error')
							{
								alert('This P.O Number is exist on your selected P.O');
								$('#po_num').prop('selectedIndex',0);
							}else{
								$.each(data.FCSelect, function( index, value ){
									$('#mytable').append('<tr><td>'+value.po_num+'</td><td>'+value.model+'</td><td>'+value.color+'</td><td>'+value.da+'</td><td>'+value.cost+'</td><td><button type="button" class="btn btn-danger btn-sm delete" value="'+data.FCID+','+value.cost+'">Remove</button></td></tr>');
									 total+=parseInt(data.FCSelect[0].cost);
								});
								$('#total').val(total);
							}

							$.ajax({
								type:'post',
								url:'<?php echo base_url(); ?>Inventory/po_nums',
								dataType:'JSON',
								success:function(data)
								{
									$('#po_num').find('option').remove();
										$('#po_num').append('<option value="">Select P.O Number</option>');
									$.each(data, function( index, value ){
										$('#po_num').append('<option value="'+value.id+'">'+value.po_num+'</option>');
									});
								}
							});
					}
			});
		});
		$("#mytable").on("click","button",function(){
			var id=$(this).val();
			console.log(id);
			$.ajax({
					type:'post',
					url:'<?php echo base_url(); ?>Inventory/removepo?id='+id,
					dataType:'JSON',
					data:$('#poform').serialize(),
					success:function(data){
						console.log(data);
						total-=parseInt(data);
					$('#total').val(total);
					$("#mytable tbody").find('button[value="'+id+'"]').each(function(){
											$(this).parents("tr").remove();
									});
					}
			});
		});
	});
</script>
