var filenames = {
    "ak-m"  :   ["load-data-ak-m-cert", "all-pdf-generate-ak-m-cert"],
    "ak"    :   ["load-data-ak-cert",   "all-pdf-generate-ak-cert"],
    "yd-m"  :   ["load-data-yd-m-cert", "all-pdf-generate-yd-m-cert"],
    "yd"    :   ["load-data-yd-cert",   "all-pdf-generate-yd-cert"],
    "of"    :   ["load-data-of-cert",   "all-pdf-generate-of-cert"]
};
function changeFormSubmitURL(ele) {
    let ind_print_submit_btn = document.getElementById("print-ind"); //individual print submit button
    let all_print_submit_btn = document.getElementById("print-all");

    ind_print_submit_btn.formAction = filenames[ele.value][0]+".php";
    all_print_submit_btn.formAction = "services/"+filenames[ele.value][1]+".php";
    // console.log(ele.value);
}