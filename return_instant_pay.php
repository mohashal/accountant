<?php session_start();
if(isset($_SESSION['permission']) && ($_SESSION['permission']==1 || $_SESSION['permission']==4)){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/return_instant_pay.php';

$hf=new he_fo();
$ins=new return_instant_pay();
$co=new config();

$css="<link href='csss/returned.css' rel='stylesheet' type='text/css'/>
<link href='csss/bills.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/bills.js"></script>
<script src="js/return_instant_pay.js"></script>';
$ready="
$('#merchant_name').on('input', function(){merchant_search();});
$('#merchant_name2').on('input', function(){merchant_search2();});
$('#bill_customer_search').on('input', function(){bill_customer_search();});
$('#bill_customer_search2').on('input', function(){bill_customer_search2();});
$('#bill_product_search').on('input', function(){bill_product_search();});
$('#bill_product_search_num').on('input', function(){bill_product_search_num();});
$('#bill_product_search_barcode').on('input', function(){search_product_barcode();});
$('#customer_name').on('input', function(){b_customer_search();});
$('#bill_search_offer').on('input', function(){search_offer_name();});
$('#bill_date').datepicker();
";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['instant_pay'],$css);

if(isset($_GET['conn'])){
$mysqli=$co->connect();

switch ($_GET['conn']) {
case 'add_bill_form':$ins->add_bill_form($mysqli);break;
case 'save_temp_pay':$m=$ins->instant_save_temp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','return_instant_pay.php?conn=add_bill_form');}break;
case 'temp_bill':$ins->show_temp_bill($mysqli);break;
case 'edit_bill':$ins->edit_instant_form($mysqli, intval($_GET['id']));break;
case 'save_edit_pay':$m=$ins->instant_save_edit($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','return_instant_pay.php?conn=temp_bill');}break;
case 'search_instant':$ins->search_instant_form($mysqli);break;

}}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>