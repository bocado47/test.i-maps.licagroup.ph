<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Treasury Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-1">
        </div>
        <div class="btn-group mr-2">
          <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="shopping-cart"></span> Create Financial Cover </button>
          <!-- <button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="download"></span> Batch Import</button> -->
        </div>
        <!-- <a href="../Excel/purchase_order.xlsx"><button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="download"></span>Download Sample File</button></a> -->
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm" id="table">
      <thead>
        <tr>
          <th>P.O. #</th>
          <th>Model</th>
          <th>Color</th>
          <th>P.O. Date</th>
          <th>Cost</th>
          <th>Bank</th>
          <th>FC #</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</main>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
   var bUrl="<?php echo base_url(); ?>";
   var table=$('#table').DataTable({
             "bProcessing":true,
             "bServerSide":true,
             "sServerMethod": "GET",
             "bInfo": false,
             "sAjaxSource":bUrl+"Inventory/tdata",
             "fnServerData":function (sSource,aoData,callback){
                 aoData.push(
                     {"name":"Id","value":1}
                 );
                 $.ajax({
                     'url':sSource,
                     'data':aoData,
                     'type':'GET',
                     'success':callback,
                     'dataType':'json',
                     'cache':true
                 });
             },
             "sDom":'<"#tblTitle"><"#tblTools"><"#tblCol"><"#sbtn"f><"#prBar"r><t><"clear"><"bottom"><p>',
             "lengthMenu":[[10,25,50,-1],[10,25,50,"ALL"]],
             "columnDefs":[
                 {"className":"text-center nwp","bSortable":false,"targets":0},
                 {"className":"text-center nwp","bSortable":true,"targets":1},
                 {"className":"text-center","bSortable":false,"targets":2},
                 {"className":"text-center","bSortable":false,"targets":3},
                 {"className":"text-center","bSortable":false,"targets":4},
                 {"className":"text-center","bSortable":false,"targets":5},
                 {"className":"text-center","bSortable":false,"targets":6}
             ],
             "drawCallback":function (settings){
             }
   });
   $('#table_processing').html('Loading');
   $('#apo').on('click',function(){
     $.ajax({
       url:'<?php echo base_url(); ?>Inventory/newfc',
       dataType:'JSON',
       success:function(data){
         console.log(data);
         $.alert({
         type:'green',
         columnClass:"col-sm-8 col-sm-offset-2",
         title:'Financial Cover',
         content:'url:'+bUrl+'Inventory/addFCForm?fcnumber='+data,
         buttons:{
           save:{
             text:'Submit',
             btnClass:'btn-green',
             action:function(){
              var main=this;
              var ar=$('#poform').serialize();
              var action="Inventory/submitFC";
                if($('#poform')[0].checkValidity() === false)
                {
                    $('#poform').addClass('was-validated');

                    return false;
                }
                $.alert({
                    title:"",
                    type:"green",
                    content:function(){
                        var self=this;
                        return $.ajax({
                        url:bUrl+action,
                        type:"POST",
                        data:ar,
                        }).done(function(wmsg){
                          self.close();
                        jQuery.notify({
                          // options
                          message: 'Submit Successfuly!'
                        },{
                          // settings
                           placement: {
                              from: "bottom",
                              align: "left"
                          },
                          type: 'success'
                        });
                        table.draw();
                        // console.log(wmsg);
                        }).fail(function(){
                        self.setContent('Form Error. Please Try Again Later.');
                        });
                    }
                });
             }
           },
           close:{
               text:'Close',
               btnClass: 'btn-red'
           },
         }
        });
       }
     });
   });
});
</script>
