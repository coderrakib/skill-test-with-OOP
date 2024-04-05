<?php
  
  require_once ('connect.php');
  
  session_start();
  
  if(!isset($_SESSION['exam'])){

    header("Location:index.php");
  }

  if(isset($_SESSION['exam'])){

    $user_id = $_SESSION['exam'];
  }

  if(isset($_SESSION['category'])){

    $category = $_SESSION['category'];
  }

  if(isset($_SESSION['topic'])){

    $topic = $_SESSION['topic'];
  }

  if(isset($_SESSION['level'])){

    $level = $_SESSION['level'];
  }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>| Online Exam System |</title>
        <link rel="stylesheet" type="text/css" href="front-assets/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="admin/assets/vendor/fonts/fontawesome/css/fontawesome-all.css" />
        <link rel="stylesheet" type="text/css" href="front-assets/css/index.css" />
        <link rel="shortcut icon" type="image/png" href="image/logo.png" />
        <style type="text/css">
            body {
                width: 100%;
                background: url(images/book.png) ;
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
        </style>
    </head>
    <body>
      <div class="container">
        <div class="row">
          <div class="col-12">
            <center>
              <h1 style="margin-top:132px;"> Your Certificate </h1>
                <div class="form-row">
                  <div class="col-12 col-md-4 offset-md-4">
                  <a class="mr-2" href='<?php echo "view_certificate.php?i=$user_id&&cat=$category&&to=$topic&&le=$level"; ?>'><button style="border:none;border-radius:0px;" class='btn btn-primary'><i class="fa fa-file"></i>&nbsp;View</button></a>
                  <a class="mr-2" href='examiner_info.php'><button style="border:none;border-radius:0px;" class='btn btn-danger'><i class="fa fa-edit"></i>&nbsp;Edit</button></a>
                  <a href='download.php'><button style="border:none;border-radius:0px;" class='btn btn-success'><i class="fa fa-download"></i>&nbsp;Download</button></a>
                  </div>
                </div>
            </center>
          </div>
        </div>
      </div>
    </body>
<script src="front-assets/js/jquery-3.3.1.min.js"></script>
<script src="front-assets/js/bootstrap.min.js"></script>
</html>