<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/merges.php';

$hf=new he_fo();
$ma=new merges();
$co=new config();


$css="<style>
.merge_button{width:50%;margin:15px auto;text-align:center;}
.merge_button a{width:auto;=text-align:center;font-size:17px;padding:5px;border:1px #344359 solid;border-radius:5px;background-color:#fff;color:#344359;font-weight:bold;cursor:pointer;transition:0.3s;}
.merge_button a:hover{background-color:#344359;color:#fff;}
</style>";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['merge_photos'],$css);

if(isset($_GET['conn'])){

switch ($_GET['conn']) {
    case 'merge-form':$ma->merge_form($mysqli);break;
    case 'merge_all':$ma->merge_cats($mysqli);break;
    }}

$hf->footer();
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>