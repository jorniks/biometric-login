
<?php
  // include 'includes/class-autoloader.php';
  // require 'vendor/autoload.php';
  // require('core/users.class.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Register - Facial Recognition</title>
  <!-- ===================================================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" href="assets/css/mdb.min.css">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" type="text/css" media="screen" href="assets/css/style.css">
  <!-- ===================================================================================== -->

  <style>
    .form-dark .font-small {
      font-size: 0.8rem; }

    .form-dark .md-form label {
      color: #fff; }

    .md-form input[type=text]:focus:not([readonly]) {
      border-bottom: 1px solid #00C851;
      -webkit-box-shadow: 0 1px 0 0 #00C851;
      box-shadow: 0 1px 0 0 #00C851; }

    .form-dark input[type=text]:focus:not([readonly]) + label {
      color: #fff; }

    .form-dark .modal-header {
        border-bottom: none;
		}
		
    #canvas {
      border:1px solid red;
      width: 100%;
      height: 100%;
      display: none;
    }
  </style>
</head>

<body class="black-skin">

    <header class="topbar mb-4">
      <?php include 'header.html'; ?>
    </header>
      <!--Main Navigation-->
  <!--Main layout-->
  <main class="mx-lg-3">

    <div class="container-fluid">

      <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
            
                <div class="card-body px-lg-5 pt-2">

                  <div class="col-md-12 text-center">

                    <!-- CANVAS FOR DISPLAYING CAPTURED IMAGE -->
                    <div class="d-none canvasDiv">
                      <img src="" class="img-fluid z-depth-1 canvasImage" alt=" ">
                      <canvas id="canvas" max-width="460" height="300"></canvas>
                      <div class="col-lg-12">
                        <button type="reset" class="btn btn-success reset">Reset</button>
                      </div>
                    </div>
                    <!-- CANVAS FOR DISPLAYING CAPTURED IMAGE -->
                    
                    <div class="view col-md-8 container-fluid">
                      <video id="video" max-width="460" height="300" autoplay></video>
                      <div class="mask pattern-1 flex-center waves-effect waves-light" id="snap">
                        <p class="white-text">
                          <i class="fa fa-camera"></i>
                        </p>
                      </div>
                    </div>
                    
                  </div>
                    <form class="md-form" style="color: #757575;" method="POST">
                      
                      <div class="md-form">
                        <input type="text" id="userID" name="username" class="form-control" required>
                        <label for="userID">Username</label>
                      </div>
                      <div class="md-form">
                        <input type="text" id="password" name="password" class="form-control" required>
                        <label for="password">Alternative Password</label>
                      </div>
            
                      <button class="btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0" name="createUser" type="submit">Create User</button>
    
                      <div class="col-md-12 text-center">
                        <div class="spinner-grow spinner-grow-sm text-success d-none" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                        <small id="spinText"></small>
                      </div>

                    </form>
                </div>
            </div>
        </div>
      </div>

		</div>
		<br>
		<br>

  </main>
  
<div class="fixed-action-btn" style="bottom: 15px; right: 34px;" title="Menu">
    <div class="btn-group-vertical" role="group" aria-label="vertical">
        <a href="" class="btn-floating green" title="Home"><i class="fa fa-home"></i></a>
        <a href="" class="btn-floating yellow darken-1" title="Add student record"><i class="fa fa-plus"></i></a>
    </div>
</div>

<!-- Footer -->
<footer class="page-footer font-small unique-color-dark">
    <div class="container">

        <!-- Grid row-->
        <div class="row d-flex text-center justify-content-center mb-md-0 mb-4">

            <div class="col-md-8 col-12 mt-5">
                <p style="line-height: 1.7rem">
                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur.
                </p>
            </div>

        </div>
      
    </div>
    
    <div class="footer-copyright text-center py-3">
        &copy;
        <script>document.write(new Date().getFullYear())</script>
        Copyright
    </div>
    
</footer>

  <!--==================================================================================
    OTHER URL FOR BACKGROUND IMAGE

    https://encrypted-tbn0.gstatic.com/images q=tbn:ANd9GcRL3-flGflTKrF0K8-PnWFxG_uYHA27bc8S00KhEfAfWotk76En

  ===================================================================================-->
  <!--Main layout-->

    <!-- ================================================================================== -->
    <script src="assets/js/plugins/jquery-3.3.1.min.js"></script>
    <!-- ================================================================================== -->
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <!-- ================================================================================== -->
    <script src="assets/js/plugins/mdb.js"></script>
    <!-- ================================================================================== -->
    <script src="assets/js/plugins/addons/sweetalert.min.js"></script>
    <!-- ================================================================================== -->

    <!-- CDN -->
    <script>
      $(document).ready(function() {
				// Grab elements, create settings, etc.
				var video = document.getElementById('video');
				var canvas = document.getElementById('canvas');
				var context = canvas.getContext('2d');

				// Get access to the camera!
				if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
					navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } }).then(function(stream) {
						video.srcObject = stream;
						video.play();
					});
				}

				// Trigger photo take
				$("#snap").click(function() {
          context.drawImage(video, -75, 0, 420, 310);
          $('.canvasImage').attr('src', canvas.toDataURL());
          $('.canvasDiv').removeClass('d-none');
          $('.view').addClass('d-none');
				});
        
				$(".reset").click(function() {
          context.clearRect(0, 0, canvas.width, canvas.height);
          $('.canvasImage').attr('src', '');
          $('.view').removeClass('d-none');
          $('.canvasDiv').addClass('d-none');
        })

				$('.md-form').submit(function(event) {
					event.preventDefault();
          var thisForm = this;

					var password = $('#password').val().trim();
					var username = $('#userID').val().trim();
          var canvasURL = canvas.toDataURL();

					if ($('.canvasImage').attr('src') == '') {
            swal("Error !", 'Capture image before submitting', "info");
          } else {
            $(".btn").addClass('disabled');
            $(".spinner-grow").removeClass('d-none');
            $("#spinText").html("Saving record to database......");

            $.ajax({
              type: 'POST',
              url: "ajax.php",
              data: {
                'password': password,
                'username': username,
                'dataURL': canvasURL,
                'createUser': true
              },
              success:function(data) {
                result = JSON.parse(data)
                if (result.msgType == 'success') {
                  swal(result.msgHead, result.msgBody, result.msgType);
                  clearSpinner();
                  thisForm.reset();
                  $(".reset").click();
                } else {
                  swal(result.msgHead, result.msgBody, result.msgType);
                  clearSpinner();
                }
              }
            });
          }
				})
      });

      function clearSpinner() {
        $(".btn").removeClass('disabled');
        $(".spinner-grow").addClass('d-none');
        $("#spinText").html("");
      }
    </script>
    <!-- MY JAVASCRIPT FILE FOR JS MANIPULATIONS ON THIS PAGE -->
    <script src="assets/js/global.js"></script>
</body>

</html>
