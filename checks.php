<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/checks.php';

$hf=new he_fo();
$ch=new checks();
$co=new config();

$css="<link href='csss/checks.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/checks.js"></script>';

$ready="
$('#check_num_search').on('input', function(){find_check_by_num();});
$('.check_date').datepicker();
";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['checks'],$css);

if(isset($_GET['conn'])){

switch ($_GET['conn']) {
    case 'not-spend':$ch->not_spend_check($mysqli);break;
    case 'check-search':$ch->search_check($mysqli);break;
    case 'our-not-spend':$ch->not_spend_our_check($mysqli);break;
    case 'out-check-search':$ch->search_our_check($mysqli);break;
    }}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>