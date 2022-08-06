<?php
include_once 'webcon/lang.php';
class ajax {

/**
*فنكشن جلب الزبائن حسب اليوم والمندوب
*@param  $mysqli mysqli_connector
*/
function get_customers($mysqli) {
$q=$mysqli->query('SELECT customers.*,areas.name as area_name,employees.first_name as sale_name from customers,areas,employees where (areas.id=customers.area_id and employees.id=customers.sales_man_id) and (customers.visit_day='.intval($_GET['day']).' and customers.sales_man_id='.intval($_GET['sale']).')');
//$q=$mysqli->query('select * from customers where visit_day='.intval($_GET['day']).' and sales_man_id='.intval($_GET['sale']) );
echo "<div class='customers_list'>";

if($q->num_rows>0){
$days=[langu['sunday'],langu['monday'],langu['tuesday'],langu['wednesday'],langu['thursday'],langu['friday'],langu['saturday']];
echo "<div class='customer_list_main'>
<div class='list_main_element_top'>".langu['customer_name']."</div>
<div class='list_main_element_top'>".langu['area']."</div>
<div class='list_main_element_top'>".langu['salesman2']."</div>
<div class='list_main_element_top'>".langu['visit_day']."</div>
<div class='list_main_element_top'>".langu['balance']."</div>
</div>";

while ($row=$q->fetch_assoc()){
if($row['balance']>0){$balance="color:red;'>".$row['balance'];}
else{$balance="'>".$row['balance'];}
echo "<div class='customer_list_main' onclick='mymodalbox(\"".$row['name']."\",\"ajax.php?search_customers=one&id=".$row['id']."\",2)'>
<div class='list_main_element'>".$row['name']."</div>
<div class='list_main_element'>".$row['area_name']."</div>
<div class='list_main_element'>".$row['sale_name']."</div>
<div class='list_main_element'>".$days[$row['visit_day']]."</div>
<div class='list_main_element' style='font-family:sans-serif;font-weight:bold;".$balance."</div>
</div>";
}

}

else {echo "<div class='msg fail'><div class='text_msg'>".langu['no_customers']."</div></div>";}
echo "</div>";

}

/**
*جلب معلومات زبون محدد
*/
function get_one_customer($mysqli) {
$q=$mysqli->query('SELECT customers.*,areas.name as area_name,employees.first_name as sale_name from customers,areas,employees where (areas.id=customers.area_id and employees.id=customers.sales_man_id) and (customers.id='.intval($_GET['id']).')');
if($q->num_rows>0){
$days=[langu['sunday'],langu['monday'],langu['tuesday'],langu['wednesday'],langu['thursday'],langu['friday'],langu['saturday']];
$q=$q->fetch_assoc();
if($q['balance']>0){$balance="color:red;'>".$q['balance'];}
else{$balance="'>".$q['balance'];}
echo "<div class='customer_details'>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['customer_name']."</div> <div class='customer_details_det'>".$q['name']."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['area']."</div> <div class='customer_details_det'>".$q['area_name']."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['address']."</div> <div class='customer_details_det'>".$q['full_address']."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['telephone']."</div> <div class='customer_details_det'>".$q['telephone']."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['salesman2']."</div> <div class='customer_details_det'>".$q['sale_name']."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['visit_day']."</div> <div class='customer_details_det'>".$days[$q['visit_day']]."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['balance']."</div> <div class='customer_details_det' style='font-family:sans-serif;font-weight:bold;".$balance."</div></div>
</div>";

}
else {echo langu['no_customers'];}
}

/**
* جلب البضائع حسب التصنيف
* @param $mysqli
*/
function get_products_cat($mysqli){
$q=$mysqli->query('select * from products where category_id='. intval($_GET['cat']));

echo "<div class='product_list'>";

if($q->num_rows>0){

echo "<div class='product_list_main'>
<div class='list_main_element_top'>".langu['product_name']."</div>
<div class='list_main_element_top small_f'>".langu['product_our_price']."</div>
<div class='list_main_element_top small_f'>".langu['price']." 1</div>
<div class='list_main_element_top small_f'>".langu['price']." 2</div>
<div class='list_main_element_top small_f'>".langu['price']." 3</div>
<div class='list_main_element_top small_f'>".langu['product_quantity']."</div>
</div>";

while ($row=$q->fetch_assoc()){
echo "<div class='product_list_main'>
<div class='list_main_element'>".$row['name']."</div>
<div class='list_main_element small_f'>".$row['our_price']."</div>
<div class='list_main_element small_f'>".$row['n_price']."</div>
<div class='list_main_element small_f'>".$row['1_price']."</div>
<div class='list_main_element small_f'>".$row['f_price']."</div>
<div class='list_main_element small_f'>".$row['quantity']."</div>
</div>";
}
}

else {echo "<div class='msg fail'><div class='text_msg'>".langu['no_products']."</div></div>";}
echo "</div>";
}

}