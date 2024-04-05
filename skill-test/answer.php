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

    date_default_timezone_set('Asia/Dhaka');
    $create_date  = date('d-m-Y');

    if(isset($_POST['submit']) && $_POST['submit'] === 'Next'){

    	$q_id 	= $_POST['hidden'];
    	$answer = isset($_POST['answer']) ? $_POST['answer'] : 0;
    	
    	$sql 	= "SELECT * FROM question WHERE id = '$q_id'";
    	$query  = $mysqli->query($sql);
    	$result = $query->fetch_assoc();
    	$q_name = $result['q_name'];
    	$q_ans  = $result['q_answer'];
        $q_mark = $result['q_mark'];
    	$q_type = $result['q_type'];

        $t_question = "SELECT * FROM question_limitation WHERE q_category = '$category' AND q_topic = '$topic' AND q_level = '$level' ORDER BY id DESC LIMIT 1";
        $q_query    = $mysqli->query($t_question);
        $limitation = $q_query->fetch_assoc();
        $count      = $limitation['q_limit']; 

    	$history 			= "SELECT * FROM history WHERE user_id = '$user_id' AND category = '$category'
    	AND topic = '$topic' AND level = '$level'";
    	$history_query  	= $mysqli->query($history);
    	$row_count 			= mysqli_num_rows($history_query);

        $convert_input      = trim(strtolower(str_replace(' ','',$answer)));
        $convert_database   = trim(strtolower(str_replace(' ','',$q_ans)));

        if($convert_input === $convert_database){
    	    
    	   if($row_count == 0){

    	    	$sql 	= "INSERT INTO history VALUES ('','$user_id','$category','$topic','$level','$count','0','0','0','0','0','0','$create_date')";
    	    	$query  = $mysqli->query($sql);
    	    }

            $sql        = "SELECT * FROM history WHERE user_id = '$user_id' AND category = '$category'
            AND topic = '$topic' AND level = '$level'";

            $query      = $mysqli->query($sql);
            $result     = $query->fetch_assoc();
            $correct    = $result['correct'];
            $mark       = $result['total_mark'];
            $cut_mark   = $result['mark_cut'];
            $i          = $correct + 1;
            $t_m        = $q_mark + $mark;
                   
            $update_sql = "UPDATE history SET correct = '$i', total_mark = '$t_m' WHERE user_id = '$user_id' AND category = '$category'
            AND topic = '$topic' AND level = '$level'";
            $update_query = $mysqli->query($update_sql);

            header("Location: question.php");
                
    	}else{

    	    if($row_count == 0){

    	    	$sql     = "INSERT INTO history VALUES ('','$user_id','$category','$topic','$level','$count','0','0','0','0','0','0','$create_date')";
                $query  = $mysqli->query($sql);
    	    }

    	    $sql 		= "SELECT * FROM history WHERE user_id = '$user_id' AND category = '$category'
        	AND topic = '$topic' AND level = '$level'";

        	$query 		= $mysqli->query($sql);
        	$result     = $query->fetch_assoc();
        	$wrong 		= $result['wrong'];
        	$i 			= $wrong + 1;

            $mark       = $result['total_mark'];
            $t_m        = $q_mark + $mark;

            $mark_cut   = $result['mark_cut'];
        	$cut_m 	    = $q_mark + $mark_cut;

        	$update_sql = "UPDATE history SET wrong = '$i', total_mark = '$t_m', mark_cut = '$cut_m' WHERE user_id = '$user_id' AND category = '$category'
        	AND topic = '$topic' AND level = '$level'";
        	$update_query = $mysqli->query($update_sql);

        	header("Location: question.php");
        }
	}  
?>