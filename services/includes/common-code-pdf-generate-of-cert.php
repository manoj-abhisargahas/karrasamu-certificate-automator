<?php
	//Add page
	$pdf->addPage('P', array($size['width'], $size['height']));
	//Use the imported page and place it at point 0,0 with a width of 210.058mm(A4)
	$pdf->useImportedPage($pageId);
	//Setting default font
	$pdf->SetFont($d_font,"",14);
	
    $oid = getCertId($cert_code[$cert_type], $odetails_row[0], 3);
	
	$oname = trim($odetails_row[1]);
	$ofname = trim($odetails_row[2]);
	$odob = trim($odetails_row[3]);
	$orole = trim($odetails_row[4]);
	
	if(!$oid) {
		echo "Official Details are None.";
		exit(0);
	}

	//---------------------
	// Printing data on pdf
	//---------------------

	$pdf->writeHTMLCell(0, 0, 35.5, 167.4, asPara($oid));
	$pdf->writeHTMLCell(0, 0, 49, 177, asPara($oname));
	$pdf->writeHTMLCell(0, 0, 55.25, 186.4, asPara($ofname));
	$pdf->writeHTMLCell(0, 0, 46.8, 195.9, asPara($odob));
	$pdf->writeHTMLCell(0, 0, 30.3, 205.6, asPara($state));
	$pdf->writeHTMLCell(0, 0, 108, 167.4, asPara($issue_date_fixed));
	
	$pdf->SetFont($ppns_EB_font,"",16);
	$pdf->writeHTMLCell(0, 0, 58.3, 219.5, asPara($orole, -1, "98%"));
	
	//Setting Support Photo Box and Signs
	$path = "../img/";

	$photobox = $path."photo-box.png";
	$sign1 = $path."srihari-sign.png";
	$sign2 = $path."sreenu-sign.png";
	$sign3 = $path."chadrasekhar-sign.png";
	$pdf->image($photobox, 161, 168, 33.6, 44.36, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
	$pdf->image($sign1, 31, 253.9, 25.5, 17.7, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
	$pdf->image($sign2, 88, 256, 48.34, 15.66, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
	$pdf->image($sign3, 155.8, 257.8, 36.15, 7.96, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
?>