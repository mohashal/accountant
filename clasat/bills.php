<?php

class bills {

/**
*فورم اضافة فاتورة جديدة
*@param $ai auto increment value
*/
function add_bill_form($mysqli,$action,$type){
$tax_send='';
$parcel_driver='';
$title=langu['add_returned_products'];
$driver='';
$offer='';
if($type==1){
$driver=$this->get_select_driver($mysqli);
$title=langu['add_bill'];
$tax_send="<div class='form_input_line'><div class='form_input_name'>".langu['add']."</div><div class='form_input_input'><input type='checkbox' name='tax_bill' value='1'/>".langu['tax_bill']." / <input type='checkbox' name='sent_bill' value='1'/>".langu['sent_bill']."</div></div>";
$parcel_driver="            <div class='form_input_line'><div class='form_input_name'>".langu['parcel_num']."</div><div class='form_input_input'><input type='text' name='parcel_num' autocomplete='off' placeholder='".langu['parcel_num']."' value=''></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['driver']."</div><div class='form_input_input'>".$driver."</div></div>
            <div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'></textarea></div></div>";
$offer="<div class='form_input_name' style='margin-left:20px;' id='search_offer_name'><input type='text' id='bill_search_offer' placeholder='".langu['offer_name']."' value='' autocomplete='off'></div>";
}

$ma=$this->get_select_date(1,1,1);
echo "
<div class='form_main'>
    <form action='bills.php?conn=".$action."' method='post' enctype='multipart/form-data'>
    <div class='form_main_name'>".$title."</div>
    <div id='debt_note' style='display:none'></div>
    <div class='form_main_inputs'>
            <div class='bills_date'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'>".$ma['day'].$ma['month'].$ma['year']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_name'><input type='text' id='bill_customer_search' autocomplete='off' placeholder='".langu['customer_name']."' value='' required></div></div>
".$tax_send."
            <div class='form_input_line'><div class='form_input_name'>".langu['area']."</div><div class='form_input_input' id='show_area'></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input' id='show_sale'></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['balance']."</div><div class='form_input_input nume' id='show_balance'></div></div>
".$parcel_driver."
    </div>
    <div class='bill_product_show' style='display:none;'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line no_print'>
".$offer."
                <div class='form_input_name' id='search_product_num'><input type='text' id='bill_product_search_num' placeholder='".langu['product_num']."' value='' autocomplete='off'></div>
                <div class='form_input_input' id='search_product_name'><input type='text' id='bill_product_search' autocomplete='off' placeholder='".langu['product_name']."' value=''></div>
                <div class='form_input_name' style='margin-right:23px;margin-top:-1px' id='search_product_barcode'><input type='text' id='bill_product_search_barcode' placeholder='".langu['barcode']."' value='' autocomplete='off'></div>
            </div>
        </div>
        <div class='bill_form_products'>
            <table class='products_list'>
                <tr class='table_head'><th class='no_print'></th><th>".langu['product_num']."</th><th>".langu['product_name']."</th><th>".langu['product_quantity']."</th><th>".langu['unit']."</th><th>".langu['price']."</th><th>".langu['bonus']."</th><th>".langu['total']."</th></tr>
            </table>
        </div>
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>0</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".$title."'><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
            <input type='hidden' name='bill_sales_id' id='bill_sales_id' value='' />
            <input type='hidden' name='bill_store_id' id='bill_store_id' value='' />
            <input type='hidden' name='bill_price' id='bill_price' value='' />
            <input type='hidden' name='custom_price' id='custom_price' value='' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='0' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='' />

    </form>
</div>
";
}

/**
*فورم اضافة فاتورة جديدة
*/
function edit_bill_form($mysqli,$id){
$row=$mysqli->query('SELECT invoices.*,customers.name as customer_name,customers.balance as cbalance,customers.custom_price,employees.name as sale_name,areas.name as area_name FROM invoices,customers,employees,areas where invoices.id='.intval($id).' and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id and areas.id=customers.area_id');
$row=$row->fetch_assoc();
$ma=$this->get_select_date(1,1,1);
$driver=$this->get_select_driver($mysqli,$row['driver_id']);
$custom_price=unserialize($row['custom_price']);
$custom_price=json_encode($custom_price);
$a=unserialize($row['products']);
$products=$this->get_products_from_array($a);
$tax_bill="<input type='checkbox' name='tax_bill' value='1'/>";
$sent_bill="<input type='checkbox' name='sent_bill' value='1'/>";
if($row['is_tax']==1){$tax_bill="<input type='checkbox' name='tax_bill' value='1' checked/>";}
if($row['is_sent']==1){$sent_bill="<input type='checkbox' name='sent_bill' value='1' checked/>";}

echo "
<div class='form_main'>
    <form action='bills.php?conn=edit-bill-save' method='post' enctype='multipart/form-data'>
    <div class='form_main_name'>".langu['add_bill']."</div>
    <div id='debt_note' style='display:none'></div>
    <div class='form_main_inputs'>
            <div class='bills_date'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'>".$ma['day'].$ma['month'].$ma['year']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_name'><input type='text' id='bill_customer_search' autocomplete='off' placeholder='".langu['customer_name']."' value='".$row['customer_name']."' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['add']."</div><div class='form_input_input'>".$tax_bill.langu['tax_bill']." / ".$sent_bill.langu['sent_bill']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['area']."</div><div class='form_input_input' id='show_area'>".$row['area_name']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input' id='show_sale'>".$row['sale_name']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['balance']."</div><div class='form_input_input nume' id='show_balance'>".$row['cbalance']." ".langu['shekel']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['parcel_num']."</div><div class='form_input_input'><input type='text' name='parcel_num' autocomplete='off' placeholder='".langu['parcel_num']."' value='".$row['parcel_num']."'></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['driver']."</div><div class='form_input_input'>".$driver."</div></div>
            <div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'>".$row['notes']."</textarea></div></div>
    </div>
    <div class='bill_product_show'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line no_print'>
                <div class='form_input_name' style='margin-left:20px;' id='search_offer_name'><input type='text' id='bill_search_offer' placeholder='".langu['offer_name']."' value='' autocomplete='off'></div>
                <div class='form_input_name' id='search_product_num'><input type='text' id='bill_product_search_num' placeholder='".langu['product_num']."' value='' autocomplete='off'></div>
                <div class='form_input_input' id='search_product_name'><input type='text' id='bill_product_search' autocomplete='off' placeholder='".langu['product_name']."' value=''></div>
                <div class='form_input_name' style='margin-right:23px;margin-top:-1px' id='search_product_barcode'><input type='text' id='bill_product_search_barcode' placeholder='".langu['barcode']."' value='' autocomplete='off'></div>
            </div>
        </div>
        <div class='bill_form_products'>
            <table class='products_list'>
                <tr class='table_head'><th class='no_print'></th><th>".langu['product_num']."</th><th>".langu['product_name']."</th><th>".langu['product_quantity']."</th><th>".langu['unit']."</th><th>".langu['price']."</th><th>".langu['bonus']."</th><th>".langu['total']."</th></tr>
                ".$products."
            </table>
        </div>
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>".$row['total']."</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit_bill']."'><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
            <input type='hidden' name='order_id' id='order_id' value='".$id."' />
            <input type='hidden' name='bill_sales_id' id='bill_sales_id' value='".$a['saleman_id']."' />
            <input type='hidden' name='bill_store_id' id='bill_store_id' value='".$a['store_id']."' />
            <input type='hidden' name='bill_price' id='bill_price' value='".$a['saleman_price']."' />
            <input type='hidden' name='custom_price' id='custom_price' value='".$custom_price."' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='".$a['product_nums']."' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='".$a['balance']."' />

    </form>
</div>
";
}
/**
*فورم البحث عن الفواتير
*/
function search_bill_form(){

echo "
<div class='form_main'>
<div class='form_main_name'>".langu['search_order']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['order_num']."</div><div class='form_input_input' id='search_num'><input type='text' id='bill_num_search' autocomplete='off' placeholder='".langu['order_num']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['order_date']."</div><div class='form_input_input' id='search_date'><input type='text' id='bill_date_search' autocomplete='off' placeholder='".langu['order_date']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_name'><input type='text' id='bill_customer_search2' autocomplete='off' placeholder='".langu['customer_name']."' value='' required></div></div>
    </div>
    <div class='form_main_name'>".langu['bills']."</div>
    <div class='bill_list_show'>

    </div>
</div>";
}
/**
*فورم البحث عن الفواتير
*/
function search_taxbill_form(){

echo "
<div class='form_main'>
<div class='form_main_name'>".langu['search_tax_sent_bill']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['taxbill_num']."</div><div class='form_input_input' id='search_taxnum'><input type='text' id='taxbill_num_search' autocomplete='off' placeholder='".langu['taxbill_num']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['sentbill_num']."</div><div class='form_input_input' id='search_taxsent'><input type='text' id='sentbill_num_search' autocomplete='off' placeholder='".langu['sentbill_num']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['tax_sent_date']."</div><div class='form_input_input' id='search_date'><input type='text' id='bill_date_search' autocomplete='off' placeholder='".langu['tax_sent_date']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_name'><input type='text' id='bill_customer_search2' autocomplete='off' placeholder='".langu['customer_name']."' value='' required></div></div>
    </div>
    <div class='form_main_name'>".langu['bills']."</div>
    <div class='bill_list_show'>

    </div>
</div>";
}
/**
*استخراج البضائع من مصفوفة قاعدة البيانات
*@param $a unserialized array from database
*/
function get_products_from_array($a){
$product='';
for($num=1;$num<=$a['product_nums'];$num++){
$total=$a['pr'.$num]['price']*$a['pr'.$num]['quantity'];
$check='';
if($a['pr'.$num]['bonus']==1){$check=' checked';$total=0;}
$product.="
<tr id='product".$num."'>
	<input type='hidden' id='product_offer".$num."' name='product_offer".$num."' value='".$a['pr'.$num]['is_offer']."'/>
	<input type='hidden' id='product_id".$num."' name='product_id".$num."' value='".$a['pr'.$num]['id']."'/>
	<input type='hidden' id='product_ids".$num."' name='product_ids".$num."' value='".$a['pr'.$num]['ids']."'/>
	<input type='hidden' id='product_unit".$num."' name='product_unit".$num."' value='".$a['pr'.$num]['unit']."'/>
	<input type='hidden' id='product_our_price".$num."' name='product_our_price".$num."' value='".$a['pr'.$num]['our_price']."'/>
        <input type='hidden' id='product_sale_price".$num."' name='product_sale_price".$num."' value='".$a['pr'.$num]['sale_price']."'/>
	<input type='hidden' id='product_name".$num."' name='product_name".$num."' value='".$a['pr'.$num]['name']."'/>
	<td class='del_product no_print' id='del_pro".$num."' onclick='del_product(".$num.")'></td>
	<td class='nume'>".$a['pr'.$num]['ids']."</td>
        <td class='nume'>".$a['pr'.$num]['name']."</td>
	<td><input type='text' autocomplete='off' name='product_quantity".$num."' id='product_quantity".$num."' value='".$a['pr'.$num]['quantity']."' oninput='change_total(".$num.")' placeholder='".langu['product_quantity']."'/></td>
	<td>".$a['pr'.$num]['unit']."</td>
        <td id='pru".$num."'><input type='text' autocomplete='off' name='product_price".$num."' id='product_price".$num."' value='".$a['pr'.$num]['price']."' oninput='change_total(".$num.")' placeholder='".langu['price']."'/></td>
	<td><input type='checkbox' id='product_bonus".$num."' name='product_bonus".$num."' onchange='check_bonus(".$num.")' value='1'".$check."></td>
	<td class='nume' id='product_total".$num."'>$total</td>
</tr>";
}
return $product;
}

/**
* حفظ الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function bill_save_temp($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=intval($_POST['select_date_year'])."-".intval($_POST['select_date_month'])."-".intval($_POST['select_date_day']);
$a=array();
$total=$_POST['bill_balance'];
$profit_all=0;
$a['saleman_id']=intval($_POST['bill_sales_id']);
$a['store_id']=intval($_POST['bill_store_id']);
$a['saleman_price']=$_POST['bill_price'];
$a['custom_price']=$_POST['custom_price'];
$a['balance']=$total;
$a['product_nums']=$num;

$this->edit_customer_price($mysqli,$num,intval($_POST['bill_store_id']));

for($i=1;$i<=$num;$i++){
if(isset($_POST['product_bonus'.$i])&&$_POST['product_bonus'.$i]==1){$bonus=1;$profit=0;}

else{$bonus=0;$profit=($_POST['product_price'.$i]*$_POST['product_quantity'.$i])-($_POST['product_our_price'.$i]*$_POST['product_quantity'.$i]);
$profit_all+=$profit;}

$a['pr'.$i]['id']=$_POST['product_id'.$i];
$a['pr'.$i]['ids']=$_POST['product_ids'.$i];
$a['pr'.$i]['unit']=$_POST['product_unit'.$i];
$a['pr'.$i]['name']=$_POST['product_name'.$i];
$a['pr'.$i]['quantity']=$_POST['product_quantity'.$i];
$a['pr'.$i]['our_price']=$_POST['product_our_price'.$i];
$a['pr'.$i]['sale_price']=$_POST['product_sale_price'.$i];
$a['pr'.$i]['price']=$_POST['product_price'.$i];
$a['pr'.$i]['bonus']=$bonus;
$a['pr'.$i]['profit']=$profit;
$a['pr'.$i]['is_offer']=$_POST['product_offer'.$i];
}
$a['profit_all']=$profit_all;
$a=serialize($a);
$tax=0;$sent=0;$te=1;
if(isset($_POST['tax_bill'])){if($_POST['tax_bill']==1){$tax=1;}}
if(isset($_POST['sent_bill'])){if($_POST['sent_bill']==1){$sent=1;}}

if($s=$mysqli->prepare("INSERT INTO invoices (profit,products,total,customer_id,sales_man_id,is_temp,is_tax,is_sent,day,month,year,date,parcel_num,driver_id,notes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")){
@$s->bind_param("dsdiiiiiiiisiis",$profit_all,$a,$total,intval($_POST['bill_store_id']),intval($_POST['bill_sales_id']),$te,$tax,$sent,date('j'),date('n'),date('Y'),$date,intval($_POST['parcel_num']),intval($_POST['select_driver']),htmlentities($_POST['notes']));
$s->execute();
$ma[0]=langu['add_bill_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['add_bill_fail'];$ma[1]=0;return $ma;}


}

/**
* تعديل الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function bill_update_temp($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=intval($_POST['select_date_year'])."-".intval($_POST['select_date_month'])."-".intval($_POST['select_date_day']);
$a=array();
$total=$_POST['bill_balance'];
$profit_all=0;
$a['saleman_id']=intval($_POST['bill_sales_id']);
$a['store_id']=intval($_POST['bill_store_id']);
$a['saleman_price']=$_POST['bill_price'];
$a['custom_price']=$_POST['custom_price'];
$a['balance']=$total;
$a['product_nums']=$num;
$this->edit_customer_price($mysqli,$num,$a['store_id']);

for($i=1;$i<=$num;$i++){
if(isset($_POST['product_bonus'.$i])&&$_POST['product_bonus'.$i]==1){$bonus=1;$profit=0;}

else{$bonus=0;$profit=($_POST['product_price'.$i]*$_POST['product_quantity'.$i])-($_POST['product_our_price'.$i]*$_POST['product_quantity'.$i]);
$profit_all+=$profit;}



$a['pr'.$i]['id']=$_POST['product_id'.$i];
$a['pr'.$i]['ids']=$_POST['product_ids'.$i];
$a['pr'.$i]['unit']=$_POST['product_unit'.$i];
$a['pr'.$i]['name']=$_POST['product_name'.$i];
$a['pr'.$i]['quantity']=$_POST['product_quantity'.$i];
$a['pr'.$i]['our_price']=$_POST['product_our_price'.$i];
$a['pr'.$i]['sale_price']=$_POST['product_sale_price'.$i];
$a['pr'.$i]['price']=$_POST['product_price'.$i];
$a['pr'.$i]['bonus']=$bonus;
$a['pr'.$i]['profit']=$profit;
$a['pr'.$i]['is_offer']=$_POST['product_offer'.$i];
}
$a['profit_all']=$profit_all;
$a=serialize($a);
$tax=0;$sent=0;$te=1;
if(isset($_POST['tax_bill'])){if($_POST['tax_bill']==1){$tax=1;}}
if(isset($_POST['sent_bill'])){if($_POST['sent_bill']==1){$sent=1;}}

if($s=$mysqli->prepare("update invoices set profit=?,products=?,total=?,customer_id=?,sales_man_id=?,is_temp=?,is_tax=?,is_sent=?,day=?,month=?,year=?,date=?,parcel_num=?,driver_id=?,notes=? where id=".intval($_POST['order_id']))){
@$s->bind_param("dsdiiiiiiiisiis",$profit_all,$a,$total,intval($_POST['bill_store_id']),intval($_POST['bill_sales_id']),$te,$tax,$sent,date('j'),date('n'),date('Y'),$date,intval($_POST['parcel_num']),intval($_POST['select_driver']),htmlentities($_POST['notes']));
$s->execute();
$ma[0]=langu['edit_bill_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['edit_bill_fail'];$ma[1]=0;return $ma;}


}

/**
 *حفظ الاسعار المعدلة للزبائن
 */
function edit_customer_price($mysqli,$num,$customer_id){
$row=$mysqli->query('select custom_price from customers where id='.$customer_id);
$row=$row->fetch_assoc();
$a=unserialize($row['custom_price']);

for($i=1;$i<=$num;$i++){
if($_POST['product_offer'.$i]==0){
$price=$_POST['product_price'.$i];
$sale_price=$_POST['product_sale_price'.$i];

if($price!=$sale_price){$a[$_POST['product_id'.$i]]=$price;}
}
}
$a=serialize($a);
$mysqli->query("update customers set custom_price='".$a."' where id=".$customer_id);
}

/**
* حفظ الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function returned_save_temp($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=intval($_POST['select_date_year'])."-".intval($_POST['select_date_month'])."-".intval($_POST['select_date_day']);
$a=array();
$total=$_POST['bill_balance'];

$a['saleman_id']=intval($_POST['bill_sales_id']);
$a['store_id']=intval($_POST['bill_store_id']);
$a['saleman_price']=$_POST['bill_price'];
$a['balance']=$total;
$a['product_nums']=$num;
for($i=1;$i<=$num;$i++){
if(isset($_POST['product_bonus'.$i])&&$_POST['product_bonus'.$i]==1){$bonus=1;}

else{$bonus=0;}



$a['pr'.$i]['id']=$_POST['product_id'.$i];
$a['pr'.$i]['ids']=$_POST['product_ids'.$i];
$a['pr'.$i]['unit']=$_POST['product_unit'.$i];
$a['pr'.$i]['name']=$_POST['product_name'.$i];
$a['pr'.$i]['quantity']=$_POST['product_quantity'.$i];
$a['pr'.$i]['our_price']=$_POST['product_our_price'.$i];
$a['pr'.$i]['sale_price']=$_POST['product_sale_price'.$i];
$a['pr'.$i]['price']=$_POST['product_price'.$i];
$a['pr'.$i]['bonus']=$bonus;
$a['pr'.$i]['is_offer']=0;
}
$a=serialize($a);
$te=1;


if($s=$mysqli->prepare("INSERT INTO returned_products (products,total,customer_id,sales_man_id,is_temp,date) VALUES (?,?,?,?,?,?)")){
@$s->bind_param("siiiis",$a,$total,intval($_POST['bill_store_id']),intval($_POST['bill_sales_id']),$te,$date);
$s->execute();
$ma[0]=langu['add_returned_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['add_returned_fail'];$ma[1]=0;return $ma;}


}

/**
* قائمة الفواتير غير المرحلة
* @param type $mysqli
*/
function show_temp_bill($mysqli){
$i3=0;
$total=0;
$pr=0;
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['temp_bill']."</div>
    <div class='form_main_inputs' style='width:95%;'>
        <div class='bill_list_main'>";

//$q=$mysqli->query('SELECT invoices.*,customers.name as customer_name,employees.name as sale_name FROM invoices,customers,employees where invoices.is_temp=1 and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id');
$q=$mysqli->query('SELECT invoices.*,areas.name as aname,customers.name as customer_name,employees.name as sale_name FROM invoices,customers,employees,areas where invoices.is_temp=1 and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id and areas.id=customers.area_id');
if($q->num_rows>0){
echo "<div class='temp_select_sale'>".$this->get_select_saleman($mysqli,"onchange='select_sale()'")."</div>
    <table class='main_table'>
            <tr>
                <th><input id='selectall' type='checkbox' onclick='select_deselect_all()' value=''/></th>
                <th>".langu['bill_num']."</th>
                <th class='no_print'></th>
                <th>".langu['customer_name']."</th>
                <th>".langu['salesman2']."</th>
                <th>".langu['area_name']."</th>
                <th>".langu['bill_total']."</th>";
if($_SESSION['permission']==1){echo "<th class='no_print'>".langu['profit']."</th>";}
            echo "<th class='no_print'></th>
                <th class='no_print'></th>";
if($_SESSION['permission']==1){echo "<th class='no_print'></th>";}
            echo "</tr>";
while ($row=$q->fetch_assoc()){
$a=unserialize($row['products']);
$i3+=1;
$total+=$row['total'];
$pr+=$a['profit_all'];
echo "
    <tr class='show_hide ".$row['sales_man_id']."'>
        <td><span class='no_print'><input class='saveit ss".$row['sales_man_id']."' name='saveit' type='checkbox' value='".$row['id']."'/></span></td>
        <td class='nume'>".$row['id']."</td>";
if($_SESSION['permission']==1){echo "<td class='products_list_symbol no_print' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?update_temp_bills=save&id=".$row['id']."\")'>✔</td>";}
echo"
        <td>".$row['customer_name']."</td>
        <td>".$row['sale_name']."</td>
        <td>".$row['aname']."</td>
        <td class='nume total".$row['sales_man_id']."'>".$row['total']."</td>";
if($_SESSION['permission']==1){echo "<td class='nume no_print pr".$row['sales_man_id']."'>".$a['profit_all']."</td>";}
        echo "<td class='products_list_symbol no_print'><a href='bills.php?conn=edit_bill&id=".$row['id']."'></a></td>
<td class='products_list_symbol no_print'><a href='printbills.php?print_bills=temp&id=".$row['id']."' target='_blank'>|</a></td>
        <td class='del_product no_print' onClick='remove_temp_bill(".$row['id'].")'></td>
    </tr>";
}
echo "<tr>
        <td>".langu['total']."</td>
        <td class='nume bil'>".$i3."</td>
        <td></td>
        <td class='saleman'></td>
        <td></td>
        <td></td>
        <td class='nume totals'>".$total."</td>";

if($_SESSION['permission']==1){echo"<td class='nume no_print prs'>".$pr."</td>";}
    echo"<td class='no_print'></td>
        <td class='no_print'></td>
        <td class='no_print'></td>
    </tr>
</table>";
}

else{echo "<div class='no_bills'>".langu['no_orders']."</div>";}
$t='';
if($_SESSION['permission']==1){$t="<div class='hide_show nprint' style='' onclick='save_select_temp(\"saveit\",\"ajaxbills.php?update_temp_bills=save&id=\")'>".langu['save_temp']."</div>";}
echo"
        </div>
    </div>
        <div class='form_input_line' style='margin:15px auto;'>".$t."<div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
</div>
";
}

/**
*فنكشن جلب التاريخ اليوم والشهر والسنة
*/
function get_select_date($day=null,$month=null,$year=null){
$ma=array();
if($day==1){
$ma['day']="<select id='select_date_day' name='select_date_day' required>";
for($i=1;$i<32;$i++){
if($i==date('j')){$ma['day'].="<option value='".$i."' selected>".$i."</option>";  }
else{$ma['day'].="<option value='".$i."'>".$i."</option>";}
}
$ma['day'].="</select>";
}

if($month==1){
$ma['month']="<select id='select_date_month' name='select_date_month' required>";
for($i=1;$i<=12;$i++){
if($i==date('n')){$ma['month'].="<option value='".$i."' selected>".$i."</option>";  }
else{$ma['month'].="<option value='".$i."'>".$i."</option>";}
}
$ma['month'].="</select>";
}

if($year==1){
$ma['year']="<select id='select_date_year' name='select_date_year' required>";
for($i=2017;$i<=date('Y')+1;$i++){
if($i==date('Y')){$ma['year'].="<option value='".$i."' selected>".$i."</option>";  }
else{$ma['year'].="<option value='".$i."'>".$i."</option>";}
}
$ma['year'].="</select>";
}

return $ma;
}
function get_select_saleman($mysqli,$func=null){

$q=$mysqli->query('select id,name from employees where employee_type=1');
$sales="<select id='select_salesman' name='select_salesman' ".$func.">
<option value='' disabled selected>".langu['selectsales']."</option>";
while ($row=$q->fetch_assoc()) {
$sales.="<option value='".$row['id']."'>".$row['name']."</option>";
}
$sales.="</select>";
return $sales;
}
function get_select_driver($mysqli,$id=null,$func=null){

$q=$mysqli->query('select id,name from employees where is_delete=0');
/*$q=$mysqli->query('select id,name from employees where employee_type=2 and is_delete=0');*/
$sales="<select id='select_driver' name='select_driver' ".$func.">
<option value='' disabled selected>".langu['select']." ".langu['driver2']."</option>";
while ($row=$q->fetch_assoc()) {
if($id==$row['id']){$sales.="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$sales.="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$sales.="</select>";
return $sales;
}

/*
function add_bill_form2(){
$ma=$this->get_select_date(1,1,1);
echo "
<div class='form_main'>
    <form action='bills.php?conn=add-bill-save' method='post' enctype='multipart/form-data'>
    <div class='form_main_name'>".langu['add_bill']."</div>
    <div class='form_main_inputs'>
            <div class='bills_date'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'>".$ma['day'].$ma['month'].$ma['year']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_name'><input type='text' id='bill_customer_search' autocomplete='off' placeholder='".langu['customer_name']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['add']."</div><div class='form_input_input'><input type='checkbox' name='tax_bill' value='1'/>".langu['tax_bill']." / <input type='checkbox' name='sent_bill' value='1'/>".langu['sent_bill']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['area']."</div><div class='form_input_input' id='show_area'></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input' id='show_sale'></div></div>
    </div>
    <div class='bill_product_show' style='display:none;'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' id='search_product_num'><input type='text' id='bill_product_search_num' placeholder='".langu['product_num']."' value='' autocomplete='off'></div><div class='form_input_input' id='search_product_name'><input type='text' id='bill_product_search' autocomplete='off' placeholder='".langu['product_name']."' value=''></div></div>
        </div>
        <div class='bill_form_products'>
            <div class='bill_products_list'><div class='bill_list_top'>".langu['product_name']."</div><div class='bill_list_top small_f'>".langu['product_quantity']."</div><div class='bill_list_top small_f'>".langu['price']."</div><div class='bill_list_top small_f'>".langu['total']."</div></div>
        </div>
        <div class='form_input_line' style='border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>0</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add_bill']."'></div>
            <input type='hidden' name='bill_sales_id' id='bill_sales_id' value='' />
            <input type='hidden' name='bill_store_id' id='bill_store_id' value='' />
            <input type='hidden' name='bill_price' id='bill_price' value='' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='0' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='' />

    </form>
</div>
";
}
*/

}