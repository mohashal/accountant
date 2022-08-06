/*جلب شيكات الزبون*/
function find_check_by_num(){

var num= document.getElementById("check_num_search").value;
if(num!=''){
$.get("ajaxbills.php?find_check=num3&func=get_check_details&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_check_num').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}


function find_our_check_by_num(){

var num= document.getElementById("our_check_num_search").value;
if(num!=''){
$.get("ajaxbills.php?find_check=our_num&func=get_our_check_details&num="+num, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_check_num').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}

function find_check_by_date(){
var month=document.getElementById("select_month_check").value;
var year=document.getElementById("select_year_check").value;
if(month!='' && year!=''){
$.get("ajaxbills.php?find_check=check_date&month="+month+"&year="+year, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.show_hide').remove();
$('#check_list').append(data);
});
}
}

function find_our_check_by_date(){
var month=document.getElementById("select_month_check").value;
var year=document.getElementById("select_year_check").value;
if(month!='' && year!=''){
$.get("ajaxbills.php?find_check=our_check_date&month="+month+"&year="+year, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.show_hide').remove();
$('#check_list').append(data);
});
}
}


/*جلب معلومات الشيك والزبون*/
function get_check_details(check_id,revenue_id){
document.getElementById("check_num_search").value='';
document.getElementById("check_customer_name").value='';
document.getElementById("check_merchant_name").value='';
$.get("ajaxbills.php?find_check=check_details&id="+check_id+"&revenue_id="+revenue_id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.show_hide').remove();
$('#check_list').append(data);
});
}

/*جلب معلومات الشيك والزبون*/
function get_our_check_details(check_id){
document.getElementById("our_check_num_search").value='';
$.get("ajaxbills.php?find_check=our_check_details&id="+check_id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.show_hide').remove();
$('#check_list').append(data);
});
}

function select_check_date(){
var date=document.getElementById("select_date").value;
var cl=document.getElementsByClassName(date);
var final=0;
for (var i = 0; i < cl.length; i++) {
cl[i].childNodes[1].innerHTML=i+1;
final+=parseFloat(cl[i].childNodes[11].innerHTML)*parseFloat(cl[i].childNodes[15].innerHTML);
}
$('.show_hide').hide();
$('.'+date).show();
document.getElementById("final_total").innerHTML=final+" شيكل";
}

function search_customer_name(){

var name= document.getElementById("check_customer_name").value;
if(name!=''){
$.get("ajax.php?search_customers=name&q=1&func=set_check_customer&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_customer').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}

function search_merchant_name(){
var name= document.getElementById("check_merchant_name").value;
if(name!=''){
$.get("ajax.php?search_merchant=name&func=set_check_merchant&name="+name, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('#search_merchant').append(data);
});}
else{$('.customer_auto_search_name').remove();$('.auto_search_msg').remove();}

}

function set_check_customer(name,mainid,id){
document.getElementById("check_customer_name").value=name;
document.getElementById("check_merchant_name").value='';
$.get("ajaxbills.php?find_check=check_details_cus&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.show_hide').remove();
$('#check_list').append(data);
});
}

function set_check_merchant(id,name){
document.getElementById("check_merchant_name").value=name;
document.getElementById("check_customer_name").value='';
$.get("ajaxbills.php?find_check=check_details_mer&id="+id, function(data){
$('.customer_auto_search_name').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
$('.show_hide').remove();
$('#check_list').append(data);
});
}

function remove_check_from_expense(id){
login_modal("ترحيل","ajax.php?checks=remove_check&id="+id);
}

function remove_our_check_from_expense(id){
login_modal("ترحيل","ajax.php?checks=remove_our_check&id="+id);
}