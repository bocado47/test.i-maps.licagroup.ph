<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Allocated</h1>
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
          <th>CS Number</th>
          <th>P.O. Number</th>
          <th>Car</th>
          <th>Dealer</th>
          <th>Status</th>
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
                "sAjaxSource":bUrl+"Inventory/allocatedRecord",
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
                    {"className":"text-center","bSortable":false,"targets":5}
                ],
                "drawCallback":function (settings){
                  $(".Adddealer").on('click',function(){
                     var id=$(this).val();
                     $.alert({
                          type:'red',
                          columnClass:"col-sm-8 col-sm-offset-2",
                          title: 'Change Allocated Dealer',
                          content: 'url:'+bUrl+'Inventory/dealer_form?id='+id,
                          buttons:{
                              save:{
                                  text:'Submit',
                                  btnClass: 'btn-green',
                                  action: function(){
                                      var main=this;
                                      var ar=$('#dealer_form').serialize();
                                      var action="Inventory/dealer_function";
                                      if($('#dealer_form')[0].checkValidity() === false)
                                      {
                                          $('#dealer_form').addClass('was-validated');

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
                     $(".invoice").on('click',function(){
                      var id=$(this).val();
                       $.alert({
                            type:'blue',
                            columnClass:"col-sm-8 col-sm-offset-2",
                            title: 'Invoice Form',
                            content: 'url:'+bUrl+'Inventory/new_invoice_form?id='+id,
                            buttons:{
                                save:{
                                    text:'Submit',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        var main=this;
                                        var ar=$('#invoice_form').serialize();
                                        var action="Inventory/invoice_function";
                                        var currentTime = new Date();
                                        var lname=$('#last_name').val();
                                        var fname=$('#first_name').val();
                                        var mname=$('#middle_name').val();
                                        var cname=$('#company_name').val();
                                        var paymodes=$('#paymodes').val();
                                        var bank=$('#bank').val();
                                        if( lname == "" && fname == "")
                                        {
                                          $('#company_name').prop('required',true);
                                          $('#last_name').prop('required',false);
                                          $('#first_name').prop('required',false);
                                        }else if(cname == ""){
                                          $('#company_name').prop('required',false);
                                          $('#last_name').prop('required',true);
                                          $('#first_name').prop('required',true);
                                        }
                                        if(paymodes == 'cash')
                                        {
                                          $('#bank').prop('required',false);
                                        }else{
                                          $('#bank').prop('required',true)
                                        }
                                        var val1=$('#sr_date').val().split('-');
                                                      var newval1=val1[1]+'-'+val1[0]+'-01';
                                                      var val2=$('#pr_date').val().split('-');
                                                      var newval2=val2[1]+'-'+val2[0]+'-01';
                                                      if(newval1 < '1990-01-01')
                                                      {
                                                        $.alert({
                                                          type:'red',
                                                          columnClass:"col-sm-6 col-sm-offset-4",
                                                          title: '<h3 style="color:red;">Error</h3>',
                                                          content: '<h5 style="color:red;">Please provide a Valid Accounting Sale Period, Thank you.</h5>',
                                                         });
                                                        $('#sr_date').val("");
                                                        return false;
                                                      }
                                                      if(newval2 < '1990-01-01')
                                                      {

                                                        $.alert({
                                                          type:'red',
                                                          columnClass:"col-sm-6 col-sm-offset-4",
                                                          title: '<h3 style="color:red;">Error</h3>',
                                                          content: '<h5 style="color:red;">Please provide a Valid Plant Released Month, Thank you.</h5>',
                                                         });
                                                        $('#pr_date').val("");

                                                        return false;
                                                      }
                                        if($("input[name=inv_amt]").val() < 1){
                                            $("input[name=inv_amt]").val('');


                                        }
                                        if($('#invoice_form')[0].checkValidity() === false)
                                        {
                                            $('#invoice_form').addClass('was-validated');

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
                                                table2.draw();
                                                console.log(wmsg);
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
                }
            });

});
</script>
