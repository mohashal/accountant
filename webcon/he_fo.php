<?php
include_once 'lang.php';
//<link href="'.$css.'.css" rel="stylesheet" type="text/css"/>
class he_fo {

/*----------فنكشن الهيدر--------*/
function headers($mysqli,$title=null,$css=null){

echo "<!DOCTYPE html>
<html ".langu['lang_html'].">
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>".$title." - ".langu['site_name']."</title>
<link href='csss/reset.css' rel='stylesheet' type='text/css'/>
<link href='js/jquery-ui/jquery-ui.css' rel='stylesheet' type='text/css'/>
<link rel='icon' href='images/main/logo2.png' type='image/png'/>
<link rel='apple-touch-icon-precomposed' href='images/main/logo2.png'/>
<link href='csss/main.css' rel='stylesheet' type='text/css'/>
".$css."
</head>
<body>
<div class='wrap'>";
if(isset($_SESSION['username'])){
echo "<div class='top_navbar'><a class='login_a' href='index.php' style='padding: 9px;'><span>  </span>".langu['main']."</a><a class='login_a' href='notifications.php?conn=all-notifications' style='padding:9px;'><span>e</span>".$this->get_notif($mysqli)."</a><a class='login_a left_nav' style='border-right:1px #5f7088 solid;' onClick='login_modal(\"".langu['logout']."\",\"login.php?logout\")'>".langu['logout']."</a><p class='left_nav'> ".$_SESSION['username']." </p></div>
<div class='main_main'>
".$this->sidebar()."
<div class='main_show'>
<p class='menu_bar' data-open='1'></p>
";}
else {echo "<script>setTimeout(\"window.top.location.href='login.php'\",200);</script>";}
}

/*------فنكشن الفوتر-----*/
function footer($js=null,$ready=null,$hide=null){

echo"
<script src='js/jquery.js'></script>
<script src='js/main.js'></script>
<script src='js/jquery-ui/jquery-ui.min.js'></script>
".$js."
<script>
$(document).ready(function() {
$('.menu_element_name').click(function(){
    $(this).next().slideToggle();
    var obj=$(this).find('.rotate_icon');
    rotate_menu_sympol(obj);
  });
$('.menu_bar').click(function(){menu_toogle();});
$.datepicker.setDefaults({
    dayNamesShort: [ 'أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت' ],
    dayNamesMin: [ 'أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت' ],
    closeText: 'إغلاق',
    prevText: 'السابق',
    nextText: 'التالي;',
    currentText: 'اليوم',
    dateFormat: 'yy-m-d',
    changeMonth: true,
    changeYear: true,
    monthNames: ['1','2','3','4','5','6','7','8','9','10','11','12'],
    monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12']
});
$(':input').keypress(function(event){
    if (event.which == '10' || event.which == '13') {
        event.preventDefault();
    }
});
".$ready.
"});
</script>
</div></div></div>
<footer class='".$hide."'>
<div id='fo-wrap'></div>
</footer>

</body>
</html>";}

/**
 * sidebar with permissions
 * @name $_SESSION['permission'] 1=>all permissions , 2=>for add temp invoice , 3=>for tax invoices
 */
function sidebar() {
$a='';
$m="<div class='main_sidebar'><p>".langu['menu']."</p>";
/*------------ صلاحية مشتركة بين  1 و 2 ---------------*/
if(isset($_SESSION['permission']) && ($_SESSION['permission']==1 ||$_SESSION['permission']==2 ||$_SESSION['permission']==3 ||$_SESSION['permission']==4)){
$o='';
if($_SESSION['permission']==1 ||$_SESSION['permission']==2){$o="<a href='bills.php?conn=temp_bill'>".langu['temp_bill']."</a><a href='bills.php?conn=search_bill'>".langu['search_order']."</a>";}
$a="<div class='menu_element'>
    <div class='menu_element_name'><span></span><div>".langu['invoices']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='bills.php?conn=add_bill'>".langu['add_bill']."</a>".$o."<a href='bills.php?conn=search_tax_bill'>".langu['search_tax_sent_bill']."</a></div>
    </div>";
if($_SESSION['permission']==2){
$a.="
<div class='menu_element'>
    <div class='menu_element_name'><span></span><div>".langu['customers']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='customers.php?conn=add-customer-form'>".langu['add_customer']."</a><a href='customers.php?conn=search-customer-form'>".langu['search_customer']."</a><a href='customers.php?conn=customer-statement-form'>".langu['statement_customer']."</a></div>
</div>
";
}
elseif($_SESSION['permission']==4){
$a="
<div class='menu_element'>
    <div class='menu_element_name'><span style='font-family:inherit;'>$</span> <div>".langu['instant_pay']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='instant_pay.php?conn=add_bill_form'>".langu['instant_pay']."</a><a href='instant_pay.php?conn=temp_bill'>".langu['temp_bill']."</a><a href='instant_pay.php?conn=search_instant'>".langu['search_order']."</a></div>
</div>
";
}
}
/*---------------- permission for 1 -----------------*/
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
$a.="
<div class='menu_element'>
    <div class='menu_element_name'><span style='font-family:inherit;'>$</span> <div>".langu['instant_pay']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='instant_pay.php?conn=add_bill_form'>".langu['instant_pay']."</a><a href='instant_pay.php?conn=temp_bill'>".langu['temp_bill']."</a><a href='instant_pay.php?conn=search_instant'>".langu['search_order']."</a>
    <a href='return_instant_pay.php?conn=add_bill_form'>".langu['add_returned_products']."</a><a href='return_instant_pay.php?conn=temp_bill'>".langu['temp_returned_bill']."</a><a href='return_instant_pay.php?conn=search_instant'>".langu['returned_search']."</a></div>
</div>

<div class='menu_element'>
    <div class='menu_element_name'><span><img src='images/main/products-icon.png' alt='products'/></span><div>".langu['products']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='products.php?conn=add_product_form'>".langu['add_product']."</a><a href='products.php?conn=search_product_form'>".langu['search_product']."</a><a href='products.php?conn=product_our_barcode'>".langu['product_our_barcode']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span>0</span><div>".langu['offers']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='offers.php?conn=offers'>".langu['offers']."</a><a href='offers.php?conn=add_offer'>".langu['add_offer']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span><img src='images/main/products-icon.png' alt='products'/></span><div style='font-size:13px;'>".langu['returned_products']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='returned.php?conn=add_returned_products'>".langu['add_returned_products']."</a><a href='returned.php?conn=temp_returned_products'>".langu['temp_returned_products']."</a><a href='returned.php?conn=search_returned_products' style='font-size: 15px;'>".langu['search_returned_products']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span><img src='images/main/products-icon.png' alt='products'/></span><div style='font-size:13px;'>".langu['damaged_products']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='damaged.php?conn=all-damaged'>".langu['damaged_products']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span></span><div>".langu['customers']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='customers.php?conn=add-customer-form'>".langu['add_customer']."</a><a href='customers.php?conn=search-customer-form'>".langu['search_customer']."</a><a href='customers.php?conn=customer-statement-form'>".langu['statement_customer']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span></span><div>".langu['merchants']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='settings.php?conn=merchants'>".langu['merchants']."</a><a href='merchants.php?conn=bill_form'>".langu['add_bill']." ".langu['from']." ".langu['merchant']."</a><a href='merchants.php?conn=temp-bill'>".langu['temp_bill']."</a><a href='merchants.php?conn=search-bill'>".langu['search_merchant_bill']."</a>
<a href='merchants.php?conn=retbill_form'>".langu['add_returned_to_merchant']."</a><a href='merchants.php?conn=rettemp-bill'>".langu['temp_returned_products']."</a><a href='merchants.php?conn=search-retbill'>".langu['search_returned_products']."</a><a href='merchants.php?conn=merchant-statment'>".langu['statement_merchant']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span><img src='images/main/checks.png' alt='products'/></span><div>".langu['revenue']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='revenue.php?conn=add-revenue-form'>".langu['add_payment_receipt']."</a><a href='revenue.php?conn=temp-revenue-form'>".langu['temp_payment_receipt']."</a><a href='revenue.php?conn=search-revenue'>".langu['search_revenue']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span><img src='images/main/checks.png' alt='products'/></span><div>".langu['expenses']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='expense.php?conn=add-expense-form'>".langu['add_expense_receipt']."</a><a href='expense.php?conn=temp-expense-form'>".langu['temp_expense_payment']."</a><a href='expense.php?conn=search-expense'>".langu['search_expense']."</a><a href='expense.php?conn=search-expense2'>".langu['search_expense2']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span><img src='images/main/checks.png' alt='products'/></span><div>".langu['checks']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='checks.php?conn=not-spend'>".langu['not_spend_checks']."</a><a href='checks.php?conn=check-search'>".langu['search_check']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span><img src='images/main/checks.png' alt='products'/></span><div style='font-size:13px;width:75%;'>".langu['our_checks']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='checks.php?conn=our-not-spend'>".langu['not_spend_checks']."</a><a href='checks.php?conn=out-check-search'>".langu['search_check']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span></span><div>".langu['reports']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='reports.php?conn=daily_report'>".langu['daily_report']."</a><a href='reports.php?conn=profits'>".langu['profits']."</a><a href='reports.php?conn=partners'>".langu['partners_expense']."</a><a href='reports.php?conn=employess_expense'>".langu['emp_expense']."</a><a href='reports.php?conn=bilss'>".langu['bills']."</a><a href='reports.php?conn=salesman'>".langu['the_salesmen']."</a><a href='reports.php?conn=equity'>".langu['equity_capital']."</a><a href='reports.php?conn=ret_check_sale'>".langu['ret_check_sale']."</a><a href='reports.php?conn=zkakah'>".langu['zakah']."</a><a href='reports.php?conn=customer-debt'>".langu['customer_debt']."</a><a href='reports.php?conn=merchant-debt'>".langu['merchant_debt']."</a><a href='reports.php?conn=few-products'>".langu['few_products']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span></span><div>".langu['settings']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='settings.php?conn=telephone'>".langu['telephons']."</a><a href='settings.php?conn=users'>".langu['users']."</a><a href='settings.php?conn=banks'>".langu['banks']."</a><a href='settings.php?conn=currency'>".langu['currencys']."</a><a href='settings.php?conn=areas'>".langu['areas']."</a><a href='settings.php?conn=categories'>".langu['categories']."</a><a href='settings.php?conn=cars'>".langu['cars']."</a><a href='settings.php?conn=employee'>".langu['employees']."</a><a href='settings.php?conn=expense_types'>".langu['expense_types']."</a><a href='settings.php?conn=product_units'>".langu['product_units']."</a><a href='settings.php?conn=partners'>".langu['partners']."</a><a href='http://localhost/phpmyadmin/db_export.php?db=account' target='_blank'>".langu['get_backup']."</a></div>
</div>
<div class='menu_element'>
    <div class='menu_element_name'><span style='font-size:27px;line-height: 20px;'></span><div>".langu['merge_photos']."</div><span class='rotate_icon'>d</span></div>
    <div class='menu_element_branch'><a href='merges.php?conn=merge-form'>".langu['merge_photos']."</a></div>
</div>";}

$m.=$a."</div>";
return $m;

}

function get_notif($mysqli){
$day=date('Y-m-d');
$row=$mysqli->query("SELECT count(id) as i FROM notifications where start_date<='".$day."' and end_date>='".$day."'");
$row=$row->fetch_assoc();
$m='';
if($row['i']!=0){$m="<p class='n_num' style='margin:3px -2px;line-height:14px;'>".$row['i']."</p>";}
return $m;
}
/*-------------------- end sidebar ------------------------*/
/**
* --------------------- msg ------------------------
*@param  $text msg text
*@param  $re to return or not
*@param  $success_fail should be success or fail in class
*/
function msg($text,$re=null,$success_fail=null,$location=null){
if($location==null){$location='index.php';}
if($re==0){echo "<div class='msg $success_fail'>";}
elseif($re==1) {echo "<script>setTimeout(\"window.top.location.reload()\",1000);</script>
<div class='msg $success_fail'>";}
elseif($re==5){
echo "<script>setTimeout(\"modal.style.display = 'none';$('.modal').remove();$('#modal_script').remove();\",1000);</script>
<div class='msg $success_fail'>";
}
else{echo "<script>setTimeout(\"window.top.location.href='".$location."'\",1000);</script>
<div class='msg $success_fail'>";}
echo"<div class='text_msg'>".$text."</div></div>";
}

}?>