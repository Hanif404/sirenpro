<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
	<title>SIRENPRO</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <style>
  html,
  body {
    max-width: 100%;
    overflow-x: hidden;
  }

  .login__body {
    min-height: 100vh;
  }

  .login__image {
    -o-object-fit: contain;
       object-fit: contain;
  }

  .login__container,
  .login__row {
    min-height: 100vh;
  }

  .login__card {
    background-color: #f6f6f6;
  }
  </style>
</head>
<body>
  <div class="container login__container">
         <div class="row login__row">
             <div class="col-md-6 d-flex">
                 <img class="login__imagek align-self-center" src="https://www.freevector.com/uploads/vector/preview/28488/Businessman_Happy_Accepting_News.jpg"
                     width="100%" alt="" />
             </div>
             <div class="col-md-5 d-flex">
                 <div class="align-self-center card login__card shadow-sm w-100">
                     <div class="card-body">
                         <form class="form-login" action="<?= base_url('auth/checkPermission')?>" method="post">
                             <h2 class="text-muted text-center">SIRENPRO</h2>

                             <div class="my-3">
                                 <h5 class="text-center">
                                     Login
                                 </h5>
                             </div>

                             <div class="">
                                 <div class="form-group">
                                     <label for="">Username</label>
                                     <input type="text" name="username" class="form-control form-control-lg" />
                                 </div>
                                 <div class="form-group">
                                     <label for="">Password</label>
                                     <input type="password" name="password" class="form-control form-control-lg" />
                                 </div>
                                 <div class="form-group">
                                     <button id="btnSubmit" class="btn btn-primary btn-lg btn-block my-3">
                                         Login
                                     </button>
                                     <div id="login-box-msg" class="text-center w-100" style="color:red;display:none;"></div>
                                     <div class="dropdown-divider my-4"></div>
                                     <div class="text-center w-100">
                                         <small>version 1.0.0</small>
                                     </div>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <script>
      clearAlert();
      $('#btnSubmit').on('click',function(){
        var frm = $('.form-login');
        var submitData = true;
        frm.submit(function (e) {
          e.preventDefault();

          if(submitData){
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                dataType:'json',
                success: function (data) {
                  if(data.code == 200){
                    window.location = '<?php echo base_url('main'); ?>';
                  }
                },
                error: function (data) {
                  var dt = data.responseJSON;
                  if(dt.code == 404){
                    $('#login-box-msg').show();
                    $('#login-box-msg').html(dt.message);
                  }else{
                    $('#login-box-msg').show();
                    $('#login-box-msg').text('Terjadi Kesalahan, Silahkan Ulangi Kembali');
                  }
                },
            });
            submitData = false;
          }
          return false;
        });
      });

      function clearAlert(){
        $('#login-box-msg').html('');
        $('#login-box-msg').hide();
      }
    </script>
</body>
</html>
