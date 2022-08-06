<?php session_start();
if(isset($_SESSION['permission'])){
include_once 'clasat/ajax_reports.php';
include_once 'webcon/config.php';

$aj=new ajax_reports();
$co=new config();

$mysqli=$co->connect();

if(isset($_GET['profits'])){
switch ($_GET['profits']){
    case 'monthly':$aj->monthly_profit($mysqli);break;
    case 'yearly':$aj->yearly_profit($mysqli);break;
    case 'daily':$aj->daily_report($mysqli);break;
}
}

elseif(isset($_GET['debts'])){
switch ($_GET['debts']){
    case 'customer':$aj->customer_debt($mysqli,1);break;
    case 'customer-us':$aj->customer_debt($mysqli,2);break;
    case 'merchant':$aj->merchant_debt($mysqli,1);break;
    case 'merchant-us':$aj->merchant_debt($mysqli,2);break;
}
}

elseif(isset($_GET['search_product'])){
    
switch ($_GET['search_product']){
case 'id':$aj->get_product_by_id($mysqli,intval($_GET['id']));break;
}

}

elseif(isset($_GET['partners'])){
    
switch ($_GET['partners']){
case 'all-year':$aj->get_partners_exoense_year($mysqli);break;
case 'zakah':$aj->zakah($mysqli);break;
case 'emp_expense':$aj->emp_expense($mysqli);break;
}

}

elseif(isset($_GET['salesmen'])){
    
switch ($_GET['salesmen']){
case 'all-month':$aj->get_salesmen_orders($mysqli);break;
case 'all-bill-year':$aj->get_bills_year($mysqli);break;
case 'ret_check':$aj->ret_check_salesman($mysqli);break;
}

}

}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}
?>