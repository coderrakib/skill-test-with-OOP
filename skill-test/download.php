<?php
	
	require_once ('connect.php');
	include ('lib/TCPDF-main/tcpdf.php');

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

	$certified        = "SELECT * FROM certified WHERE user_id = '$user_id' AND q_category = '$category' AND q_topic = '$topic' AND q_level = '$level'";
    $certified_query  = $mysqli->query($certified);
    $count            = mysqli_num_rows($certified_query);
    $result           = $certified_query->fetch_assoc();
    $get_cer          = $result['certificate'];

    if(!empty($get_cer)){

        $path = "certificate/$get_cer";
    }

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	    require_once(dirname(__FILE__).'/lang/eng.php');
	    $pdf->setLanguageArray($l);
	}
	$pdf->SetMargins(30, 20);
	$pdf->AddPage('L','A4');
	$file = $path;
	$pdf->image($file);
	$download = $pdf->Output(__DIR__ . 'certificate.pdf', 'D');

	if($download){

		session_destroy();
		header("Refresh:1; url= index.php");
	}
?>