<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/settings.php';

$hf=new he_fo();
$st=new settings();
$co=new config();

$css="<link href='csss/settings.css' rel='stylesheet' type='text/css'/>";
$js='<script src="js/settings.js"></script>';



$mysqli=$co->connect();
$hf->headers($mysqli,langu['settings'],$css);

if(isset($_GET['conn'])){


switch ($_GET['conn']) {
    case'merchants':$st->form_merchants($mysqli,'merchant','merchants');break;
    case'banks':$st->form_elements($mysqli,'bank','banks');break;
    case'currency':$st->form_currency($mysqli);break;
    case 'areas':$st->form_elements($mysqli,'area','areas');break;
    case 'categories':$st->form_elements($mysqli,'categorie','categories');break;
    case 'partners':$st->form_elements($mysqli,'partner','partners');break;
    case 'cars':$st->form_cars($mysqli,'car','cars');break;
    case 'employee':$st->form_employee($mysqli);break;
    case 'product_units':$st->form_elements($mysqli,'product_unit','product_unit');break;
    case 'expense_types':$st->form_expens($mysqli,'expense_type','expense_types');break;
    case 'telephone':$st->form_telephone($mysqli,'telephon','telephons');break;
    case 'users':$st->form_users($mysqli,'user', 'users');
}}

$hf->footer($js);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>