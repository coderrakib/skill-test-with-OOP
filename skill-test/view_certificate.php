<?php
	
	require_once ('connect.php');
	
	$user_id 	= (int) $_GET['i'];
	$category 	= (int) $_GET['cat'];
	$topic 		= (int) $_GET['to'];
	$level      =  $_GET['le'];

	$sql = "SELECT * FROM certified WHERE user_id = '$user_id' AND q_category =
	'$category' AND q_topic = '$topic' AND q_level = '$level'";
	$query = $mysqli->query($sql);
	$result = $query->fetch_assoc();
	$certificate = $result['certificate'];
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<center><img src="certificate/<?php echo $certificate ?>"></center>
</body>
</html>