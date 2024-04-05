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

  if(isset($_SESSION['category'])){

    $category = $_SESSION['category'];
  }

  if(isset($_SESSION['topic'])){

    $topic = $_SESSION['topic'];
  }

  if(isset($_SESSION['level'])){

    $level = $_SESSION['level'];
  }

  $history      = "SELECT * FROM history WHERE user_id = '$user_id' AND topic = '$topic'
    AND category = '$category' AND level = '$level'";
  $history_query    = $mysqli->query($history);
  $result           = $history_query->fetch_assoc();
  $level            = isset($result['level']) ? $result['level'] : 0;
  $right            = isset($result['correct']) ? $result['correct'] : 0;
  $total_mark       = isset($result['total_mark']) ? $result['total_mark'] : 0;
  $mark_cut         = isset($result['mark_cut']) ? $result['mark_cut'] : 0;

  $obt              = $total_mark - $mark_cut;

  $mark_obt = "UPDATE history SET mark_obt = '$obt' WHERE user_id = '$user_id' AND topic = '$topic'
    AND category = '$category' AND level = '$level'";
  $obt_query = $mysqli->query($mark_obt);

  if($level == 'Beginner'){

    if($right >= 2){
    $sql = "UPDATE history SET result = 'Passed' WHERE user_id = '$user_id' AND topic = '$topic'
        AND category = '$category' AND level = '$level'";
    $query = $mysqli->query($sql);
  }else{
    $sql = "UPDATE history SET result = 'Failed' WHERE user_id = '$user_id' AND topic = '$topic'
        AND category = '$category' AND level = '$level'";
    $query = $mysqli->query($sql);
  }
} 

if($level == 'Intermediate'){

    if($right >= 4){
    $sql = "UPDATE history SET result = 'Passed' WHERE user_id = '$user_id' AND topic = '$topic'
        AND category = '$category' AND level = '$level'";
    $query = $mysqli->query($sql);
  }else{
    $sql = "UPDATE history SET result = 'Failed' WHERE user_id = '$user_id' AND topic = '$topic'
        AND category = '$category' AND level = '$level'";
    $query = $mysqli->query($sql);
  }
}

if($level == 'Advance'){

    if($right >= 6){
    $sql = "UPDATE history SET result = 'Passed' WHERE user_id = '$user_id' AND topic = '$topic'
        AND category = '$category' AND level = '$level'";
    $query = $mysqli->query($sql);
  }else{
    $sql = "UPDATE history SET result = 'Failed' WHERE user_id = '$user_id' AND topic = '$topic'
        AND category = '$category' AND level = '$level'";
    $query = $mysqli->query($sql);
  }
}

if($level == 'Expert'){

    if($right >= 8){
    $sql = "UPDATE history SET result = 'Passed' WHERE user_id = '$user_id' AND topic = '$topic'
        AND category = '$category' AND level = '$level'";
    $query = $mysqli->query($sql);
  }else{
    $sql = "UPDATE history SET result = 'Failed' WHERE user_id = '$user_id' AND topic = '$topic'
        AND category = '$category' AND level = '$level'";
    $query = $mysqli->query($sql);
  }
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
    <?php 

      $sql      = "SELECT * FROM history WHERE user_id = '$user_id' AND topic = '$topic'
              AND category = '$category' AND level = '$level'";
      $query            = $mysqli->query($sql);
      $result           = $query->fetch_assoc();
      $right            = isset($result['correct']) ? $result['correct'] : 0;
      $wrong            = isset($result['wrong']) ? $result['wrong'] : 0;
      $t_q              = isset($result['total_question']) ? $result['total_question'] : 0;
      $mark             = isset($result['total_mark']) ? $result['total_mark'] : 0;
      $cut_mark         = isset($result['mark_cut']) ? $result['mark_cut'] : 0;
      $mark_obt         = isset($result['mark_obt']) ? $result['mark_obt'] : 0;
      $res              = isset($result['result']) ? $result['result'] : 0;
      $get_ans          = $right + $wrong;
      $no_ans           = $t_q - $get_ans;
    ?>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
          <div class="shadow p-3 mb-5 mt-5 bg-white rounded">
            <h3 style="background:#337ab7; color:#fff; padding:5px 0px 7px 0px;" class="text-center"><i class="fas fa-info-circle"></i>&nbsp;Your Exam Result</h3>
              <table style="border:1px solid #ddd;" class="table table-hover text-center">
                  <tbody>
                    <tr>
                      <td><h5 style="margin-bottom:0px;">Total Question</h5></td>
                      <td><h5 class="text-info" style="margin-bottom:0px;"><?php echo $t_q;?></h5></td>
                    </tr>
                    <tr>
                      <td><h5 style="margin-bottom:0px;">No Answer</h5></td>
                      <td><h5 class="text-info" style="margin-bottom:0px;"><?php echo $no_ans;?></h5></td>
                    </tr>
                    <tr>
                      <td><h5 style="margin-bottom:0px;">Right Answer&nbsp;&nbsp;<span><i class="fas fa-check text-success"></i></span></h5></td>
                      <td><h5 class="text-success" style="margin-bottom:0px;"><?php echo $right;?></h5></td>
                    </tr>
                    <tr>
                      <td><h5 style="margin-bottom:0px;">Wrong Answer&nbsp;&nbsp;<span><i class="fas fa-times text-danger"></i></span></h5></td>
                      <td><h5 class="text-danger" style="margin-bottom:0px;"><?php echo $wrong;?></h5></td>
                    </tr>
                    <tr>
                      <td><h5 style="margin-bottom:0px;">Total Mark</h5></td>
                      <td><h5 class="text-info" style="margin-bottom:0px;"><?php echo $mark;?></h5></td>
                    </tr>
                    <tr>
                      <td><h5 style="margin-bottom:0px;">Mark Cut</h5></td>
                      <td><h5 class="text-info" style="margin-bottom:0px;"><?php echo $cut_mark;?></h5></td>
                    </tr>
                    <tr>
                      <td><h5 style="margin-bottom:0px;">Mark Obtained</h5></td>
                      <td><h5 class="text-info" style="margin-bottom:0px;"><?php echo $mark_obt;?></h5></td>
                    </tr>
                    <tr>
                      <td><h5 style="margin-bottom:0px;">Exam Result</h5></td>
                      <?php 
                        if(!empty($res)){

                          if($res == 'Passed'){
                            echo "<td><h5 class='text-success' style='margin-bottom:0px;'>$res</h5></td>";
                          }else{
                            echo "<td><h5 class='text-danger' style='margin-bottom:0px;'>$res</h5></td>";
                          }
                        }else{
                          echo "<td><h5 class='text-danger' style='margin-bottom:0px;'>$res</h5></td>";
                        }
                      ?>
                    </tr>
                  </tbody>
                </table>
                <form>
                <div class="row">

                  <div class="col mr-md-3">
                    <?php 
                      if(!empty($res)){

                        if($res == 'Passed'){
                          echo "<center><img src='images/1.jpg' class='img-responsive float-right' alt='Passed' width='70' height='70'></center>";
                        }else{
                          echo "<center><img src='images/2.jpg' class='img-responsive float-right' alt='Failed' width='70' height='70'></center>";
                        }
                      }else{
                        echo "<center><img src='images/2.jpg' class='img-responsive float-right' alt='Failed' width='70' height='70'></center>";
                      }
                    ?>
                  </div>
                  <div class="col ml-md-3">
                   <?php 
                        if(!empty($res)){

                          if($res == 'Passed'){
                            echo "<a style='margin-top:18px;' class='btn btn-success' href='examiner_info.php'>Get Certificate</a>";
                          }else{
                            echo "<a style='margin-top:18px;' class='btn btn-danger' href='logout.php'>Retech Exam</a>";
                          }
                        }else{
                          echo "<a href='logout.php'><button style='margin-top:18px;' class='btn btn-danger'>Retech Exam</button></a>";
                        }
                      ?>
                  </div>
                </div>
            <div>
        </div>
      </div>
    </div>
  <script src="front-assets/js/jquery-3.3.1.min.js"></script>
  <script src="front-assets/js/bootstrap.min.js"></script>
</body>
</html>
