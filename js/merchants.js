/*-----------جلب التجار حسب الاسم----------*/
function merchant_search(){
var name= document.getElementById("merchant_name").value;
if(name!=''){
$.get("ajax.php?search_merchant=name&func=set_merchant_info&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#merchant_search').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}

function set_merchant_info(id,name){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();
document.getElementById("merchant_name").value=name;
document.getElementById("merchant_id").value=id;
$('.bill_product_show').show('fade');
}
/*------------------- search products by barcode ---------------------- */
function search_product_barcode(){
var barcode=document.getElementById("bill_product_search_barcode").value;
if(barcode!=''){
$.get("ajaxbills.php?search_bills=barcode_search&barcode="+barcode, function(data){
remove_divs();
$('#search_product_barcode').append(data);
});}
else{remove_divs();}
}
/*-------------------- search products by name  ----------------------- */
function bill_product_search(){
var name=document.getElementById("bill_product_search").value;
if(name!=''){
$.get("ajaxbills.php?search_bills=name_search&no=1&name="+name, function(data){
remove_divs();
$('#search_product_name').append(data);
});}
else{remove_divs();}
}
/*-------------------- search products by name  ----------------------- */
function bill_product_search_num(){
var num=document.getElementById("bill_product_search_num").value;
if(num!=''){
$.get("ajaxbills.php?search_bills=num_search&no=1&num="+num, function(data){
remove_divs();
$('#search_product_num').append(data);
});}
else{remove_divs();}
}
/*---------------------- get one product by id -------------------------*/
function get_product_by_id(id){
document.getElementById("bill_product_search_num").value='';
var num=parseInt(document.getElementById("bill_product_nums").value);
num=num+1;
var price=document.getElementById("bill_price").value;
$.get("ajaxbills.php?search_bills=product&id="+id+"&num="+num+"&price="+price, function(data){
document.getElementById("bill_product_search").value='';
$('.product_auto_search_name').remove();
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
document.getElementById("bill_product_nums").value=num;
$('.table_head').after(data);
//$('.bill_form_products').append(data);
sum_total();



});
}
/*----------------------------- sum all product_total ------------------*/
function sum_total(){
var num=document.getElementById("bill_product_nums").value;
num=parseFloat(num);
var t2='';
var total=0;
var t1;
for(i=1;i<=num;i++){
t2='product_total'+i;
t1=document.getElementById(t2).innerHTML;
t1=parseFloat(t1);
total+=t1;
}
document.getElementById("show_final_total").innerHTML=roundd(total,2);
document.getElementById("bill_balance").value=roundd(total,2);
}
/*---------------------------- change total and final total --------------*/
function change_total(num){
var quantity=parseFloat(document.getElementById('product_quantity'+num).value);
var price=parseFloat(document.getElementById('product_price'+num).value);
var our_price=parseFloat(document.getElementById('product_our_price'+num).value);


if(document.getElementById('product_bonus'+num).checked){
document.getElementById('product_total'+num).innerHTML=0;
sum_total();
$('.error_price').remove();
}
else {var total=roundd(price*quantity,2);
document.getElementById('product_total'+num).innerHTML=total;
sum_total();
$('.error_price').remove();
}



}
/*---------------- check bonus and change total---------------*/
function check_bonus(num){

if(document.getElementById('product_bonus'+num).checked){
document.getElementById('product_total'+num).innerHTML=0;
sum_total();
$('.error_price').remove();
}

else{
change_total(num);
}

}
/*--------------- round floats ------------------------------*/
function roundd(value, decimals) {
  return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}
/*---------------- delete product from bill form -------------------*/
function del_product(num){
$('#product'+num).remove();
var i2=0;
var nums=document.getElementById("bill_product_nums");
for(i=num+1;i<=nums.value;i++){
i2=i-1;
$('#product'+i).attr("id","product"+i2);
$('#product_offer'+i).attr("name","product_offer"+i2);$('#product_offer'+i).attr("id","product_offer"+i2);
$('#product_id'+i).attr("name","product_id"+i2);$('#product_id'+i).attr("id","product_id"+i2);
$('#product_ids'+i).attr("name","product_ids"+i2);$('#product_ids'+i).attr("id","product_ids"+i2);
$('#product_unit'+i).attr("name","product_unit"+i2);$('#product_unit'+i).attr("id","product_unit"+i2);
$('#product_sale_price'+i).attr("name","product_sale_price"+i2);$('#product_sale_price'+i).attr("id","product_sale_price"+i2);
$('#product_bonus'+i).attr("onclick","check_bonus("+i2+")");$('#product_bonus'+i).attr("name","product_bonus"+i2);$('#product_bonus'+i).attr("id","product_bonus"+i2);
$('#product_our_price'+i).attr("name","product_our_price"+i2);$('#product_our_price'+i).attr("id","product_our_price"+i2);
$('#product_name'+i).attr("name","product_name"+i2);$('#product_name'+i).attr("id","product_name"+i2);
$('#del_pro'+i).attr("onclick","del_product("+i2+")");$('#del_pro'+i).attr("id","del_pro"+i2);
$('#product_quantity'+i).attr("oninput","change_total("+i2+")");$('#product_quantity'+i).attr("name","product_quantity"+i2);$('#product_quantity'+i).attr("id","product_quantity"+i2);
$('#pru'+i).attr("id","pru"+i2);
$('#product_price'+i).attr("oninput","change_total("+i2+")");$('#product_price'+i).attr("name","product_price"+i2);$('#product_price'+i).attr("id","product_price"+i2);
$('#product_total'+i).attr("id","product_total"+i2);
}
nums.value-=1;
sum_total();
}
/*-------------------- remove search and products div ---------------------*/
function remove_divs(){
$('.product_auto_search_barcode').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
}
/*ازالة فاتورة غير مرحلة*/
function remove_merchant_temp_bill(id){
var c=confirm('هل تريد حذف هذه الفاتورة ؟');
if(c){login_modal("ازالة فاتورة","ajaxbills.php?update_temp_bills=merchant-del&id="+id);}
}
function remove_merchant_rettemp_bill(id){
var c=confirm('هل تريد حذف هذه الفاتورة ؟');
if(c){login_modal("ازالة فاتورة","ajaxbills.php?update_temp_bills=retmerchant-del&id="+id);}
}
/**/
function check_merchant_search(){

var name= document.getElementById("search_merchant_name").value;

if(name!=''){
$.get("ajax.php?search_merchant=name&q=1&func=set_merchant_info2&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_customer').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
/*وضع ايدي الزبون في حقل ايدي المخفي*/
function set_merchant_info2(id,name){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
document.getElementById("search_merchant_name").value=name;
document.getElementById("merchant_id").value=id;
monthly_yearly();
}

function monthly_yearly(){
var year_check=document.getElementById("is_yearly").checked;
var month_check=document.getElementById("is_monthly").checked;

if(year_check){
document.getElementById("statment_print").href='';
$('.monthly').hide();
$('#yearly').show();
yearly();
}

if(month_check){
document.getElementById("statment_print").href='';
$('#yearly').hide();
$('.monthly').show();
monthly();
}
}

/*monthly_show*/
function monthly(){
var id=document.getElementById("merchant_id").value;
var month_from=document.getElementById("date1").value;
var month_to=document.getElementById("date2").value;

if(month_from!='' && month_to!='' && id!=''){
document.getElementById("statment_print").href='printbills.php?print_statment=month_merchant&id='+id+'&mfrom='+month_from+'&mto='+month_to;
}
}

/*yearly_show*/
function yearly(){
var id=document.getElementById("merchant_id").value;
var year=document.getElementById("select_yearyearly").value;
if(year!='' && id!=''){
document.getElementById("statment_print").href='printbills.php?print_statment=year_merchant&id='+id+'&year='+year;
}
}

/*-------------------- get returned from selected date ----------------------*/
function search_bills_date(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var date=document.getElementById("bill_date").value;
$.get("ajaxbills.php?find_merchant_bill=date&date="+date, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}
function search_retbills_date(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var date=document.getElementById("bill_date").value;
$.get("ajaxbills.php?find_merchant_bill=retdate&date="+date, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}
/*-------------------- get bills from bill num ----------------------*/
function search_bill_num(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var num=document.getElementById("bill_num_search").value;

$.get("ajaxbills.php?find_merchant_bill=num&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}

function search_retbill_num(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var num=document.getElementById("bill_num_search").value;

$.get("ajaxbills.php?find_merchant_bill=retnum&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}

/*-----------جلب التجار حسب الاسم----------*/
function merchant_search2(func){
var name= document.getElementById("merchant_name2").value;
if(name!=''){
$.get("ajax.php?search_merchant=name&func="+func+"&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#merchant_search').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
function merchant_search3(func){
var name= document.getElementById("merchant_name3").value;
if(name!=''){
$.get("ajax.php?search_merchant=name&func="+func+"&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#merchant_search').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}

/*---------- البحث عن طلبية من التاجر حسب اسم التاجر ------------*/
function get_bill_merchant(id,name){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
document.getElementById("merchant_name2").value=name;

$.get("ajaxbills.php?find_merchant_bill=name&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});
}

function get_retbill_merchant(id,name){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
document.getElementById("merchant_name3").value=name;

$.get("ajaxbills.php?find_merchant_bill=retname&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});
}