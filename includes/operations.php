<?php
	//set empty response.
	function set_empty_response() {
		$GLOBALS["response"] = ["success_msg"=>"false", "errors"=>[]];
	}
	
	//set success msg.
	function set_success_response($msg) {
		$GLOBALS["response"]["success_msg"] = $msg;
	}
	
	//set response.
	function set_response($key_name, $value) {
		$GLOBALS["response"][$key_name] = $value;
	}
	
	//returns errors count.
	function errors_count() {
		return count($GLOBALS["response"]["errors"]);
	}
	
	//push error into response.
	function push_error_response($error_msg) {
		array_push($GLOBALS["response"]["errors"], $error_msg);
	}
	
	//prints response in JSON.
	function print_response() {
		echo json_encode($GLOBALS["response"]);
	}
	
	function isValueEmpty($value) {
		if($value=="" || $value==null)
			return true;
		else
			return false;
	}

	function getCertId($cert_code, $pid, $pad_num=4) {
		// return $cert_code.str_pad($pid, 4, '0', STR_PAD_LEFT);
		return $cert_code.str_pad($pid, $pad_num, '0', STR_PAD_LEFT);
	}

	function getEvent($evt="", $medal="", $include_medal=true) {
        if(isValueEmpty($medal))
            return "";
		else if($include_medal)
			return "<span class=\"evt\">$evt<b>$medal</b></span><br>";
		else
			return "<span class=\"evt\">$evt</span><br>";
    }

	$ak = [ 0=>["Yeka - Onti Karra Ayudha Kala","Individual - Single Stick"],
			1=>["Yeka - Rendu Karrala Ayudha Kala","Individual - Double Stick"],
			2=>["Jatha - Onti Karra Ayudha Kala","Pair - Single Stick"],
			3=>["Jatha - Rendu Karrala Ayudha Kala", "Pair - Double Stick"],
			4=>["Sva Saili - Onti Karra Ayudha Kala","Free Style - Single Stick"],
			5=>["Sva Saili - Rendu Karrala Ayudha Kala","Free Style - Double Stick"]];
	
	$yd = [ 0=>["Onti Karra Yuddam","Single Stick Fight"],
			1=>["Rendu Karrala Yuddam","Double Stick Fight"],
			2=>["Jattu Karra Yuddam","Team Stick Fight"]];
	
	$issue_date_fixed = "15-12-2024";

	//Return input text as paragraph
	//Orange Color = #d05b27
	function asPara($text="", int $len=-1, string $f_srtch="96.5%", 
		string $ltr_spc="0em", string $ln_h="1", string $color="#d05b27") {

		if($len!=-1) {
			$text = substr($text, 0, $len);
		}

		return "<p style=\"font-stretch: $f_srtch; letter-spacing: $ltr_spc; 
		line-height:$ln_h; color:$color;\">"
		.$text."</p>";
	}

	$cert_code = [
	"ak-m"  =>  "1ST-NKC24-M-AK",
    "ak"    =>  "1ST-NKC24-AK",
    "yd-m"  =>  "1ST-NKC24-M-YD",
    "yd"    =>  "1ST-NKC24-YD",
    "of"    =>  "1ST-NKC24-OF"];

	$ind_print_filenames = [
	"ak-m"  =>  "ind-pdf-generate-ak-m-cert",
    "ak"    =>  "ind-pdf-generate-ak-cert",
    "yd-m"  =>  "ind-pdf-generate-yd-m-cert",
    "yd"    =>  "ind-pdf-generate-yd-cert",
    "of"    =>  "ind-pdf-generate-of-cert"];

	$comm_code_filenames = [
	"ak-m"  =>  "common-code-pdf-generate-ak-m-cert",
	"ak"    =>  "common-code-pdf-generate-ak-cert",
	"yd-m"  =>  "common-code-pdf-generate-yd-m-cert",
	"yd"    =>  "common-code-pdf-generate-yd-cert",
	"of"    =>  "common-code-pdf-generate-of-cert"];

	$bg_cert_filenames = [
	"ak-m"  =>  ["plain-ak-m-cert", "sample-ak-m-cert"],
	"ak"    =>  ["plain-ak-cert", "sample-ak-cert"],
	"yd-m"  =>  ["plain-yd-m-cert", "sample-yd-m-cert"],
	"yd"    =>  ["plain-yd-cert", "sample-yd-cert"],
	"of"    =>  ["plain-of-cert", "sample-of-cert"]];

	$bg_plain_a4_filename = "plain-a4";
?>