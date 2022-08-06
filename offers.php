<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/offers.php';

$hf=new he_fo();
$of=new offers();
$co=new config();

$css="<link href='csss/bills.css' rel='stylesheet' type='text/css'/>
<link href='csss/offers.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/bills.js"></script><script src="js/offers.js"></script>';
$ready="
$('#bill_customer_search').on('input', function(){bill_customer_search();});
$('#bill_customer_search2').on('input', function(){bill_customer_search2();});
$('#bill_product_search').on('input', function(){bill_product_search();});
$('#bill_product_search_num').on('input', function(){bill_product_search_num();});
$('#bill_product_search_barcode').on('input', function(){search_product_barcode();});
$('#bill_date_search').on('change', function(){search_bill_date();});
$('#bill_num_search').on('input', function(){search_bill_num();});
";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['offers'],$css);

if(isset($_GET['conn'])){

switch ($_GET['conn']) {
    case 'add_offer':$of->add_offer_form();break;
    case 'save_new_offer':$m=$of->save_new_offer($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','offers.php?conn=offers');}break;
    case 'offers':$of->show_offers($mysqli);break;
    case 'edit_offer':$of->edit_offer_form($mysqli);break;
    case 'save_edit_offer':$m=$of->save_edit_offer($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','offers.php?conn=offers');}break;
}

}


$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}
