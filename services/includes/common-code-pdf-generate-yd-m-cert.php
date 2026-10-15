<?php
	//Add page
	$pdf->addPage('P', array($size['width'], $size['height']));
	//Use the imported page and place it at point 0,0 with a width of 210.058mm(A4)
	$pdf->useImportedPage($pageId);
	//Setting default font
	$pdf->SetFont($d_font,"",14);
	
    $pid = getCertId($cert_code[$cert_type], $pdetails_row[0]);
	
	$pname = trim($pdetails_row[1]);
	$pfname = trim($pdetails_row[2]);
	$pdob = trim($pdetails_row[3]);
	$pcat = trim($pdetails_row[4])." ".trim($pdetails_row[5]);
	
	$medals = [	$pdetails_row[6], 
				$pdetails_row[7], 
				$pdetails_row[8]];
	
	if(!$pid) {
		echo "Player Details are None.";
		exit(0);
	}

	//---------------------
	// Printing data on pdf
	//---------------------

	$pdf->writeHTMLCell(0, 0, 34.4, 149.6, asPara($pid));
	$pdf->writeHTMLCell(0, 0, 48, 159.3, asPara($pname));
	$pdf->writeHTMLCell(0, 0, 54.2, 168.7, asPara($pfname));
	$pdf->writeHTMLCell(0, 0, 45.9, 178.2, asPara($pdob));
	$pdf->writeHTMLCell(0, 0, 39, 187.8, asPara($pcat));
	$pdf->writeHTMLCell(0, 0, 140.8, 187.9, asPara($state));
	$pdf->writeHTMLCell(0, 0, 168.2, 149.7, asPara($issue_date_fixed));
	
	//Events Printing Positions
	$evt_x = 13.5; //event x-position
	$evt_y = 210; //total event line y-position
	$evt_line_gap = 8;
	$eng_x = [55.8, 64.4, 58.4]; //event english name x-position
	$mdl_x = 166.5; //event medal x-position
	$y_pc = 0; //y-position count: print only played events but in next to each other
 
	//printing medals
	for($i = 0; $i < 3; $i++) {
		if($medals[$i]!="") {
			$y = $evt_y + ($y_pc * $evt_line_gap);
			$tel = $yd[$i][0]; // event telugu name
			$eng = "(".$yd[$i][1].")"; // event english name
			$mdl = $medals[$i]; // player got medal

			$pdf->SetFont($ppns_B_font,"",12);
			$pdf->writeHTMLCell(0, 0, $evt_x, $y, asPara($tel, -1, "98%"));

			$pdf->SetFont($ppns_M_font,"",11);
			$pdf->writeHTMLCell(0, 0, $eng_x[$i], $y+0.2, asPara($eng, -1, "98%"));
			
			$pdf->SetFont($ppns_EB_font,"",15);
			$pdf->writeHTMLCell(0, 0, $mdl_x, $y-0.5, asPara($mdl, -1, "98%"));
			
			$y_pc++;
		}
	}
	
	//Setting Support Photo Box and Signs
	$path = "../img/";

	$photobox = $path."photo-box.png";
	$sign1 = $path."srihari-sign.png";
	$sign2 = $path."sreenu-sign.png";
	$sign3 = $path."chadrasekhar-sign.png";
	$pdf->image($photobox, 163.4, 101, 33.6, 44.36, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
	$pdf->image($sign1, 32.4, 253.6, 25.5, 17.7, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
	$pdf->image($sign2, 87.7, 255.7, 48.34, 15.66, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
	$pdf->image($sign3, 155.8, 257.2, 36.15, 7.96, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
?>