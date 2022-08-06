<?php session_start();
if(isset($_SESSION['permission'])){
include_once 'clasat/ajax_settings.php';
include_once 'webcon/config.php';

$aj=new ajax_settings();
$co=new config();

$mysqli=$co->connect();

echo "<!DOCTYPE html>
<html ".langu['lang_html'].">
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title></title>
<link href='csss/reset.css' rel='stylesheet' type='text/css'/>
<link rel='icon' href='images/main/logo2.png' type='image/png'/>
<link rel='apple-touch-icon-precomposed' href='images/main/logo2.png'/>
<link href='csss/main.css' rel='stylesheet' type='text/css'/>
<link href='js/jquery-ui/jquery-ui.css' rel='stylesheet' type='text/css'/>
</head>
<body>
<div class='wrap'>
<style>.form_input_line{height: auto;}</style>";
$ready='';
if(isset($_GET['bank'])){

switch ($_GET['bank']){
case 'add-form':$aj->add_form('bank');break;
case 'add_save':$aj->add_save($mysqli,'banks');break;
case 'edit-form':$aj->edit_form($mysqli,'bank','banks');break;
case 'edit_save':$aj->edit_save($mysqli,'banks');break;
case 'delete':$aj->delete($mysqli,'banks');break;
}

}

elseif(isset($_GET['merchant'])){
$fields="<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['area']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='area' placeholder='".langu['area_name']."' value='' required /></div></div>
<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['telephone']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='tel' placeholder='".langu['telephone']."' value='' required /></div></div>
<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['balance']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='balance' placeholder='".langu['balance']."' value='' required /></div></div>";
switch ($_GET['merchant']){
case 'add-form':$aj->add_form('merchant',$fields);break;
case 'add_save':$aj->add_save_merchant($mysqli,'merchants');break;
case 'edit-form':$aj->edit_form_merchant($mysqli,'merchant','merchants');break;
case 'edit_save':$aj->edit_save_merchant($mysqli,'merchants');break;
case 'delete':$aj->delete($mysqli,'merchants');break;
}

}

elseif(isset($_GET['telephon'])){
$fields="<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['telephone']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='tel' placeholder='".langu['telephone']."' value='' required /></div></div>";
switch ($_GET['telephon']){
case 'add-form':$aj->add_form('telephon',$fields);break;
case 'add_save':$aj->add_save_telephon($mysqli,'telephons');break;
case 'edit-form':$aj->edit_form_telephon($mysqli,'telephon','telephons');break;
case 'edit_save':$aj->edit_save_telephon($mysqli,'telephons');break;
case 'delete':$aj->delete($mysqli,'telephons');break;
}

}
elseif(isset($_GET['user'])){
$fields="<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['password']."</div><div class='form_input_input' style='width:65%;'><input type='password' autocomplete='off' name='passw' value='' required /></div></div>
<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['permission']."</div><div class='form_input_input' style='width:65%;'><select id='select_perm' name='select_perm'><option value='' disabled selected>".langu['select_perm']."</option><option value='1'>مدير</option><option value='2'>ادخال فواتير + الزبائن</option><option value='3'>ضريبة</option><option value='4'>البيع الفوري</option></select></div></div>";
switch ($_GET['user']){
case 'add-form':$aj->add_form('user',$fields);break;
case 'add_save':$aj->add_save_user($mysqli,'users');break;
case 'edit-form':$aj->edit_form_user($mysqli,'user','users');break;
case 'edit_save':$aj->edit_save_user($mysqli,'users');break;
case 'delete':$aj->delete($mysqli,'users');break;
}

}

elseif(isset($_GET['currency'])){

switch ($_GET['currency']){
case 'add-form-currency':$aj->add_form_currency();break;
case 'add_save_currency':$aj->add_save_currency($mysqli);break;
case 'edit-form-currency':$aj->edit_form_currency($mysqli);break;
case 'edit_save_currency':$aj->edit_save_currency($mysqli);break;
case 'delete_currency':$aj->delete_currency($mysqli);break;
}

}

elseif(isset($_GET['area'])){

switch ($_GET['area']){
case 'add-form':$aj->add_form('area');break;
case 'add_save':$aj->add_save($mysqli,'areas');break;
case 'edit-form':$aj->edit_form($mysqli,'area','areas');break;
case 'edit_save':$aj->edit_save($mysqli,'areas');break;
case 'delete':$aj->delete($mysqli,'areas');break;
}

}

elseif(isset($_GET['categorie'])){

switch ($_GET['categorie']){
case 'add-form':$aj->add_form('categorie');break;
case 'add_save':$aj->add_save($mysqli,'categories');break;
case 'edit-form':$aj->edit_form($mysqli,'categorie','categories');break;
case 'edit_save':$aj->edit_save($mysqli,'categories');break;
case 'delete':$aj->delete($mysqli,'categories');break;
}

}

elseif(isset($_GET['partner'])){

switch ($_GET['partner']){
case 'add-form':$aj->add_form('partner');break;
case 'add_save':$aj->add_save($mysqli,'partners');break;
case 'edit-form':$aj->edit_form($mysqli,'partner','partners');break;
case 'edit_save':$aj->edit_save($mysqli,'partners');break;
case 'delete':$aj->delete($mysqli,'partners');break;
}

}

elseif(isset($_GET['product_unit'])){

switch ($_GET['product_unit']){
case 'add-form':$aj->add_form('product_unit');break;
case 'add_save':$aj->add_save($mysqli,'product_unit');break;
case 'edit-form':$aj->edit_form($mysqli,'product_unit','product_unit');break;
case 'edit_save':$aj->edit_save($mysqli,'product_unit');break;
case 'delete':$aj->delete($mysqli,'product_unit');break;
}

}

elseif(isset($_GET['expense_type'])){

switch ($_GET['expense_type']){
case 'add-form':$aj->add_form('expense_type');break;
case 'add_save':$aj->add_save($mysqli,'expense_types');break;
case 'edit-form':$aj->edit_form($mysqli,'expense_type','expense_types');break;
case 'edit_save':$aj->edit_save($mysqli,'expense_types');break;
case 'delete':$aj->delete($mysqli,'expense_types');break;
}

}

elseif(isset($_GET['employee'])){
/*<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['salary']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='salary' placeholder='".langu['salary']."' value='' required /></div></div>*/
$fields="<input type='hidden' autocomplete='off' name='salary' value=''/>
<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['employee_type']."</div><div class='form_input_input' style='width:65%;'><select id='select_type' name='select_type' onchange='show_hide_sprice()' required><option value='' disabled selected>".langu['selecttype']."</option><option value='1'>".langu['salesman3']."</option><option value='2'>".langu['driver2']."</option><option value='3'>".langu['employee']."</option></select></div></div>
<div class='form_input_line' id='e_price'  style='display:none'><div class='form_input_name' style='width:35%;'>".langu['employee_price']."</div><div class='form_input_input' style='width:65%;'><select id='select_sale_price' name='select_sale_price'><option value='' disabled selected>".langu['selectsaprice']."</option><option value='n_price'>n_price</option><option value='fa_price'>fa_price</option><option value='t_price'>t_price</option><option value='f_price'>f_price</option></select></div></div>";

switch ($_GET['employee']){
case 'add-form':$aj->add_form('employee',$fields);break;
case 'add_save':$aj->add_save_employee($mysqli);break;
case 'edit-form':$aj->edit_form($mysqli,'employee','employees',$fields);break;
case 'edit_save':$aj->edit_save_employee($mysqli);break;
case 'delete':$aj->delete($mysqli,'employees');break;
}

}

elseif(isset($_GET['car'])){

$fields="<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['license_plate']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='license_plate' placeholder='".langu['license_plate']."' value='' required /></div></div>
<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['license_end_date']."</div><div class='form_input_input' style='width:65%;'><input type='text' class='all_dates' autocomplete='off' name='license_end_date' placeholder='".langu['license_end_date']."' value='' required /></div></div>
<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['insurance_end_date']."</div><div class='form_input_input' style='width:65%;'><input type='text' class='all_dates' autocomplete='off' name='insurance_end_date' placeholder='".langu['insurance_end_date']."' value='' required /></div></div>
<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['purchase_date']."</div><div class='form_input_input' style='width:65%;'><input type='text' class='all_dates' autocomplete='off' name='purchase_date' placeholder='".langu['purchase_date']."' value='' required /></div></div>
";

switch ($_GET['car']){
case 'add-form':$aj->add_form('car',$fields);break;
case 'add_save':$aj->add_save_car($mysqli);break;
case 'edit-form':$aj->edit_form_car($mysqli,'car','cars',$fields);break;
case 'edit_save':$aj->edit_save_car($mysqli);break;
case 'delete':$aj->delete($mysqli,'cars');break;
}

}


elseif(isset ($_GET['find_check'])){
switch ($_GET['find_check']) {
    case'form_returned':$aj->add_form_returned();break;
}
}

elseif(isset ($_GET['notifications'])){
switch ($_GET['notifications']) {
    case'show':$aj->show_notify($mysqli);break;
    case'add-form':$aj->add_form_notify();break;
    case'add-save':$aj->add_save_notify($mysqli);break;
    case 'edit-form':$aj->edit_form_notify($mysqli);break;
    case 'edit_save':$aj->edit_save_notify($mysqli);break;
    case'delete':$aj->delete_notify($mysqli);break;
}
}
else{

switch ($_GET['else']) {
    case'update-product-save':$aj->update_product_save($mysqli);break;
}
}

echo "</div>
<script src='js/jquery.js'></script>
<script src='js/main.js'></script>
<script src='js/ajax_settings.js'></script>
<script src='js/jquery-ui/jquery-ui.min.js'></script>
<script>

$(document).ready(function() {
".$ready."
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
$('.all_dates').datepicker();
});
</script>
</body>
</html>";
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}
?>