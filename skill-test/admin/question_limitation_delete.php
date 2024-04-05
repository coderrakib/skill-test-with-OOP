<?php 
	
	require_once ('../connect.php');

    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }

	$admin_id = (int) $_GET['admin_id'];
	$id 	  = (int) $_GET['id'];
	
    if(isset($_POST['submit']) && $_POST['submit'] === 'Yes'){

        $sql        = "DELETE FROM question_limitation WHERE id = $id ";

        if( $mysqli->query($sql) ) {
        echo "<script> alert ('Successfully Deleted Question Limitation') </script>";
        echo "<script>window.open('question_limitation.php?admin_id=$admin_id','_self') </script>";
    } else {
        echo "<script> alert ('Not Deleted in Question Limitation') </script>";
        echo "<script>window.open('question_limitation.php?admin_id=$admin_id','_self') </script>";
    }   
} 
       
?>
