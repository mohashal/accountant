<?php session_start();
if(isset($_SESSION['permission'])){
include_once 'clasat/ajax_html.php';
include_once 'webcon/config.php';

$aj=new ajax_html();
$co=new config();

$mysqli=$co->connect();

echo "<!DOCTYPE html>
<html ".langu['lang_html'].">
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title></title>
<link href='csss/reset.css' rel='stylesheet' type='text/css'/>
<link rel='icon' href='images/main/logo2.png' type='image/png'/>
<link rel='apple-touch-icon-precomposed' href='images/main/logo2.png'/>
<link href='csss/main.css' rel='stylesheet' type='text/css'/>
<link href='js/jquery-ui/jquery-ui.css' rel='stylesheet' type='text/css'/>
</head>
<body>
<div class='wrap'>
<style>
.form_input_line{height: auto;}
.product_auto_search_name {margin-top:-4px;margin-right:25%;width: 47%;}
</style>";
$ready='';
if(isset($_GET['damaged'])){

switch ($_GET['damaged']){
case 'add-damaged':$aj->add_form_damaged();break;
case 'add_save_damage':$aj->add_save_damaged($mysqli);break;
case 'edit-form-damaged':$aj->edit_form_damaged($mysqli);break;
case 'edit_save_damage':$aj->edit_save_damaged($mysqli);break;
}

}


echo "</div>
<script src='js/jquery.js'></script>
<script src='js/main.js'></script>
<script src='js/ajax_html.js'></script>
<script src='js/jquery-ui/jquery-ui.min.js'></script>
<script>

$(document).ready(function() {
".$ready."
$.datepicker.setDefaults({
    dayNamesShort: [ 'أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت' ],
    dayNamesMin: [ 'أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت' ],
    closeText: 'إغلاق',
    prevText: 'السابق',
    nextText: 'التالي;',
    currentText: 'اليوم',
    dateFormat: 'yy-m-d',
    changeMonth: true,
    changeYear: true,
    monthNames: ['1','2','3','4','5','6','7','8','9','10','11','12'],
    monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12']
});
$('.all_dates').datepicker();
});
</script>
</body>
</html>";
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}
?>