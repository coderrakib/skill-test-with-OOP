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

  $get_question   = "SELECT * FROM question WHERE q_category = '$category' AND q_topic = '$topic' AND q_level = '$level'";
  $question_query = $mysqli->query($get_question);
  $row_count      = mysqli_num_rows($question_query);

  if($row_count == 0){

    echo "<script>alert('Question Not Found ! Please Choose Another Topic')</script>";
    echo "<script>window.open('choose_question.php','_self')</script>";
  }else{

      $sql        = "SELECT * FROM question_limitation WHERE q_category = '$category' AND q_topic = '$topic' AND q_level = '$level' ORDER BY id DESC LIMIT 1";
      $query      = $mysqli->query($sql);
      $limitation = $query->fetch_assoc();
      $count      = $limitation['q_limit']; 

      if(isset($_SESSION['counting'])){
            
        $_SESSION['counting']++;
      }
      else{

        $_SESSION['counting'] = 1;
      }

      if($_SESSION['counting'] <= $count){

      if($level == "Beginner"){

        $sql    = "SELECT * FROM question where q_category = '$category' AND q_topic = '$topic' AND q_level = '$level' order by RAND()";
      }

      if($level == "Intermediate"){

        $sql    = "SELECT * from question where q_category = '$category' AND q_topic = '$topic' AND q_level = '$level'
                    union all
                    (select *
                     from question
                     where q_category = '$category' AND q_topic = '$topic' AND q_level = 'Beginner'
                     limit 3
                    )
                    order by RAND();";
      }

      if($level == "Advance"){

        $sql    = "SELECT * from question where q_category = '$category' AND q_topic = '$topic' AND q_level = '$level'
                    union all
                    (select *
                     from question
                     where q_category = '$category' AND q_topic = '$topic' AND q_level = 'Beginner'
                     limit 3
                    )
                    union all
                    (select *
                     from question
                     where q_category = '$category' AND q_topic = '$topic' AND q_level = 'Intermediate'
                     limit 3
                    )
                    order by RAND();";
      }

      if($level == "Expert"){

        $sql    = "SELECT * FROM question where q_category = '$category' AND q_topic = '$topic' AND q_level = '$level' 
                  union all
                    (select *
                     from question
                     where q_category = '$category' AND q_topic = '$topic' AND q_level = 'Beginner'
                     limit 3
                    )
                    union all
                    (select *
                     from question
                     where q_category = '$category' AND q_topic = '$topic' AND q_level = 'Intermediate'
                     limit 3
                    )
                    union all
                    (select *
                     from question
                     where q_category = '$category' AND q_topic = '$topic' AND q_level = 'Advance'
                     limit 3
                    )
                order by RAND()";
      }
      
      $query      = $mysqli->query($sql);
      
      $result   = $query->fetch_assoc();
      $id       = $result['id'];
      $name     = $result['q_name'];
      $duration = $result['q_time'];
      $mark     = $result['q_mark'];
      $type     = $result['q_type'];
      $level    = $result['q_level'];
      $q_option       = $result['q_option'];
      $q_answer       = $result['q_answer'];
      $explode_opt    = explode(',', $q_option);
      $explode_ans    = explode(',', $q_answer);
      $opt            = strip_tags($name);
      $re_opt         = explode('.', $opt);

    }else{

      echo "<script>alert('Your Exam Time Over')</script>";
      echo "<script>window.open('result.php','_self')</script>";
    }
  } 
?>
<!DOCTYPE html>
<html lang="en-US" class="no-js" prefix="og: http://ogp.me/ns#">
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
    <script type="text/javascript">
      window.history.forward();
      function noBack() { window.history.forward(); }
    </script>
  </head>
  <body onload="noBack();" 
  onpageshow="if (event.persisted) noBack();" onunload="">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
          <div class="shadow p-3 mb-5 mt-5 bg-white rounded">
            <h3 class="text-center py-3">Your Examation Question</h3>
            <h4 class="text-center pb-3">Question <?php if(isset($_SESSION['counting'])){echo $_SESSION['counting'];}?>
                  of <?php echo $count; ?>
            </h4>
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h5 class="d-inline">Mark - </h5>
                    <h5 class="d-inline"><?php echo $mark; ?></h5>
                  </div>
                  <div class="col text-right">
                    <h5 class="d-inline">Time - </h5>
                    <h5 class="d-inline"><span id="response"><?php echo $duration;?></span></h5>
                  </div>
                </div>
              </div>
              
              <form action="answer.php" method="POST">
                    <?php if($type === "MCQ") { ?>
                    <div class="card-body">
                      <div class="card-padding">
                        <h3 class="bg-primary text-light text-center mb-2 pt-2 pb-2 rounded">Single select multiple choice question</h3>
                        <h5 class="font-weight-bold mb-1 pt-2"><?php echo $name; ?></h5>
                          <?php $x = 1; foreach ($explode_opt as $option => $opt) { ?>
                          <div class="form-check pl-0">
                            <label class="toggle">
                              <input type="radio" name="answer" value="<?php echo $x; ?>">&nbsp;&nbsp;<span class="label-text"><?php echo $opt;?></span>
                            </label>
                          </div>
                          <?php $x++; } ?>
                      </div>
                    </div>
                    <?php } ?>
                    <?php if($type === "Gap Filling") { ?>
                    <div class="card-body">
                      <div class="card-padding">
                        <h3 class="bg-primary text-light text-center mb-2 pt-2 pb-2 rounded">Select answer and gap filling</h3>
                          <h5 class="font-weight-bold mb-1 pt-2"><?php echo $name; ?></h5> 
                            <?php $x = 1; foreach ($explode_opt as $option => $opt) { ?>
                            <div class="form-check pl-0">
                            <label class="toggle">
                              <input type="radio" name="answer" value="<?php echo $x; ?>">&nbsp;&nbsp;<span class="label-text"><?php echo $opt;?></span>
                            </label>
                          </div>
                            <?php $x++; } ?>
                        </div>
                      </div>
                    <?php } ?>
                    <?php if($type === "Rearrange") { ?>
                    <div class="card-body">
                      <div class="card-padding">
                        <h3 class="bg-primary text-light text-center mb-3 pt-2 pb-2 rounded">Drag & drop rearrange the words into box</h3>
                          <?php foreach ($re_opt as $option => $opt) { ?>
                          <div class="form-check form-check-inline pt-2">
                            <p style="font-size:18px; font-weight:bold;" draggable="true"><?php echo $opt; ?></p>
                            <br>
                          </div>
                          <?php } ?>
                          <textarea class="form-control" name="answer"></textarea>
                      </div>
                    </div>
                  <?php } ?>
                <div class="card-footer text-muted">
                 <div class="text-right">
                    <input type="hidden" name="hidden" value="<?php echo $id;?>">
                    <input style="border:none;border-radius:0px;" class="btn btn-primary" type="submit" name="submit" value="Next">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>    
    <script>
    document.addEventListener('dragstart', function (event) {
      event.dataTransfer.setData('Text', event.target.innerHTML);
    });


  var end_second = document.getElementById("response").innerHTML;
  
  setInterval(function(){
    
    end_second--;

    if(end_second >= 0){

      id = document.getElementById("response");
      id.innerHTML = end_second;
    }

    if(end_second < 0){
      window.location.reload(true);
    } 

  }, 1000);
  </script>
    <script src="front-assets/js/jquery-3.3.1.min.js"></script>
    <script src="front-assets/js/bootstrap.min.js"></script>
  </body>
</html>
