
<?php
  include "../core/con.php";

  if(!$_GET['course']){
    redirectTo('../');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Authentication - Facial Recognition</title>
  <!-- ===================================================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" href="../assets/css/mdb.min.css">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" href="../assets/css/materialdesignicons.min.css">
  <!-- ===================================================================================== -->
  <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/style.css">
  <!-- ===================================================================================== -->

  <style>
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
        <?php include '../header.html';?>
    </header>
      <!--Main Navigation-->
  <!--Main layout-->
  <main class="mx-lg-3">
    
    <div class="container-fluid">
      <div class="row">
        
          <div class="col-lg-6">
            <div class="row">
              <div class="col-md-6">
                
                <!-- Form -->
                <form class="md-form" style="color: #757575;">
              
                  <input type="text" id="regNumberSearch" class="form-control">
                  <label for="regNumberSearch">Registration Number</label>
                  
                  <button type="button" class="btn btn-outline-success waves-effect verify">Fetch Record</button>
                </form>

                <!-- Grid row -->
              <div class="row">
                
                  <div class="col-xl-12 col-md-12 mb-3">
                    <img src="" class="img-fluid z-depth-1 rounded studentImage" alt="">
                  </div>
                
                </div>
                <!-- Grid row -->
              </div>
              
              <div class="col-md-6">
                <ul class="list-group list-group-flush studentDetail">

                </ul>
              </div>
            </div>
          </div>
            
        
        <div class="col-lg-6">
          <div class="col-md-12">
            <!-- CANVAS FOR DISPLAYING CAPTURED IMAGE -->
            <div class="canvasDiv col-md-8 d-none">
              <img src="" class="img-fluid z-depth-1 canvasImage" alt=" ">
              <canvas id="canvas" max-width="460" height="300" class="d-none"></canvas>
              <!-- <div class="col-lg-12">
                <button type="reset" class="btn btn-success reset">Reset</button>
              </div> -->
              <div class="col-lg-8 text-center mt-2">
                <div class="spinner-border spinner-border-sm text-success" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <small id="spinText" class="text-success"></small>
              </div>
            </div>
            
              <!-- CANVAS FOR DISPLAYING CAPTURED IMAGE -->
              
              
              <div class="view col-md-8 text-center container-fluid">
                <video id="video" max-width="460" height="300" autoplay></video>
                <div class="mask flex-center waves-effect waves-light" id="snap">
                  <p class="green-text">
                    <i class="fa fa-camera"></i> Click to capture &amp; compare
                  </p>
                </div>
                <small id="errText" class="text-danger"></small>
              </div>
            </div>
          </div>

        </div>

      </div>

  </main>
  <!--Main layout-->
  
<div class="fixed-action-btn" style="bottom: 15px; right: 34px;" title="Menu">
    <div class="btn-group-vertical" role="group" aria-label="vertical">
        <a href="../" class="btn-floating green" title="Home"><i class="fa fa-home"></i></a>
        <a href="../register" class="btn-floating yellow darken-1" title="Add student record"><i class="fa fa-plus"></i></a>
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
        <?=date("Y", time())?>
        Copyright
    </div>
    
</footer>


    <!-- ================================================================================== -->
    <script src="../assets/js/plugins/jquery-3.3.1.min.js"></script>
    <!-- ================================================================================== -->
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <!-- ================================================================================== -->
    <script src="../assets/js/plugins/mdb.js"></script>
    <!-- ================================================================================== -->
    <script src="../assets/js/plugins/addons/sweetalert.min.js"></script>
    <!-- ================================================================================== -->
  <!-- ================================================================================== -->
  <!-- MY JAVASCRIPT FILE FOR JS MANIPULATIONS ON THIS PAGE -->
  <script src="../assets/js/global.js"></script>
  <script>
      // Grab elements, create settings, etc.
      var video = document.getElementById('video');
      var canvas = document.getElementById('canvas');
      var context = canvas.getContext('2d');
      $("#snap").addClass('disabled');

      // Get access to the camera!
      if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
          navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
              video.srcObject = stream;
              video.play();
          });
      }

      $('.verify').click(function() {
        $('.studentDetail').html('');
        $('.studentImage').attr('src', '');

        var matricNo = $('#regNumberSearch').val().trim();
        var url = new URLSearchParams(window.location.search);
        var course = url.get('course');

        if (matricNo) {

          $.ajax({
            type: 'POST',
            url: "../core/backend.php",
            data: {
              'fmatricNo': matricNo,
              'url': course
            },
            success:function(data) {
              if (data == 1) {
                swal(matricNo, "is to seat for this exam !", "success");
              } else if (data == 2) {
                swal(matricNo, "is not supposed to seat for this exam !", "error");
              } else if (data == 3) {
                swal("", "Provided matriculation number is incorrect", "info");
              } else if (JSON.parse(data)) {
                var result = JSON.parse(data);
                $('.studentDetail').html(popDetails('Name', result['name'], 'Name'));
                $('.studentDetail').append(popDetails('Matric No.', result['regNo'], 'Matric'));
                $('.studentDetail').append(popDetails('Course', result['course'], 'Course'));
                $('.studentImage').attr('src', result['image'])
                $("#snap").removeClass('disabled');
              } else {
                swal("Fatal Error", data, "error");
              }
            }
          });

        } else {
          swal("Empty value", "You must provide a matricNo to continue!", "error");
        }
      });


      // Trigger photo take
      $("#snap").click(function() {
          context.drawImage(video, -75, 0, 420, 310);
          var canvasURL = canvas.toDataURL();
          var matricNo = $('#sdMatric').text().trim();
          $('.canvasImage').attr('src', canvasURL);
          
          // $(".spinner-grow").removeClass('d-none');
          $("#spinText").html("comparing faces ...");
          
          $('.canvasDiv').removeClass('d-none');
          $('.view').addClass('d-none');

          $.ajax({
            type: 'POST',
            url: "../core/backend.php",
            data: {
              'cmatricNo': matricNo,
              'dataURL': canvasURL
            },
            success:function(data) {
              if (data == 1) {
                swal('MATCH', "This is the registered student for this exam !", "success");
                $('.canvasImage').attr('src', '');
                $('.view').removeClass('d-none');
                $('.canvasDiv').addClass('d-none');
                $("#snap").addClass('disabled');
              } else if (data == 2) {
                swal('DIFFERENT', "This is not the face registered for this exam !", "warning");
                $('.canvasImage').attr('src', '');
                $('.view').removeClass('d-none');
                $('.canvasDiv').addClass('d-none');
                $("#snap").addClass('disabled');
              } else if (data == 3) {
                swal(matricNo, "image failed to process !", "info");
                $('.view').addClass('d-none');
                $('.canvasDiv').removeClass('d-none');
                $("#errText").html("Fatal server error. Check your connection.");
              } else {
                swal("Fatal Error !", data, "error");
                $('.view').removeClass('d-none');
                $('.canvasDiv').addClass('d-none');
                $("#errText").html("Fatal server error. Check your connection.");
              }
            }
          });
      });

      function popDetails(title, value, id) {
        return "<li class=\"list-group-item black-text\">" +
                    "<span class=\"chip green white-text\">" + title +"</span>" +
                    "<label id=sd" + id + ">" + value + "</label>" +
                  "</li>"
      }
  </script>
</body>

</html>
