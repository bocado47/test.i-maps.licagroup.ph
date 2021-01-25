<?php
$CI =& get_instance();
$CI->load->model('Dsar_m');

$dealer=$CI->Dsar_m->cm();
$sc=$CI->Dsar_m->sc();
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
<div class="row">
  <table class="table">
    <tr>
      <td class="text-center" colspan="4"><b>P.O Details</b></td>
    </tr>
      <?php foreach($po as $value){ ?>
        <?php foreach($dealer as $dlr){ ?>

            <?php if($dlr->id == $value->dealer) {?>
            <?php $deal=$dlr->Company.' '.$dlr->Branch; ?>
            <?php } ?>
        <?php } ?>
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
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo number_format($value->cost); ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Inventory Status:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $value->Status1; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Accounting Status:</label></td>
        <td class="text-left"  style="width:30%;"  scope="col"><span><?php echo $value->Status2; ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label></label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span></span></td>
      </tr>
      <?php } ?>
    <tr>
      <td class="text-center" colspan="4"><b>C.S Details</b></td>
    </tr>
    <?php foreach($vehicle as $cs){ ?>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>C.S Number:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $cs->cs_num; ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Model:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $cs->Product; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Model Year:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $cs->model_yr; ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Model Color:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $cs->color; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Model Cost:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo number_format($cs->cost); ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Location:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $cs->location; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>VRR Number:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $cs->vrr_num; ?></span></td>
        <td class="text-right" style="width:30%;" scope="col"><label>Vehicle Received Date:</label></td>
        <td class="text-left"  style="width:20%;" scope="col"> <span><?php echo $cs->veh_received; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>CSR Received Date:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $cs->csr_received; ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Paid Date:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $cs->paid_date; ?></span></td>
      </tr>
      <?php foreach($gp as $gpd){ ?>
        <tr>
          <td class="text-right" style="width:20%;" scope="col"><label>Production Number:</label></td>
          <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $gpd->production_num; ?></span></td>
          <td class="text-right" style="width:20%;" scope="col"><label>Engine Number:</label></td>
          <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $gpd->engine_number; ?></span></td>
        </tr>
      <?php } ?>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Subsidy Claiming:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo number_format($cs->subsidy_claiming); ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Subsidy Claimed:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo number_format($cs->subsidy_claimed); ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Allocation Dealer:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $cs->alloc_dealer; ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Allocation Date:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $cs->alloc_date; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Plant Sales Report:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $cs->plant_sales_report; ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Plant Sale Month:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $cs->plant_sales_month; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>(IMAPS) Release Date:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $cs->imaps_actual_release_date; ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>(GP) Release DAte:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $cs->gp_actual_release_date; ?></span></td>
      </tr>
    <?php } ?>
    <tr>
      <td class="text-center" colspan="4"><b>Sales Details</b></td>
    </tr>
    <?php foreach($gp as $gpd){ ?>
      <?php foreach($sc as $scvl){ ?>

          <?php if($scvl->id == $gpd->sc) {?>
          <?php $sc_fullName=ucfirst($scvl->Lname).','.ucfirst($scvl->Fname).' '.ucfirst($scvl->Mname); ?>
          <?php } ?>
      <?php } ?>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Name:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo ucfirst(strtolower($gpd->last_name)).','.ucfirst(strtolower($gpd->first_name)).' '.ucfirst(strtolower($gpd->middle_name)); ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Invoice Number:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $gpd->invoice_number; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Invoice Amount:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo number_format($gpd->invoice_amount); ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Invoice Date:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $gpd->invoice_date; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Sales Person:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $sc_fullName; ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Invoice Date:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $gpd->invoice_date; ?></span></td>
      </tr>
      <tr>
        <td class="text-right" style="width:20%;" scope="col"><label>Company Name:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"><span><?php echo $gpd->company_name; ?></span></td>
        <td class="text-right" style="width:20%;" scope="col"><label>Bank:</label></td>
        <td class="text-left"  style="width:30%;" scope="col"> <span><?php echo $gpd->bank; ?></span></td>
      </tr>
    <?php } ?>
  </table>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    // $('.money').mask("#,##0.00", {reverse: true});
  });
</script>
