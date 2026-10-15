<?php 
	include("includes/operations.php");
?>
<DOCTYPE! html>
<html>
	<head>
		<title>Yuddam Participation Certificates</title>
        <?php include("includes/html-page-head.php"); ?>
	</head>
	<body>
    <h1 class="center yd">Yuddam Participation Certificates</h1>
<?php
    $cert_type = $_POST['cert-type'];
    $ind_print_filename = "services/".$ind_print_filenames[$cert_type].".php"; //individual print filename
    $bg_cert = $_POST['bg_cert'];

    $csv_file_details = $_FILES["load-csv-file"];
    $csv_file_tmp_name = $csv_file_details["tmp_name"];
    $csv_file = fopen($csv_file_details["tmp_name"], "r");
    
    if($csv_file!==false) {
        //Reading Coach Name
        $row = fgetcsv($csv_file, 0, ",");
        $coach = $row[1];
        $state = $row[3];
        $issue_date = $row[5]; //ignore
        echo "<span class=\"coach\">Coach:<b>".$coach."</b></span>";
        echo "<span class=\"coach\">State:<b>".$state."</b></span>";
        echo "<span class=\"coach\">Issue Date:<b>".$issue_date_fixed."</b></span>";
        $count = 0;

        fgetcsv($csv_file, 0, ","); //Ignoring Table heading

        echo "<table>
        <tr>
            <th>SL No.</th>
            <th class='id-no'>ID No.</th>
            <th>Player Name</th>
            <th>Father Name</th>
            <th>DOB</th>
            <th>Category</th>
            <th>Played Events</th>
            <th>Print Certificate</th>
        </tr>";
        while($pdetails_row = fgetcsv($csv_file, 0, ",")) {
            // if player played atleast one event then display
            if($pdetails_row[15]!=0) {
                $count++;
                echo "<tr>";
                echo "<td>".$count."</td>";
                echo "<td class='id-no'>".$pdetails_row[0]."</td>";
                echo "<td>".$pdetails_row[1]."</td>";
                echo "<td>".$pdetails_row[2]."</td>";
                echo "<td>".$pdetails_row[3]."</td>";
                echo "<td>".$pdetails_row[4]."<br>".$pdetails_row[5]."</td>";

                echo "<td>";
                $events = getEvent($yd[0][0], $pdetails_row[6], false);
                $events.= getEvent($yd[1][0], $pdetails_row[7], false);
                $events.= getEvent($yd[2][0], $pdetails_row[8], false);
                echo $events;
                echo "</td>";

                echo "<td>";
                echo "<form method=\"POST\" target=\"_blank\" enctype=\"multipart/form-data\" action=\"$ind_print_filename\">";
                echo "<input type=\"hidden\" name=\"pdetails_row\" value='".json_encode($pdetails_row)."'/>";
                echo "<input type=\"hidden\" name=\"state\" value=\"".$state."\"/>";
                echo "<input type=\"hidden\" name=\"cert-type\" value=\"".$cert_type."\"/>";
                echo "<input type=\"hidden\" name=\"bg_cert\" value=\"".$bg_cert."\"/>";
                echo "<input class=\"btn\" type=\"submit\" value=\"Print Certificate\"/>";
                echo "</form>";
                echo "</td>";

                echo "</tr>";
            }
        }
        if($count == 0) {
            echo "<tr><td colspan='13'>No Data Found.</td></tr>";
        }
        echo "</table>";
        
        fclose($csv_file);
    }
?>
    </form>
</html>