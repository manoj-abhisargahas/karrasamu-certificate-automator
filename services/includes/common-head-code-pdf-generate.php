<?php
    // Including the TCPDI library
	// Look for the vendor folder inside the active web root directory
	require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
	
	use \setasign\Fpdi\Tcpdf\Fpdi;
	
	//functions
	include("../includes/operations.php");
	
	//Create new PDF importer object
	$pdf = new Fpdi();
	
	//Remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	//Add fonts
	//Generate Required files for custom fonts http://www.fpdf.org/makefont/
	//For Info Refer: https://www.vrsofttech.com/fpdf/how-to-add-custom-font-in-fpdf
	$d_font = "Mont-HeavyDEMO";
	$ppns_EB_font = "Poppins-ExtraBold";
	$ppns_B_font = "Poppins-Bold";
	$ppns_M_font = "Poppins-Medium";

	$pdf->AddFont($d_font,"","Mont-HeavyDEMO.php");
	$pdf->AddFont($ppns_EB_font,"","Poppins-ExtraBold.php");
	$pdf->AddFont($ppns_B_font,"","Poppins-Bold.php");
	$pdf->AddFont($ppns_M_font,"","Poppins-Medium.php");

	$cert_type = $_POST['cert-type'];

	$comm_code_filename = "includes/".$comm_code_filenames[$cert_type].".php";
	
	$bg_cert = $_POST['bg_cert'];
	$bg_cert_filename = $bg_plain_a4_filename;
	
	if($bg_cert=="yes") {
		$bg_cert_filename = $bg_cert_filenames[$cert_type][0];
	}
	else if($bg_cert=="bprint") {
		$bg_cert_filename = $bg_cert_filenames[$cert_type][1];
	}

	//Set the source file
	$pageCount = $pdf->setSourceFile("../pdf/".$bg_cert_filename.".pdf"); 
	//Import Page 1
	$pageId = $pdf->importPage(1);
	//Get Page width and Height
	$size = $pdf->getTemplateSize($pageId);
?>