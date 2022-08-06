/*-------------------- remove search and products div ---------------------*/
function remove_divs(){
$('.product_auto_search_barcode').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
}
/*-------------------- search products by name  ----------------------- */
function product_search(){
var name=document.getElementById("product_name").value;
if(name!=''){
$.get("ajaxbills.php?search_bills=name_search&name="+name, function(data){
remove_divs();
$('#search_name').append(data);
});}
else{remove_divs();}
}
/*------------------------- get product by id -------------------------*/
function get_product_by_id(id){
$.get("ajax_reports.php?search_product=id&id="+id, function(data){
remove_divs();
var product=JSON.parse(data);
document.getElementById("product_name").value=product.name;
document.getElementById("product_num").value=product.id2;
document.getElementById("product_id").value=product.id;
});
}
/*-------------------- search products by name  ----------------------- */
function product_search_num(){
var num=document.getElementById("product_num").value;
if(num!=''){
$.get("ajaxbills.php?search_bills=num_search&num="+num, function(data){
remove_divs();
$('#search_num').append(data);
});}
else{remove_divs();}
}