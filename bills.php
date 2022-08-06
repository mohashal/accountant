<?php session_start();
if(isset($_SESSION['permission'])){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/bills.php';

$hf=new he_fo();
$bi=new bills();
$co=new config();

$css="<link href='csss/bills.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/bills.js"></script>';
$ready="
$('#bill_customer_search').on('input', function(){bill_customer_search();});
$('#bill_customer_search2').on('input', function(){bill_customer_search2();});
$('#bill_product_search').on('input', function(){bill_product_search();});
$('#bill_product_search_num').on('input', function(){bill_product_search_num();});
$('#bill_product_search_barcode').on('input', function(){search_product_barcode();});
$('#bill_date_search').on('change', function(){search_bill_date();});
$('#bill_num_search').on('input', function(){search_bill_num();});
$('#taxbill_num_search').on('input', function(){search_taxbill_num();});
$('#sentbill_num_search').on('input', function(){search_sentbill_num();});
$('#bill_search_offer').on('input', function(){search_offer_name();});
$('#bill_date_search').datepicker();
";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['bills'],$css);

if(isset($_GET['conn'])){


switch ($_GET['conn']) {
    case 'add_bill':$bi->add_bill_form($mysqli,'add-bill-save',1);break;
    case 'add-bill-save':$m=$bi->bill_save_temp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','bills.php?conn=add_bill');}break;
    case 'temp_bill':$bi->show_temp_bill($mysqli);break;
    case 'edit_bill':$bi->edit_bill_form($mysqli,$_GET['id']);break;
    case 'edit-bill-save':$m=$bi->bill_update_temp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','bills.php?conn=temp_bill');}break;
    case 'search_bill':$bi->search_bill_form();break;
    case 'search_tax_bill':$bi->search_taxbill_form();break;
    case 'show_bill_list':$bi->show_bill_list($mysqli);break;
    case 'returned_products-save':$m=$bi->returned_save_temp($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','returned.php?conn=add_returned_products');}break;
    default:$bi->add_bill_form();break;
}

}


$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}
