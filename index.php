<?php session_start();
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/index.php';

$hf=new he_fo();
$in=new index();
$co=new config();

$js="<script src='js/chart.js'></script>
<script src='js/main_charts.js'></script>";

$mysqli=$co->connect();

$hf->headers($mysqli,langu['main']);

if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
$m=$in->money_charts($mysqli);$js.=$m;
}
$hf->footer($js);


?>