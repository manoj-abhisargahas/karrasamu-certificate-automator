<!DOCTYPE html>
<html>
	<head>
        <title>Karrasamu Certificates</title>
        <?php include("includes/html-page-head.php"); ?>
    </head>
	<body class="center">
		<div id="main-body">
			<!--SHADE BODY FOR DIALOGS-->
			<div id="shade-body"></div>
            <h1 class="title">1st National Karrasamu Championship-2024</h1>
            <h2>Certificates Print</h2>

            <hr>
            <form class="load-csv" method="POST" target="_blank" enctype="multipart/form-data">
                <label class="sec-h" for="cert-type">Select Certificate type:</label>
                <select id="cert-type" name="cert-type" oninput="changeFormSubmitURL(this)">
                    <option value="ak-m">Ayudha Kala Merit certificates</option>
                    <option value="ak">Ayudha Kala Participation certificates</option>
                    <option value="yd-m">Yuddam Merit certificates</option>
                    <option value="yd">Yuddam Participation certificates</option>
                    <option value="of">Official certificates</option>
                </select>
                <div class="bg_cert">
                    <span class="sec-h">Background Certificate:</span>
                    &nbsp;&nbsp;
                    <label for="bg_cert-yes">
                        <input id="bg_cert-yes" name="bg_cert" type="radio" value="yes" checked>
                        Yes
                    </label>
                    &nbsp;&nbsp;
                    <label for="bg_cert-bprint">
                       <input id="bg_cert-bprint" name="bg_cert" type="radio" value="bprint">
                       Blue Print
                    </label>
                    &nbsp;&nbsp;
                    <label for="bg_cert-no">
                       <input id="bg_cert-no" name="bg_cert" type="radio" value="no">
                       No
                    </label>
                </div>
                <label for="load-csv-file">
                        <b>Load CSV File</b>&nbsp;
                        <input id="load-csv-file" name="load-csv-file" type="file" value="Load CSV" required>
                    </label>
                <div class="btns">
                    <input id="print-ind" type="submit" value="Print Individual Certificates" formaction="load-data-ak-m-cert.php">
                    <input id="print-all" type="submit" value="Print All Certificates" formaction="services/all-pdf-generate-ak-m-cert.php">
                </div>
            </form>
            <hr>
			<div class="sample-csv">
                <h3>Download Sample CSV files to test:</h3>
                <div class="file-links"><span>Players Certificates:</span>&nbsp;<a href="sample-csv/players_cert-coach-g_leela.csv">players_cert-coach-g_leela.csv</a></div>
                <div class="file-links"><span>Officials Certificates:</span>&nbsp;<a href="sample-csv/officials_cert-telangana.csv">officials_cert-telangana.csv</a></div>
            </div>
        </div>
    </body>
</html>