<?php
	include("includes/common-head-code-pdf-generate.php");
	
	//get and convert player details from string to array
	$pdetails_row = json_decode($_POST['pdetails_row']);
	$state = trim($_POST['state']);

	//continued in below file (Reused code twice)
	include($comm_code_filename);
	
	//Output PDF document
	ob_clean();
	$pdf->Output(strtolower($pid).".pdf", "I");
?>