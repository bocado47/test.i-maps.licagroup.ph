
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">User Table</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-1">
                <!-- <span data-feather="calendar"></span>Date -->
              </div>
              <div class="btn-group mr-2">
                <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="user-plus"></span> Add User</button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-sm" id="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
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
                "sAjaxSource":bUrl+"Admin/user_record",
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
                    {"className":"text-center nwp","bSortable":true,"targets":1},
                    {"className":"text-center","bSortable":false,"targets":2},
                    {"className":"text-center","bSortable":false,"targets":3},
                    {"className":"text-center","bSortable":false,"targets":4}
                ],
                "drawCallback":function (settings){
                  $(".btnview").on('click',function(){
                     var id=$(this).val();
                     $.alert({
                        type:'blue',
                        columnClass:"col-sm-6 col-sm-offset-4",
                        title: 'User Profile View And Edit',
                        content: 'url:'+bUrl+'Admin/user_profile?id='+id,
                        buttons:{
                          save:{
                              text:'Update',
                              btnClass: 'btn-green',
                              action:function()
                              {
                                var main=this;
                                var ar=$('#user_edit_form').serialize();
                                var action="Admin/userupdateform?id="+id;
                                if($('#user_edit_form')[0].checkValidity() === false)
                                {
                                    $('#user_edit_form').addClass('was-validated');

                                    return false;
                                }
                                $.alert({
                                    title:"Form",
                                    type:"green",
                                    content:function(){
                                        var self=this;
                                        return $.ajax({
                                        url:bUrl+action,
                                        type:"POST",
                                        data:ar,
                                        }).done(function(wmsg){
                                        self.setContent('<font color="green"><center>Submit Successfuly!</center></font>');
                                        self.setContentAppend('</br>');
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
                          }
                        }
                        // content:id,
                     });
                  });
                  $(".btnaccess").on('click',function(){
                      var id=$(this).val();
                      $.alert({
                          type:'blue',
                          columnClass:"col-sm-6 col-sm-offset-4",
                          title: 'User Profile Access',
                          content: 'url:'+bUrl+'Admin/user_access?id='+id,
                          buttons:{
                          save:{
                              text:'Update',
                              btnClass: 'btn-green',
                              action:function()
                              {
                                var main=this;
                                var ar=$('#user_access_form').serialize();
                                console.log(ar);
                                var action="Admin/user_access_update?id="+id;
                                if($('#user_access_form')[0].checkValidity() === false)
                                {
                                    $('#user_access_form').addClass('was-validated');

                                    return false;
                                }
                                $.alert({
                                    title:"Form",
                                    type:"green",
                                    content:function(){
                                        var self=this;
                                        return $.ajax({
                                        url:bUrl+action,
                                        type:"POST",
                                        data:ar,
                                        }).done(function(wmsg){
                                        self.setContent('<font color="green"><center>Submit Successfuly!</center></font>');
                                        self.setContentAppend('</br>');
                                        table.draw();
                                        console.log(wmsg);
                                        }).fail(function(){
                                        self.setContent('Form Error. Please Try Again Later.');
                                        });
                                    }
                                });
                              }
                          },
                          close:{
                          }
                        }
                      });
                  });
                  $(".btndelete").on('click',function(){
                    var id=$(this).val();
                    var action="Admin/user_delete?id="+id;
                    $.ajax({
                      url:bUrl+action,
                      type:"POST",
                      dataType:"JSON",
                      success:function(data)
                      {
                        // console.log(data);
                        table.draw();
                      },
                      error:function(){
                        console.log('error');
                      }
                    });
                  });
                  $(".btnactivate").on('click',function(){
                    var id=$(this).val();
                    var action="Admin/user_activate?id="+id;
                    $.ajax({
                      url:bUrl+action,
                      type:"POST",
                      dataType:"JSON",
                      success:function(data)
                      {
                        // console.log(data);
                        table.draw();
                      },
                      error:function(){
                        console.log('error');
                      }
                    });
                  });
                },
      });

      $('#apo').on('click',function(){
          $.alert({
          type:'green',
          columnClass:"col-sm-8 col-sm-offset-2",
          title:'Add User',
          content:'url:'+bUrl+'Admin/user_form',
          buttons:
          {
            confirm:
            {
              text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function(){
                                var main=this;
                                var ar=$('#user_form').serialize();
                                var action="Admin/useraddform";
                                if($('#user_form')[0].checkValidity() === false)
                                {
                                    $('#user_form').addClass('was-validated');

                                    return false;
                                }
                                $.alert({
                                    title:"Form",
                                    type:"green",
                                    content:function(){
                                        var self=this;
                                        return $.ajax({
                                        url:bUrl+action,
                                        type:"POST",
                                        data:ar,
                                        }).done(function(wmsg){
                                        self.setContent('<font color="green"><center>Submit Successfuly!</center></font>');
                                        self.setContentAppend('</br>');
                                        table.draw();
                                        // console.log(wmsg);
                                        }).fail(function(){
                                        self.setContent('Form Error. Please Try Again Later.');
                                        });
                                    }
                                });
                            },
            },
            // next:
            // {
            //  text:'Submit And Create Invoice',
            //  btnClass:'btn-success invoice'
            // },
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
