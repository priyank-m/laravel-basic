<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="apple-touch-icon" sizes="76x76" href="{{url('/')}}/backend/assets/img/favicon.png?T={{time()}}">
  <link rel="icon" type="image/png" href="{{url('/')}}/backend/assets/img/favicon.png">
  <title>
    Material Dashboard 2 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{url('/')}}/backend/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="{{url('/')}}/backend/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{url('/')}}/backend/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>

<body class="bg-gray-200">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">

      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign Up</h4>
             
                </div>
              </div>
              <div class="card-body">
                <form method="post" role="form" class="text-start regform" id="regform" action="javascript:void(0)">
                  
                  <div class="alert alert-success d-none" id="msg_div">
                    <span id="res_message"></span>
                  </div>
                            
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                  </div>  
                  <span class="errorMessage" role="name"></span>
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" id="phone" class="form-control" autocomplete="off" onkeypress="return /[0-9()+\s]/i.test(event.key)">
                  </div>
                  <span class="errorMessage" role="phone"></span>
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" autocomplete="off">
                  </div>
                  <span class="errorMessage" role="email"></span>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                  </div>
                  <span class="errorMessage" role="password"></span>
                  <div class="text-center">
                    </div><button type="submit" id="send_form" class="btn bg-gradient-primary w-100 my-4 mb-2"><div class="spinner-border d-none" style="width: 1.3rem;height: 1.3rem"></div><span class="regspinner">Submit</span></button>
                  </div>
                  <p class="text-sm text-center">
                  <a href="{{ url('/') }}" class="text-primary text-gradient font-weight-bold">Sign in</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="{{url('/')}}/backend/assets/js/core/popper.min.js"></script>
  <script src="{{url('/')}}/backend/assets/js/core/bootstrap.min.js"></script>
  <script src="{{url('/')}}/backend/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{url('/')}}/backend/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <script>
  //-----------------
  $(document).ready(function(){
  $('#send_form').click(function(e){
       e.preventDefault();


      $('.regspinner').addClass('d-none');
      $('.spinner-border').removeClass('d-none');
        
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('.errorMessage').html('')
      $.ajax({
      url: '/registration',
      method: 'post',
      data: $('.regform').serialize(),
      success: function(response){
         //------------------------

         if (response.status == true) { // If success then redirect to login 
            $('#msg_div').hide(); 
            window.location = response.redirect_location;
          }
          
         if (response.status == 400) {
          
          $('.regspinner').removeClass('d-none');
          $('.spinner-border').addClass('d-none'); 
          var test = response.errors;
          jQuery.each(test, function(key, value){
            $("[role='" + key + "']").append("<h6 class='text-danger'>" + value + "</h6>");
          });
         }else{

            $('.regspinner').removeClass('d-none');
            $('.spinner-border').addClass('d-none');
            $('#res_message').show();
            $('#res_message').html(response.msg);
            $('.name_error').html();
            $('#msg_div').removeClass('d-none');
 
            document.getElementById("regform").reset(); 
            setTimeout(function(){
            $('#res_message').hide();
            $('#msg_div').hide();
            },10000);
         //--------------------------
         }
      }});
      
      
     });
  });
  //-----------------
  </script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
 
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{url('/')}}/backend/assets/js/material-dashboard.min.js?v=3.0.0"></script>
</body>

</html>