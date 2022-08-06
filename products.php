<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/products.php';

$hf=new he_fo();
$pr=new products();
$co=new config();

$css="<link href='csss/products.css' rel='stylesheet' type='text/css'/>";
$js='<script src="js/products.js"></script>';
$ready="$('#select_category').on('change', function() {
search_product_cat();
});
$('#product_num_search').on('input', function(){search_product_num();});
$('#product_name_search').on('input', function(){search_product_name();});
$('#barcode_search').on('input', function(){search_product_barcode();});
";
/*$('#product_name_search').on('propertychange change click keyup input paste blur', function(){
alert(1);
});*/
$mysqli=$co->connect();
$hf->headers($mysqli,langu['products'],$css);

if(isset($_GET['conn'])){

switch ($_GET['conn']) {
    case 'add_product_form':$pr->add_product_form($mysqli,$co->get_auto_increment_value($mysqli,'products'));break;
    case 'add-product-save':$m=$pr->add_product_save($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');$pr->add_product_form($mysqli);}else{$hf->msg($m[0],$m[1],'success','products.php?conn=add_product_form');}break;
    case 'search_product_form':$pr->search_product_form($mysqli);break;
    case 'update-product-save':$m=$pr->update_product_save($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');$pr->add_product_form($mysqli);}else{$hf->msg($m[0],$m[1],'success','products.php?conn=search_product_form');}break;
    case 'product_our_barcode':$pr->product_our_barcode($mysqli);break;
    case 'set_barcode':$m=$pr->add_barcode_empty($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');}else{$hf->msg($m[0],$m[1],'success','products.php?conn=search_product_form');}break;
}}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>