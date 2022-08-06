<?php session_start();
if(isset($_SESSION['permission']) && $_SESSION['permission']==1){
include_once 'webcon/he_fo.php';
include_once 'webcon/config.php';
include_once 'clasat/revenue.php';

$hf=new he_fo();
$ch=new revenue();
$co=new config();

$css="<link href='csss/revenue.css' rel='stylesheet' type='text/css'/>";

$js='<script src="js/revenue.js"></script>';

$ready="$('.customer_search_select').find('select').on('change', function() {get_costomers_sale_day();})
$('#select_salesmantemp').on('change', function(){show_hide_temp_rev();});
$('#select_salesmansearch').on('change', function(){show_hide_rev();});
$('#check_customer_name').on('input', function(){check_customer_search();});
$('#s_customer_name').on('input', function(){s_customer_search();});
$('#check_merchant_name').on('input', function(){check_merchant_search();});
$('#check_num_search').on('input', function(){find_check_by_num();});
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
$hf->headers($mysqli,langu['revenue'],$css);

if(isset($_GET['conn'])){

switch ($_GET['conn']) {
    case 'add-revenue-form':$ch->form_add_revenue($mysqli);break;
    case'add-revenue-save':$m=$ch->form_save_revenue($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');$ch->form_add_revenue($mysqli);}else{$hf->msg($m[0],$m[1],'success','revenue.php?conn=add-revenue-form');}break;
    case'temp-revenue-form':$ch->form_temp_revenue($mysqli);break;
    case'edit-temp-revenue':$ch->form_edit_revenue($mysqli);break;
    case'edit-revenue-save':$m=$ch->save_edit_revenue($mysqli);if($m[1]==0){$hf->msg($m[0],$m[1],'fail');$ch->form_temp_revenue($mysqli);}else{$hf->msg($m[0],$m[1],'success','revenue.php?conn=temp-revenue-form');}break;
    case 'search-revenue':$ch->search_revenue($mysqli);break;
    }}

$hf->footer($js,$ready);
}
else {echo "<script>setTimeout(\"window.top.location.href='index.php'\",200);</script>";}

?>