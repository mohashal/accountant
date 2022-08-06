<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/expense.php';

$hf=new he_fo();
$ex=new expense();
$co=new config();

$css="<link href='csss/expense.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/expense.js"></script>';

$ready="
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
$('.check_date').datepicker();
";

$mysqli=$co->connect();
$hf->headers($mysqli,langu['expenses'],$css);

if(isset($_GET['conn'])){

if($_GET['conn']=='edit-temp-expense'){

include_once 'clasat/ajax_expense.php';
$ajx=new ajax_expense();
$row=$mysqli->query('select * from expense where id='.intval($_GET['id']));$row=$row->fetch_assoc();
$fields='';
$type=intval($_GET['type']);
switch ($type) {
    case '0':$fields=$ajx->get_partner_form($mysqli,$row['partner_id']);break;
    case '1':$fields=$ajx->get_salary_form($mysqli,$row['employee_id']);break;
    case '2':$fields=$ajx->get_salary_form($mysqli,$row['employee_id']);break;
    case '3':$fields=$ajx->get_merchant_form($mysqli,$row['merchant_id']);break;
    case '4':$fields=$ajx->get_car_form($mysqli,$row['car_id']);break;
    case '5':$fields=$ajx->get_customer_form($mysqli,$row['customer_id']);break;
}
$ex->edit_expense_form($mysqli,$row,intval($_GET['id']),$type,$fields);
}

else{
switch ($_GET['conn']) {
case 'add-expense-form':$ex->add_expense_form($mysqli);break;
case 'save_expense_form':$m=$ex->save_expense_form($mysqli,$_POST['expense_type']);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');$ex->add_expense_form($mysqli);}else{$hf->msg($m[0],$m[1],'success','expense.php?conn=add-expense-form');}break;
case 'temp-expense-form':$ex->temp_expense_form($mysqli);break;
case 'search-expense':$ex->search_expense($mysqli,1);break;
case 'search-expense2':$ex->search_expense($mysqli,2);break;
}}

}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>