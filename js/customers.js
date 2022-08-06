/*get customers */
function get_costomers_sale_day(){
var sale= document.getElementById("select_salesman").value;
var day=document.getElementById('select_visit_day').value;

if(sale!=='' && day!==''){
$.get("ajax.php?search_customers=all&day="+day+"&sale=+"+sale, function(data){
$('.customers_list').remove();
$('.customer_details_in').remove();
$('.customer_search_show').append(data);
});
}

}
/*-------------------- remove search and products div ---------------------*/
function remove_divs(){
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
}
/*-------------------- search products by name  ----------------------- */
function search_customer_name(){
var name= document.getElementById("customer_name_search").value;
if(name!=''){
$.get("ajax.php?search_customers=name&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.product_search_select').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}
}
/*-------------------- search products by name  ----------------------- */
function search_customer_name2(){
var name= document.getElementById("customer_name_search2").value;
if(name!=''){
$.get("ajax.php?search_customers=name&j=2&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#name_search2').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}
}
function get_this_customer2(name,id){
document.getElementById('is_branch').value=id;
document.getElementById('customer_name_search2').value=name;
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
}
/*----------------------- get one customer details -----------*/
function get_this_customer(id){

$.get("ajax.php?search_customers=one&in&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.customers_list').remove();
$('.customer_details').remove();
$('.customer_details_in').remove();
$('.customer_search_show').append(data);
});
}
/*------------------- show hide main_branch -----------------*/
function show_hide_branch_search(){
$('#search_main').fadeToggle();
}

/*-----------جلب الزبائن حسب الاسم----------*/
function check_customer_search(){

var name= document.getElementById("search_customer_name").value;

if(name!=''){
$.get("ajax.php?search_customers=name&q=1&func=set_customer_info&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_customer').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
/*وضع ايدي الزبون في حقل ايدي المخفي*/
function set_customer_info(name,main,id){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
document.getElementById("search_customer_name").value=name;
document.getElementById("customer_id").value=id;
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
var id=document.getElementById("customer_id").value;
var month_from=document.getElementById("date1").value;
var month_to=document.getElementById("date2").value;
if(month_from!='' && month_to!='' && id!=''){
document.getElementById("statment_print").href='printbills.php?print_statment=month&id='+id+'&mfrom='+month_from+'&mto='+month_to;
}
}

/*yearly_show*/
function yearly(){
var id=document.getElementById("customer_id").value;
var year=document.getElementById("select_yearyearly").value;
if(year!='' && id!=''){
document.getElementById("statment_print").href='printbills.php?print_statment=year&id='+id+'&year='+year;
}
}