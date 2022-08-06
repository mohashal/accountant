<?php session_start();
if(isset($_SESSION['permission'])){

include_once 'clasat/ajax_expense.php';
include_once 'webcon/config.php';

$aj=new ajax_expense();
$co=new config();

$mysqli=$co->connect();

if(isset($_GET['type'])){
$type=$_GET['type'];
switch ($type) {
    case '0':echo $aj->get_partner_form($mysqli);break;
    case '1':echo $aj->get_salary_form($mysqli);break;
    case '2':echo $aj->get_salary_form($mysqli,null,1);break;
    case '3':echo $aj->get_merchant_form();break;
    case '4':echo $aj->get_car_form($mysqli);break;
    case '5':echo $aj->get_customer_form();break;

}

}

if(isset($_GET['search'])){
$type=$_GET['search'];
switch ($type) {
    case 'employee':$aj->get_employee_name_salary($mysqli,$type);break;
    case "table_check_details":$aj->table_checks_details($mysqli);break;
    case 'expense_month_year':$aj->get_by_monthyear($mysqli);break;
    case 'expense_month_year2':$aj->get_by_monthyear($mysqli,2);break;
    case 'revenue_month_year':$aj->get_by_monthyear_rev($mysqli);break;
    case 'debt-customer':$aj->debt_customer_note($mysqli);break;
    case 'revenue_customer':$aj->get_by_customer_rev($mysqli);break;

}

}

}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}