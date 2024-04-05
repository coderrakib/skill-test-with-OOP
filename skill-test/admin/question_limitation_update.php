<?php 
	
	require_once ('../connect.php');

    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }

	$admin_id = (int) $_GET['admin_id'];
	$id 	  = (int) $_GET['id'];
	
    if(isset($_POST['submit']) && $_POST['submit'] === 'Update'){

        $category       = $_POST['category'];
        $topic          = $_POST['topic'];
        $level          = $_POST['level'];
        $limit		    = $_POST['limit'];
        date_default_timezone_set('Asia/Dhaka');
        $create_date 	= date('d-m-Y');

        //$messages 		= [];

        if(isset($category,$topic,$level,$limit,$create_date)){

           	if(empty($level)){

                echo "<script> alert ('Question Level is Required') </script>";
                echo "<script>window.open('question_limitation.php?admin_id=$admin_id','_self') </script>";
            }

            if(empty($limit)){

                echo "<script> alert ('Question Limit is Required') </script>";
                echo "<script>window.open('question_limitation.php?admin_id=$admin_id','_self') </script>";
            }

            else{

            	$sql = "UPDATE question_limitation SET q_category = '$category', q_topic = '$topic', q_level = '$level', q_limit = '$limit', create_date = '$create_date' WHERE id = '$id'";

                if($mysqli->query($sql)){

                	echo "<script> alert ('Successfully Updated in Your Question Limitation') </script>";
                	echo "<script>window.open('question_limitation.php?admin_id=$admin_id','_self') </script>";
                                    
                }else{

                	echo "<script> alert ('Not Updated in Your Question Limitation') </script>";
                	echo "<script>window.open('question_limitation.php?admin_id=$admin_id','_self') </script>";
                }
            }
        }
    }

?>
