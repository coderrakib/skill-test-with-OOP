<?php
	
	require_once ('../connect.php');

	$position = $_POST['position'];
	
	$i= 1;

	foreach($position as $k=>$v){

	 echo $sql = "UPDATE question_category SET position_order = '$i' WHERE id= '$v'";
	 
	 $mysqli->query($sql);
		
		$i++;
	}
?>
