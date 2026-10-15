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
	$pcat = trim($pdetails_row[4]);
	
	$medals = [$pdetails_row[9],$pdetails_row[10], 
				$pdetails_row[11], $pdetails_row[12],
				$pdetails_row[13], $pdetails_row[14]];
	
	if(!$pid) {
		echo "Player Details are None.";
		exit(0);
	}

	//---------------------
	// Printing data on pdf
	//---------------------

	$pdf->writeHTMLCell(0, 0, 35.2, 150.5, asPara($pid));
	$pdf->writeHTMLCell(0, 0, 48.6, 160, asPara($pname));
	$pdf->writeHTMLCell(0, 0, 55, 169.5, asPara($pfname));
	$pdf->writeHTMLCell(0, 0, 46.7, 179, asPara($pdob));
	$pdf->writeHTMLCell(0, 0, 39.9, 188.6, asPara($pcat));
	$pdf->writeHTMLCell(0, 0, 141.4, 188.2, asPara($state));
	$pdf->writeHTMLCell(0, 0, 168.8, 149.9, asPara($issue_date_fixed));
	
	//Events Printing Positions
	$evt_x = 13.6; //event x-position
	$evt_y = 208.6; //total event line y-position
	$evt_line_gap = 7;
	$eng_x = [80, 88.5, 81.6, 90.4, 86.95, 95.85]; //event english name x-positions
	$y_pc = 0; //y-position count: print only played events but in next to each other
 
	//printing medals
	for($i = 0; $i < 6; $i++) {
		if($medals[$i]!="") {
			$y = $evt_y + ($y_pc * $evt_line_gap);
			$tel = $ak[$i][0]; // event telugu name
			$eng = "(".$ak[$i][1].")"; // event english name

			$pdf->SetFont($ppns_B_font,"",12);
			$pdf->writeHTMLCell(0, 0, $evt_x, $y, asPara($tel, -1, "98%"));

			$pdf->SetFont($ppns_M_font,"",11);
			$pdf->writeHTMLCell(0, 0, $eng_x[$i], $y+0.2, asPara($eng, -1, "98%"));
			
			$y_pc++;
		}
	}
	
	//Setting Support Photo Box and Signs
	$path = "../img/";
	
	$sign1 = $path."srihari-sign.png";
	$sign2 = $path."sreenu-sign.png";
	$sign3 = $path."chadrasekhar-sign.png";
	$pdf->image($sign1, 33.1, 254.1, 25.5, 17.7, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
	$pdf->image($sign2, 88, 256, 48.34, 15.66, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
	$pdf->image($sign3, 156, 257, 36.15, 7.96, "PNG", "", "", false, 300, "", false, false, 0, false, false, false);
?>