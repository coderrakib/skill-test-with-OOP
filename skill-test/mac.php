<?php

require_once ('connect.php');

session_start();  

if(isset($_POST['submit']) && $_POST['submit'] === 'Your Skill Test'){

	$MAC = exec('getmac'); 
  
	$MAC = strtok($MAC, ' '); 

	date_default_timezone_set('Asia/Dhaka');
    $create_date  = date('d-m-Y');

	$sql 		= "SELECT * FROM users WHERE mac_id = '$MAC'";
	$query  	= $mysqli->query($sql);
	$row_count  = mysqli_num_rows($query);
	$result     = $query->fetch_assoc();
	$user_id 	= $result['id'];

	if($row_count == 1){

		$_SESSION['exam'] = $user_id;
		header("Location:choose_question.php");
		exit();

	}else{

		if($row_count == 0){

			$sql 	= "INSERT INTO users (mac_id,create_date) VALUES ('$MAC','$create_date')";
			$query  = $mysqli->query($sql);

			$sql 		= "SELECT * FROM users WHERE mac_id = '$MAC'";
			$query  	= $mysqli->query($sql);
			$result     = $query->fetch_assoc();
			$user_id 	= $result['id'];

			$_SESSION['exam'] = $user_id;
			header("Location:choose_question.php");
			exit();
			
		}else{

			echo "<script>alert('Your are not valid user')</script>";
		}
	} 
   
}else{

	echo "<script>alert('Something Went Wrong')</script>";
}

?>   