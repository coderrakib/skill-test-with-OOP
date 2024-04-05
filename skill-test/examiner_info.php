<?php
  require_once ('connect.php');
  session_start();

  if(!isset($_SESSION['exam'])){

    header("Location:index.php");
    exit();
  }

  if(isset($_SESSION['exam'])){

    $user_id = $_SESSION['exam'];
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
              <h1 style="margin-top:132px;"> Your Information </h1>
              <form method="POST" action="certificate.php">
                <div class="form-row">
                  <div class="col-12 col-md-4 offset-md-4">
                    <input style="border:none;border-radius:0px;" type="text" name="name" class="form-control" placeholder="Your name">
                  </div>
                </div>
                <div class="col-12 mt-3">
                  <input class="btn-1 mt-3 mb-5" type="submit" name="submit" value="Submit">
                </div>
              </form>
            </center>
          </div>
        </div>
      </div>
    </body>
<script src="front-assets/js/jquery-3.3.1.min.js"></script>
<script src="front-assets/js/bootstrap.min.js"></script>
</html>