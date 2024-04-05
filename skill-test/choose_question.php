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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript">
          window.history.forward();
          function noBack() { window.history.forward(); }
        </script>
    </head>
    <body onload="noBack();" 
      onpageshow="if (event.persisted) noBack();" onunload="">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <center>
              <h1 style="margin-top:132px;"> Choose Your Exam </h1>
               <?php
              
                if(isset($_POST['submit']) && $_POST['submit'] === "Start Exam"){

                  $category   = $_POST['category'];
                  $topic      = $_POST['topic'];
                  $level      = $_POST['level'];

                  $errors = [];

                  if(isset($category,$topic,$level)){

                    if(empty($category) && empty($topic) && empty($level)){

                      $errors[] = "All Filled is Required";
                    }
                    else{

                      if(empty($category)){

                        $errors[] = "Exam name is Required";
                      }

                      if(empty($topic)){

                        $errors[] = "Exam Topic is Required";
                      }

                      if(empty($level)){

                        $errors[] = "Exam Level is Required";
                      }
                    }

                    if(!empty($errors)){

                      foreach ($errors as $error) {
                        
                        echo "<div class='alert alert-danger'>
                            <h5 class='pb-0 m-0'>$error</h5>
                          </div>";;
                      }
                    }
                    else{

                      $history      = "SELECT * FROM history WHERE user_id = '$user_id' AND topic = '$topic'
                      AND category = '$category' AND level = '$level'";
                      $history_query    = $mysqli->query($history);
                      $row_count        = mysqli_num_rows($history_query);
                     
                      if($row_count == 1){

                        $result           = $history_query->fetch_assoc();
                        $res              = $result['result'];

                        if($res == 'Passed'){
                        
                        echo "<div class='alert alert-warning'>
                            <h5 class='pb-0 m-0'>Sorry ! You Have Already Passed in This Exam</h5>
                          </div>";

                        }elseif($res == 'Failed'){

                          $sql = "UPDATE history SET correct = '0', wrong ='0', total_mark = '0', mark_cut = '0', mark_obt = '0', result = '0' WHERE user_id = '$user_id' AND topic = '$topic'
                          AND category = '$category' AND level = '$level'";

                          if($mysqli->query($sql)){

                            $_SESSION['category'] = $category;
                            $_SESSION['topic'] = $topic;
                            $_SESSION['level'] = $level;

                            header("Location:question.php");
                            exit();

                          }else{
                            echo "<div class='alert alert-warning p-0 m-0'>
                              <h5 class='pb-0 m-0'>Something Went Wrong ..</h5>
                            </div>";
                          }
                        }
                      }else{

                        $_SESSION['category'] = $category;
                        $_SESSION['topic'] = $topic;
                        $_SESSION['level'] = $level;

                        header("Location:question.php");
                        exit();
                      }
                    }
                  }
                }
              ?>
              <form method="POST" action="">
                <div class="form-row">
                  <div class="col-12 col-md-4 mt-4">
                    <select style="border:none;border-radius:0px;" name="category" class="form-control">
                      <option value="">Select Exam Name</option>
                        <?php

                          $sql  = "SELECT * FROM question_category WHERE parent_id = 0";
                          $query  = $mysqli->query($sql);

                          while($row = $query->fetch_assoc()){

                            echo "<option value='".$row['id']."'>".$row['category_name']."</option>";
                          }
                        ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-4 mt-4">
                    <select style="border:none;border-radius:0px;" name="topic" class="form-control">
                      <option value="">Select Exam Topic Choose Exam Name First</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-4 mt-4">
                    <select style="border:none;border-radius:0px;" name="level" class="form-control">
                      <option value="">Select Exam Difficulty Level</option>
                      <option value="Beginner">Beginner</option>
                      <option value="Intermediate">Intermediate</option>
                      <option value="Advance">Advance</option>
                      <option value="Expert">Expert</option>
                    </select>
                  </div>
                </div>
                <div class="col-12 mt-3">
                  <input class="btn-1 mt-3 mb-5" type="submit" name="submit" value="Start Exam">
                </div>
              </form>
              <h2 class="mt-3"> Good &nbsp;Luck. </h2>
            </center>
          </div>
        </div>
      </div>
    </body>

    <script>
    $( "select[name='category']" ).change(function () {
      var categoryID = $(this).val();

      if(categoryID) {

          $.ajax({
              url: "topic_ajaxPro.php",
              dataType: 'Json',
              data: {'id':categoryID},
              success: function(data) {
                $('select[name="topic"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="topic"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
              }
          });
      }else{

        $('select[name="topic"]').empty();
      }
  });
</script>
<script src="front-assets/js/jquery-3.3.1.min.js"></script>
<script src="front-assets/js/bootstrap.min.js"></script>
</html>