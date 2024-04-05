<?php
	
	$mysqli = new mysqli('localhost', 'root', '', 'online_exam');

	if($mysqli->connect_error){

		die('Database Connection Is Not Successfully !');
	}
	/*else{

		echo 'Database Connection Successfully';
	}*/
?>