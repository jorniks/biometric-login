
<?php
  include '../includes/env-autoload.php';
  new DotEnv('../.env');
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Dashboard - <?=getenv('APP_NAME')?></title>
  <!-- ========================================================================== -->
  <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
  <!-- ========================================================================== -->
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <!-- ========================================================================== -->
  <link rel="stylesheet" href="../assets/css/mdb.min.css">
  <!-- ========================================================================== -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <!-- ========================================================================== -->
</head>

<body class="black-skin">

  <?php include '../header.php'; ?>

  <!--Main layout-->
  <main>
    <div class="container-fluid">
      
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
    
  <div class="footer-copyright text-center py-3">
    &copy;
    <script>document.write(new Date().getFullYear())</script>
    Copyright
  </div>
</footer>

  <!--========================================================================
    OTHER URL FOR BACKGROUND IMAGE

    https://encrypted-tbn0.gstatic.com/images q=tbn:ANd9GcRL3-flGflTKrF0K8-PnWFxG_uYHA27bc8S00KhEfAfWotk76En

  =========================================================================-->
  <!--Main layout-->

    <!-- ====================================================================== -->
    <script src="../assets/js/plugins/jquery-3.3.1.min.js"></script>
    <!-- ====================================================================== -->
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <!-- ====================================================================== -->
    <script src="../assets/js/plugins/mdb.js"></script>
    <!-- ====================================================================== -->
    <script src="../assets/js/plugins/sweetalert.min.js"></script>
    <!-- ====================================================================== -->

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
                'logUser': true
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
    <script src="../assets/js/global.js"></script>
</body>

</html>
