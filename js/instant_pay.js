/*---------------------- get one product by id -------------------------*/
function get_product_by_id(id){
var num=parseInt(document.getElementById("bill_product_nums").value);


document.getElementById("bill_product_search_num").value='';
document.getElementById("bill_product_search_barcode").value='';

num=num+1;
var price=document.getElementById("bill_price").value;
$.get("ajaxbills.php?search_bills=product&id="+id+"&num="+num+"&price="+price, function(data){
document.getElementById("bill_product_search").value='';
$('.product_auto_search_name').remove();
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
document.getElementById("bill_product_nums").value=num;
$('.table_head').after(data);
sum_total();

//$('.bill_form_products').append(data);

});
}

/*change between normal customer and merchant*/
function show_hide_customer_merchant(){
var customer=document.getElementById("is_customer");
var merchant=document.getElementById("is_merchant");
var partner=document.getElementById("is_partner");
var employee=document.getElementById("is_employee");

if(merchant.checked){
$('#show_hide_customer').hide();$('#show_hide_merchant').show();
$('#show_hide_employee').hide();$('#show_hide_partner').hide();
$('#merchant_balance').show();document.getElementById("customer_name").value='';
document.getElementById("select_employee").value=0;
document.getElementById("select_partner").value=0;
}
if(customer.checked){
$('#show_hide_merchant').hide();$('#merchant_balance').hide();
$('#show_hide_employee').hide();$('#show_hide_partner').hide();
$('#show_hide_customer').show();
document.getElementById("show_balance").innerHTML='';
document.getElementById("merchant_name").value='';
document.getElementById("merchant_id").value=0;
document.getElementById("select_employee").value=0;
document.getElementById("select_partner").value=0;
}
if(partner.checked){
$('#show_hide_customer').hide();$('#show_hide_merchant').hide();
$('#show_hide_employee').hide();$('#show_hide_partner').show();
$('#merchant_balance').hide();document.getElementById("customer_name").value='';
document.getElementById("show_balance").innerHTML='';
document.getElementById("merchant_name").value='';
document.getElementById("merchant_id").value=0;
document.getElementById("select_employee").value=0;

}
if(employee.checked){
$('#show_hide_customer').hide();$('#show_hide_merchant').hide();$('#show_hide_employee').show();$('#show_hide_partner').hide();
$('#merchant_balance').hide();document.getElementById("customer_name").value='';
document.getElementById("show_balance").innerHTML='';
document.getElementById("merchant_name").value='';
document.getElementById("merchant_id").value=0;
document.getElementById("select_partner").value=0;
}
}

/*-----------جلب التجار حسب الاسم----------*/
function merchant_search(){
var name= document.getElementById("merchant_name").value;
if(name!=''){
$.get("ajax.php?search_merchant=name&func=set_to_bill&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#merchant_search').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
/*-----------جلب التجار حسب الاسم----------*/
function merchant_search2(){
var name= document.getElementById("merchant_name2").value;
if(name!=''){
$.get("ajax.php?search_merchant=name&func=get_bill_merchant&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#merchant_search').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}

function set_to_bill(id,name,balance){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();
document.getElementById("merchant_name").value=name;
document.getElementById("merchant_id").value=id;
document.getElementById("show_balance").innerHTML=balance;
document.getElementById("select_partner").value=0;
document.getElementById("select_employee").value=0;
$('.bill_product_show').show('fade');
}
/*-------------------- get returned from selected date ----------------------*/
function search_instant_date(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var date=document.getElementById("bill_date").value;
$.get("ajaxbills.php?find_instant=date&date="+date, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
document.getElementById("select_partner").value=0;
document.getElementById("select_employee").value=0;
$('.bill_list_show').append(data);
});

}
/*-------------------- get bills from bill num ----------------------*/
function search_bill_num(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var num=document.getElementById("bill_num_search").value;

$.get("ajaxbills.php?find_instant=num&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
document.getElementById("select_partner").value=0;
document.getElementById("select_employee").value=0;
$('.bill_list_show').append(data);
});

}
function get_bill_merchant(id,name){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
document.getElementById("merchant_name2").value=name;

$.get("ajaxbills.php?find_instant=name&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
document.getElementById("select_partner").value=0;
document.getElementById("select_employee").value=0;
$('.bill_list_show').append(data);
});
}

function remove_instant_bill(id){
var c=confirm('هل تريد حذف هذه الطلبية؟');
if(c){login_modal("ازالة طلبية","ajaxbills.php?update_temp_bills=del_inst&id="+id);}
}

function search_instant_pay_partner(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var id=document.getElementById("select_partner").value;
$.get("ajaxbills.php?find_instant=partner&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
document.getElementById("select_employee").value=0;
$('.bill_list_show').append(data);
});
}

function search_instant_pay_employee(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var id=document.getElementById("select_employee").value;
$.get("ajaxbills.php?find_instant=employee&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
document.getElementById("select_partner").value=0;
$('.bill_list_show').append(data);
});
}