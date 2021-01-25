<style type="text/css">
  td{
    white-space: nowrap;
  }
  .sorting_asc:before{
    display: none !important;
  }
  .sorting_asc:after{
    display: none !important;
  }
  div.dt-buttons {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }
  .up{
    text-transform: uppercase;
  }
</style>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Change Location: (Batch)</h1>
    <div class="tab-content">
      <div id="vehicle" class="container tab-pane active"><br>
          <div class="btn-toolbar mb-2 mb-md-0" style="float:right">
            <div class="btn-group mr-2">
              <button class="btn btn-md btn-outline-secondary" id="locationButton"><span data-feather="map-pin"></span> Change Location</button>
            </div>
          </div>
      </div>
    </div>
  </div>
  <br><br>
  <div class="table-responsive">
    <table class="table table-striped table-sm" id="table">
      <thead>
        <tr>
          <th>C.S. Number</th>
          <th>P.O. Number</th>
          <th>Location</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</main>
<script type="text/javascript">
	$(document).ready(function() {
    var bUrl="<?php echo base_url(); ?>";
    var table=$('#table').DataTable({
              "processing":true,
              "serverSide":true,
              "sServerMethod": "POST",
              "sAjaxSource":bUrl+"Dashboard/POCS_loc",
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
                  {"className":"text-center","bSortable":true,"targets":3}
              ],
              "drawCallback":function (settings){
                $(".add").on('click',function(){
                  var id=$(this).val();
                  $.ajax({
                    url: bUrl+"Dashboard/addToSelection?id="+id,
                    type:"GET",
                    dataType:"JSON",
                    success:function(data)
                    {
                      table.draw();
                    },
                    error:function(){
                      console.log('error');
                    }
                  });
                });
                $(".remove").on('click',function(){
                  var id=$(this).val();
                  $.ajax({
                    url: bUrl+"Dashboard/removeToSelection?id="+id,
                    type:"GET",
                    dataType:"JSON",
                    success:function(data)
                    {
                      table.draw();
                    },
                    error:function(){
                      console.log('error');
                    }
                  });
                });
              }
            });

            $("#locationButton").on('click',function(){
                               $.alert({
                               type:'green',
                               columnClass:"col-sm-8 col-sm-offset-2",
                               title:'Change Vehicle Location',
                               content:'url:'+bUrl+'Inventory/changelocform',
                               buttons:
                                 {
                                   confirm:
                                   {
                                     text: 'Submit',
                                                   btnClass: 'btn-blue',
                                                   action: function(){
                                                       var main=this;
                                                       var ar=$('#change_location_form').serialize();
                                                       var action="Inventory/change_form";
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
                                                   },
                                   },
                                   close:
                                   {
                                     text:'Close',
                                     btnClass:'btn-red'
                                   }
                                 }
                               });
                         });
  });
</script>
