/*جلب فواتير الزبون*/
function b_customer_search(){
var name= document.getElementById("customer_name").value;

if(name!=''){
$.get("ajax.php?search_customers=name&q=1&func=set_customer&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#customer_search').append(data);

});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
/*-------------------- get this customer saved bills ----------------------*/
function set_customer(name,main,id){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
document.getElementById("customer_name").value=name;
document.getElementById("customer_id").value=id;
$('.product_auto_search_name').remove();

}

/*ازالة فاتورة غير مرحلة*/
function remove_returned_temp_bill(id){
var c=confirm('هل تريد حذف هذه الفاتورة ؟');
if(c){login_modal("ازالة فاتورة","ajaxbills.php?update_temp_bills=returned-del&id="+id);}
}

/*-------------------- search products by name  ----------------------- */
function bill_product_search2(){
var name=document.getElementById("bill_product_search").value;
if(name!=''){
$.get("ajaxbills.php?search_bills=name_search&name="+name+"&no=1", function(data){
remove_divs();
$('#search_product_name').append(data);
});}
else{remove_divs();}
}
/*-------------------- search products by name  ----------------------- */
function bill_product_search_num2(){
var num=document.getElementById("bill_product_search_num").value;
if(num!=''){
$.get("ajaxbills.php?search_bills=num_search&num="+num+"&no=1", function(data){
remove_divs();
$('#search_product_num').append(data);
});}
else{remove_divs();}
}
/*-------------------- get returned from selected date ----------------------*/
function search_returned_date(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var date=document.getElementById("bill_date").value;
$.get("ajaxbills.php?find_returned=date&date="+date, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}

function search_returned_sale(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var id=document.getElementById("select_salesman").value;
$.get("ajaxbills.php?find_returned=sale&id="+id, function(data){
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

$.get("ajaxbills.php?find_returned=num&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}
function get_customer_bills(name,main,id){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
document.getElementById("bill_customer_search2").value=name;

$.get("ajaxbills.php?find_returned=name&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}
function get_product_by_id(id){
var num=parseInt(document.getElementById("bill_product_nums").value);
var custom_price=JSON.parse(document.getElementById("custom_price").value);
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
if(custom_price.hasOwnProperty(id)){
document.getElementById("product_price"+num).value=custom_price[id];
change_total(num);
}


});
}