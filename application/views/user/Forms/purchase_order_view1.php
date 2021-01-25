<?php
$CI =& get_instance();
$CI->load->model('Dsar_m');

$dealer=$CI->Dsar_m->cm();
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
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
	table td{
	  text-align: left;
	}
	.table td{
	      padding: 0.45rem !important;
	          font-size: 15px;
	}
	label{
		font-weight: bold;
		font-size: 13px;
	}
</style>

<?php foreach($info as  $value) {   $deal='';?>

  <?php foreach($dealer as $dlr){ ?>

      <?php if($dlr->id == $value->dealer) {?>
      <?php $deal=$dlr->Company.' '.$dlr->Branch; ?>
      <?php } ?>

  <?php } ?>
    <!-- <form class="row" class="needs-validation" id="poeditform">
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
				      <input type="date"  class="form-control" name="po_date" id="po_date2" value="<?php echo $value->po_date; ?>" readonly required>
				       <div class="invalid-feedback">
				        Please provide a P.O. date.
				      	</div>
				    </div>
			  	</div>
			  	<div class="form-group row">
			  		<label for="dealer" class="col-sm-2 col-form-label">Dealer:</label>
				    <div class="col-sm-10">
              <input type="text"  class="form-control" name="po_date" id="po_date2" value="<?php echo $deal; ?>" readonly required>
				       <div class="invalid-feedback">
				        Please select a dealer.
				       </div>
				    </div>
			  	</div>
					<div class="form-group row">
						<input type="hidden" value="<?php echo $id; ?>" name='poid'/>
					    <label for="po_num" class="col-sm-2 col-form-label">Model</label>
					    <div class="col-sm-4">
					      <input type="text"  class="form-control" name="Model" id="Model" value="<?php echo $value->Product; ?>" readonly required/>
					       <div class="invalid-feedback">
					        Please provide a P.O. number.
					      	</div>
					    </div>
					    <label for="po_date" class="col-sm-2 col-form-label">Model Year:</label>
					    <div class="col-sm-4">
					      <input type="text"  class="form-control" name="model_yr" id="model_yr" value="<?php echo $value->model_yr; ?>" readonly required>
					       <div class="invalid-feedback">
					        Please provide a P.O. date.
					      	</div>
					    </div>
				  	</div>
						<div class="form-group row">
							<input type="hidden" value="<?php echo $id; ?>" name='poid'/>
						    <label for="po_num" class="col-sm-2 col-form-label">Color</label>
						    <div class="col-sm-4">
						      <input type="text"  class="form-control" name="Color" id="Color" value="<?php echo $value->color; ?>" readonly required/>
						       <div class="invalid-feedback">
						        Please provide a P.O. number.
						      	</div>
						    </div>
						    <label for="po_date" class="col-sm-2 col-form-label">Cost:</label>
						    <div class="col-sm-4">
						      <input type="text"  class="form-control money" name="Cost" id="Cost" value="<?php echo $value->cost; ?>" readonly required>
						       <div class="invalid-feedback">
						        Please provide a P.O. date.
						      	</div>
						    </div>
					  	</div>
			  	<div class="form-group row">
			  		<label for="remarks" class="col-sm-2 col-form-label">Inventory Status:</label>
				    <div class="col-sm-10">
              <input type="text"  class="form-control" name="po_date" id="po_date2" value="<?php echo $value->Status1; ?>" readonly required>
               <div class="invalid-feedback">
                Please select a dealer.
               </div>
				    </div>
			  	</div>
					<div class="form-group row">
			  		<label for="remarks" class="col-sm-2 col-form-label">Accounting Status:</label>
				    <div class="col-sm-10">
              <input type="text"  class="form-control" name="po_date" id="po_date2" value="<?php echo $value->Status2; ?>" readonly required>
               <div class="invalid-feedback">
                Please select a dealer.
               </div>
				    </div>
			  	</div>
			</div>
	</form> -->
	<div class="row">
		<table class="table">
			<tr>
				<td class="text-right" style="width:20%;" scope="col"><label>P.O. Number:</label></td>
				<td class="text-left"  style="width:30%;" scope="col"><span><?php echo $value->po_num; ?></span></td>
				<td class="text-right" style="width:20%;" scope="col"><label>P.O. Date:</label></td>
				<td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $value->po_date; ?></span></td>
			</tr>
			<tr>
				<td class="text-right" style="width:20%;" scope="col"><label>P.O. Dealer:</label></td>
				<td class="text-left"  style="width:30%;" scope="col"><span><?php echo $deal; ?></span></td>
				<td class="text-right" style="width:20%;" scope="col"><label>P.O Model:</label></td>
				<td class="text-left"  style="width:30%;"  scope="col"><span><?php echo $value->Product; ?></span></td>
			</tr>
			<tr>
				<td class="text-right" style="width:20%;" scope="col"><label>P.O. Model Year:</label></td>
				<td class="text-left"  style="width:30%;" scope="col"><span><?php echo $value->model_yr; ?></span></td>
				<td class="text-right" style="width:20%;" scope="col"><label>P.O Model Color:</label></td>
				<td class="text-left"  style="width:30%;"  scope="col"><span><?php echo $value->color; ?></span></td>
			</tr>
			<tr>
				<td class="text-right" style="width:20%;" scope="col"><label>P.O. Model Cost:</label></td>
				<td class="text-left"  style="width:30%;" scope="col"><span><?php echo number_format((float)$value->cost, 2, '.', ''); ?></span></td>
				<td class="text-right" style="width:20%;" scope="col"><label>Inventory Status:</label></td>
				<td class="text-left"  style="width:30%;" scope="col"><span><?php echo $value->Status1; ?></span></td>
			</tr>
			<tr>
				<td class="text-right" style="width:20%;" scope="col"><label>Accounting Status:</label></td>
				<td class="text-left"  style="width:30%;"  scope="col"><span><?php echo $value->Status2; ?></span></td>
				<td class="text-right" style="width:20%;" scope="col"><label></label></td>
				<td class="text-left"  style="width:30%;" scope="col"><span></span></td>
			</tr>
		</table>
	</div>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
    var select=$('select').select2();
		$('.money').mask("#,##0.00", {reverse: true});
    var bUrl="<?php echo base_url(); ?>";

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
	});
</script>
