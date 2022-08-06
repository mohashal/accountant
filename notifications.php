<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/notifications.php';

$hf=new he_fo();
$n=new notifications();
$co=new config();

$css="<link href='csss/notifications.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/notifications.js"></script>';

$ready="$('.select_date').datepicker();";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['notifications'],$css);

if(isset($_GET['conn'])){


switch ($_GET['conn']) {
    case 'all-notifications':$n->show_all_notifications($mysqli);break;
    }}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>