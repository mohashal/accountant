/*جلب معلومات الزبون */
function bill_customer_search(){

var name= document.getElementById("bill_customer_search").value;
if(name!=''){
$.get("ajax.php?search_customers=name&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_name').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
/*جلب فواتير الزبون*/
function bill_customer_search2(){

var name= document.getElementById("bill_customer_search2").value;
if(name!=''){
$.get("ajax.php?search_customers=name&q=1&func=get_customer_bills&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_name').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}
/*-------------------- get this customer saved bills ----------------------*/
function get_customer_bills(name,main,id){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
document.getElementById("bill_customer_search2").value=name;

$.get("ajaxbills.php?find_bills=name&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}
/*-------------------- get bills from selected date ----------------------*/
function search_bill_date(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var date=document.getElementById("bill_date_search").value;

$.get("ajaxbills.php?find_bills=date&date="+date, function(data){
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

$.get("ajaxbills.php?find_bills=num&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}
/*-------------------- get bills from bill num ----------------------*/
function search_taxbill_num(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var num=document.getElementById("taxbill_num_search").value;

$.get("ajaxbills.php?find_bills=taxnum&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}
/*-------------------- get bills from bill num ----------------------*/
function search_sentbill_num(){
$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();$('.msg').remove();
var num=document.getElementById("sentbill_num_search").value;

$.get("ajaxbills.php?find_bills=sentnum&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.products_list').remove();
$('.bill_list_show').append(data);
});

}
/*-------------------- remove search and products div ---------------------*/
function remove_divs(){
$('.product_auto_search_barcode').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
}
/*------------------------- get customer info -----------------------------*/
function get_this_customer(id){
document.getElementById("debt_note").innerHTML='';
$('#debt_note').hide();
$.get("ajaxbills.php?search_bills=name&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
var customer=JSON.parse(data);
if(parseInt(customer.balance)<0){$('#show_balance').css("color", "red");}
else{$('#show_balance').css("color", "green");}
document.getElementById("bill_customer_search").value=customer.name;
document.getElementById("show_area").innerHTML=customer.area_name;
document.getElementById("show_sale").innerHTML=customer.sale_name;
document.getElementById("show_balance").innerHTML=customer.balance+' شيكل';
document.getElementById("bill_store_id").value=customer.id;
document.getElementById("bill_sales_id").value=customer.sales_man_id;
document.getElementById("bill_price").value=customer.sale_price;
document.getElementById("custom_price").value=customer.custom_price;

$('.bill_product_show').show();
});

$.get("ajax_expense.php?search=debt-customer&id="+id, function(data){
if(data!=''){
$('#debt_note').show();
document.getElementById("debt_note").innerHTML=data;
}
});

}
/*-------------------- search products by name  ----------------------- */
function bill_product_search(){
var name=document.getElementById("bill_product_search").value;
if(name!=''){
$.get("ajaxbills.php?search_bills=name_search&name="+name, function(data){
remove_divs();
$('#search_product_name').append(data);
});}
else{remove_divs();}
}
/*-------------------- search products by name  ----------------------- */
function bill_product_search_num(){
var num=document.getElementById("bill_product_search_num").value;
if(num!=''){
$.get("ajaxbills.php?search_bills=num_search&num="+num, function(data){
remove_divs();
$('#search_product_num').append(data);
});}
else{remove_divs();}
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
/*---------------------- get one product by id -------------------------*/
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
//$('.products_list').append(data);
sum_total();
if(custom_price.hasOwnProperty(id)){
document.getElementById("product_price"+num).value=custom_price[id];
change_total(num);
}

//$('.bill_form_products').append(data);
//window.scrollTo(0,document.body.scrollHeight);

});
}
/*--------------------------- get offers product -----------------------*/
function get_offer_by_id(id,nums){
var num=parseInt(document.getElementById("bill_product_nums").value);
nums=parseInt(nums);
document.getElementById("bill_search_offer").value='';

$.get("ajaxbills.php?search_bills=offer-product&id="+id+"&num="+num, function(data){
document.getElementById("bill_product_search").value='';
$('.product_auto_search_name').remove();
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
document.getElementById("bill_product_nums").value=num+nums;
$('.table_head').after(data);
//$('.products_list tr').prepend(data);

sum_total();

//window.scrollTo(0,document.body.scrollHeight);

});
}
/*------------------- search offer by name ---------------------- */
function search_offer_name(){
var name=document.getElementById("bill_search_offer").value;
if(name!=''){
$.get("ajaxbills.php?search_bills=offer_name&name="+name, function(data){
remove_divs();
$('#search_offer_name').append(data);
});}
else{remove_divs();}
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
total=roundd(total,2);
document.getElementById("show_final_total").innerHTML=total;
document.getElementById("bill_balance").value=total;
}
/*---------------------------- change total and final total --------------*/
function change_total(num){
var quantity=parseFloat(document.getElementById('product_quantity'+num).value);
var price=parseFloat(document.getElementById('product_price'+num).value);
var our_price=parseFloat(document.getElementById('product_our_price'+num).value);

if(price>=our_price){
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
else{$('.error_price').remove();$('#pru'+num).append("<div class='error_price'>لا يمكنك اختيار سعر اقل من راس المال</div>");}

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

/*----------------- remove temp bill --------------------*/
function remove_temp_bill(id){
var c=confirm('هل تريد حذف هذه الطلبية؟');
if(c){login_modal("ازالة طلبية","ajaxbills.php?update_temp_bills=del&id="+id);}

}
/*------------ اظهار الفواتير الغير مرحلة لمندوب معين --------*/
function select_sale(){
var i=document.getElementById('select_salesman').value;
var total=document.getElementsByClassName('total'+i);
var pr=document.getElementsByClassName('pr'+i);
var total2=0;
var pr2=0;
for (var i5 = 0;i5<total.length;i5++) {var total2=total2+parseFloat(total[i5].innerHTML);}
for (var i5 = 0;i5<pr.length;i5++) {var pr2=pr2+parseFloat(pr[i5].innerHTML);}
$('.no_resault').hide();
$('.show_hide').hide();

var count_element=$('.'+i).length;
total2=roundd(total2,2);
pr2=roundd(pr2,2);
if(count_element>0){$('.'+i).show();$('.bil').html(total.length);$('.totals').html(total2);$('.prs').html(pr2);}
else{$('.show_hide').hide();$('.no_resault').hide();$('.bil').html('');$('.totals').html('');$('.prs').html('');$('.form_main').append("<div class='no_resault'>لا يوجد فواتير غير مرحلة لهذا المندوب</div>");}

$("#selectall").prop('checked',false);
select_deselect_all();
var saves=document.getElementsByClassName('saveit');
var saveth=document.getElementsByClassName('ss'+i);
for (var i5 = 0;i5<saves.length;i5++) {saves[i5].name='nosave';}
for (var i5 = 0;i5<saveth.length;i5++) {saveth[i5].name='saveit';}

}

/*----------------------------------*/
/*function getCheckedCheckboxesFor(checkboxName) {
    var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
    Array.prototype.forEach.call(checkboxes, function(el) {
        values.push(el.value);
    });
    return values;
}*/