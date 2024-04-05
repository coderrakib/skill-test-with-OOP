<?php 
	
	require_once ('../connect.php');

    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }

	$admin_id = (int) $_GET['admin_id'];
	$id 	  = (int) $_GET['id'];
	
    if(isset($_POST['submit']) && $_POST['submit'] === 'Yes'){

        $sql        = "DELETE FROM question_category WHERE id = $id ";

        if($mysqli->query($sql)){

        	$sub_cat 	= "SELECT * FROM question_category WHERE parent_id = $id ";
  			$query 		= $mysqli->query($sub_cat);
		    
		    while ($row = $query->fetch_assoc()){

		    	$p_id		= $row['parent_id'];

		    	$subsql		= "DELETE FROM question_category WHERE parent_id = $p_id ";

		    	if($mysqli->query($subsql)){
					
					echo "<script> alert ('Successfully Deleted in Your Category') </script>";
            		echo "<script>window.open('question_category.php?admin_id=$admin_id','_self') </script>";
		    	}
		    	else{
					
					echo "<script> alert ('Not Deleted in Your Sub Category') </script>";
            		echo "<script>window.open('question_category.php?admin_id=$admin_id','_self') </script>";
					
		    	}
		    } 

		    echo "<script> alert ('Successfully Deleted in Your Category') </script>";
            echo "<script>window.open('question_category.php?admin_id=$admin_id','_self') </script>";           
       	}
       	else{

            echo "<script> alert ('Not Deleted in Your Category') </script>";
            echo "<script>window.open('question_category.php?admin_id=$admin_id','_self') </script>";
        }
    }
?>
