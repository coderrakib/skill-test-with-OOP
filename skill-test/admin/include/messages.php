<?php 

	$classname = $_SESSION['class_name'];

	foreach ($_SESSION['messages'] as $message) {

		echo "<div class='alert $classname alert-dismissible fade show mb-5 mt-0' role='alert'>
  			<strong>$message</strong>
  			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    			<span aria-hidden='true'>&times;</span>
  			</button>
		</div>";
	}
?>