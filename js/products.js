/*-------------------search products by category---------------------- */
function search_product_cat(){
var cat= document.getElementById("select_category").value;

$.get("ajax.php?search_product=cat&cat="+cat, function(data){
$('.product_list').remove();
remove_divs();
$('.product_details_in').remove();
$('.product_search_show').append(data);
});
}
/*-------------------- remove search and products div ---------------------*/
function remove_divs(){
$('.product_auto_search_barcode').remove();
$('.product_auto_search_name').remove();
$('.auto_search_msg').remove();
}
/*-------------------- search products by name  ----------------------- */
function search_product_name(){
var name= document.getElementById("product_name_search").value;
if(name!=''){
$.get("ajax.php?search_product=name&name="+name, function(data){
remove_divs();
$('#search_name').append(data);
});}
else{remove_divs();}
}
/*-------------------- search products by num  ----------------------- */
function search_product_num(){
/*$.get("ajaxbills.php?search_bills=num_search&no=1&num="+num, function(data){*/
var num=document.getElementById("product_num_search").value;
if(num!=''){
$.get("ajax.php?search_product=num&num="+num, function(data){
remove_divs();
$('#search_num').append(data);
});}
else{remove_divs();}
}
/*------------------- search products by barcode ---------------------- */
function search_product_barcode(){
var barcode= document.getElementById("barcode_search").value;
if(barcode!=''){
$.get("ajax.php?search_product=barcode&barcode="+barcode, function(data){
remove_divs();
$('#search_barcode').append(data);
});}
else{remove_divs();}
}
/*--------------------- get product by id ---------------------------*/
function get_product_by_id(id){
$.get("ajax.php?search_product=one&in&id="+id, function(data){
remove_divs();
$('.product_list').remove();
$('.product_details_in').remove();
$('.product_search_show').append(data);
});
document.getElementById("product_num_search").value='';
document.getElementById("barcode_search").value='';
document.getElementById("product_name_search").value='';
}
/*--------------------- get product by id ---------------------------*/
function get_product_by_id2(id){
$.get("ajax.php?search_product=one2&in&id="+id, function(data){
remove_divs();
$('.product_list').remove();
$('.product_details_in').remove();
$('.product_search_show').append(data);
});
document.getElementById("product_num_search").value='';
document.getElementById("barcode_search").value='';
document.getElementById("product_name_search").value='';
}
/*اضافة لون الى الصنف*/
function add_color(){
var num=parseInt(document.getElementById("is_colors").value);
num=num+1;
document.getElementById("is_colors").value=num;
var name="<input type='text' style='width:30%;' autocomplete='off' name='color_name"+num+"' placeholder='اسم البضاعة' value='' required>";
var quan="<input type='text' style='width:30%;' autocomplete='off' name='color_quan"+num+"' placeholder='الكمية' value='' required>";
var barcode="<input type='text' style='width:30%;' autocomplete='off' name='color_barcode"+num+"' placeholder='الباركود' value=''>";
var color_line="<div class='form_input_line'><div class='form_input_name nume'>"+num+"</div><div class='form_input_input'>"+name+" "+quan+" "+barcode+"</div></div>";
$('#colors').append(color_line);
}
function removebox(id,name,q,price){
var modal = document.getElementById("myModal");
modal.style.display = "none";$(".modal").remove();$("#modal_script").remove();
$("#q"+id).html(q);
$("#name"+id).html(name);
$("#price"+id).html(price);
}
function removebox2(){
var modal = document.getElementById("myModal");
modal.style.display = "none";$(".modal").remove();$("#modal_script").remove();
}

function generate_barcode(){

$.get("ajax.php?search_merchant=barcode", function(data){
document.getElementById('barcode').value=data;
});
}

function print_barcode(){
var bar=document.getElementById('barcode').value;
window.open('ajax.php?search_merchant=print_barcode&bar='+bar, '_blank');
}