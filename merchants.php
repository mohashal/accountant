<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/merchants.php';

$hf=new he_fo();
$mr=new merchants();
$co=new config();

$css="<link href='csss/merchants.css' rel='stylesheet' type='text/css'/>
<link href='csss/bills.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/merchants.js"></script>';
$ready="
$('#merchant_name').on('input', function(){merchant_search();});
$('#merchant_name2').on('input', function(){merchant_search2('get_bill_merchant');});
$('#merchant_name3').on('input', function(){merchant_search3('get_retbill_merchant');});
$('#bill_product_search').on('input', function(){bill_product_search();});
$('#bill_product_search_num').on('input', function(){bill_product_search_num();});
$('#bill_product_search_barcode').on('input', function(){search_product_barcode();});
$('#bill_date').datepicker();
$('.date_input').datepicker();
$('#date1').on('change', function(){monthly();});
$('#date2').on('change', function(){monthly();});
";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['merchants'],$css);

if(isset($_GET['conn'])){


switch ($_GET['conn']) {
case 'bill_form':$mr->add_bill_form();break;
case 'add-bill-save':$m=$mr->bill_save_temp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','merchants.php?conn=bill_form');}break;
case 'temp-bill':$mr->show_temp_bill($mysqli);break;
case 'edit_bill':$mr->edit_bill_form($mysqli);break;
case 'edit-bill-save':$m=$mr->bill_save_edit_temp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','merchants.php?conn=temp-bill');}break;
case 'merchant-statment':$mr->statment_merchant_form($mysqli);break;
case 'search-bill':$mr->search_bill_form();break;
case 'retbill_form':$mr->add_retbill_form();break;
case 'add-retbill-save':$m=$mr->bill_save_rettemp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','merchants.php?conn=retbill_form');}break;
case 'edit_retbill':$mr->edit_retbill_form($mysqli);break;
case 'edit-retbill-save':$m=$mr->bill_save_retedit_temp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','merchants.php?conn=rettemp-bill');}break;
case 'rettemp-bill':$mr->show_rettemp_bill($mysqli);break;
case 'search-retbill':$mr->search_retbill_form();break;
}}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>