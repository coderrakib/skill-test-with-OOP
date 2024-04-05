<?php
 
require_once ('connect.php');

session_start();

if(!isset($_SESSION['exam'])){

  header("Location:index.php");
}

if(isset($_POST['submit']) && $_POST['submit'] === "Submit"){

  $name       = $_POST['name'];

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

  $errors = [];

  if(isset($name,$user_id,$category,$topic,$level)){

    if(empty($name) && empty($user_id) && empty($category) && empty($topic) && empty($level)){

      $errors[] = "All Filed is Required";
    }
    else{

    if(empty($name)){

      $errors[] = "Examiner name is Required";
    }                   
  }

  if(!empty($errors)){

    foreach ($errors as $error) {

      echo "<h4 style='border:1px solid #f5c6cb; margin:0px 12px 10px 12px; background:#f8d7da; color:#721c24; padding:10px 5px 10px 10px; border-radius:5px;'> 
      $error </h4>";
    }
  }
  else{

      $sql    = "SELECT * FROM question_category WHERE id = '$category'";
      $query  = $mysqli->query($sql);
      $result = $query->fetch_assoc();
      $exam   = $result['category_name'];

      $rand   = rand(100,999);
      $certificate_id = "STRR".$user_id.$rand;

      header('Content-type: image/jpeg');
      $font=realpath('Monoton-Regular.ttf');
      $font_r=realpath('arial.ttf');
      $image=imagecreatefromjpeg("images/format.jpg");
      $color=imagecolorallocate($image, 0, 0, 0);
      $date=date('d F, Y');
      imagettftext($image, 18, 0, 880, 188, $color,$font, $date);
      $name = $name;
      $no   ="Certificate : ".$certificate_id;
      $exam = "$exam ( $level )";
      $certificate = $certificate_id.'.jpg';
      imagettftext($image, 30, 0, 245, 320, $color,$font, $name);
      imagettftext($image, 20, 0, 245, 430, $color,$font, $exam);
      imagettftext($image, 14, 0, 505, 110, $color,$font_r, $no);
      
      date_default_timezone_set('Asia/Dhaka');
      $create_date  = date('d-m-Y');

      $select       = "SELECT * FROM users WHERE id = '$user_id'";
      $select_query = $mysqli->query($select);
      $sel_result   = $select_query->fetch_assoc();
      $mac_id       = $sel_result['mac_id'];

      $certified        = "SELECT * FROM certified WHERE user_id = '$user_id' AND q_category = '$category' AND q_topic = '$topic' AND q_level = '$level'";
      $certified_query  = $mysqli->query($certified);
      $count            = mysqli_num_rows($certified_query);
      $result           = $certified_query->fetch_assoc();
      $get_cer          = $result['certificate'];

      if($count == 0){

        $insert = "INSERT INTO certified VALUES ('','$name','$user_id','$mac_id','$category','$topic','$level','$certificate_id','$certificate','$create_date')";

        if($mysqli->query($insert)){

          imagejpeg($image,"certificate/$certificate");
          imagedestroy($image);
          header("Location:get_certificate.php");

        }else{

          echo "<h4 style='border:1px solid #f5c6cb; margin:0px 12px 10px 12px; background:#f8d7da; color:#721c24; padding:10px 5px 10px 10px; border-radius:5px;'> 
          Somethings Went Wrong ! Please Try Again </h4>";
          header("Refresh:1; url= examiner_info.php");
        }

      }else{

          if(!empty($get_cer)){

            $path = "certificate/$get_cer";
            unlink($path);
          }

          $update = "UPDATE certified SET name = '$name', certificate_id = '$certificate_id', certificate = '$certificate' 
          WHERE user_id = '$user_id' AND q_category = '$category' AND q_topic = '$topic' AND q_level = '$level'";
          
          if($mysqli->query($update)){

            imagejpeg($image,"certificate/$certificate");
            imagedestroy($image);
            header("Location:get_certificate.php");

          }else{

            echo "<h4 style='border:1px solid #f5c6cb; margin:0px 12px 10px 12px; background:#f8d7da; color:#721c24; padding:10px 5px 10px 10px; border-radius:5px;'> 
            Somethings Went Wrong ! Please Try Again </h4>";
            header("Refresh:1; url= examiner_info.php");
          }
        }
      }
    }
  }
?>