<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/reports.php';

$hf=new he_fo();
$re=new reports();
$co=new config();

$css="<link href='csss/reports.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/reports.js"></script>';

$ready="
$('#check_num_search').on('input', function(){find_check_by_num();});
$('.in_date').datepicker();
";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['reports'],$css);

if(isset($_GET['conn'])){

switch ($_GET['conn']) {
    case 'profits':$re->profits_form();break;
    case 'customer-debt':$re->customer_debt($mysqli);break;
    case 'merchant-debt':$re->merchant_debt($mysqli);break;
    case 'few-products':$re->few_products($mysqli);break;
    case 'partners':$re->partners_expense($mysqli);break;
    case 'equity':$re->equity_capital($mysqli);break;
    case 'salesman':$re->salesmen_orders($mysqli);break;
    case 'bilss':$re->all_bills_form($mysqli);break;
    case 'daily_report':$re->daily_report($mysqli);break;
    case 'ret_check_sale':$re->salesman_returned_check();break;
    case 'zkakah':$re->zakah();break;
    case 'employess_expense':$re->employees_expenses();break;
    }}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>