<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="<?php echo base_url(); ?>assets/images/lica_ico.png">

      <title>Vehicle Inventory</title>

      <!--CSS-->
      <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/css/signin.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/css/jquery-confirm.min.css" rel="stylesheet">
      <!-- CSS END -->

      <!-- JS -->
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-confirm.min.js"></script>
      <!-- JS END -->

      <!-- STYLE -->
      <style type="text/css">
        .jconfirm-content
        {
          overflow: hidden !important;
        }
        .jconfirm-buttons {
            float:none !important;
        }
        #loadiv{
          display: none;
        }
        .loader {
          border: 16px solid red;
          border-radius: 50%;
          border-top: 16px solid black;
          width: 70px;
          height: 70px;
          -webkit-animation: spin 2s linear infinite; /* Safari */
          animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
        #snowflakesCanvas{
          z-index: -1;
        }
        canvas#snowflakesCanvas{
          display:block;
        }
        canvas{
          position:fixed;
        }
        .xmas{
          color:#fff; font-weight:bold;
        }
        .xmasbtn{
          background-color: #002e5f !important;
          border-color: #ecf5ff important;
        }
      </style>
      <!-- STYLE END -->
  </head>
  <body class="text-center">
    <!-- <canvas id="snowflakesCanvas"></canvas> -->
    <form class="form-signin" id="login" method="POST" action="<?php echo base_url();?>Login/logged_in" style="margin-top: 100px !important;">
      <img class="mb-4" src="<?php echo base_url(); ?>assets/images/lica_ico.png" style="width:10vw;">
      <h1 class="h3 mb-3 font-weight-normal xmas" style="font-size: 2vw;">Inventory Monitoring, Analysis, and Projection System (i-MAPS)</h1><br/>
      <center id="loadiv"><div class="loader"></div><br/></center>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail"  name="email" class="form-control" placeholder="Email address" required="" autofocus="" autocomplete="off">
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword"  name="password" class="form-control" placeholder="Password" required="" autocomplete="off">
      <button class="btn btn-lg btn-primary btn-block xmasbtn" type="submit" id="logged_in">Sign in</button>
      <!-- <p class="mt-5 mb-3 text-muted">© Grimoire-Guild</p> -->
    </form>
  </body>
</html>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/canvas.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#login").submit(function(e) {
            var form = $(this);
            var bUrl="<?php echo base_url(); ?>";
            var url = form.attr('action');
              $.ajax({
                  type: 'POST',
                  url: url,
                  dataType:'JSON',
                  data:form.serialize(),
                  beforeSend: function() {
                      // setting a timeout
                      $('#loadiv').show();
                  },
                  success: function(data) {
                    console.log(data);
                     if(data == 'error')
                     {
                       $.alert({
                         type:'red',
                         title: '<font color="red">Error!</font>',
                         content: 'Please Check You Email And Password.<br/> Or Kinldy Contact Your Supervisor To Check Your Account If Still Activated.',
                         buttons: {
                                cancel: {
                                    text: 'close',
                                    btnClass: 'btn-red',
                                    keys:['enter'],
                                    action: function () {
                                       location.reload();
                                    }
                                }

                            }
                       });
                     }else{
                        // window.location=bUrl + 'Inventory';
                        var name='';
                        var type='';
                        console.log(data);
                        // $.each(data, function (index, value) {
                          name+=data.Name;
                          type+=data.Type;

                        // // });
                        // if(type == 4)
                        // {
                        //   $.alert({
                        //    type:'green',
                        //    title: '<font color="Green">Logged In!</font>',
                        //    content: 'Welcome to Inventory System<h3>'+name+'</h3>',
                        //    buttons: {
                        //           success: {
                        //               text: 'Ok',
                        //               btnClass: 'btn-success',
                        //               keys:['enter'],
                        //               action: function () {
                        //                  // location.reload();
                        //                  window.location=bUrl + 'Inventory/Tdashboard';
                        //               }
                        //           }
                        //
                        //       }
                        //   });
                        // }else{
                          $.alert({
                           type:'green',
                           title: '<font color="Green">Logged In!</font>',
                           content: 'Welcome to Inventory System<h3>'+name+'</h3>',
                           buttons: {
                                  success: {
                                      text: 'Ok',
                                      btnClass: 'btn-success',
                                      keys:['enter'],
                                      action: function () {
                                         // location.reload();
                                         window.location=bUrl + 'Dashboard';
                                      }
                                  }

                              }
                          });
                        // }

                        // var obj =JSON.stringify(data);
                        // alert(obj-'Name']);
                     }
                  },
                  error: function(xhr) { // if error occured

                  },
                  complete: function() {
                       $('#loadiv').hide();
                  },
              });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
      });
</script>
