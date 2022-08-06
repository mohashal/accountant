<?php session_start();
if(isset($_SESSION['permission'])){
include_once 'clasat/ajax.php';
include_once 'webcon/config.php';

$aj=new ajax();
$co=new config();

$mysqli=$co->connect();

if(isset($_GET['search_customers'])){
if(!isset($_GET['q'])){$q=null;}else{$q=$_GET['q'];}if(!isset($_GET['func'])){$func=null;}else{$func=$_GET['func'];}
switch ($_GET['search_customers']){
case 'all':$aj->get_customers($mysqli);break;
case 'one':$aj->get_one_customer($mysqli);break;
case 'name':$aj->search_customer_name($mysqli,$q,$func);break;
case 'saleman':$aj->get_saleman($mysqli,intval($_GET['customer']));break;
default :$aj->get_customers($mysqli);break;
}
}

elseif(isset($_GET['search_product'])){
switch ($_GET['search_product']){
case 'cat':$aj->get_products_cat($mysqli);break;
case 'name':$aj->get_product_name($mysqli);break;
case 'num':$aj->get_product_num($mysqli);break;
case 'barcode':$aj->get_product_barcode($mysqli);break;
case 'one':$aj->get_one_product($mysqli);break;
case 'one2':$aj->get_one_product2($mysqli);break;
}
}

elseif(isset($_GET['search_merchant'])){
if(!isset($_GET['func'])){$func=null;}else{$func=$_GET['func'];}
switch ($_GET['search_merchant']){
case 'name':$aj->search_merchant_name($mysqli,$func);break;
case 'barcode':$aj->generate_barcode($mysqli,201810051000);break;
case 'print_barcode':$aj->print_barcode($_GET['bar']);
}
}

elseif(isset($_GET['checks'])){
switch ($_GET['checks']){
case 'remove_check':$aj->remove_check_from_expense($mysqli);break;
case 'remove_our_check':$aj->remove_our_check($mysqli);break;
}
}

}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}
?>