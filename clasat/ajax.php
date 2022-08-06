<?php
include_once 'webcon/lang.php';
class ajax {

/**
*فنكشن جلب الزبائن حسب اليوم والمندوب
*@param  $mysqli mysqli_connector
*/
function get_customers($mysqli) {
$q='SELECT customers.*,areas.name as area_name,employees.name as sale_name from customers,areas,employees where (areas.id=customers.area_id and employees.id=customers.sales_man_id) and (customers.visit_day='.intval($_GET['day']).' and customers.sales_man_id='.intval($_GET['sale']).')';
if($_GET['day']==8){$q='SELECT customers.*,areas.name as area_name,employees.name as sale_name from customers,areas,employees where (areas.id=customers.area_id and employees.id=customers.sales_man_id) and customers.sales_man_id='.intval($_GET['sale']);}
$q=$mysqli->query($q);
//$q=$mysqli->query('select * from customers where visit_day='.intval($_GET['day']).' and sales_man_id='.intval($_GET['sale']) );
echo "<div class='customers_list'>";

if($q->num_rows>0){
$total=0;
$days=[langu['sunday'],langu['monday'],langu['tuesday'],langu['wednesday'],langu['thursday'],langu['friday'],langu['saturday']];
/*echo "<div class='customer_list_main'>
<div class='list_main_element_top'>".langu['customer_name']."</div>
<div class='list_main_element_top'>".langu['area']."</div>
<div class='list_main_element_top small_f'>".langu['balance']."</div>
</div>";*/
echo "
<table class='main_table'>
    <tr>
        <th>".langu['customer_num']."</th>
        <th>".langu['customer_name']."</th>
        <th>".langu['balance']."</th>
        <th>".langu['address']."</th>
        <th>".langu['notes']."</th>
        <th class='no_print'></th>
    </tr>";
$i=1;
while ($row=$q->fetch_assoc()){

$total+=$row['balance'];
if($row['balance']>0){$balance="color:red;'>".$row['balance'];}
else{$balance="'>".$row['balance'];}
/*echo "<div class='customer_list_main' onclick='mymodalbox(\"".$row['name']."\",\"ajax.php?search_customers=one&id=".$row['id']."\",2)'>
<div class='list_main_element'>".$row['name']."</div>
<div class='list_main_element'>".$row['area_name']."</div>
<div class='list_main_element small_f' style='font-family:sans-serif;font-weight:bold;".$balance."</div>
</div>";*/
if($i==26){
echo "
    <tr class='page-break'>
        <td class='nume'>".$row['id']."</td>
        <td>".$row['name']."</td>
        <td style='font-family:sans-serif;font-weight:bold;".$balance."</td>
        <td>".$row['area_name']."</td>
        <td class='nume'>".$row['notes']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".$row['name']."\",\"ajax.php?search_customers=one&id=".$row['id']."\",2)'></td>
    </div>
    </tr>";
$i=1;}

else{echo "
    <tr>
        <td class='nume'>".$row['id']."</td>
        <td>".$row['name']."</td>
        <td style='font-family:sans-serif;font-weight:bold;".$balance."</td>
        <td>".$row['area_name']."</td>
        <td class='nume'>".$row['notes']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".$row['name']."\",\"ajax.php?search_customers=one&id=".$row['id']."\",2)'></td>
    </tr>";}


$i++;
}
echo "
    <tr>
        <td>".langu['final_total']."</td>
        <td></td>
        <td style='font-family:sans-serif;font-weight:bold;'>".$total."</td>
        <td></td>
        <td></td>
        <td class='no_print'></td>
    </tr>
</table>";
}

else {echo "<div class='msg fail'><div class='text_msg'>".langu['no_customers']."</div></div>";}
echo "</div>";

}

/**
*جلب معلومات زبون محدد
*/
function get_one_customer($mysqli) {
echo "<style>.customer_auto_search_name{width:55%;margin:0;}</style>";
$q=$mysqli->query('SELECT * from customers where id='.intval($_GET['id']));
if($q->num_rows>0){

$q=$q->fetch_assoc();
if($q['balance']>0){$balance="<input style='font-family:sans-serif;font-weight:bold;color:red;' type='text' name='customer_balance' placeholder='".langu['balance']."' value='".$q['balance']."' required>";}
else{$balance="<input type='text' autocomplete='off' name='customer_balance' placeholder='".langu['balance']."' value='".$q['balance']."' required>";}

if(isset($_GET['in'])){$class="<div class='customer_details_in'><div class='customer_details_title'>".$q['name']."</div>";}
else{$class="<div class='customer_details_modal'>";}

if($q['main_id']==0){$main_branch="<div class='customer_details_line'><div class='customer_details_name'>".langu['is_it']."</div><div class='customer_details_det'><input type='radio' name='is_main_branch' id='is_main' value='0' onchange='show_hide_branch_search()' checked>".langu['is_main']." <input type='radio' name='is_main_branch' id='is_branch' value='' onchange='show_hide_branch_search()'>".langu['is_branch']."</div></div>
<div class='customer_details_line' id='search_main' style='display:none;'><div class='customer_details_name'>".langu['main_customer']."</div><div class='customer_details_det' id='name_search2'><input type='text' autocomplete='off' name='customer_name_search2' id='customer_name_search2' placeholder='".langu['customer_name']."' value='' oninput='search_customer_name2()'></div></div>";}
else{$q2=$mysqli->query('SELECT name from customers where id='.$q['main_id']);$q2=$q2->fetch_assoc();
$main_branch="<div class='customer_details_line'><div class='customer_details_name'>".langu['is_it']."</div><div class='customer_details_det'><input type='radio' name='is_main_branch' id='is_main' value='0' onchange='show_hide_branch_search()'>".langu['is_main']." <input type='radio' name='is_main_branch' id='is_branch' value='".$q['main_id']."' onchange='show_hide_branch_search()' checked>".langu['is_branch']."</div></div>
<div class='customer_details_line' id='search_main'><div class='customer_details_name'>".langu['main_customer']."</div><div class='customer_details_det' id='name_search2'><input type='text' autocomplete='off' name='customer_name_search2' id='customer_name_search2' placeholder='".langu['customer_name']."' value='".$q2['name']."' oninput='search_customer_name2()'></div></div>";}

$a_s_w=$this->get_areas_salesman2($mysqli,$q['area_id'],$q['sales_man_id'],$q['visit_day']);
echo $class."<form action='customers.php?conn=update-customer-save' method='post'>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['customer_name']."</div> <div class='customer_details_det'><input type='text' autocomplete='off' name='customer_name' placeholder='".langu['customer_name']."' value='".$q['name']."' required></div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['area']."</div> <div class='customer_details_det'>".$a_s_w['area']."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['address']."</div> <div class='customer_details_det'><input type='text' autocomplete='off' name='customer_address' placeholder='".langu['full_address']."' value='".$q['full_address']."' required></div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['telephone']."</div> <div class='customer_details_det'><input type='text' autocomplete='off' name='customer_tel' placeholder='".langu['telephone']."' value='".$q['telephone']."'></div></div>
".$main_branch."
<div class='customer_details_line'> <div class='customer_details_name'>".langu['salesman2']."</div> <div class='customer_details_det'>".$a_s_w['sales']."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['visit_day']."</div> <div class='customer_details_det'>".$a_s_w['days']."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['balance']."</div> <div class='customer_details_det'>".$balance."</div></div>
<div class='customer_details_line'> <div class='customer_details_name'>".langu['notes']."</div> <div class='customer_details_det'><textarea name='customer_notes'>".$q['notes']."</textarea></div></div>
<input type='hidden' name='c_id' value='".$q['id']."'/>
<div class='customer_details_line' style='border:0;'><input type='submit' value='".langu['update_customer']."'></div>
</form></div>";

}
else {echo langu['no_customers'];}
}

/**
 * جلب الزبائن حسب الاسم
 * @param $mysqli
 * @param $q if 1 use query for main stores
 * @param $func function for on click
 */
function search_customer_name($mysqli,$q=null,$func=null){
$o='get_this_customer(';
$name=mysqli_real_escape_string($mysqli,htmlentities($_GET['name']));

if(isset($_GET['j'])){$query="select customers.id,customers.name,areas.name as aname from customers,areas where areas.id=customers.area_id and customers.name like '%".$name."%' and main_id=0";}
else{$query="select customers.id,customers.name,customers.main_id,areas.name as aname from customers,areas where areas.id=customers.area_id and customers.name like '%".$name."%'";}

$q=$mysqli->query($query);
echo "<div class='customer_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){

if(isset($_GET['j'])){$o='get_this_customer2("'.$row['name'].'",';}
if($func!=null){$o=$func.'("'.$row['name'].'",'.$row['main_id'].',';}

echo "<div class='customer_auto_search' onclick='".$o.$row['id'].")'>".$row['name']." - ".$row['aname']."</div>";
}

}
else{echo "<div class='customer_auto_search'>".langu['no_customers_name']."</div>";}
echo "</div>";
}

/**
 * جلب التجار حسب الاسم
 * @param $mysqli
 */
function search_merchant_name($mysqli,$func=null){

$name=mysqli_real_escape_string($mysqli,htmlentities($_GET['name']));

$q=$mysqli->query("select id,name,balance from merchants where name like '%".$name."%' and is_delete=0");
echo "<div class='customer_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
$f='';
if($func!=null){$f=" onclick='".$func."(".$row['id'].",\"".$row['name']."\")'";}
if($func=='set_to_bill'){$f=" onclick='".$func."(".$row['id'].",\"".$row['name']."\",\"".$row['balance']."\")'";}

echo "<div class='customer_auto_search'".$f.">".$row['name']."</div>";
}

}
else{echo "<div class='customer_auto_search'>".langu['no_merchant_name']."</div>";}
echo "</div>";
}

/**
 * جلب مندوب المبيعات
 * @param type $customer_id
 */
function get_saleman($mysqli,$customer_id){
$q=$mysqli->query("select customers.sales_man_id as sale_id,customers.balance,employees.name as ename from employees,customers where customers.sales_man_id=employees.id and customers.id=".$customer_id);
$q=$q->fetch_assoc();
echo json_encode($q);
}

/**
* جلب البضائع حسب التصنيف
* @param $mysqli
*/
function get_products_cat($mysqli){
$q=$mysqli->query('select products.*,product_unit.name as uname from products,product_unit where product_unit.id=products.unit_id and category_id='. intval($_GET['cat']));

echo "<div class='product_list'>";

if($q->num_rows>0){
echo "    <table class='main_table'>
            <tr>
                <th>".langu['product_num']."</th>
                <th>".langu['product_name']."</th>
                <th>".langu['product_quantity']."</th>
                <th>".langu['unit']."</th>
                <th>".langu['product_our_price']."</th>
                <th>".langu['edit']."</th>
                <th>".langu['image']."</th>
            </tr>";


while ($row=$q->fetch_assoc()){
echo "<tr>
        <td class='nume'>".$row['id2']."</td>
        <td class='nume' id='name".$row['id']."'>".$row['name']."</td>
        <td class='nume' id='q".$row['id']."'>".$row['quantity']."</td>
        <td>".$row['uname']."</td>
        <td class='nume' id='price".$row['id']."'>".$row['our_price']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".$row['name']."\",\"ajax.php?search_product=one&id=".$row['id']."\",1)'></td>
        <td class='edit_symbol' onclick='imagebox(\"".$row['name']."\",\"images/products/(".$row['id2'].").jpg\")'>[</td>
     </tr>";
}
echo "</table>";
}

else {echo "<div class='auto_search_msg'><div class='msg fail'><div class='text_msg'>".langu['no_products']."</div></div></div>";}
echo "</div>";
}
/*
function get_products_cat($mysqli){
$q=$mysqli->query('select products.*,product_unit.name as uname from products,product_unit where product_unit.id=products.unit_id and category_id='. intval($_GET['cat']));

echo "<div class='product_list'>";

if($q->num_rows>0){

echo "<div class='product_list_main'>
<div class='list_main_element_top'>".langu['product_name']."</div>
<div class='list_main_element_top small_f'>".langu['product_quantity']."</div>
<div class='list_main_element_top small_f'>".langu['unit']."</div>
<div class='list_main_element_top small_f'>".langu['product_our_price']."</div>
</div>";

while ($row=$q->fetch_assoc()){
echo "<div class='product_list_main' onclick='mymodalbox(\"".$row['name']."\",\"ajax.php?search_product=one&id=".$row['id']."\",2)'>
<div class='list_main_element'>".$row['name']."</div>
<div class='list_main_element small_f'>".$row['quantity']."</div>
<div class='list_main_element small_f'>".$row['uname']."</div>
<div class='list_main_element small_f'>".$row['our_price']."</div>
</div>";
}
}

else {echo "<div class='auto_search_msg'><div class='msg fail'><div class='text_msg'>".langu['no_products']."</div></div></div>";}
echo "</div>";
}
*/

/**
 * جلب البضاعة حسب الاسم
 * @param $mysqli
 */
function get_product_name($mysqli){

$name=mysqli_real_escape_string($mysqli,htmlentities($_GET['name']));
$q=$mysqli->query("select id,name from products where name like '%".$name."%'");
echo "<div class='product_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
echo "<div class='product_auto_search' onclick='get_product_by_id2(".$row['id'].")'>".$row['name']."</div>";
}

}
else{echo "<div class='product_auto_search'>".langu['no_products_name']."</div>";}
echo "</div>";
}
/**
 * جلب البضاعة حسب رقم الصنف
 * @param $mysqli
 */
function get_product_num($mysqli){

$name=mysqli_real_escape_string($mysqli,htmlentities($_GET['num']));
$q=$mysqli->query("select id,name from products where id2='".$name."'");

echo "<div class='product_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
echo "<div class='product_auto_search' onclick='get_product_by_id2(".$row['id'].")'>".$row['name']."</div>";
}

}
else{echo "<div class='product_auto_search'>".langu['no_products_name']."</div>";}
echo "</div>";
}
/**
 * جلب البضاعة حسب الباركود
 * @param $mysqli
 */
function get_product_barcode($mysqli){
$barcode=mysqli_real_escape_string($mysqli,htmlentities($_GET['barcode']));
$q=$mysqli->query('select id,name from products where barcode="'.$barcode.'" or barcode2="'.$barcode.'" or barcode3="'.$barcode.'"');
echo "<div class='product_auto_search_barcode'>";
@$num=$q->num_rows;
if($num>0){

while ($row=$q->fetch_assoc()){
echo "<div class='product_auto_search' onclick='get_product_by_id2(".$row['id'].")'>".$row['name']."</div>";
}

}
else{echo "<div class='product_auto_search'>".langu['no_products_barcode']."</div>";}
echo "</div>";
}

/**
*جلب معلومات بضاعة محددة
*/
function get_one_product($mysqli) {
echo "<link href='csss/reset.css' rel='stylesheet' type='text/css'/><link href='csss/main.css' rel='stylesheet' type='text/css'/><link href='csss/products.css' rel='stylesheet' type='text/css'/>
<script src='js/jquery.js'></script><script src='js/main.js'></script><script src='js/products.js'></script>
<style>html{direction: rtl;}</style>";
$q=$mysqli->query('SELECT products.*,product_unit.name as unit_name,categories.name as category_name from products,product_unit,categories where (product_unit.id=products.unit_id and categories.id=products.category_id) and (products.id='.intval($_GET['id']).')');
if($q->num_rows>0){

$q=$q->fetch_assoc();

if(isset($_GET['in'])){$class="<div class='product_details_in'><div class='product_details_title'>".$q['name']."</div>";}
else{$class="<div class='product_details_modal'>";}
$b='';
if($q['barcode']==''){$b="<span class='barcode_spans' onclick='generate_barcode()'>".langu['generate_barcode']."</span>";}
$b.="<span class='barcode_spans' onclick='print_barcode()'>".langu['print_barcode']."</span>";
$cat_unit=$this->get_unit_cat2($mysqli,$q['unit_id'],$q['category_id']);
echo $class."
<form action='ajax_settings.php?else=update-product-save' method='post' enctype='multipart/form-data'>
<div class='product_details_line'> <div class='product_details_name'>".langu['product_num2']."</div><div class='product_details_det nume' style='line-height: 30px;'>".$q['id2']."</div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['image']."</div> <div class='product_details_det edit_symbol' onclick='imagebox(\"".$q['name']."\",\"images/products/(".$q['id2'].").jpg\")'>[</div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['product_name']."</div> <div class='product_details_det'><input name='product_name' placeholder='".langu['product_name']."' type='text' value='".$q['name']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['unit']."</div> <div class='product_details_det'>".$cat_unit['unit']."</div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['product_quantity']."</div> <div class='product_details_det'><input name='product_quantity' placeholder='".langu['product_quantity']."' type='text' value='".$q['quantity']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['category']."</div> <div class='product_details_det'>".$cat_unit['cat']."</div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['product_our_price']."</div> <div class='product_details_det'><input name='product_our_price' placeholder='".langu['product_our_price']."' type='text' value='".$q['our_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['price']." n</div> <div class='product_details_det'><input name='product_price1' placeholder='".langu['price']." 1' type='text' value='".$q['n_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['price']." f-a</div> <div class='product_details_det'><input name='product_price2' placeholder='".langu['price']." 2' type='text' value='".$q['fa_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['price']." t</div> <div class='product_details_det'><input name='product_price3' placeholder='".langu['price']." 3' type='text' value='".$q['t_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['price']." f</div> <div class='product_details_det'><input name='product_price4' placeholder='".langu['price']." 4' type='text' value='".$q['f_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['cartoon_capicity']."</div> <div class='product_details_det'><input name='cartoon_capicity' placeholder='".langu['cartoon_capicity']."' type='text' value='".$q['cartoon_capicity']."'> </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['barcode']."</div> <div class='product_details_det' style='display:flex;'><input name='barcode' id='barcode' placeholder='".langu['barcode']."' type='text' value='".$q['barcode']."'>".$b." </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['barcode']." 2</div> <div class='product_details_det'><input name='barcode2' placeholder='".langu['barcode']." 2' type='text' value='".$q['barcode2']."'> </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['barcode']." 3</div> <div class='product_details_det'><input name='barcode3' placeholder='".langu['barcode']." 3' type='text' value='".$q['barcode3']."'> </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['image']."</div> <div class='product_details_det'><input type='file' name='product_image' id='product_image'></div></div>
<input type='hidden' name='p_id' value='".$q['id']."'/>
<div class='product_details_line'><input type='submit' value='".langu['update_product']."'></div>
</form></div>";

}
else {echo langu['no_customers'];}
}
function get_one_product2($mysqli) {

$q=$mysqli->query('SELECT products.*,product_unit.name as unit_name,categories.name as category_name from products,product_unit,categories where (product_unit.id=products.unit_id and categories.id=products.category_id) and (products.id='.intval($_GET['id']).')');
if($q->num_rows>0){

$q=$q->fetch_assoc();

if(isset($_GET['in'])){$class="<div class='product_details_in'><div class='product_details_title'>".$q['name']."</div>";}
else{$class="<div class='product_details_modal'>";}

$cat_unit=$this->get_unit_cat2($mysqli,$q['unit_id'],$q['category_id']);

$b='';
if($q['barcode']==''){$b="<span class='barcode_spans' onclick='generate_barcode()'>".langu['generate_barcode']."</span>";}
$b.="<span class='barcode_spans' onclick='print_barcode()'>".langu['print_barcode']."</span>";
echo $class."
<form action='products.php?conn=update-product-save' method='post' enctype='multipart/form-data'>
<div class='product_details_line'> <div class='product_details_name'>".langu['product_num2']."</div><div class='product_details_det nume' style='line-height: 30px;'>".$q['id2']."</div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['image']."</div> <div class='product_details_det edit_symbol' onclick='imagebox(\"".$q['name']."\",\"images/products/(".$q['id2'].").jpg\")'>[</div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['product_name']."</div> <div class='product_details_det'><input name='product_name' placeholder='".langu['product_name']."' type='text' value='".$q['name']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['unit']."</div> <div class='product_details_det'>".$cat_unit['unit']."</div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['product_quantity']."</div> <div class='product_details_det'><input name='product_quantity' placeholder='".langu['product_quantity']."' type='text' value='".$q['quantity']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['category']."</div> <div class='product_details_det'>".$cat_unit['cat']."</div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['product_our_price']."</div> <div class='product_details_det'><input name='product_our_price' placeholder='".langu['product_our_price']."' type='text' value='".$q['our_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['price']." n</div> <div class='product_details_det'><input name='product_price1' placeholder='".langu['price']." 1' type='text' value='".$q['n_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['price']." f-a</div> <div class='product_details_det'><input name='product_price2' placeholder='".langu['price']." 2' type='text' value='".$q['fa_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['price']." t</div> <div class='product_details_det'><input name='product_price3' placeholder='".langu['price']." 3' type='text' value='".$q['t_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['price']." f</div> <div class='product_details_det'><input name='product_price4' placeholder='".langu['price']." 4' type='text' value='".$q['f_price']."' required > </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['cartoon_capicity']."</div> <div class='product_details_det'><input name='cartoon_capicity' placeholder='".langu['cartoon_capicity']."' type='text' value='".$q['cartoon_capicity']."'> </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['barcode']."</div> <div class='product_details_det' style='display:flex;'><input name='barcode' id='barcode' placeholder='".langu['barcode']."' type='text' value='".$q['barcode']."'> ".$b." </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['barcode']." 2</div> <div class='product_details_det'><input name='barcode2' placeholder='".langu['barcode']." 2' type='text' value='".$q['barcode2']."'> </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['barcode']." 3</div> <div class='product_details_det'><input name='barcode3' placeholder='".langu['barcode']." 3' type='text' value='".$q['barcode3']."'> </div></div>
<div class='product_details_line'> <div class='product_details_name'>".langu['image']."</div> <div class='product_details_det'><input type='file' name='product_image' id='product_image'></div></div>
<input type='hidden' name='p_id' value='".$q['id']."'/>
<div class='product_details_line'><input type='submit' value='".langu['update_product']."'></div>
</form></div>";

}
else {echo langu['no_customers'];}
}


/**
 *جلب الوحدة و التصنيف
 *@param $unit if 1 get unit
 *@param $category if 1 get category
 *@return array 'unit','cat'
 */
function get_unit_cat2($mysqli,$unit_id=null,$category_id=null){
$ma=array();


$q=$mysqli->query('SELECT * FROM product_unit');


$ma['unit']="<select id='select_unit' name='select_unit' required>
<option value='' disabled >".langu['selectunit']."</option>";
while ($row=$q->fetch_assoc()) {
if($unit_id==$row['id']){$ma['unit'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$ma['unit'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$ma['unit'].="</select>";



$q=$mysqli->query('SELECT * FROM categories');
$ma['cat']="<select id='select_category' name='select_category' required>
<option value='' disabled>".langu['selectcategory']."</option>";
while ($row=$q->fetch_assoc()) {
if($category_id==$row['id']){$ma['cat'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$ma['cat'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$ma['cat'].="</select>";




return $ma;
}

/**
 *جلب المناطق والمندوبين
 *@param $area_id
 *@param $salesman_id
 *@param $days_id
 *@return array 'area','sales','days'
 */
function get_areas_salesman2($mysqli,$area_id,$salesman_id,$days_id){
$ma=array();

$q=$mysqli->query('select * from areas');


$ma['area']="<select id='select_area' name='select_area' required>
<option value='' disabled>".langu['selectarea']."</option>";
while ($row=$q->fetch_assoc()) {
if($area_id==$row['id']){$ma['area'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$ma['area'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$ma['area'].="</select>";



$q=$mysqli->query('select id,name from employees where employee_type=1');
$ma['sales']="<select id='select_salesman' name='select_salesman' required>
<option value='' disabled>".langu['selectsales']."</option>";
while ($row=$q->fetch_assoc()) {
if($salesman_id==$row['id']){$ma['sales'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$ma['sales'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$ma['sales'].="</select>";


$m=[langu['sunday'],langu['monday'],langu['tuesday'],langu['wednesday'],langu['thursday'],langu['friday'],langu['saturday']];
$days='';
for($i=0;$i<7;$i++){
if($days_id==$i){$days.="<option value='".$i."' selected>".$m[$i]."</option>";}
else{$days.="<option value='".$i."'>".$m[$i]."</option>";}
}

$ma['days']="
<select id='select_visit_day' name='select_visit_day' required>
    <option value='' disabled>".langu['selectday']."</option>
".$days."
</select>";


return $ma;
}

function generate_barcode($mysqli,$x){
$code=$this->generateEAN($x);
$row=$mysqli->query('select barcode,barcode2,barcode3 from products where barcode='.$code.' or barcode2='.$code.' or barcode3='.$code);
if($row->num_rows>0){
$this->generate_barcode($mysqli,$x+1);
}
else {echo $code;}

}

function print_barcode($barcode){
echo "<script src='js/jquery.js'></script><script src='js/barcode2.js'></script>";
echo '<canvas id="barcode" width="300" height="150"></canvas>
<script>$("#barcode").EAN13("'.$barcode.'");</script>';
/*echo "
<script src='js/barcode.js'></script>
<div id='barc'></div>
<script>$('#barc').barcode('".$barcode."', 'ean13');</script>";*/

}

function generateEAN($number)
{
  $code =str_pad($number, 9, '0');
  //$code =str_pad($number, 9, '0', STR_PAD_LEFT);
  $weightflag = true;
  $sum = 0;
  for ($i = strlen($code) - 1; $i >= 0; $i--)
  {
    $sum += (int)$code[$i] * ($weightflag?3:1);
    $weightflag = !$weightflag;
  }
  $code .= (10 - ($sum % 10)) % 10;
  return $code;
}

/*
function generateEAN($number)
{
  $code = '200' . str_pad($number, 9, '0');
  $weightflag = true;
  $sum = 0;
  // Weight for a digit in the checksum is 3, 1, 3.. starting from the last digit. 
  // loop backwards to make the loop length-agnostic. The same basic functionality 
  // will work for codes of different lengths.
  for ($i = strlen($code) - 1; $i >= 0; $i--)
  {
    $sum += (int)$code[$i] * ($weightflag?3:1);
    $weightflag = !$weightflag;
  }
  $code .= (10 - ($sum % 10)) % 10;
  return $code;
}
 */

/**
 * ازالة شيك من المصاريف وارجاعه للشركة وتعديل الرصيد في سند الصرف وعند التاجر او الزبون 
 * @param type $mysqli
 */
function remove_check_from_expense($mysqli){
$ch_id=intval($_GET['id']);
$ret=0;
$row=$mysqli->query("select * from checks where id=".$ch_id);
$row=$row->fetch_assoc();

if($row['currency_id']==1){$total=$row['check_value'];}
else{$total=$row['check_value']*$row['exchange_rate'];}

if($row['expense_id']!=0){

$r=$mysqli->query('select * from expense where id='.$row['expense_id']);
$r=$r->fetch_assoc();

$checks=unserialize($r['checks_ids']);
for($i=0;$i<count($checks);$i++){
if($checks[$i]==$ch_id){unset($checks[$i]);$checks=array_values($checks);}
}

$st=$mysqli->query('select id from customer_merchant_statment where statment_type=7 and id_for_type='.$row['expense_id']);
$st=$st->fetch_assoc();

if($r['customer_id']!=0){
$mysqli->query('update customers set balance=balance-'.$total.' where id='.$r['customer_id']);
$mysqli->query('update customer_merchant_statment set balance=balance-'.$total.',all_balance=all_balance-'.$total.' where id='.$st['id']);
$mysqli->query('update customer_merchant_statment set all_balance=all_balance-'.$total.' where customer_id='.$r['customer_id'].' and id>'.$st['id']);
}

elseif($r['merchant_id']!=0){
$mysqli->query('update merchants set balance=balance+'.$total.' where id='.$r['merchant_id']);
$mysqli->query('update customer_merchant_statment set balance=balance-'.$total.',all_balance=all_balance+'.$total.' where id='.$st['id']);
$mysqli->query('update customer_merchant_statment set all_balance=all_balance+'.$total.' where merchant_id='.$r['merchant_id'].' and id>'.$st['id']);
}
$mysqli->query('update expense set check_value=check_value-'.$total.' , checks_ids="'.serialize($checks).'" , check_count=check_count-1 where id='.$row['expense_id']);
}

$mysqli->query('update checks set expense_id=0,is_returned=0 where id='.$ch_id);
if($mysqli->affected_rows>0){$this->msg('success',langu['save_temp_success']);}

else{$this->msg('fail',langu['save_temp_fail']);}
}

/*
 * ازالة الشيك الشخصي نهائيا وحذفه
 */
function remove_our_check($mysqli){
$ch_id=intval($_GET['id']);
$ret=0;
$row=$mysqli->query("select * from our_checks where id=".$ch_id);
$row=$row->fetch_assoc();
if($row['currency_id']==1){$total=$row['check_value'];}
else{$total=$row['check_value']*$row['exchange_rate'];}


$r=$mysqli->query('select * from expense where id='.$row['expense_id']);
$r=$r->fetch_assoc();

$checks=unserialize($r['our_checks_ids']);
for($i=0;$i<count($checks);$i++){
if($checks[$i]==$ch_id){unset($checks[$i]);$checks=array_values($checks);}
}

$st=$mysqli->query('select id from customer_merchant_statment where statment_type=7 and id_for_type='.$row['expense_id']);
$st=$st->fetch_assoc();

if($r['customer_id']!=0){
$mysqli->query('update customers set balance=balance-'.$total.' where id='.$r['customer_id']);
$mysqli->query('update customer_merchant_statment set balance=balance-'.$total.',all_balance=all_balance-'.$total.' where id='.$st['id']);
$mysqli->query('update customer_merchant_statment set all_balance=all_balance-'.$total.' where customer_id='.$r['customer_id'].' and id>'.$st['id']);
}

elseif($r['merchant_id']!=0){
$mysqli->query('update merchants set balance=balance+'.$total.' where id='.$r['merchant_id']);
$mysqli->query('update customer_merchant_statment set balance=balance-'.$total.',all_balance=all_balance+'.$total.' where id='.$st['id']);
$mysqli->query('update customer_merchant_statment set all_balance=all_balance+'.$total.' where merchant_id='.$r['merchant_id'].' and id>'.$st['id']);
}
$mysqli->query('update expense set our_check_value=our_check_value-'.$total.' ,our_checks_ids="'.serialize($checks).'" , check_count=check_count-1 where id='.$row['expense_id']);


$mysqli->query('delete from our_checks where id='.$ch_id);
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}

else{$this->msg('fail',langu['edit_fail']);}
}
/**
 *اشعار 
 */
function msg($success_fail,$text,$re=null){
$re1='';
if($re==null){$re1="<script>setTimeout(\"window.top.location.reload()\",1000);</script>";}
echo "
<style>
.msg{width:90%;margin:10px auto;font-weight:bold;font-size:16px;text-align:center;background-color:#fff;border:1px solid #c8cfd8;color:#344459;border-radius:5px;padding:7px;}
.fail{border-color:#f99ea3;color:#ff0715;}
.success{border-color:#6aa766;color:#4a901f;}
</style>
<div class='msg $success_fail'>
".$re1."
<div class='text_msg'>".$text."</div></div>";
}

}