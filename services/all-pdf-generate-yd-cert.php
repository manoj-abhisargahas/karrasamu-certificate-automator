<?php
	include("includes/common-head-code-pdf-generate.php");
	
	//get player details in csv file
	$csv_file_details = $_FILES["load-csv-file"];
    $csv_file_tmp_name = $csv_file_details["tmp_name"];
    $csv_file = fopen($csv_file_details["tmp_name"], "r");

	if($csv_file!==false) {
		//Reading Coach Name
		$row = fgetcsv($csv_file, 0, ",");
		$state = $row[3];
		$count = 0;

        fgetcsv($csv_file, 0, ","); //Ignoring Table heading

		while($pdetails_row = fgetcsv($csv_file, 0, ",")) {
			// if player played atleast one event then display
			if($pdetails_row[15]!=0) {
				$count++;

				//continued in below file (Reused code twice)
				include($comm_code_filename);
			}
		}

		if($count == 0) {
			echo "<tr><td colspan='13'>No Data Found.</td></tr>";
		}

		fclose($csv_file);
	}

	//Output PDF document
	ob_clean();
	$pdf->Output(strtolower($pid).".pdf", "I");
?>