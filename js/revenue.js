/*-----------جلب الزبائن حسب الاسم----------*/
function check_customer_search(){

var name= document.getElementById("check_customer_name").value;
if(name!=''){
$.get("ajax.php?search_customers=name&q=1&func=set_customer_info&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_customer').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
function s_customer_search(){

var name= document.getElementById("s_customer_name").value;
if(name!=''){
$.get("ajax.php?search_customers=name&q=1&func=set_customer_rev&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_customer').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
/*-----------جلب الزبائن حسب الاسم----------*/
function check_merchant_search(){
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
/*---------------وضع معلومات الزبون في الانبوت--------------*/
function set_customer_info(name,main_id,id){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
document.getElementById("check_customer_name").value=name;
document.getElementById("customer_id").value=id;
document.getElementById("main_customer_id").value=main_id;
document.getElementById("check_merchant_name").value='';
document.getElementById("merchant_id").value=0;

$.get("ajax.php?search_customers=saleman&customer="+id, function(data){
var customer=JSON.parse(data);
document.getElementById("select_salesman").value=customer.sale_id;
var bal=document.getElementById("set_balance");
if(bal!==null){bal.innerHTML=customer.balance;}
$('#set_sale').text(customer.ename);
});
}

function set_customer_rev(name,main_id,id){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
document.getElementById("s_customer_name").value=name;
document.getElementById("search_expense_month").value=0;
document.getElementById("search_expense_year").value=0;


$('#salesmans').hide('fade');
document.getElementById('select_salesmansearch').value='n';
document.getElementById("revenues_append").innerHTML='';
$.get("ajax_expense.php?search=revenue_customer&id="+id, function(data){
$('.no_resault').hide();
$('#revenues_append').append(data);
});

}
/*---------------وضع معلومات التاجر في الانبوت--------------*/
function set_to_bill(id,name,balance){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
document.getElementById("check_merchant_name").value=name;
document.getElementById("merchant_id").value=id;
var bal=document.getElementById("set_balance");
if(bal!==null){bal.innerHTML=balance;}
document.getElementById("check_customer_name").value='';
document.getElementById("customer_id").value=0;
}
/*----------------- اظهار واخفاء الزبون والتاجر في الشيكات ---------------*/
function show_hide_customer_merchant(){
var customer=document.getElementById("is_customer");
var merchant=document.getElementById("is_merchant");
var partner=document.getElementById("is_partner");
var employee=document.getElementById("is_employee");
var normal=document.getElementById("is_normal");
var bal=document.getElementById("set_balance");
if(bal!==null){bal.innerHTML='';}
document.getElementById("check_merchant_name").value='';
document.getElementById("select_partner").value=0;
document.getElementById("select_employee").value=0;
document.getElementById("customername").value='';
hide_all_types();
if(merchant.checked){$('#show_hide_merchant').fadeToggle();$(".show_hide_baln").show();$('#is_check_hs').show();}
if(customer.checked){$('#show_hide_customer').fadeToggle();$('#show_hide_sale').fadeToggle();$(".show_hide_baln").show();$('#is_check_hs').show();}
if(partner.checked){$('#show_hide_partner').fadeToggle();$(".show_hide_baln").hide();$('#is_check_hs').hide();}
if(employee.checked){$('#show_hide_emp').fadeToggle();$(".show_hide_baln").hide();$('#is_check_hs').hide();}
if(normal.checked){$('#show_hide_ncustomer').fadeToggle();$(".show_hide_baln").hide();$('#is_check_hs').show();}
}
function hide_all_types(){
$('#show_hide_sale').hide();$('#show_hide_customer').hide();
$('#show_hide_merchant').hide();$('#show_hide_partner').hide();
$('#show_hide_emp').hide();$('#show_hide_ncustomer').hide();
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
    <td><span class='delete_check delinp' id='delete_el"+i+"' onclick='delete_check("+i+",0)'></span>"+bank+"</td>\
    <td><input type='text' autocomplete='off' id='check_num"+i+"' name='check_num"+i+"' placeholder='رقم الشيك' value='' required></td>\
    <td><input type='text' autocomplete='off' class='check_date' id='check_date"+i+"' name='check_date"+i+"' placeholder='تاريخ الشيك' value='' required></td>\
    <td><input type='text' autocomplete='off' id='check_value"+i+"' name='check_value"+i+"' placeholder='قيمة الشيك' value='' required></td>\
    <td>"+currency+"</td>\
    <td><input type='text' autocomplete='off' id='exchange_rate"+i+"' name='exchange_rate"+i+"' placeholder='سعر الصرف' value=''></td>\
    <td><input type='file' name='check_image"+i+"' id='check_image"+i+"'></td>\
</tr>";
$('.check_list').append(tr_content);
$('.check_date').datepicker();

$('#select_bank0').attr("name","select_bank"+i);$('#select_bank0').attr("id","select_bank"+i);
$('#select_cur0').attr("name","select_cur"+i);$('#select_cur0').attr("id","select_cur"+i);
document.getElementById("checks_count").value=i;
window.scrollTo(0,document.body.scrollHeight);
}

/*حذف شيك من الجدول*/
function delete_check(i,id){
/*<span class='delete_check' id='delete_el".$i."' onclick='delete_check(".$i.")'></span>
<span class='delete_check delinp' id='delete_el"+i+"' onclick='delete_check("+i+")'></span>*/
var count=parseInt(document.getElementById("checks_count").value);
$("#check"+i).remove();
var ch_id=0;
for(i2=i+1;i2<=count;i2++){
i3=i2-1;

/* var myEle =document.getElementById("this_check_id"+i2);
    if(myEle){
     ch_id= myEle.value;
     delete_check_from_database(ch_id);
     $("#this_check_id"+i2).attr("name","this_check_id"+i3);$("#this_check_id"+i2).attr("id","this_check_id"+i3);
    }*/
$('#check'+i2).attr("id","check"+i3);
$('#delete_el'+i2).attr("onclick","delete_check("+i3+","+ch_id+")");$('#delete_el'+i2).attr("id","delete_el"+i3);
$("#check_num"+i2).attr("name","check_num"+i3);$("#check_num"+i2).attr("id","check_num"+i3);
$("#check_date"+i2).attr("name","check_date"+i3);$("#check_date"+i2).attr("id","check_date"+i3);
$("#check_value"+i2).attr("name","check_value"+i3);$("#check_value"+i2).attr("id","check_value"+i3);
$("#exchange_rate"+i2).attr("name","exchange_rate"+i3);$("#exchange_rate"+i2).attr("id","exchange_rate"+i3);
$("#check_image"+i2).attr("name","check_image"+i3);$("#check_image"+i2).attr("id","check_image"+i3);
$("#select_cur"+i2).attr("name","select_cur"+i3);$("#select_cur"+i2).attr("id","select_cur"+i3);
$("#select_bank"+i2).attr("name","select_bank"+i3);$("#select_bank"+i2).attr("id","select_bank"+i3);

}
$('.check_date').datepicker("destroy");
$('.check_date').datepicker();
document.getElementById("checks_count").value=count-1;

}

/*function delete_check_from_database(id){
$.get("ajax_expense.php?search=revenue_customer&id="+id, function(data){

});
}*/

/*جلب شيكات الزبائن*/
function find_check_by_num(){

var num= document.getElementById("check_num_search").value;
if(num!=''){
$.get("ajaxbills.php?find_check=num&func=get_check_details&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_check_num').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}

/*جلب معلومات الشيك والزبون*/
function get_check_details(check_id,revenue_id){

$.get("ajaxbills.php?find_check=check_details&id="+check_id+"&revenue_id="+revenue_id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.show_hide').remove();
$('.check_list').append(data);
});
}

/*------------حذف سند قبض غير مرحل--------------*/
function remove_temp_rev(id){
var c=confirm('هل تريد الحذف ؟');
if(c){mymodalbox("الحذف","ajaxbills.php?find_check=delete_temp_rev&id="+id+"",1);}
}
/*------------- اخفاء واظهار السندات غير المرحله حسب المندوب -----------------*/
function show_hide_temp_rev(){
var id=document.getElementById("select_salesmantemp").value;
var count_element=$('.'+id).length;
var total_check=0;
var total_cash=0;
var total_discount=0;

if(count_element>0){

$('.'+id).each(function(i, obj) {
total_cash+=parseFloat($(this).data("cash"));
total_discount+=parseFloat($(this).data("discount"));
total_check+=parseFloat($(this).data("check"));
});

$('.no_resault').hide();$('.show_hide').show();$('.show_hide').hide();
$('.'+id).show('fade');
$('#temp_total_cash').html(total_cash);
$('#temp_total_check').html(total_discount);
$('#temp_total_discount').html(total_check);
$('#temp_total').show();

}
else {$('.show_hide').hide();$('.no_resault').hide();$('.form_main').append("<div class='no_resault'>لا يوجد سندات غير مرحلة لهذا المندوب</div>");}

$("#selectall").prop('checked',false);
select_deselect_all();
var saves=document.getElementsByClassName('saveit');
var saveth=document.getElementsByClassName('ss'+id);
for (var i5 = 0;i5<saves.length;i5++) {saves[i5].name='nosave';}
for (var i5 = 0;i5<saveth.length;i5++) {saveth[i5].name='saveit';}
}
/*------------- اخفاء واظهار السندات غير المرحله حسب المندوب -----------------*/
function show_hide_rev(){
var id=document.getElementById("select_salesmansearch").value;
var count_element=$('.'+id).length;
var total_check=0;
var total_cash=0;
var total_discount=0;
var total_count=0;

$('#temp_total_cash').html('');
$('#temp_total_check').html('');
$('#temp_total_discount').html('');
$('#check_count_all').html('');
if(count_element>0){

$('.'+id).each(function() {
total_cash+=parseFloat($(this).data("cash"));
total_discount+=parseFloat($(this).data("check"));
total_check+=parseFloat($(this).data("discount"));
total_count+=parseFloat($(this).data("chcount"));

});

$('.no_resault').hide();$('.show_hide').show();$('.show_hide').hide();
$('.'+id).show('fade');
$('#temp_total_cash').html(total_cash);
$('#temp_total_check').html(total_discount);
$('#temp_total_discount').html(total_check);
$('#check_count_all').html(total_count);
$('#temp_total').show();

}
else {$('.show_hide').hide();$('.no_resault').hide();$('.form_main').append("<div class='no_resault'>لا يوجد سندات غير مرحلة لهذا المندوب</div>");}

}
/*----------- جلب جميع السندات في شهر معين---------------*/
function get_records_by_monthyear(){
var month=document.getElementById("search_expense_month").value;
var year=document.getElementById("search_expense_year").value;

if(month!=0 && year!=0){
$('#salesmans').show('fade');
document.getElementById("s_customer_name").value='';
document.getElementById('select_salesmansearch').value='n';
document.getElementById("revenues_append").innerHTML='';
$.get("ajax_expense.php?search=revenue_month_year&month="+month+"&year="+year, function(data){
$('.no_resault').hide();
$('#revenues_append').append(data);
});

}

}