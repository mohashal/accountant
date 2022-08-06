<?php session_start();
if(isset($_SESSION['permission'])){
include_once 'clasat/printbills.php';
include_once 'webcon/config.php';

$pr=new printbills();
$co=new config();
echo "<!DOCTYPE html>
<html ".langu['lang_html'].">
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>".langu['bills']." - ".langu['site_name']."</title>
<link href='csss/reset.css' rel='stylesheet' type='text/css'/>
<link rel='icon' href='images/main/logo2.png' type='image/png'/>
<link rel='apple-touch-icon-precomposed' href='images/main/logo2.png'/>
<link href='csss/main.css' rel='stylesheet' type='text/css'/>
<link href='csss/printbills.css' rel='stylesheet' type='text/css'/>
</head>
<body>
<div class='wrap'>";

$mysqli=$co->connect();

if(isset($_GET['print_bills'])){

switch ($_GET['print_bills']) {
    case 'temp':$pr->print_temp($mysqli,$_GET['id']);break;
    case 'tax':$pr->print_with_head($mysqli,$_GET['id'],'tax');break;
    case 'sent':$pr->print_with_head($mysqli,$_GET['id'],'sent');break;
    case 'returned':$pr->print_merchant_or_returned($mysqli,$_GET['id'],1);break;
    case 'merchant_bill':$pr->print_merchant_or_returned($mysqli,$_GET['id'],2);break;
    case 'instant':$pr->print_merchant_or_returned($mysqli,$_GET['id'],3);break;
    case 'retmerchant':$pr->print_merchant_or_returned($mysqli,$_GET['id'],4);break;
    case 'return_instant':$pr->print_merchant_or_returned($mysqli,$_GET['id'],5);break;
}

}

elseif(isset($_GET['print_payment'])){

switch ($_GET['print_payment']) {
    case 'expense':$pr->print_expense($mysqli,$_GET['id'],$_GET['type']);break;
    case 'revenue':$pr->print_revenue($mysqli,$_GET['id']);break;
}

}

elseif(isset($_GET['print_statment'])){

switch ($_GET['print_statment']) {
    case 'month':$pr->print_monthly_statment($mysqli,intval($_GET['id']), htmlentities($_GET['mfrom']), htmlentities($_GET['mto']));break;
    case 'year':$pr->print_yearly_statment($mysqli,intval($_GET['id']),intval($_GET['year']));break;
    case 'month_merchant':$pr->print_monthly_statment_merchant($mysqli,intval($_GET['id']), htmlentities($_GET['mfrom']), htmlentities($_GET['mto']));break;
    case 'year_merchant':$pr->print_yearly_statment_merchant($mysqli,intval($_GET['id']),intval($_GET['year']));break;
}

}

echo "</div>
<script src='js/jquery.js'></script>
<script src='js/main.js'></script>
</body></html>";
}

else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}