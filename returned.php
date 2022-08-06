<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/returned.php';

$hf=new he_fo();
$ret=new returned();
$co=new config();

$css="<link href='csss/returned.css' rel='stylesheet' type='text/css'/>
<link href='csss/bills.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/bills.js"></script>
<script src="js/returned.js"></script>';
$ready="
$('#merchant_name').on('input', function(){merchant_search();});
$('#bill_customer_search').on('input', function(){bill_customer_search();});
$('#bill_customer_search2').on('input', function(){bill_customer_search2();});
$('#bill_product_search').on('input', function(){bill_product_search2();});
$('#bill_product_search_num').on('input', function(){bill_product_search_num2();});
$('#customer_name').on('input', function(){b_customer_search();});
$('#bill_date').datepicker();
";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['returned_products'],$css);

if(isset($_GET['conn'])){
$mysqli=$co->connect();

switch ($_GET['conn']) {
case 'temp_returned_products':$ret->show_temp_bill($mysqli);break;
case 'edit_bill':$ret->edit_returned_form($mysqli);break;
case 'bill-save':$m=$ret->save_edit_temp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','returned.php?conn=temp_returned_products');}break;
case 'add_returned_products':$ret->add_bill_form($mysqli,'returned_products-save',2);break;
case 'returned_products-save':$m=$ret->returned_save_temp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','bills.php?conn=add_returned_products');}break;
case 'search_returned_products':$ret->returned_search($mysqli);break;
}}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>