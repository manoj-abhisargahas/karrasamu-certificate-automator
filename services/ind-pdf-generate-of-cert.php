<?php
	include("includes/common-head-code-pdf-generate.php");
	
	//get and convert player details from string to array
	$odetails_row = json_decode($_POST['odetails_row']);
	$state = trim($_POST['state']);

	//continued in below file (Reused code twice)
	include($comm_code_filename);
	
	//Output PDF document
	ob_clean();
	$pdf->Output(strtolower($oid).".pdf", "I");
?>