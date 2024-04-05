<?php 
	
	require_once ('../connect.php');

    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }

	$admin_id = (int) $_GET['admin_id'];
	$id 	  = (int) $_GET['id'];
	
    if(isset($_POST['submit']) && $_POST['submit'] === 'Update'){

        //$parent_id 		= isset($_POST['parent_id']) ? $_POST['parent_id'] : NULL;
        $category		= $_POST['category'];
        date_default_timezone_set('Asia/Dhaka');
        $create_date 	= date('d-m-Y');

        //$messages 		= [];

        if(isset($category,$create_date)){

           	if(empty($category)){

                echo "<script> alert ('Question Category Name is Required') </script>";
                echo "<script>window.open('question_category.php?admin_id=$admin_id','_self') </script>";
            }

            else{

            	$sql = "UPDATE question_category SET category_name = '$category', create_date = '$create_date' WHERE id = '$id'";

                if($mysqli->query($sql)){

                	echo "<script> alert ('Successfully Updated in Your Category') </script>";
                	echo "<script>window.open('question_category.php?admin_id=$admin_id','_self') </script>";
                                    
                }else{

                	echo "<script> alert ('Not Updated in Your Category') </script>";
                	echo "<script>window.open('question_category.php?admin_id=$admin_id','_self') </script>";
                }
            }
        }
    }

?>
