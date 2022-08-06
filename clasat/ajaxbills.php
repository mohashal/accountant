<?php

class ajaxbills {

/**
 *جلب معلومات الزبون المندوب والسعر والمنطقة
 * @param  $mysqli
 */
function get_customer_info($mysqli){
$q=$mysqli->query('SELECT customers.*,areas.name as area_name,employees.name as sale_name,employees.product_price as sale_price from customers,areas,employees where (areas.id=customers.area_id and employees.id=customers.sales_man_id) and customers.id='.intval($_GET['id']));

if($q->num_rows>0){
$q=$q->fetch_assoc();
$c=unserialize($q['custom_price']);
$c=json_encode($c);
$q['custom_price']=$c;
echo json_encode($q);
}

}

/**
*جلب معلومات البضاعة والسعر
* @param $mysqli
*/
function get_product_info($mysqli){
$q=$mysqli->query('SELECT products.*,product_unit.name as unit_name FROM products,product_unit where products.unit_id=product_unit.id and products.id='.intval($_GET['id']));

if($q->num_rows>0){
$q=$q->fetch_assoc();
$num=intval($_GET['num']);
$price=$q[$_GET['price']];
echo "<tr id='product".$num."'>
<input type='hidden' id='product_offer".$num."' name='product_offer".$num."' value='0'/>
<input type='hidden' id='product_id".$num."' name='product_id".$num."' value='".$q['id']."'/>
<input type='hidden' id='product_ids".$num."' name='product_ids".$num."' value='".$q['id2']."'/>
<input type='hidden' id='product_unit".$num."' name='product_unit".$num."' value='".$q['unit_name']."'/>
<input type='hidden' id='product_our_price".$num."' name='product_our_price".$num."' value='".$q['our_price']."'/>
<input type='hidden' id='product_sale_price".$num."' name='product_sale_price".$num."' value='".$price."'/>
<input type='hidden' id='product_name".$num."' name='product_name".$num."' value='".$q['name']."'/>
<td class='del_product no_print' id='del_pro".$num."' onclick='del_product(".$num.")'></td>
<td class='nume'>".$q['id2']."</td><td class='nume'>".$q['name']."</td>
<td><input type='text' autocomplete='off' name='product_quantity".$num."' id='product_quantity".$num."' value='1' oninput='change_total(".$num.")' placeholder='".langu['product_quantity']."'/></td>
<td>".$q['unit_name']."</td>
<td id='pru".$num."'><input type='text' autocomplete='off' name='product_price".$num."' id='product_price".$num."' value='".$price."' oninput='change_total(".$num.")' placeholder='".langu['price']."'/></td>
<td><input type='checkbox' id='product_bonus".$num."' name='product_bonus".$num."' onchange='check_bonus(".$num.")' value='1'></td>
<td class='nume' id='product_total".$num."'>$price</td></tr>";
//echo "<div class='bill_products_list' id='product".$num."'><input type='hidden' id='product_id".$num."' name='product_id".$num."' value='".$q['id']."'/><input type='hidden' id='product_unit".$num."' name='product_unit".$num."' value='".$q['unit_name']."'/><input type='hidden' id='product_our_price".$num."' name='product_our_price".$num."' value='".$q['our_price']."'/><input type='hidden' id='product_name".$num."' name='product_name".$num."' value='".$q['name']."'/><span class='del_product' id='del_pro".$num."' onclick='del_product(".$num.")'></span><div class='bill_list_element'>".$q['name']."</div><div class='bill_list_element small_f'><input type='text' autocomplete='off' name='product_quantity".$num."' id='product_quantity".$num."' value='1' oninput='change_total(".$num.")' placeholder='".langu['product_quantity']."'/></div><div class='bill_list_element small_f'  id='pru".$num."'><input type='text' autocomplete='off' name='product_price".$num."' id='product_price".$num."' value='".$price."' oninput='change_total(".$num.")' placeholder='".langu['price']."'/></div><div class='bill_list_element small_f' id='product_total".$num."'>$price</div></div>";
}
}
function get_offer_info($mysqli){
$q=$mysqli->query('SELECT * from offers where id='.intval($_GET['id']));

if($q->num_rows>0){
$q=$q->fetch_assoc();
$a=unserialize($q['products']);
$product='';
for($num2=1;$num2<=$a['product_nums'];$num2++){
$num=intval($_GET['num'])+$num2;
$total=$a['pr'.$num2]['price']*$a['pr'.$num2]['quantity'];
$check='';
if($a['pr'.$num2]['bonus']==1){$check=' checked';$total=0;}
$product.="
<tr id='product".$num."'>
	<input type='hidden' id='product_offer".$num."' name='product_offer".$num."' value='1'/>
	<input type='hidden' id='product_id".$num."' name='product_id".$num."' value='".$a['pr'.$num2]['id']."'/>
	<input type='hidden' id='product_ids".$num."' name='product_ids".$num."' value='".$a['pr'.$num2]['ids']."'/>
	<input type='hidden' id='product_unit".$num."' name='product_unit".$num."' value='".$a['pr'.$num2]['unit']."'/>
	<input type='hidden' id='product_our_price".$num."' name='product_our_price".$num."' value='".$a['pr'.$num2]['our_price']."'/>
        <input type='hidden' id='product_sale_price".$num."' name='product_sale_price".$num."' value='".$a['pr'.$num2]['our_price']."'/>
	<input type='hidden' id='product_name".$num."' name='product_name".$num."' value='".$a['pr'.$num2]['name']."'/>
	<td class='del_product no_print' id='del_pro".$num."' onclick='del_product(".$num.")'></td>
        <td class='nume'>".$a['pr'.$num2]['ids']."</td>
        <td class='nume'>".$a['pr'.$num2]['name']."</td>
	<td><input type='text' autocomplete='off' name='product_quantity".$num."' id='product_quantity".$num."' value='".$a['pr'.$num2]['quantity']."' oninput='change_total(".$num.")' placeholder='".langu['product_quantity']."'/></td>
        <td>".$a['pr'.$num2]['unit']."</td>
        <td id='pru".$num."'><input type='text' autocomplete='off' name='product_price".$num."' id='product_price".$num."' value='".$a['pr'.$num2]['price']."' oninput='change_total(".$num.")' placeholder='".langu['price']."'/></td>
	<td><input type='checkbox' id='product_bonus".$num."' name='product_bonus".$num."' onchange='check_bonus(".$num.")' value='1'".$check."></td>
	<td class='nume' id='product_total".$num."'>$total</td>
</tr>";
}
}
echo $product;
}
/**
 * جلب البضاعة حسب الاسم
 * @param $mysqli
 */
function get_product_name($mysqli){

$name=mysqli_real_escape_string($mysqli,htmlentities($_GET['name']));

$q="select id,name,quantity from products where name like '%".$name."%' and quantity <> 0";
if(isset($_GET['no'])){
if($_GET['no']==1){$q="select id,name,quantity from products where name like '%".$name."%'";}
}
$q=$mysqli->query($q);
echo "<div class='product_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
echo "<div class='product_auto_search' onclick='get_product_by_id(".$row['id'].")'>".$row['name']." - الكمية : ".$row['quantity']."</div>";
}

}
else{echo "<div class='product_auto_search'>".langu['no_products_name']."</div>";}
echo "</div>";
}

function get_offer_by_name($mysqli){

$name=mysqli_real_escape_string($mysqli,htmlentities($_GET['name']));

$q="select * from offers where name like '%".$name."%'";

$q=$mysqli->query($q);
echo "<div class='product_auto_search_name' style='width:25%'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
$a=unserialize($row['products']);
echo "<div class='product_auto_search' onclick='get_offer_by_id(".$row['id'].",\"".$a['product_nums']."\")'>".$row['name']."</div>";
}

}
else{echo "<div class='product_auto_search'>".langu['no_offers_name']."</div>";}
echo "</div>";
}
/**
*جلب الشيكات
*/
function get_check_by_num($mysqli){

$num=mysqli_real_escape_string($mysqli,htmlentities($_GET['num']));
$func=mysqli_real_escape_string($mysqli,htmlentities($_GET['func']));
$q=$mysqli->query("SELECT checks.*,revenue.merchant_id,revenue.customer_id FROM checks,revenue where checks.check_num like '".$num."%' and (checks.is_returned=0 and checks.expense_id=0) and revenue.id=checks.revenue_id");
echo "<div class='customer_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
echo "<div class='customer_auto_search' style='font-family:sans-serif;' onclick='".$func."(".$row['id'].",".$row['revenue_id'].")'>".langu['check_num']." : ".$row['check_num']."</div>";
}

}
else{echo "<div class='customer_auto_search'>".langu['no_check_name']."</div>";}
echo "</div>";
}
/**
*جلب الشيكات2
*/
function get_check_by_num2($mysqli){

$num=mysqli_real_escape_string($mysqli,htmlentities($_GET['num']));
$func=mysqli_real_escape_string($mysqli,htmlentities($_GET['func']));
$q=$mysqli->query("SELECT * FROM checks where check_num like '".$num."%' and is_returned=0 and expense_id=0");
echo "<div class='customer_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
echo "<div class='customer_auto_search' style='font-family:sans-serif;' onclick='".$func."(".$row['id'].")'>".langu['check_num']." : ".$row['check_num']."</div>";
}

}
else{echo "<div class='customer_auto_search'>".langu['no_check_name']."</div>";}
echo "</div>";
}

/**
*جلب الشيكات2
*/
function get_check_by_num3($mysqli){

$num=mysqli_real_escape_string($mysqli,htmlentities($_GET['num']));
$func=mysqli_real_escape_string($mysqli,htmlentities($_GET['func']));
$q=$mysqli->query("SELECT * FROM checks where check_num like '".$num."%'");
echo "<div class='customer_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
echo "<div class='customer_auto_search' style='font-family:sans-serif;' onclick='".$func."(".$row['id'].")'>".langu['check_num']." : ".$row['check_num']."</div>";
}

}
else{echo "<div class='customer_auto_search'>".langu['no_check_name']."</div>";}
echo "</div>";
}

function get_our_check_by_num($mysqli){

$num=mysqli_real_escape_string($mysqli,htmlentities($_GET['num']));
$func=mysqli_real_escape_string($mysqli,htmlentities($_GET['func']));
$q=$mysqli->query("SELECT * FROM our_checks where check_num like '".$num."%'");
echo "<div class='customer_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
echo "<div class='customer_auto_search' style='font-family:sans-serif;' onclick='".$func."(".$row['id'].")'>".langu['check_num']." : ".$row['check_num']."</div>";
}

}
else{echo "<div class='customer_auto_search'>".langu['no_check_name']."</div>";}
echo "</div>";
}

/**
* تعديل حالة الشيك الى مرتجع
* @param type $mysqli
*/
function save_return_check($mysqli){
$ch_id=intval($_POST['check_id']);
$ret=floatval($_POST['returned_value']);
$row=$mysqli->query("select checks.*,currency.name as cur_name from checks,currency where checks.currency_id=currency.id and checks.id=".$ch_id);
$row=$row->fetch_assoc();
$costumer_id=$row['customer_id'];
$merchant_id=$row['merchant_id'];
$check_num=$row['check_num'];
if($row['currency_id']==1){$total=$row['check_value'];}
else{$total=$row['check_value']*$row['exchange_rate'];}

$total2=$total;
$total=$total+$ret;

if($row['expense_id']!=0){

$r=$mysqli->query('select * from expense where id='.$row['expense_id']);
$r=$r->fetch_assoc();
if($r['customer_id']!=0){
$mysqli->query('update customers set balance=balance-'.$total.' where id='.$r['customer_id']);
$row4=$mysqli->query('select balance from customers WHERE id='.$r['customer_id']);
$row4=$row4->fetch_assoc();
$this->insert_to_statment($mysqli,10,$ch_id, $total,$row4["balance"],$r['customer_id'],0);
//$mysqli->query('INSERT INTO return_not_personal_check (customer_id,all_balance,check_id,date) VALUES ('.$r['customer_id'].','.$row4["balance"].','.$ch_id.',"'.date('Y-m-d').'")');
}

elseif($r['merchant_id']!=0){
$mysqli->query('update merchants set balance=balance+'.$total.' where id='.$r['merchant_id']);
$row4=$mysqli->query('select balance from merchants WHERE id='.$r['merchant_id']);
$row4=$row4->fetch_assoc();
$this->insert_to_statment($mysqli,10,$ch_id, $total,$row4["balance"],0,$r['merchant_id']);
//$mysqli->query('INSERT INTO return_not_personal_check (merchant_id,all_balance,check_id,date) VALUES ('.$r["merchant_id"].','.$row4["balance"].','.$ch_id.',"'.date('Y-m-d').'")');
}

}



if($costumer_id!=0){
$q=$mysqli->query('select * from customers where id='.$costumer_id);$q=$q->fetch_assoc();
$main_customer_id=$q['main_id'];
if($main_customer_id==0){$s_id=$costumer_id;}else{$s_id=$main_customer_id;}
$q=$mysqli->query('select customers.name as cname,employees.name as ename from customers,employees where customers.id='.$s_id.' and customers.sales_man_id=employees.id');$q=$q->fetch_assoc();
$name=langu['check_returned_to'].$q['cname'];
$notes=langu['check_num']." : ".$check_num." \n".langu['check_value']." : ".$row['check_value']." ".$row['cur_name']."\n".langu['check_returned_increase']." : ".$ret." ".langu['shekel']."\n".langu['check_date']." : ".$row['check_date']."\n".langu['salesman2']." : ".$q['ename'];
$mysqli->query("INSERT INTO notifications (name,start_date,end_date,notes) VALUES ('".$name."','".date('Y-m-d')."','".date('Y-m-d', strtotime("+15 days"))."','".$notes."')");
$mysqli->query("UPDATE customers SET balance=balance+".$total." WHERE id=".$s_id);
$row3=$mysqli->query('select balance from customers WHERE id='.$s_id);
$row3=$row3->fetch_assoc();
$this->insert_to_statment($mysqli,8,$ch_id, $total,$row3['balance'],$s_id,0);
/*$mysqli->query('update checks set all_balance='.$row3['balance'].' where id='.$ch_id);
$mysqli->query('update revenue set checks_value=checks_value-'.$total2.',return_checks=1,all_balance=all_balance+'.$total2.' where id='.$row['revenue_id']);*/
}

elseif($merchant_id!=0){
$q=$mysqli->query('select name from merchants where id='.$merchant_id);$q=$q->fetch_assoc();
$name=langu['check_returned_to'].$q['name'];
$notes=langu['check_num']." : ".$check_num." \n".langu['check_value']." : ".$row['check_value']." ".$row['cur_name']."\n".langu['check_returned_increase']." : ".$ret." ".langu['shekel']."\n".langu['check_date']." : ".$row['check_date'];
$mysqli->query("INSERT INTO notifications (name,start_date,end_date,notes) VALUES ('".$name."','".date('Y-m-d')."','".date('Y-m-d', strtotime("+15 days"))."','".$notes."')");
$mysqli->query("UPDATE merchants SET balance=balance-".$total." WHERE id=".$merchant_id);
$row3=$mysqli->query('select balance from merchants WHERE id='.$merchant_id);
$row3=$row3->fetch_assoc();
$this->insert_to_statment($mysqli,8,$ch_id, $total,$row3['balance'],0,$merchant_id);
/*$mysqli->query('update checks set all_balance='.$row3['balance'].' where id='.$ch_id);
/*$mysqli->query('update revenue set checks_value=checks_value-'.$total2.',return_checks=1,all_balance=all_balance-'.$total2.' where id='.$row['revenue_id']);*/
}

elseif($row['normal_customer']!=0){
$name=langu['check_returned_to'].$row['normal_customer_name'];
$notes=langu['check_num']." : ".$check_num." \n".langu['check_value']." : ".$row['check_value']." ".$row['cur_name']."\n".langu['check_returned_increase']." : ".$ret." ".langu['shekel']."\n".langu['check_date']." : ".$row['check_date'];
$mysqli->query("INSERT INTO notifications (name,start_date,end_date,notes) VALUES ('".$name."','".date('Y-m-d')."','".date('Y-m-d', strtotime("+15 days"))."','".$notes."')");
}

if($mysqli->affected_rows>0){
$mysqli->query("UPDATE checks SET is_returned=1,returned_value=".$ret.",returned_date='".date('Y-m-d')."' WHERE id=".$ch_id);
if($mysqli->affected_rows>0){$this->msg('success',langu['check_return_success']);}
else{$this->msg('fail',langu['check_return_fail']);}
}
else{$this->msg('fail',langu['check_return_fail']);}
}

/*
 *حفظ الشيك للحذف
 */
function save_delete_check_rev($mysqli){
$ch_id=intval($_POST['check_id']);
$ret=0;
$row=$mysqli->query("select checks.*,currency.name as cur_name from checks,currency where checks.currency_id=currency.id and checks.id=".$ch_id);
$row=$row->fetch_assoc();
$costumer_id=$row['customer_id'];
$merchant_id=$row['merchant_id'];
if($row['currency_id']==1){$total=$row['check_value'];}
else{$total=$row['check_value']*$row['exchange_rate'];}

$total=$total;

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
$mysqli->query('update customers set balance=balance+'.$total.' where id='.$r['customer_id']);
$mysqli->query('update customer_merchant_statment set balance=balance-'.$total.',all_balance=all_balance-'.$total.' where id='.$st['id']);
$mysqli->query('update customer_merchant_statment set all_balance=all_balance-'.$total.' where customer_id='.$r['customer_id'].' and id>'.$st['id']);
}

elseif($r['merchant_id']!=0){
$mysqli->query('update merchants set balance=balance-'.$total.' where id='.$r['merchant_id']);
$mysqli->query('update customer_merchant_statment set balance=balance-'.$total.',all_balance=all_balance+'.$total.' where id='.$st['id']);
$mysqli->query('update customer_merchant_statment set all_balance=all_balance+'.$total.' where merchant_id='.$r['merchant_id'].' and id>'.$st['id']);
}
$mysqli->query('update expense set check_value=check_value-'.$total.' and checks_ids="'.serialize($checks).'" where id='.$row['expense_id']);
}

}

/**
*ترحيل سند القبض الغير مرحل وتعديل حسابات الزبائن والتجار
*/
function update_temp_permant_revenue($mysqli){
$row=$mysqli->query("select * from revenue where id=".intval($_GET['id']));
$row=$row->fetch_assoc();

$costumer_id=$row['customer_id'];
$main_customer_id=$row['main_customer_id'];
$merchant_id=$row['merchant_id'];
$discount=$row['discount'];
$cash_value=$row['cash_value'];
$checks_value=$row['checks_value'];
$balance=0;
$s_id=0;

if($row['is_check']==1){
$total=$checks_value+$cash_value+$discount;
if($costumer_id!=0){
if($main_customer_id==0){$s_id=$costumer_id;}else{$s_id=$main_customer_id;}
$mysqli->query("UPDATE customers SET balance=balance-".$total." WHERE id=".$s_id);
$row3=$mysqli->query("select balance from customers WHERE id=".$s_id);
$row3=$row3->fetch_assoc();
$balance=$row3['balance'];
}

if($merchant_id!=0){
$mysqli->query("UPDATE merchants SET balance=balance+".$total." WHERE id=".$merchant_id);
$row3=$mysqli->query("select balance from merchants WHERE id=".$merchant_id);
$row3=$row3->fetch_assoc();
$balance=$row3['balance'];
}

}

else {
$total=$cash_value+$discount;
if($costumer_id!=0){
if($main_customer_id==0){$s_id=$costumer_id;}else{$s_id=$main_customer_id;}
$mysqli->query("UPDATE customers SET balance=balance-".$total." WHERE id=".$s_id);
$row3=$mysqli->query("select balance from customers WHERE id=".$s_id);
$row3=$row3->fetch_assoc();
$balance=$row3['balance'];
}

if($merchant_id!=0){
$mysqli->query("UPDATE merchants SET balance=balance+".$total." WHERE id=".$merchant_id);
$row3=$mysqli->query("select balance from merchants WHERE id=".$merchant_id);
$row3=$row3->fetch_assoc();
$balance=$row3['balance'];
}
}
$this->insert_to_statment($mysqli,6,$row['id'],$total,$balance,$s_id,$merchant_id);
if($mysqli->affected_rows>0){$mysqli->query("UPDATE revenue SET is_temp=0,all_balance=".$balance." WHERE id=".$_GET['id']);
$this->msg('success',langu['from_temp_success']);}

else{$this->msg('fail',langu['from_temp_fail']);}
}

/**
 *حذف سند قبض غير مرحل
 */
function delete_temp_revenue($mysqli){
$mysqli->query("DELETE FROM revenue WHERE id=".$_GET['id']);
if($mysqli->affected_rows>0){$this->msg('success',langu['delete_success']);}

else{$this->msg('fail',langu['delete_fail']);}
}

/**
 * جلب البضاعة حسب رقم الصنف
 * @param $mysqli
 */
function get_product_num($mysqli){

$name=mysqli_real_escape_string($mysqli,htmlentities($_GET['num']));
$q="select id,name,quantity from products where id2='".$name."' and quantity <> 0";
if(isset($_GET['no'])){
if($_GET['no']==1){$q="select id,name,quantity from products where id2='".$name."'";}
}
$q=$mysqli->query($q);

echo "<div class='product_auto_search_name'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
echo "<div class='product_auto_search' onclick='get_product_by_id(".$row['id'].")'>".$row['name']." - الكمية : ".$row['quantity']."</div>";
}

}
else{echo "<div class='product_auto_search'>".langu['no_products_name']."</div>";}
echo "</div>";
}
/**
 * جلب البضاعة حسب الاسم
 * @param $mysqli
 */
function get_product_barcode($mysqli){

$barcode=mysqli_real_escape_string($mysqli,htmlentities($_GET['barcode']));
$q='select id,name,quantity from products where barcode="'.$barcode.'" or barcode2="'.$barcode.'" or barcode3="'.$barcode.'" and quantity <> 0';

if(isset($_GET['no'])){
if($_GET['no']==1){$q='select id,name,quantity from products where barcode="'.$barcode.'" or barcode2="'.$barcode.'" or barcode3="'.$barcode.'"';}
}
$q=$mysqli->query($q);
echo "<div class='product_auto_search_name' style='width:25%;margin-top:-2px;'>";
$num=$q->num_rows;
if($num>0){
while ($row=$q->fetch_assoc()){
echo "<div class='product_auto_search' onclick='get_product_by_id(".$row['id'].")'>".$row['name']." - الكمية : ".$row['quantity']."</div>";
}

}
else{echo "<div class='product_auto_search'>".langu['no_products_barcode']."</div>";}
echo "</div>";
}

/**
*ترحيل الفاتورة وتثبيتها في قاعدة البيانات
*/
function save_temp_bill($mysqli){
$id=intval($_GET['id']);
$mysqli->query("UPDATE invoices SET is_temp='0' WHERE id=".$id);

if($mysqli->affected_rows>0){

$row=$mysqli->query('select invoices.*,customers.main_id from invoices,customers where invoices.id='.$id.' and customers.id=invoices.customer_id');
$row=$row->fetch_assoc();
$a=unserialize($row['products']);
if($row['is_tax']==1){$mysqli->query('insert into tax_invoice (invoice_id) VALUES ('.$id.')');}
if($row['is_sent']==1){$mysqli->query('insert into sent_invoice (invoice_id) VALUES ('.$id.')');}

if($row['main_id']==0){
$mysqli->query("update customers set balance=balance+".$row['total']." where id=".$row['customer_id']);
$q=$mysqli->query('select balance from customers where id='.$row['customer_id']);
$q=$q->fetch_assoc();
$mysqli->query("UPDATE invoices SET all_balance=".$q['balance']." WHERE id=".$id);
$this->insert_to_statment($mysqli,1,$id,$row['total'],$q['balance'],$row['customer_id'],0);
}

else{
$mysqli->query("update customers set balance=balance+".$row['total']." where id=".$row['main_id']);
$q=$mysqli->query('select balance from customers where id='.$row['main_id']);
$q=$q->fetch_assoc();
$mysqli->query("UPDATE invoices SET all_balance=".$q['balance']." WHERE id=".$id);
$this->insert_to_statment($mysqli,1,$id,$row['total'],$q['balance'],$row['main_id'],0);
}

$s=$mysqli->prepare("update products set quantity=quantity-? where id=?");

for($i=1;$i<=$a['product_nums'];$i++){
@$s->bind_param("ii",$a['pr'.$i]['quantity'],$a['pr'.$i]['id']);
$s->execute();
}

$this->msg('success',langu['save_temp_success']);

}

else{$this->msg('fail',langu['save_temp_fail']);}
}


/**
* حذف طلبية غير مرحلة
* @param type $mysqli
*/
function del_temp_bill($mysqli){
$mysqli->query('DELETE FROM invoices WHERE id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['del_temp_success']);}
else{$this->msg('fail',langu['del_temp_fail']);}
}

function del_inst_temp_bill($mysqli){
$mysqli->query('DELETE FROM instant_invoice WHERE id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['del_temp_success']);}
else{$this->msg('fail',langu['del_temp_fail']);}
}

function del_ret_inst_temp_bill($mysqli){
$mysqli->query('DELETE FROM return_instant_invoice WHERE id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['del_temp_success']);}
else{$this->msg('fail',langu['del_temp_fail']);}
}

function del_offer($mysqli){
$mysqli->query('DELETE FROM offers WHERE id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['del_temp_success']);}
else{$this->msg('fail',langu['del_temp_fail']);}
}

/**
*جلب قائمة الفاواتير التي تم البحث عنها حسب الاسم اوالتاريخ اوالرقم
*/
function show_bill_list($mysqli,$type){
if($type=='taxnum'){
$q1=$mysqli->query('select invoice_id from tax_invoice where id='.intval($_GET['num']));$q1=$q1->fetch_assoc();
$query="SELECT invoices.*,customers.name as customer_name,employees.name as sale_name FROM invoices,customers,employees where invoices.id=".$q1['invoice_id']." and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id order by invoices.id desc";
}

elseif($type=='sentnum'){
$q1=$mysqli->query('select invoice_id from sent_invoice where id='.intval($_GET['num']));$q1=$q1->fetch_assoc();
$query="SELECT invoices.*,customers.name as customer_name,employees.name as sale_name FROM invoices,customers,employees where invoices.id=".$q1['invoice_id']." and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id order by invoices.id desc";
}

else{
switch ($type) {
    case 'name':$query="SELECT invoices.*,customers.name as customer_name,employees.name as sale_name FROM invoices,customers,employees where invoices.customer_id=".intval($_GET['id'])." and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id order by invoices.id desc";break;
    case 'num':$query="SELECT invoices.*,customers.name as customer_name,employees.name as sale_name FROM invoices,customers,employees where invoices.id=".intval($_GET['num'])." and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id order by invoices.id desc";break;
    case 'date':$query="SELECT invoices.*,customers.name as customer_name,employees.name as sale_name FROM invoices,customers,employees where invoices.date='".$_GET['date']."' and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id order by invoices.id desc";break;
}}
    
$q=$mysqli->query($query);
if(@$q->num_rows>=1){
$total=0;
echo "
<table class='products_list'>
    <tr>
        <th>".langu['order_num']."</th>
        <th>".langu['customer_name']."</th>
        <th>".langu['salesman2']."</th>
        <th>".langu['bill_order']."</th>
        <th>".langu['date']."</th>
        <th></th>
        <th>".langu['tax_bill']."</th>
        <th>".langu['sent_bill']."</th>
    </tr>";
while($row=$q->fetch_assoc()){
$total+=$row['total'];
$tax='<td></td>';$sent='<td></td>';
if($row['is_tax']==1){$tax="<td class='products_list_symbol'><a href='printbills.php?print_bills=tax&id=".$row['id']."' target='_blank'>|</a></td>";}
if($row['is_sent']==1){$sent="<td class='products_list_symbol'><a href='printbills.php?print_bills=sent&id=".$row['id']."' target='_blank'>|</a></td>";}
echo "
    <tr>
        <td class='nume'>".$row['id']."</td>
        <td>".$row['customer_name']."</td>
        <td>".$row['sale_name']."</td>
        <td class='nume'>".$row['total']."</td>
        <td class='nume'>".$row['date']."</td>
        <td class='products_list_symbol'><a href='printbills.php?print_bills=temp&id=".$row['id']."' target='_blank'>|</a></td>
    ".$tax.$sent."
    </tr>";
}
echo "
    <tr>
        <td>".langu['final_total']."</td>
        <td></td>
        <td></td>
        <td class='nume'>".$total."</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>";
}

else{$this->msg('fail',langu['find_bills_error'],1);}
}
/**
*جلب قائمة الفاواتير التي تم البحث عنها حسب الاسم اوالتاريخ اوالرقم
*/
function show_returned_list($mysqli,$type){

switch ($type) {
    case 'name':$query="SELECT returned_products.*,customers.name as customer_name,employees.name as sale_name FROM returned_products,customers,employees where returned_products.customer_id=".intval($_GET['id'])." and returned_products.sales_man_id=employees.id and returned_products.customer_id=customers.id order by returned_products.id desc";break;
    case 'num':$query="SELECT returned_products.*,customers.name as customer_name,employees.name as sale_name FROM returned_products,customers,employees where returned_products.id=".intval($_GET['num'])." and returned_products.sales_man_id=employees.id and returned_products.customer_id=customers.id order by returned_products.id desc";break;
    case 'date':$query="SELECT returned_products.*,customers.name as customer_name,employees.name as sale_name FROM returned_products,customers,employees where returned_products.date='".$_GET['date']."' and returned_products.sales_man_id=employees.id and returned_products.customer_id=customers.id order by returned_products.id desc";break;
    case 'sale':$query="SELECT returned_products.*,customers.name as customer_name,employees.name as sale_name FROM returned_products,customers,employees where returned_products.sales_man_id='".intval($_GET['id'])."' and returned_products.sales_man_id=employees.id and returned_products.customer_id=customers.id order by returned_products.id desc";break;
}
    
$q=$mysqli->query($query);
if(@$q->num_rows>=1){
$t=0;$i=1;
echo "
<table class='products_list'>
    <tr>
        <th></th>
        <th>".langu['num']." ".langu['returned_order']."</th>
        <th>".langu['customer_name']."</th>
        <th>".langu['total']."</th>
        <th>".langu['salesman2']."</th>
        <th>".langu['date']."</th>
        <th></th>
    </tr>";
while($row=$q->fetch_assoc()){
$t+=$row['total'];
echo "
    <tr>
        <td class='nume'>".$i."</td>
        <td class='nume'>".$row['id']."</td>
        <td>".$row['customer_name']."</td>
        <td class='nume'>".$row['total']."</td>
        <td>".$row['sale_name']."</td>
        <td class='nume'>".$row['date']."</td>
        <td class='products_list_symbol'><a href='printbills.php?print_bills=returned&id=".$row['id']."' target='_blank'>|</a></td>
    </tr>";
$i++;
}
echo "
    <tr>
        <td></td>
        <td>".langu['final_total']."</td>
        <td></td>
        <td class='nume'>".$t."</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>";
}

else{$this->msg('fail',langu['find_bills_error'],1);}
}
/**
*جلب قائمة الفاواتير التي تم البحث عنها حسب الاسم اوالتاريخ اوالرقم
*/
function show_instant_list($mysqli,$type){
$t_id=0;
$total=0;
$t_profit=0;
switch ($type) {
    case 'name':$query="SELECT instant_invoice.*,merchants.name as merchant_name FROM instant_invoice,merchants where instant_invoice.merchant_id=".intval($_GET['id'])." and instant_invoice.merchant_id=merchants.id order by instant_invoice.id desc";break;
    case 'num':$query="SELECT instant_invoice.*,merchants.name as merchant_name FROM instant_invoice,merchants where instant_invoice.id=".intval($_GET['num'])." and instant_invoice.merchant_id=merchants.id order by instant_invoice.id desc";break;
    case 'date':$query="SELECT instant_invoice.*,merchants.name as merchant_name FROM instant_invoice,merchants where instant_invoice.date='".$_GET['date']."' and instant_invoice.merchant_id=merchants.id order by instant_invoice.id desc";break;
    case'partner':$query="SELECT * FROM instant_invoice where partner_id='".$_GET['id']."' order by id desc";break;
    case'employee':$query="SELECT * FROM instant_invoice where employee_id='".$_GET['id']."' order by id desc";break;
}

$q=$mysqli->query($query);
if(@$q->num_rows>=1){
echo "
<table class='products_list'>
    <tr>
        <th>".langu['bill_num']."</th>
        <th>".langu['from']."</th>
        <th>".langu['bill_total']."</th>
        <th>".langu['profit']."</th>
        <th>".langu['date']."</th>
        <th class='products_list_symbol'></th>
    </tr>";
while($row=$q->fetch_assoc()){
$t_id+=1;
$total+=$row['total'];
$t_profit+=$row['profit'];
$name=langu['instant_pay'];
if($row['merchant_id']!=0){$name=$row['merchant_name'];}
elseif($row['employee_id']!=0){$q2=$mysqli->query("select name from employees where id=".$row['employee_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
elseif($row['partner_id']!=0){$q2=$mysqli->query("select name from partners where id=".$row['partner_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
else{if($row['customer_name']!=''){$name=$row['customer_name'];}else{$name=langu['normal_customer'];}}

echo "
    <tr>
        <td class='nume'>".$row['id']."</td>
        <td>".$name."</td>
        <td class='nume'>".$row['total']."</td>
        <td class='nume'>".$row['profit']."</td>
        <td class='nume'>".$row['date']."</td>
        <td class='products_list_symbol'><a href='printbills.php?print_bills=instant&id=".$row['id']."' target='_blank'>|</a></td>
    </tr>";
}
echo "
    <tr>
        <td class='nume'>".$t_id."</td>
        <td></td>
        <td class='nume'>".$total."</td>
        <td class='nume'>".$t_profit."</td>
        <td class='nume'></td>
        <td class='products_list_symbol'></td>
    </tr>
</table>";
}

else{$this->msg('fail',langu['find_bills_error'],1);}

}

/**
*جلب قائمة الفاواتير التي تم البحث عنها حسب الاسم اوالتاريخ اوالرقم
*/
function show_ret_instant_list($mysqli,$type){
$t_id=0;
$total=0;
$t_profit=0;
switch ($type) {
    case 'name':$query="SELECT return_instant_invoice.*,merchants.name as merchant_name FROM return_instant_invoice,merchants where return_instant_invoice.merchant_id=".intval($_GET['id'])." and return_instant_invoice.merchant_id=merchants.id order by return_instant_invoice.id desc";break;
    case 'num':$query="SELECT return_instant_invoice.*,merchants.name as merchant_name FROM return_instant_invoice,merchants where return_instant_invoice.id=".intval($_GET['num'])." and return_instant_invoice.merchant_id=merchants.id order by return_instant_invoice.id desc";break;
    case 'date':$query="SELECT return_instant_invoice.*,merchants.name as merchant_name FROM return_instant_invoice,merchants where return_instant_invoice.date='".$_GET['date']."' and return_instant_invoice.merchant_id=merchants.id order by return_instant_invoice.id desc";break;
    case'partner':$query="SELECT * FROM return_instant_invoice where partner_id='".$_GET['id']."' order by id desc";break;
    case'employee':$query="SELECT * FROM return_instant_invoice where employee_id='".$_GET['id']."' order by id desc";break;
}

$q=$mysqli->query($query);
if(@$q->num_rows>=1){
echo "
<table class='products_list'>
    <tr>
        <th>".langu['bill_num']."</th>
        <th>".langu['from']."</th>
        <th>".langu['bill_total']."</th>
        <th>".langu['profit']."</th>
        <th>".langu['date']."</th>
        <th class='products_list_symbol'></th>
    </tr>";
while($row=$q->fetch_assoc()){
$t_id+=1;
$total+=$row['total'];
$t_profit+=$row['profit'];
$name=langu['instant_pay'];
if($row['merchant_id']!=0){$name=$row['merchant_name'];}
elseif($row['employee_id']!=0){$q2=$mysqli->query("select name from employees where id=".$row['employee_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
elseif($row['partner_id']!=0){$q2=$mysqli->query("select name from partners where id=".$row['partner_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
else{if($row['customer_name']!=''){$name=$row['customer_name'];}else{$name=langu['normal_customer'];}}

echo "
    <tr>
        <td class='nume'>".$row['id']."</td>
        <td>".$name."</td>
        <td class='nume'>".$row['total']."</td>
        <td class='nume'>".$row['profit']."</td>
        <td class='nume'>".$row['date']."</td>
        <td class='products_list_symbol'><a href='printbills.php?print_bills=return_instant&id=".$row['id']."' target='_blank'>|</a></td>
    </tr>";
}
echo "
    <tr>
        <td class='nume'>".$t_id."</td>
        <td></td>
        <td class='nume'>".$total."</td>
        <td class='nume'>".$t_profit."</td>
        <td class='nume'></td>
        <td class='products_list_symbol'></td>
    </tr>
</table>";
}

else{$this->msg('fail',langu['find_bills_error'],1);}

}

function show_merchant_bill_list($mysqli,$type){

switch ($type) {
    case 'name':$query="SELECT merchant_invoice.*,merchants.name as merchant_name FROM merchant_invoice,merchants where merchant_invoice.merchant_id=".intval($_GET['id'])." and merchant_invoice.merchant_id=merchants.id order by merchant_invoice.id desc";break;
    case 'num':$query="SELECT merchant_invoice.*,merchants.name as merchant_name FROM merchant_invoice,merchants where merchant_invoice.bill_num=".intval($_GET['num'])." and merchant_invoice.merchant_id=merchants.id order by merchant_invoice.id desc";break;
    case 'date':$query="SELECT merchant_invoice.*,merchants.name as merchant_name FROM merchant_invoice,merchants where merchant_invoice.date='".$_GET['date']."' and merchant_invoice.merchant_id=merchants.id order by merchant_invoice.id desc";break;
}
    
$q=$mysqli->query($query);
if(@$q->num_rows>=1){
echo "
<table class='products_list'>
    <tr>
        <th>".langu['bill_num']."</th>
        <th>".langu['from']." ".langu['merchant2']."</th>
        <th>".langu['bill_total']."</th>
        <th>".langu['date']."</th>
        <th></th>
    </tr>";
while($row=$q->fetch_assoc()){

echo "
    <tr>
        <td class='nume'>".$row['bill_num']."</td>
        <td>".$row['merchant_name']."</td>
        <td class='nume'>".$row['total']."</td>
        <td class='nume'>".$row['date']."</td>
        <td class='products_list_symbol'><a href='printbills.php?print_bills=merchant_bill&id=".$row['id']."' target='_blank'>|</a></td>
    </tr>";
}
echo "
</table>";
}

else{$this->msg('fail',langu['find_bills_error'],1);}
}

function show_merchant_retbill_list($mysqli,$type){

switch ($type) {
    case 'name':$query="SELECT merchant_returned.*,merchants.name as merchant_name FROM merchant_returned,merchants where merchant_returned.merchant_id=".intval($_GET['id'])." and merchant_returned.merchant_id=merchants.id order by merchant_returned.id desc";break;
    case 'num':$query="SELECT merchant_returned.*,merchants.name as merchant_name FROM merchant_returned,merchants where merchant_returned.id=".intval($_GET['num'])." and merchant_returned.merchant_id=merchants.id order by merchant_returned.id desc";break;
    case 'date':$query="SELECT merchant_returned.*,merchants.name as merchant_name FROM merchant_returned,merchants where merchant_returned.date='".$_GET['date']."' and merchant_returned.merchant_id=merchants.id order by merchant_returned.id desc";break;
}
    
$q=$mysqli->query($query);
if(@$q->num_rows>=1){
echo "
<table class='products_list'>
    <tr>
        <th>".langu['bill_num']."</th>
        <th>".langu['from']." ".langu['merchant2']."</th>
        <th>".langu['bill_total']."</th>
        <th>".langu['date']."</th>
        <th></th>
    </tr>";
while($row=$q->fetch_assoc()){

echo "
    <tr>
        <td class='nume'>".$row['id']."</td>
        <td>".$row['merchant_name']."</td>
        <td class='nume'>".$row['total']."</td>
        <td class='nume'>".$row['date']."</td>
        <td class='products_list_symbol'><a href='printbills.php?print_bills=retmerchant&id=".$row['id']."' target='_blank'>|</a></td>
    </tr>";
}
echo "
</table>";
}

else{$this->msg('fail',langu['find_bills_error'],1);}
}
/**
*جلب معلومات الشيك ووضعها في جدول
*/
function get_check_details($mysqli){
$r_id=$_GET['revenue_id'];

$row=$mysqli->query("SELECT checks.*,banks.name as bank_name,currency.name as cur_name FROM checks,banks,currency where checks.id=".intval($_GET['id'])." and banks.id=checks.bank_id and currency.id=checks.currency_id");
$row=$row->fetch_assoc();
$del="";
$name=langu['normal_customer'];
if($row['customer_id']!=0){$row2=$mysqli->query("select name from customers where id=".$row['customer_id']);$row2=$row2->fetch_assoc(); $name=$row2['name'];}
elseif($row['merchant_id']!=0){$row2=$mysqli->query("select name from merchants where id=".$row['merchant_id']);$row2=$row2->fetch_assoc();$name=$row2['name'];}
elseif($row['normal_customer']==1){if($row['normal_customer_name']!=''){$name=$row['normal_customer_name'];}}

if($row['is_returned']==0){$ret="<td class='returned_symbol' onclick='login_modal(\"".langu['checks']."\",\"ajaxbills.php?find_check=spend&id=".intval($_GET['id'])."\")'><span></span></td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajax_settings.php?find_check=form_returned&id=".intval($_GET['id'])."\")'><span></span></td>";}
elseif($row['is_returned']==2){$ret="<td style='color:green;font-size:20px;'>✔</td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajax_settings.php?find_check=form_returned&id=".intval($_GET['id'])."\")'><span></span></td>";}
else{$ret="<td style='font-size:20px;font-weight:bold;'>X</td><td style='color:green;font-size:20px;'>✔</td>";}
if($row['expense_id']!=0){$del="<span class='delete_check delinp' id='delete_el".$row['id']."' onclick='remove_check_from_expense(".$row['id'].")'></span>";}
echo "
<tr class='show_hide'>
    <td>".$del.$name."</td>
    <td>".$row['bank_name']."</td>
    <td class='nume'>".$row['check_num']."</td>
    <td class='nume'>".$row['check_date']."</td>
    <td class='nume'>".$row['check_value']."</td>
    <td class='nume'>".$row['cur_name']."</td>
    <td class='nume'>".$row['exchange_rate']."</td>
".$ret."
</tr>";

}
function get_customer_check($mysqli){


$q=$mysqli->query("SELECT checks.*,banks.name as bank_name,currency.name as cur_name FROM checks,banks,currency where checks.customer_id=".intval($_GET['id'])." and banks.id=checks.bank_id and currency.id=checks.currency_id");
while($row=$q->fetch_assoc()){
$del="";
$name=langu['normal_customer'];
if($row['customer_id']!=0){$row2=$mysqli->query("select name from customers where id=".$row['customer_id']);$row2=$row2->fetch_assoc(); $name=$row2['name'];}
elseif($row['merchant_id']!=0){$row2=$mysqli->query("select name from merchants where id=".$row['merchant_id']);$row2=$row2->fetch_assoc();$name=$row2['name'];}
elseif($row['normal_customer']==1){if($row['normal_customer_name']!=''){$name=$row['normal_customer_name'];}}

if($row['is_returned']==0){$ret="<td class='returned_symbol' onclick='login_modal(\"".langu['checks']."\",\"ajaxbills.php?find_check=spend&id=".$row['id']."\")'><span></span></td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajax_settings.php?find_check=form_returned&id=".$row['id']."\")'><span></span></td>";}
elseif($row['is_returned']==2){$ret="<td style='color:green;font-size:20px;'>✔</td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajax_settings.php?find_check=form_returned&id=".$row['id']."\")'><span></span></td>";}
else{$ret="<td style='font-size:20px;font-weight:bold;'>X</td><td style='color:green;font-size:20px;'>✔</td>";}
if($row['expense_id']!=0){$del="<span class='delete_check delinp' id='delete_el".$row['id']."' onclick='remove_check_from_expense(".$row['id'].")'></span>";}
echo "
<tr class='show_hide'>
    <td>".$del.$name."</td>
    <td>".$row['bank_name']."</td>
    <td class='nume'>".$row['check_num']."</td>
    <td class='nume'>".$row['check_date']."</td>
    <td class='nume'>".$row['check_value']."</td>
    <td class='nume'>".$row['cur_name']."</td>
    <td class='nume'>".$row['exchange_rate']."</td>
".$ret."
</tr>";
}
}

function get_merchant_check($mysqli){


$q=$mysqli->query("SELECT checks.*,banks.name as bank_name,currency.name as cur_name FROM checks,banks,currency where checks.merchant_id=".intval($_GET['id'])." and banks.id=checks.bank_id and currency.id=checks.currency_id");
while($row=$q->fetch_assoc()){
$del='';
$name=langu['normal_customer'];
if($row['customer_id']!=0){$row2=$mysqli->query("select name from customers where id=".$row['customer_id']);$row2=$row2->fetch_assoc(); $name=$row2['name'];}
elseif($row['merchant_id']!=0){$row2=$mysqli->query("select name from merchants where id=".$row['merchant_id']);$row2=$row2->fetch_assoc();$name=$row2['name'];}
elseif($row['normal_customer']==1){if($row['normal_customer_name']!=''){$name=$row['normal_customer_name'];}}

if($row['is_returned']==0){$ret="<td class='returned_symbol' onclick='login_modal(\"".langu['checks']."\",\"ajaxbills.php?find_check=spend&id=".$row['id']."\")'><span></span></td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajax_settings.php?find_check=form_returned&id=".$row['id']."\")'><span></span></td>";}
elseif($row['is_returned']==2){$ret="<td style='color:green;font-size:20px;'>✔</td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajax_settings.php?find_check=form_returned&id=".$row['id']."\")'><span></span></td>";}
else{$ret="<td style='font-size:20px;font-weight:bold;'>X</td><td style='color:green;font-size:20px;'>✔</td>";}
if($row['expense_id']!=0){$del="<span class='delete_check delinp' id='delete_el".$row['id']."' onclick='remove_check_from_expense(".$row['id'].")'></span>";}
echo "
<tr class='show_hide'>
    <td>".$del.$name."</td>
    <td>".$row['bank_name']."</td>
    <td class='nume'>".$row['check_num']."</td>
    <td class='nume'>".$row['check_date']."</td>
    <td class='nume'>".$row['check_value']."</td>
    <td class='nume'>".$row['cur_name']."</td>
    <td class='nume'>".$row['exchange_rate']."</td>
".$ret."
</tr>";
}
}

function get_check_by_date($mysqli){

$q=$mysqli->query("SELECT checks.*,banks.name as bank_name,currency.name as cur_name FROM checks,banks,currency where month(checks.check_date)=".intval($_GET['month'])." and year(checks.check_date)=".intval($_GET['year'])." and banks.id=checks.bank_id and currency.id=checks.currency_id");
while($row=$q->fetch_assoc()){
$del='';
$name=langu['normal_customer'];
if($row['customer_id']!=0){$row2=$mysqli->query("select name from customers where id=".$row['customer_id']);$row2=$row2->fetch_assoc(); $name=$row2['name'];}
elseif($row['merchant_id']!=0){$row2=$mysqli->query("select name from merchants where id=".$row['merchant_id']);$row2=$row2->fetch_assoc();$name=$row2['name'];}
elseif($row['normal_customer']==1){if($row['normal_customer_name']!=''){$name=$row['normal_customer_name'];}}

if($row['is_returned']==0){$ret="<td class='returned_symbol' onclick='login_modal(\"".langu['checks']."\",\"ajaxbills.php?find_check=spend&id=".intval($row['id'])."\")'><span></span></td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajax_settings.php?find_check=form_returned&id=".intval($row['id'])."\")'><span></span></td>";}
elseif($row['is_returned']==2){$ret="<td style='color:green;font-size:20px;'>✔</td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajax_settings.php?find_check=form_returned&id=".intval($row['id'])."\")'><span></span></td>";}
else{$ret="<td style='font-size:20px;font-weight:bold;'>X</td><td style='color:green;font-size:20px;'>✔</td>";}
if($row['expense_id']!=0){$del="<span class='delete_check delinp' id='delete_el".$row['id']."' onclick='remove_check_from_expense(".$row['id'].")'></span>";}
echo "
<tr class='show_hide'>
    <td>".$name."</td>
    <td>".$row['bank_name']."</td>
    <td class='nume'>".$row['check_num']."</td>
    <td class='nume'>".$row['check_date']."</td>
    <td class='nume'>".$row['check_value']."</td>
    <td class='nume'>".$row['cur_name']."</td>
    <td class='nume'>".$row['exchange_rate']."</td>
".$ret."
</tr>";
}
}
/**
*جلب معلومات الشيك ووضعها في جدول
*/
function get_our_check_details($mysqli){

$q=$mysqli->query("SELECT our_checks.*,banks.name as bank_name,currency.name as cur_name FROM our_checks,banks,currency where our_checks.id=".intval($_GET['id'])." and banks.id=our_checks.bank_id and currency.id=our_checks.currency_id");

while($row=$q->fetch_assoc()){
if($row['customer_id']!=0){$que="select name from customers where id=".$row['customer_id'];}
elseif($row['merchant_id']!=0){$que="select name from merchants where id=".$row['merchant_id'];}
elseif($row['employee_id']!=0){$que="select name from employees where id=".$row['employee_id'];}
elseif($row['partner_id']!=0){$que="select name from partners where id=".$row['partner_id'];}
else{$que="SELECT expense_types.name from expense_types,expense where expense.id=".$row['expense_id']." and expense.expense_type=expense_types.id";}
$row2=$mysqli->query($que);
$row2=$row2->fetch_assoc();

if($row['is_returned']==0){$ret="<td class='returned_symbol' onclick='login_modal(\"".langu['checks']."\",\"ajaxbills.php?find_check=our_check_spend&id=".$row['id']."\")'><span></span></td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajaxbills.php?find_check=our_check_return&id=".$row['id']."\")'><span></span></td>";}
elseif($row['is_returned']==1){$ret="<td style='color:red;font-size:20px;'>X</td><td style='color:green;font-size:20px;'>✔</td>";}
else{$ret="<td style='color:green;font-size:20px;'>✔</td><td style='color:red;font-size:20px;'>X</td>";}
echo "
<tr class='show_hide'>
    <td><span class='delete_check delinp' id='delete_el".$row['id']."' onclick='remove_our_check_from_expense(".$row['id'].")'></span>".$row2['name']."</td>
    <td>".$row['bank_name']."</td>
    <td class='nume'>".$row['check_num']."</td>
    <td class='nume'>".$row['check_date']."</td>
    <td class='nume'>".$row['check_value']."</td>
    <td class='nume'>".$row['cur_name']."</td>
    <td class='nume'>".$row['exchange_rate']."</td>
".$ret."
</tr>";
}
}

function get_our_check_by_date($mysqli){

$q=$mysqli->query("SELECT our_checks.*,banks.name as bank_name,currency.name as cur_name FROM our_checks,banks,currency where month(our_checks.check_date)=".intval($_GET['month'])." and year(our_checks.check_date)=".intval($_GET['year'])." and banks.id=our_checks.bank_id and currency.id=our_checks.currency_id");

while($row=$q->fetch_assoc()){
if($row['customer_id']!=0){$que="select name from customers where id=".$row['customer_id'];}
elseif($row['merchant_id']!=0){$que="select name from merchants where id=".$row['merchant_id'];}
elseif($row['employee_id']!=0){$que="select name from employees where id=".$row['employee_id'];}
elseif($row['partner_id']!=0){$que="select name from partners where id=".$row['partner_id'];}
else{$que="SELECT expense_types.name from expense_types,expense where expense.id=".$row['expense_id']." and expense.expense_type=expense_types.id";}
$row2=$mysqli->query($que);
$row2=$row2->fetch_assoc();

if($row['is_returned']==0){$ret="<td class='returned_symbol' onclick='login_modal(\"".langu['checks']."\",\"ajaxbills.php?find_check=our_check_spend&id=".$row['id']."\")'><span></span></td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajaxbills.php?find_check=our_check_return&id=".$row['id']."\")'><span></span></td>";}
elseif($row['is_returned']==1){$ret="<td style='color:red;font-size:20px;'>X</td><td style='color:green;font-size:20px;'>✔</td>";}
else{$ret="<td style='color:green;font-size:20px;'>✔</td><td style='color:red;font-size:20px;'>X</td>";}
echo "
<tr class='show_hide'>
    <td>".$row2['name']."</td>
    <td>".$row['bank_name']."</td>
    <td class='nume'>".$row['check_num']."</td>
    <td class='nume'>".$row['check_date']."</td>
    <td class='nume'>".$row['check_value']."</td>
    <td class='nume'>".$row['cur_name']."</td>
    <td class='nume'>".$row['exchange_rate']."</td>
".$ret."
</tr>";
}
}

/**
 * تم صرف الشيك من الزبائن او التجار
 * @param type $mysqli
 */
function check_spend($mysqli){
$mysqli->query('update checks set is_returned=2 where id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}
else{$this->msg('fail',langu['edit_fail']);}
}

/**
 * تم صرف الشيك الشخصي
 * @param type $mysqli
 */
function our_check_spend($mysqli){
$id=intval($_GET['id']);
/*$row=$mysqli->query('select * from our_checks where id='.$id);
$row=$row->fetch_assoc();
if($row['customer_id']!=0){$mysqli->query('update customers set balance=balance+'.$row['check_value'].' where id='.$row['customer_id']);}
elseif($row['merchant_id']!=0){$mysqli->query('update merchants set balance=balance-'.$row['check_value'].' where id='.$row['merchant_id']);}*/
$mysqli->query('update our_checks set is_returned=2 where id='.$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}
else{$this->msg('fail',langu['edit_fail']);}
}

/**
 * ارجاع الشيك الشخصي
 * @param type $mysqli
 */
function our_check_return($mysqli){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from our_checks where id='.$id);
$row=$row->fetch_assoc();
if($row['currency_id']==1){$total=$row['check_value'];}
else{$total=$row['check_value']*$row['exchange_rate'];}
if($row['customer_id']!=0){
$mysqli->query('update customers set balance=balance-'.$total.' where id='.$row['customer_id']);
$row4=$mysqli->query('select balance from customers WHERE id='.$row['customer_id']);
$row4=$row4->fetch_assoc();
$this->insert_to_statment($mysqli,9,$id, $total,$row4["balance"],$row['customer_id'],0);
//$mysqli->query('INSERT INTO return_not_personal_check (customer_id,all_balance,our_check_id,date) VALUES ('.$row['customer_id'].','.$row4["balance"].','.$id.',"'.date('Y-m-d').'")');
}

elseif($row['merchant_id']!=0){
$mysqli->query('update merchants set balance=balance+'.$total.' where id='.$row['merchant_id']);
$row4=$mysqli->query('select balance from merchants WHERE id='.$row['merchant_id']);
$row4=$row4->fetch_assoc();
$this->insert_to_statment($mysqli,9,$id, $total,$row4["balance"],0,$row['merchant_id']);
//$mysqli->query('INSERT INTO return_not_personal_check (merchant_id,all_balance,our_check_id,date) VALUES ('.$row["merchant_id"].','.$row4["balance"].','.$id.',"'.date('Y-m-d').'")');
}

$mysqli->query('update our_checks set is_returned=1 where id='.$id);

if($mysqli->affected_rows>0){$this->msg('success',langu['check_return_success']);}
else{$this->msg('fail',langu['check_return_fail']);}
}

/**
 * ترحيل سند الصرف
 * @param $mysqli
 */
function update_temp_permnt_expense($mysqli,$id,$type){
$row=$mysqli->query('select * from expense where id='.$id);$row=$row->fetch_assoc();
$total=$row['cash_value']+$row['check_value']+$row['our_check_value'];
$type=$row['expense_type'];
/*--if merchants--*/
if($type==3){
$total+=$row['discount'];
$mysqli->query('update merchants set balance=balance-'.$total.' where id='.$row['merchant_id']);
$row3=$mysqli->query('select balance from merchants where id='.$row['merchant_id']);
$row3=$row3->fetch_assoc();
$this->insert_to_statment($mysqli,7,$id,$total,$row3['balance'],0,$row['merchant_id']);
$mysqli->query('update expense set is_temp=0,all_balance='.$row3['balance'].' where id='.$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['from_temp_success']);}
else{$this->msg('fail',langu['from_temp_fail']);}
}

/*--if customer--*/
elseif($type==5){
$total+=$row['discount'];
$row2=$mysqli->query('select * from customers where id='.$row['customer_id']);
$row2=$row2->fetch_assoc();

if($row2['main_id']==0){$mysqli->query('update customers set balance=balance+'.$total.' where id='.$row['customer_id']);$cid=$row['customer_id'];}
else{$mysqli->query('update customers set balance=balance+'.$total.' where id='.$row2['main_id']);$cid=$row2['main_id'];}
$row3=$mysqli->query('select balance from customers where id='.$cid);
$row3=$row3->fetch_assoc();
$this->insert_to_statment($mysqli,7,$id,$total,$row3['balance'],$cid,0);
$mysqli->query('update expense set is_temp=0,all_balance='.$row3['balance'].' where id='.$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['from_temp_success']);}
else{$this->msg('fail',langu['from_temp_fail']);}
}
/*--others--*/
else{
$mysqli->query('update expense set is_temp=0 where id='.$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['from_temp_success']);}
else{$this->msg('fail',langu['from_temp_fail']);}
}

/*-- if checks true save them--*/
if($row['is_check']==1){
$mysqli->query('update checks set is_returned=2 where expense_id='.$id);
}

}

/**
 * حذف سند صرف غير مرحل
 * @param $mysqli
 * @param $id ايدي سند الصرف
 */
function delete_temp_exp($mysqli,$id){
$mysqli->query('update checks set expense_id=0,is_returned=0 where expense_id='.$id);
$mysqli->query('DELETE FROM our_checks WHERE expense_id='.$id);
$mysqli->query('DELETE FROM expense WHERE id='.$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['delete_success']);}
else{$this->msg('fail',langu['delete_fail']);}
}

/**
* حذف طلبية غير مرحلة
* @param type $mysqli
*/
function del_merchant_temp_bill($mysqli){
$mysqli->query('DELETE FROM merchant_invoice WHERE id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['del_temp_success']);}
else{$this->msg('fail',langu['del_temp_fail']);}
}
function del_retmerchant_temp_bill($mysqli){
$mysqli->query('DELETE FROM merchant_returned WHERE id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['del_temp_success']);}
else{$this->msg('fail',langu['del_temp_fail']);}
}

function del_ret_temp_bill($mysqli){
$mysqli->query('DELETE FROM returned_products WHERE id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['del_temp_success']);}
else{$this->msg('fail',langu['del_temp_fail']);}
}
/**
 *حفظ فاتورة غير مرحلة وتعديل البضاعة حسب السعر والكمية
 */
function save_merchant_temp_bill($mysqli){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from merchant_invoice WHERE id='.$id);
$row=$row->fetch_assoc();

$pr=unserialize($row['products']);
$num=$pr['product_nums'];
for($i=1;$i<=$num;$i++){
$quantity=$pr['pr'.$i]['quantity'];

if($pr['pr'.$i]['bonus']==1){
$mysqli->query('update products set quantity=quantity+'.$quantity.' where id='.$pr['pr'.$i]['id']);
}

else{
$row2=$mysqli->query('select * from products where id='.$pr['pr'.$i]['id']);
$row2=$row2->fetch_assoc();

if($row2['our_price']==$pr['pr'.$i]['price']){
$mysqli->query('update products set quantity=quantity+'.$quantity.' where id='.$pr['pr'.$i]['id']);
}

else{
$all_quant=$row2['quantity']+$quantity;
$old_price=$row2['quantity']*$row2['our_price'];
$new_price=$quantity*$pr['pr'.$i]['price'];
$all_price=$old_price+$new_price;
$final_price=$all_price/$all_quant;
$mysqli->query('update products set quantity='.$all_quant.',our_price='.$final_price.' where id='.$pr['pr'.$i]['id']);
}
}

}

$mysqli->query('update merchants set balance=balance+'.$pr['balance'].' where id='.$row['merchant_id']);
$q=$mysqli->query('select balance from merchants where id='.$row['merchant_id']);
$q=$q->fetch_assoc();
$notes=langu['order']." ".langu['from']." ".langu['merchant']." ".langu['num']." : ".$row['bill_num'];
$this->insert_to_statment($mysqli,3,$id,$pr['balance'],$q['balance'],0,$row['merchant_id']);
$mysqli->query("update merchant_invoice SET is_temp='0',all_balance=".$q['balance']." WHERE id=".$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['save_temp_success']);}

else{$this->msg('fail',langu['save_temp_fail']);}

}

function save_retmerchant_temp_bill($mysqli){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from merchant_returned WHERE id='.$id);
$row=$row->fetch_assoc();

$pr=unserialize($row['products']);
$num=$pr['product_nums'];
for($i=1;$i<=$num;$i++){
$quantity=$pr['pr'.$i]['quantity'];

$mysqli->query('update products set quantity=quantity-'.$quantity.' where id='.$pr['pr'.$i]['id']);

}

$mysqli->query('update merchants set balance=balance-'.$pr['balance'].' where id='.$row['merchant_id']);
$q=$mysqli->query('select balance from merchants where id='.$row['merchant_id']);
$q=$q->fetch_assoc();
$this->insert_to_statment($mysqli,4,$id,$pr['balance'],$q['balance'],0,$row['merchant_id']);
$mysqli->query("update merchant_returned SET is_temp='0',all_balance=".$q['balance']." WHERE id=".$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['save_temp_success']);}

else{$this->msg('fail',langu['save_temp_fail']);}

}
/**
 *حفظ فاتورة بضاعه مرتجعة
 */
function save_returned_temp_bill($mysqli){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from returned_products WHERE id='.$id);
$row=$row->fetch_assoc();

$pr=unserialize($row['products']);
$num=$pr['product_nums'];
for($i=1;$i<=$num;$i++){

$mysqli->query('update products set quantity=quantity+'.$pr['pr'.$i]['quantity'].' where id='.$pr['pr'.$i]['id']);

}
$row2=$mysqli->query('select * from customers WHERE id='.$row['customer_id']);
$row2=$row2->fetch_assoc();
if($row2['main_id']==0){
$mysqli->query('update customers set balance=balance-'.$pr['balance'].' where id='.$row['customer_id']);
$row3=$mysqli->query('select balance from customers WHERE id='.$row2['id']);
$row3=$row3->fetch_assoc();
$this->insert_to_statment($mysqli,2,$id,$pr['balance'],$row3['balance'],$row['customer_id'],0);
}

else{
$mysqli->query('update customers set balance=balance-'.$pr['balance'].' where id='.$row2['main_id']);
$row3=$mysqli->query('select balance from customers WHERE id='.$row2['main_id']);
$row3=$row3->fetch_assoc();
$this->insert_to_statment($mysqli,2,$id,$pr['balance'],$row3['balance'],$row2['main_id'],0);
}

$mysqli->query("update returned_products SET is_temp='0',all_balance=".$row3['balance']." WHERE id=".$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['save_temp_success']);}

else{$this->msg('fail',langu['save_temp_fail']);}

}

function save_temp_instant($mysqli){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from instant_invoice where id='.$id);
$row=$row->fetch_assoc();
$a=unserialize($row['products']);

if($row['merchant_id']!=0){
$mysqli->query('update merchants set balance=balance-'.$row['total'].' where id='.$row['merchant_id']);
$row3=$mysqli->query('select balance from merchants where id='.$row['merchant_id']);
$row3=$row3->fetch_assoc();
$mysqli->query('update instant_invoice set is_temp=0,all_balance='.$row3['balance'].' where id='.$id);
$this->insert_to_statment($mysqli,5,$id,$row['total'],$row3['balance'],0,$row['merchant_id']);
}
elseif($row['partner_id']!=0){
$mysqli->query("INSERT INTO expense (expense_type,is_cash,cash_value,date,partner_id,is_temp) VALUES (0,1,".$row['total'].",'".$row['date']."',".$row['partner_id'].",0)");
}
elseif($row['employee_id']!=0){
$mysqli->query("INSERT INTO expense (expense_type,is_cash,cash_value,date,employee_id,is_temp) VALUES (1,1,".$row['total'].",'".$row['date']."',".$row['employee_id'].",0)");
}

$mysqli->query('update instant_invoice set is_temp=0 where id='.$id);



$s=$mysqli->prepare("update products set quantity=quantity-? where id=?");

for($i=1;$i<=$a['product_nums'];$i++){
@$s->bind_param("ii",$a['pr'.$i]['quantity'],$a['pr'.$i]['id']);
$s->execute();
}


if($mysqli->affected_rows>0){$this->msg('success',langu['save_temp_success']);}

else{$this->msg('fail',langu['save_temp_fail']);}
}

function save_temp_ret_instant($mysqli){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from return_instant_invoice where id='.$id);
$row=$row->fetch_assoc();
$a=unserialize($row['products']);

if($row['merchant_id']!=0){
$mysqli->query('update merchants set balance=balance+'.$row['total'].' where id='.$row['merchant_id']);
$row3=$mysqli->query('select balance from merchants where id='.$row['merchant_id']);
$row3=$row3->fetch_assoc();
$mysqli->query('update return_instant_invoice set is_temp=0,all_balance='.$row3['balance'].' where id='.$id);
$this->insert_to_statment($mysqli,11,$id,$row['total'],$row3['balance'],0,$row['merchant_id']);
}

$mysqli->query('update return_instant_invoice set is_temp=0 where id='.$id);



$s=$mysqli->prepare("update products set quantity=quantity+? where id=?");

for($i=1;$i<=$a['product_nums'];$i++){
@$s->bind_param("ii",$a['pr'.$i]['quantity'],$a['pr'.$i]['id']);
$s->execute();
}


if($mysqli->affected_rows>0){$this->msg('success',langu['save_temp_success']);}

else{$this->msg('fail',langu['save_temp_fail']);}
}

/**
 * اضافة الحركة الى جدول كشف الحساب
 *  @param object $mysqli mysqli connector
 * @param int $type Description {
 * 1=>فاتورة من زبون,
 * 2=>فاتورة مرتجعة من زبون',
 * 3=>فاتورة من تاجر,
 * 4=>فاتورة مرتجعة من تاجر,
 * 5=>بيع فوري,
 * 6=>الايرادات,
 * 7=>المصاريف,
 * 8=>شيك مرتجع,
 * 9=>شيك شخصي مرتجع,
 * 10=>شيك مرتجع ليس للشخص,
 * 11=>فاتورة مرتجعة من البيع الفوري ,
 * }
 
 */
function insert_to_statment($mysqli,$type,$id_for,$total,$all_balance,$c_id,$m_id){
$mysqli->query('insert into customer_merchant_statment 
(statment_type,id_for_type,balance,all_balance,customer_id,merchant_id,date) VALUES
('.$type.','.$id_for.','.$total.','.$all_balance.','.$c_id.','.$m_id.',"'.date('Y-m-d').'")');
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