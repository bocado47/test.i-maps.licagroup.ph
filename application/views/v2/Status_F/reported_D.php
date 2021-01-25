<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Reported Dashboard</h1>
    <!-- div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-1">
        </div>
        <div class="btn-group mr-2">
          <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="shopping-cart"></span> Add Purchase Order</button>
          <button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="download"></span> Batch Import</button>
        </div>
        <a href="../Excel/purchase_order.xlsx"><button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="download"></span>Download Sample File</button></a>
    </div> -->
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm" id="table">
      <thead>
        <tr>
          <th>C.S. Number</th>
          <th>P.O. Number</th>
          <th>Accounting Status</th>
          <th>Inventory Status</th>
          <th>Options</th>
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
                "bPrcessing":true,
                "bServerSide":true,
                "sServerMethod": "GET",
                "bInfo": false,
                "sAjaxSource":bUrl+"Inventory/reportedRecord",
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
                "lengthMenu":[[10,25,50,-1],[10,25,50,"ALL"]],
                "columnDefs":[
                    {"className":"text-center nwp","bSortable":false,"targets":0},
                    {"className":"text-center nwp","bSortable":false,"targets":1},
                    {"className":"text-center","bSortable":false,"targets":2},
                    {"className":"text-center","bSortable":false,"targets":3},
                    {"className":"text-center","bSortable":false,"targets":4},
                ],
                  "drawCallback":function (settings){
                    $(".receive").on('click',function(){
                       var value=$(this).val();
                       var array=value.split(",");
                       var id=array[0];
                       var po_num=array[1];
                       $.alert({
                            type:'blue',
                            columnClass:"col-sm-4 col-sm-offset-6",
                            title: 'Received Form',
                            content:'url:'+bUrl+'Dashboard/received_form?id='+id+'&po_num='+po_num,
                            buttons:{
                                save:{
                                    text:'Submit',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        var main=this;
                                        var ar=$('#receive_form').serialize();
                                        var action="Dashboard/receive_function";
                                        if($('#receive_form')[0].checkValidity() === false)
                                        {
                                            $('#receive_form').addClass('was-validated');

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
                                                  console.log(wmsg);
                                                self.close();
                                                jQuery.notify({
                                                  // options
                                                  message: 'Receive Successfuly!'
                                                },{
                                                  // settings
                                                   placement: {
                                                      from: "bottom",
                                                      align: "left"
                                                  },
                                                  type: 'success'
                                                });
                                                table.draw();
                                                }).fail(function(){
                                                self.setContent('Form Error. Please Try Again Later.');
                                                });
                                            }
                                        });
                                    },
                                },
                                close:{
                                    text:'Close',
                                    btnClass: 'btn-red'
                                },
                              }
                        });
                    });
                    $(".cl").on('click',function(){
                      var id=$(this).val();
                      $.alert({
                           type:'blue',
                           columnClass:"col-sm-4 col-sm-offset-6",
                           title: 'Change Location Form',
                           content:'url:'+bUrl+'Dashboard/change_location?id='+id,
                           buttons:{
                               save:{
                                   text:'Submit',
                                   btnClass: 'btn-green',
                                   action: function(){
                                       var main=this;
                                       var ar=$('#change_loc_form').serialize();
                                       var action="Dashboard/change_location_function";
                                       if($('#change_loc_form')[0].checkValidity() === false)
                                       {
                                           $('#change_loc_form').addClass('was-validated');

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
                                                 message: 'Change Location Successfuly!'
                                               },{
                                                 // settings
                                                  placement: {
                                                     from: "bottom",
                                                     align: "left"
                                                 },
                                                 type: 'success'
                                               });
                                               table.draw();
                                               table2.draw();
                                               }).fail(function(){
                                               self.setContent('Form Error. Please Try Again Later.');
                                               });
                                           }
                                       });
                                   },
                               },
                               close:{
                                   text:'Close',
                                   btnClass: 'btn-red'
                               },
                             }
                       });
                    });
                    $(".release").on('click',function(){
                      var value=$(this).val();
                      var array=value.split(",");
                      var id=array[0];
                      var cs_num=array[1];
                      var po_num=array[2];

                        $.alert({
                             type:'blue',
                             columnClass:"col-sm-4 col-sm-offset-6",
                             title: 'Release Form',
                             content:'url:'+bUrl+'Dashboard/release?id='+id+'&cs_num='+cs_num+'&po_num='+po_num,
                             buttons:{
                                 save:{
                                     text:'Submit',
                                     btnClass: 'btn-green',
                                     action: function(){
                                         var main=this;
                                         var ar=$('#release_form').serialize();
                                         var action="Dashboard/release_function";
                                         if($('#release_form')[0].checkValidity() === false)
                                         {
                                             $('#release_form').addClass('was-validated');

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
                                                   message: 'Released Successfuly!'
                                                 },{
                                                   // settings
                                                    placement: {
                                                       from: "bottom",
                                                       align: "left"
                                                   },
                                                   type: 'success'
                                                 });
                                                 table.draw();
                                                 table2.draw();
                                                 }).fail(function(){
                                                 self.setContent('Form Error. Please Try Again Later.');
                                                 });
                                             }
                                         });
                                     },
                                 },
                                 close:{
                                     text:'Close',
                                     btnClass: 'btn-red'
                                 },
                               }
                         });
                    });
                    $(".view").on('click',function(){
                      var value=$(this).val();
                      var array=value.split(",");
                      var id=array[0];
                      var cs_num=array[1];
                      var po_num=array[2];

                        $.alert({
                             type:'blue',
                             columnClass:"col-sm-9 col-sm-offset-2",
                             title: 'View Details',
                             content:'url:'+bUrl+'Dashboard/view_details?id='+id+'&cs_num='+cs_num+'&po_num='+po_num,
                             buttons:{
                                 close:{
                                     text:'Close',
                                     btnClass: 'btn-red'
                                 },
                               }
                        });
                    });
                  }

            });

});
</script>
