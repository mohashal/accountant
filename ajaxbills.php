<?php session_start();
if(isset($_SESSION['permission'])){
include_once 'clasat/ajaxbills.php';
include_once 'webcon/config.php';

$aj=new ajaxbills();
$co=new config();

$mysqli=$co->connect();

if(isset($_GET['search_bills'])){

switch ($_GET['search_bills']) {
    case 'name':$aj->get_customer_info($mysqli);break;
    case 'product':$aj->get_product_info($mysqli);break;
    case 'name_search':$aj->get_product_name($mysqli);break;
    case 'num_search':$aj->get_product_num($mysqli);break; 
    case 'barcode_search':$aj->get_product_barcode($mysqli);break;
    case 'offer_name':$aj->get_offer_by_name($mysqli);break;
    case 'offer-product':$aj->get_offer_info($mysqli);break;
}

}

elseif(isset($_GET['update_temp_bills'])){

switch ($_GET['update_temp_bills']) {
    case 'del':$aj->del_temp_bill($mysqli);break;
    case'save':$aj->save_temp_bill($mysqli);break;
    case 'merchant-save':$aj->save_merchant_temp_bill($mysqli);break;
    case 'merchant-del':$aj->del_merchant_temp_bill($mysqli);break;
    case 'retmerchant-save':$aj->save_retmerchant_temp_bill($mysqli);break;
    case 'retmerchant-del':$aj->del_retmerchant_temp_bill($mysqli);break;
    case 'returned-del':$aj->del_ret_temp_bill($mysqli);break;
    case 'ret-save':$aj->save_returned_temp_bill($mysqli);break;
    case 'instant':$aj->save_temp_instant($mysqli);break;
    case 'del_inst':$aj->del_inst_temp_bill($mysqli);break;
    case 'ret_instant':$aj->save_temp_ret_instant($mysqli);break;
    case 'del_ret_inst':$aj->del_ret_inst_temp_bill($mysqli);break;
    case 'offer_del':$aj->del_offer($mysqli);break;
}

}

elseif(isset($_GET['find_bills'])){

switch ($_GET['find_bills']) {
    case 'name':$aj->show_bill_list($mysqli,'name');break;
    case'num':$aj->show_bill_list($mysqli,'num');break;
    case'sentnum':$aj->show_bill_list($mysqli,'sentnum');break;
    case'taxnum':$aj->show_bill_list($mysqli,'taxnum');break;
    case'date':$aj->show_bill_list($mysqli,'date');break;
}

}

elseif(isset($_GET['find_returned'])){

switch ($_GET['find_returned']) {
    case 'name':$aj->show_returned_list($mysqli,'name');break;
    case'num':$aj->show_returned_list($mysqli,'num');break;
    case'date':$aj->show_returned_list($mysqli,'date');break;
    case'sale':$aj->show_returned_list($mysqli,'sale');break;
}

}
elseif(isset($_GET['find_instant'])){

switch ($_GET['find_instant']) {
    case 'name':$aj->show_instant_list($mysqli,'name');break;
    case'num':$aj->show_instant_list($mysqli,'num');break;
    case'date':$aj->show_instant_list($mysqli,'date');break;
    case'partner':$aj->show_instant_list($mysqli,'partner');break;
    case'employee':$aj->show_instant_list($mysqli,'employee');break;
}

}

elseif(isset($_GET['find_ret_instant'])){

switch ($_GET['find_ret_instant']) {
    case 'name':$aj->show_ret_instant_list($mysqli,'name');break;
    case'num':$aj->show_ret_instant_list($mysqli,'num');break;
    case'date':$aj->show_ret_instant_list($mysqli,'date');break;
    case'partner':$aj->show_ret_instant_list($mysqli,'partner');break;
    case'employee':$aj->show_ret_instant_list($mysqli,'employee');break;
}

}

elseif(isset($_GET['find_merchant_bill'])){

switch ($_GET['find_merchant_bill']) {
    case 'name':$aj->show_merchant_bill_list($mysqli,'name');break;
    case'num':$aj->show_merchant_bill_list($mysqli,'num');break;
    case'date':$aj->show_merchant_bill_list($mysqli,'date');break;
    case 'retname':$aj->show_merchant_retbill_list($mysqli,'name');break;
    case'retnum':$aj->show_merchant_retbill_list($mysqli,'num');break;
    case'retdate':$aj->show_merchant_retbill_list($mysqli,'date');break;
}

}

elseif(isset ($_GET['find_check'])){
switch ($_GET['find_check']) {
    case 'num':$aj->get_check_by_num($mysqli);break;
    case 'num2':$aj->get_check_by_num2($mysqli);break;
    case 'num3':$aj->get_check_by_num3($mysqli);break;
    case 'our_num':$aj->get_our_check_by_num($mysqli);break;
    case 'check_details':$aj->get_check_details($mysqli);break;
    case 'our_check_details':$aj->get_our_check_details($mysqli);break;
    case 'save_returned':$aj->save_return_check($mysqli);break;
    case 'save_temp_rev':$aj->update_temp_permant_revenue($mysqli);break;
    case 'delete_temp_rev':$aj->delete_temp_revenue($mysqli);break;
    case 'spend':$aj->check_spend($mysqli);break;
    case 'our_check_return':$aj->our_check_return($mysqli);break;
    case 'our_check_spend':$aj->our_check_spend($mysqli);break;
    case 'check_details_cus':$aj->get_customer_check($mysqli);break;
    case 'check_details_mer':$aj->get_merchant_check($mysqli);break;
    case 'check_date':$aj->get_check_by_date($mysqli);break;
    case 'our_check_date':$aj->get_our_check_by_date($mysqli);break;
}
}

elseif(isset ($_GET['expense'])){
switch ($_GET['expense']) {
    case 'save_temp_exp':$aj->update_temp_permnt_expense($mysqli,intval($_GET['id']),intval($_GET['exp_type']));break;
    case 'delete_temp_exp':$aj->delete_temp_exp($mysqli,intval($_GET['id']));break;
}
}

}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}
