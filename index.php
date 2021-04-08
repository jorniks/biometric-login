
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

  <style>
    main {
      margin-top: 120px;
    }

    #reset {
      cursor: pointer;
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
      <?php include 'header.php'; ?>
    </header>
      <!--Main Navigation-->

  <!--Main layout-->
  <main>
    <div class="container-fluid my-5">

      <div class="row justify-content-center">
        <div class="col-md-4">
          <div style="height: 80vh">
            <div class="d-flex justify-content-center align-items-center h-100">
              <div class="container">
              
                <div class="card">
                  <div class="d-flex justify-content-center py-3">
                    <!-- CANVAS FOR DISPLAYING CAPTURED IMAGE -->
                    <div class="d-none view" id="canvasDiv">
                      <img src="" class="img-fluid canvasImage" alt=" ">
                      <div class="mask pattern-1 flex-center">
                        <p class="white-text mx-4 my-2" style="height: 100%; width: 100%; text-align: right;">
                        <span class="badge red px-2" id="reset">Reset</span>
                        </p>
                      </div>
                      <canvas id="canvas" max-width="200" height="200"></canvas>
                      <div class="text-center">
                      </div>
                    </div>
                    <!-- CANVAS FOR DISPLAYING CAPTURED IMAGE -->

                    <div class="view" id="videoView">
                      <video id="video" max-width="200" height="200" autoplay></video>
                      <div class="mask pattern-1 flex-center waves-effect waves-light" id="snap">
                        <p class="white-text">
                          <i class="fa fa-2x fa-camera"></i>
                          <!-- Click to capture -->
                        </p>
                      </div>
                    </div>
                  </div>
                  
                  <div class="card-body px-lg-4 pt-2">
                    <form method="POST" class="my-3">
                      <div class="mb-4">
                        <input type="text" id="userID" name="username" class="form-control" placeholder="Username" required>
                      </div>
                      <div class="mb-4">
                        <input type="text" id="password" name="password" class="form-control" placeholder="Alternative Password" required>
                      </div>

                      <div class="text-center">
                        <button class="btn btn-outline-success btn-md waves-effect z-depth-0" name="createUser" type="submit">Create User</button>
                      </div>
                    
                      <div class="col-md-12 text-center">
                        <div class="spinner-grow spinner-grow-sm text-success d-none" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                        <small id="spinText"></small>
                      </div>
                    </form>
                    <div class="my-3 text-right">
                      Have an account? <a href="login/">Login</a>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>


		</div>
  </main>
  
<div class="fixed-action-btn" style="bottom: 15px; right: 34px;" title="Menu">
    <div class="btn-group-vertical" role="group" aria-label="vertical">
        <a href="" class="btn-floating green" title="Home"><i class="fa fa-home"></i></a>
        <a href="" class="btn-floating yellow darken-1" title="Add student record"><i class="fa fa-plus"></i></a>
    </div>
</div>

<!-- Footer -->
<footer class="page-footer font-small unique-color-dark">
  <!-- <div class="container">
    <div class="row d-flex text-center justify-content-center mb-md-0 mb-4">
      <div class="col-md-8 col-12 mt-5">
        <p style="line-height: 1.7rem">
          Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur.
        </p>
      </div>
    </div>
  </div> -->
    
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
					}).catch(function(error) {
            swal('Camera Mode', 'Failed to open camera. Kindly, grant permission', 'error');
          });
				}

				// Trigger photo take
				$("#snap").click(function() {
          context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 16, 0, 265, 200);
          $('.canvasImage').attr('src', canvas.toDataURL());
          $('#canvasDiv').removeClass('d-none');
          $('#videoView').addClass('d-none');
				});
        
				$("#reset").click(function() {
          context.clearRect(0, 0, canvas.width, canvas.height);
          $('.canvasImage').attr('src', '');
          $('#videoView').removeClass('d-none');
          $('#canvasDiv').addClass('d-none');
        })

				$('form').submit(function(event) {
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
                  $("#reset").click();
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
