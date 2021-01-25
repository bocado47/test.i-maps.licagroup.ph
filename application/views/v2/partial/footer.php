 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   <!--  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
   <!--  <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script> -->

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace();
    </script>

    <!-- Graphs -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"/></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"/></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/canvas2.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <!--  -->
    <script>
      feather.replace();
    </script>
  </body>
</html>
<?php
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
?>
<script type="text/javascript">
var bUrl="<?php echo base_url(); ?>";
  $(document).ready(function() {

    $("#profile").on("click",function(){
      $.alert({
        type:'blue',
        columnClass:"col-sm-5 col-sm-offset-4",
        title: 'Profile',
        content: 'url:'+bUrl+'Inventory/profile',
        buttons:{
              confirm:
              {
                  text:'Change Password',
                  btnClass: 'btn-green',
                  keys:['enter'],
                  action: function(){
                    $.alert({
                      type:'blue',
                      columnClass:"col-sm-5 col-sm-offset-4",
                      title: 'Change Password',
                      content: 'url:'+bUrl+'Inventory/changepas',
                      buttons:
                      {
                        change:{
                          text:'submit',
                          keys:['enter'],
                          btnClass:'btn-green',
                          action:function(){
                            var main=this;
                            var ar=$('#changepass_form').serialize();
                            var action="Inventory/change";
                             if($('#changepass_form')[0].checkValidity() === false)
                              {
                                  $('#changepass_form').addClass('was-validated');

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
                                  self.setContent('<font color="green"><center>Change Password Successfuly!</center></font>');
                                  // self.close();
                                  }).fail(function(){
                                  self.setContent('Form Error. Please Try Again Later.');
                                  });
                                },
                                buttons:{
                                  logout:{
                                    text:"LOGOUT",
                                    keys:['enter'],
                                    action: function () {
                                      main.close();
                                      window.location.href= bUrl+'Login/Logout';
                                    }
                                  }
                                }
                            });
                          },
                        },
                        close:{
                          text:'Close',
                          keys:[''],
                        },
                      }
                    });
                  },
              },
              logout:
              {
                  text:'Log Out',
                  btnClass: 'btn-red',
                  keys:['enter'],
                  action: function () {
                      this.close();
                      window.location.href= bUrl+'Login/Logout';
                  }
              },
              close:
              {
                  text:'Close',
              },
        },
      });
    });
    $("#UN").on("click",function(){
      // $(".hidden-un").fadeIn();
      // $(".hidden-is").hide();
      // $(".hidden-as").hide();
      $(".hidden-an").hide();
      $(".hidden-tn").hide();
    });
    $("#IS").on("click",function(){
      // $(".hidden-is").fadeIn();
      // $(".hidden-un").hide();
      // $(".hidden-as").hide();
      $(".hidden-an").hide();
      $(".hidden-tn").hide();
    });
    $("#AS").on("click",function(){
      // $(".hidden-as").fadeIn();
      // $(".hidden-is").hide();
      // $(".hidden-un").hide();
      $(".hidden-an").hide();
      $(".hidden-tn").hide();
    });
    $("#AN").on("click",function(){
      $(".hidden-an").fadeIn();
      // $(".hidden-is").hide();
      // $(".hidden-as").hide();
      // $(".hidden-un").hide();
      $(".hidden-tn").hide();
    });
    $("#TN").on("click",function(){
      $(".hidden-tn").fadeIn();
      // $(".hidden-is").hide();
      // $(".hidden-as").hide();
      $(".hidden-an").hide();
      // $(".hidden-un").hide();
    });
  });
</script>
