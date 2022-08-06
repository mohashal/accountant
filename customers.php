<?php session_start();
if(isset($_SESSION['permission'])){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/customers.php';

$hf=new he_fo();
$cu=new customers();
$co=new config();

$css="<link href='csss/customers.css' rel='stylesheet' type='text/css'/>";
$js='<script src="js/customers.js"></script>';
$ready="$('.customer_search_select').find('select').on('change', function() {get_costomers_sale_day();})
$('#customer_name_search').on('input', function(){search_customer_name();});
$('#date1').on('change', function(){monthly();});
$('#date2').on('change', function(){monthly();});
$('.date_input').datepicker({});
";

$conn=$co->connect();
$hf->headers($conn,langu['customers'],$css);

if(isset($_GET['conn'])){


switch ($_GET['conn']) {
    case 'add-customer-form':$cu->add_customer_form($conn);break;
    case 'add-customer-save':$m=$cu->add_customer_save($conn);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');$cu->add_customer_form($conn);}else{$hf->msg($m[0],$m[1],'success','customers.php?conn=add-customer-form');}break;
    case 'search-customer-form':$cu->search_customer_form($conn);break;
    case 'update-customer-save':$m=$cu->update_customer_save($conn);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','customers.php?conn=search-customer-form');}break;
    case 'customer-statement-form':$cu->statment_customer_form($conn);break;
    default:break;
}}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>