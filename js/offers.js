/*---------------------- get one product by id -------------------------*/
function get_product_by_id(id){
var num=parseInt(document.getElementById("bill_product_nums").value);


document.getElementById("bill_product_search_num").value='';
num=num+1;
var price=document.getElementById("bill_price").value;
$.get("ajaxbills.php?search_bills=product&id="+id+"&num="+num+"&price="+price, function(data){
document.getElementById("bill_product_search").value='';
$('.product_auto_search_name').remove();
$('.customer_auto_search_name').remove();
$('.auto_search_msg').remove();
document.getElementById("bill_product_nums").value=num;
$('.products_list').append(data);
/*$('.table_head').after(data);*/
sum_total();

//$('.bill_form_products').append(data);
window.scrollTo(0,document.body.scrollHeight);

});
}

function remove_offer(id){
var c=confirm('هل تريد حذف هذه الطلبية؟');
if(c){login_modal("ازالة طلبية","ajaxbills.php?update_temp_bills=offer_del&id="+id);}
}