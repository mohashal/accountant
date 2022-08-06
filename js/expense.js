/*-------------- جلب نوع المصروف ---------------*/
function get_expense_type(){
var type=document.getElementById('expense_type').value;
document.getElementById('discount').value=0;

$.get("ajax_expense.php?type="+type, function(data){
$('.form_append').html('');
$('.form_append').append(data);
});

if(type==3 || type==5){
$('.discount_in').show('fade');
}
else{$('.discount_in').hide('fade');}
}

/*جلب اسم الموظف وراتبه*/
function get_salary_name(){

       var selected=$('#employee_id').find('option:selected');
       var name=selected.data('name');
       var salary=selected.data('salary');
document.getElementById('employee_name').value=name;
document.getElementById('employee_salary').value=salary;

}
/*--------------------- اظهار او اخفاء الشيك والنقدي ---------------------*/
function show_hide_cash_check(){
var cash=document.getElementById("is_cash");
var check=document.getElementById("is_check");

if(cash.checked){$('#if_cash').show('fade');$('#if_cash2').show('fade');}
else{$('#if_cash').hide('fade');$('#if_cash2').hide('fade');}
if(check.checked){$('#if_check').show('fade');}
else{$('#if_check').hide('fade');}
}
/*--------------------------- اضافة شيك للفورم  ----------------------------*/
function add_check_fields(){

var bank=document.getElementById("select_banks").value;
var currency=document.getElementById("select_curs").value;
var i=parseInt(document.getElementById("checks_count").value)+1;
var tr_content="\
<tr id='check"+i+"'>\
    <td class='nume'><span class='delete_check delinp' id='delete_el"+i+"' onclick='delete_check("+i+")'></span><p id='nu"+i+"'>"+i+"</p></td>\
    <td>شخصي</td>\
    <td>"+bank+"</td>\
    <td><input type='text' autocomplete='off' id='check_num"+i+"' name='check_num"+i+"' placeholder='رقم الشيك' value='' required></td>\
    <td><input type='text' autocomplete='off' class='check_date' id='check_date"+i+"' name='check_date"+i+"' placeholder='تاريخ الشيك' value='' required></td>\
    <td><input type='text' autocomplete='off' id='check_value"+i+"' name='check_value"+i+"' placeholder='قيمة الشيك' value='' oninput='sum_total_exch()' required></td>\
    <td>"+currency+"</td>\
    <td><input type='text' autocomplete='off' id='exchange_rate"+i+"' name='exchange_rate"+i+"' oninput='sum_total_exch()' placeholder='سعر الصرف' value=''></td>\
    <td><input type='file' name='check_image"+i+"' id='check_image"+i+"'></td>\
    <input type='hidden' name='check_id"+i+"' id='check_id"+i+"' value='0'>\
</tr>";
$('.final_res').before(tr_content);
$('.check_date').datepicker();

$('#select_bank0').attr("name","select_bank"+i);$('#select_bank0').attr("id","select_bank"+i);
$('#select_cur0').attr("name","select_cur"+i);$('#select_cur0').attr("id","select_cur"+i);
document.getElementById("checks_count").value=i;
sum_total_exch();
window.scrollTo(0,document.body.scrollHeight);
}

/*البحث عن شيك عن طرق الرقم*/
function find_check_by_num(func){

var num= document.getElementById("check_num_search").value;

if(num!=''){
$.get("ajaxbills.php?find_check=num2&func="+func+"&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_check_num').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}

/*جلب معلومات الشيك واضافتها للجدول*/
function table_check_details(id){
var i=parseInt(document.getElementById("checks_count").value)+1;

$.get("ajax_expense.php?search=table_check_details&i="+i+"&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
document.getElementById("check_num_search").value='';
$('.final_res').before(data);
document.getElementById("checks_count").value=i;
sum_total_exch();
});

window.scrollTo(0,document.body.scrollHeight);

}

/*حذف شيك من الجدول*/
function delete_check(i){
/*<span class='delete_check' id='delete_el".$i."' onclick='delete_check(".$i.")'></span>
<span class='delete_check delinp' id='delete_el"+i+"' onclick='delete_check("+i+")'></span>*/
var count=parseInt(document.getElementById("checks_count").value);
$("#check"+i).remove();

for(i2=i+1;i2<=count;i2++){
i3=i2-1;
var c_id=parseInt(document.getElementById("check_id"+i2).value);
if(c_id==0){
$('#check'+i2).attr("id","check"+i3);
$('#nu'+i2).html(i3);$('#nu'+i2).attr("id","nu"+i3);
$('#delete_el'+i2).attr("onclick","delete_check("+i3+")");$('#delete_el'+i2).attr("id","delete_el"+i3);
$("#check_num"+i2).attr("name","check_num"+i3);$("#check_num"+i2).attr("id","check_num"+i3);
$("#check_date"+i2).attr("name","check_date"+i3);$("#check_date"+i2).attr("id","check_date"+i3);
$("#check_value"+i2).attr("name","check_value"+i3);$("#check_value"+i2).attr("id","check_value"+i3);
$("#exchange_rate"+i2).attr("name","exchange_rate"+i3);$("#exchange_rate"+i2).attr("id","exchange_rate"+i3);
$("#check_image"+i2).attr("name","check_image"+i3);$("#check_image"+i2).attr("id","check_image"+i3);
$("#select_cur"+i2).attr("name","select_cur"+i3);$("#select_cur"+i2).attr("id","select_cur"+i3);
$("#select_bank"+i2).attr("name","select_bank"+i3);$("#select_bank"+i2).attr("id","select_bank"+i3);
$('#check_id'+i2).attr("name","check_id"+i3);$('#check_id'+i2).attr("id","check_id"+i3);
}
else{
$('#check'+i2).attr("id","check"+i3);
$('#nu'+i2).html(i3);$('#nu'+i2).attr("id","nu"+i3);
$('#delete_el'+i2).attr("onclick","delete_check("+i3+")");$('#delete_el'+i2).attr("id","delete_el"+i3);
$('#check_id'+i2).attr("name","check_id"+i3);$('#check_id'+i2).attr("id","check_id"+i3);
$('#check_value'+i2).attr("name","check_value"+i3);$('#check_value'+i2).attr("id","check_value"+i3);
$('#check_exr'+i2).attr("name","check_exr"+i3);$('#check_exr'+i2).attr("id","check_exr"+i3);
}

}
$('.check_date').datepicker("destroy");
$('.check_date').datepicker();

document.getElementById("checks_count").value=count-1;
sum_total_exch();
}

/*-----------جلب التجار حسب الاسم----------*/
function merchant_search(){
var name= document.getElementById("check_merchant_name").value;
if(name!=''){
$.get("ajax.php?search_merchant=name&func=set_to_bill&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_merchant').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
/*-----------جلب التجار حسب الاسم----------*/
function customer_search(){
var name= document.getElementById("check_customer_name").value;
if(name!=''){
$.get("ajax.php?search_customers=name&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_customer').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}

/*------------------ وضع معلومات التاجر في الفورم ------------------*/
function set_to_bill(id,name,balance){
$('.customer_auto_search_name').remove();
document.getElementById("check_merchant_name").value=name;
document.getElementById("merchant_id").value=id;
document.getElementById("merchant_balance").innerHTML=balance;
}
function get_this_customer(id){
$('.customer_auto_search_name').remove();
$.get("ajaxbills.php?search_bills=name&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
var customer=JSON.parse(data);
document.getElementById("check_customer_name").value=customer.name;
});
document.getElementById("merchant_id").value=id;
}
/*------------حذف سند صرف غير مرحل--------------*/
function remove_temp_exp(id){
var c=confirm('هل تريد الحذف ؟');
if(c){mymodalbox("الحذف","ajaxbills.php?expense=delete_temp_exp&id="+id+"",1);}
}

/*----------- جلب جميع السندات في شهر معين---------------*/
function get_records_by_monthyear(type){
var month=document.getElementById("search_expense_month").value;
var year=document.getElementById("search_expense_year").value;
var ur='';
var t=parseInt(type);
if(month!=0 && year!=0){

if(t==1){ur="ajax_expense.php?search=expense_month_year&month="+month+"&year="+year;}
if(t==2){ur="ajax_expense.php?search=expense_month_year2&month="+month+"&year="+year;}
document.getElementById("expenses_append").innerHTML='';
$.get(ur, function(data){
$('#show_tr').show('fade');
$('#expenses_append').append(data);
document.getElementById("expense_type").value=-1;
document.getElementById("partners").value=-1;
$('#partners').hide();
});

}

}
/*---------- اظهار واخفاء السندات --------------*/
function show_hide_tr(){
$('.show_hide_tr').hide();
var id=document.getElementById("expense_type").value;
$('.'+id).show('fade');
sum_expense('.'+id);
if(id==0){$('#partners').show();$('#employees').hide();document.getElementById("partners").value=-1;}
else if(id==1){$('#partners').hide();$('#employees').show();document.getElementById("employees").value=-1;}
else{document.getElementById("partners").value=-1;$('#partners').hide();$('#employees').hide();document.getElementById("employees").value=-1;}
}
/*----------- اختيار شريك ------------*/
function select_partner(){
var id=document.getElementById("partners").value;
$('.show_hide_tr').hide();
$('.pa'+id).show();
sum_expense('.pa'+id);
}
function select_employee(){
var id=document.getElementById("employees").value;
$('.show_hide_tr').hide();
$('.em'+id).show();
sum_expense('.em'+id);
}

function sum_expense(class_name){
var count_element=$(class_name).length;
var total_check=0;
var total_cash=0;
var total_ourcheck=0;

$('#total_cash').html('');
$('#total_check').html('');
$('#total_our_check').html('');
if(count_element>0){

$(class_name).each(function() {
total_cash+=parseFloat($(this).data("cash"));
total_check+=parseFloat($(this).data("check"));
total_ourcheck+=parseFloat($(this).data("ourcheck"));

});

$('#total_cash').html(total_cash);
$('#total_check').html(total_check);
$('#total_our_check').html(total_ourcheck);

}
}

function sum_total_exch(){
var count=parseInt(document.getElementById("checks_count").value);
var total=0;

for(i2=1;i2<=count;i2++){
var t1=0;
var e1=1;

var c_id=parseInt($("#check_id"+i2).val());
if(c_id==0){
if(document.getElementById("check_value"+i2).value!=''){t1=parseFloat(document.getElementById("check_value"+i2).value);}
if(document.getElementById("exchange_rate"+i2).value!=''){e1=parseFloat(document.getElementById("exchange_rate"+i2).value);}
}

else {
if(document.getElementById("check_value"+i2).value!=''){t1=parseFloat(document.getElementById("check_value"+i2).value);}
if(document.getElementById("check_exr"+i2).value!=''){e1=parseFloat(document.getElementById("check_exr"+i2).value);}
}

var ta=t1*e1;
total+=ta;
}
document.getElementById("total_values").innerHTML=total;
}
/*--------------- round floats ------------------------------*/
function roundd(value, decimals) {
  return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}