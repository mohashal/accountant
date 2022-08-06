<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/damaged.php';

$hf=new he_fo();
$da=new damaged();
$co=new config();

$css="<link href='csss/damaged.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/damaged.js"></script>';
$ready="
$('#bill_customer_search').on('input', function(){bill_customer_search();});
$('#bill_date_search').datepicker({});
";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['damaged_products'],$css);

if(isset($_GET['conn'])){

switch ($_GET['conn']) {
    case 'all-damaged':$da->all_damaged($mysqli);break;
}

}


$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}
?>