<?php

class return_instant_pay {
/**
*فورم اضافة فاتورة جديدة
*@param $ai auto increment value
*/
function add_bill_form($mysqli){
$re=$this->get_partner_employee($mysqli,99999,99999);
echo "
<div class='form_main'>
    <form action='return_instant_pay.php?conn=save_temp_pay' method='post' enctype='multipart/form-data'>
    <div class='form_main_name'>".langu['returned_products']."</div>
    <div class='form_main_inputs'>
            <div class='bills_date'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'><input type='text' id='bill_date' name='bill_date' autocomplete='off' placeholder='".langu['bill_date']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['pay_to']."</div><div class='form_input_input'>
<input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()'>".langu['merchant']."
<input type='radio' name='is_customer_merchant' id='is_partner' value='2' onchange='show_hide_customer_merchant()'>".langu['partner']."    
<input type='radio' name='is_customer_merchant' id='is_employee' value='3' onchange='show_hide_customer_merchant()'>".langu['employee']."
<input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()' checked>".langu['normal_customer']."</div></div>
            <div class='form_input_line' id='show_hide_customer'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input'><input type='text' autocomplete='off' id='customer_name' name='customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_merchant' style='display:none;'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' autocomplete='off' id='merchant_name' name='merchant_name' oninput='merchant_search()' placeholder='".langu['merchant_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_partner' style='display:none;'><div class='form_input_name'></div><div class='form_input_input'>".$re['partner']."</div></div>
            <div class='form_input_line' id='show_hide_employee' style='display:none;'><div class='form_input_name'></div><div class='form_input_input'>".$re['employee']."</div></div>
            <div class='form_input_line' id='merchant_balance' style='display:none;'><div class='form_input_name'>".langu['balance']."</div><div class='form_input_input nume' id='show_balance'></div></div>
            <div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'></textarea></div></div>
            <input type='hidden' id='merchant_id' name='merchant_id' value='0' />
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
            </table>
        </div>
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>0</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['pay']."'><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
            <input type='hidden' name='bill_price' id='bill_price' value='fa_price' />
            <input type='hidden' name='custom_price' id='custom_price' value='' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='0' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='' />

    </form>
</div>
";
}
function edit_instant_form($mysqli,$id){
$q=$mysqli->query('select return_instant_invoice.*,merchants.name as mname,merchants.balance from return_instant_invoice,merchants where merchants.id=return_instant_invoice.merchant_id and return_instant_invoice.id='.$id);
$row=$q->fetch_assoc();
$re=$this->get_partner_employee($mysqli,$row['partner_id'],$row['employee_id']);
$pr=unserialize($row['products']);
$num=$pr['product_nums'];
$products=$this->get_products_from_array($pr);

$check_merchant="
<div class='form_input_line'><div class='form_input_name'>".langu['pay_to']."</div><div class='form_input_input'>
<input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()'>".langu['merchant']."
<input type='radio' name='is_customer_merchant' id='is_partner' value='2' onchange='show_hide_customer_merchant()'>".langu['partner']."    
<input type='radio' name='is_customer_merchant' id='is_employee' value='3' onchange='show_hide_customer_merchant()'>".langu['employee']."
<input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()' checked>".langu['normal_customer']."</div>
</div>
<div class='form_input_line' id='show_hide_customer'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input'><input type='text' autocomplete='off' id='customer_name' name='customer_name' placeholder='".langu['customer_name']."' value='".$row['customer_name']."'></div></div>
<div class='form_input_line' id='show_hide_merchant' style='display:none;'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' autocomplete='off' id='merchant_name' name='merchant_name' oninput='merchant_search()' placeholder='".langu['merchant_name']."' value=''></div></div>
<div class='form_input_line' id='merchant_balance' style='display:none;'><div class='form_input_name'>".langu['balance']."</div><div class='form_input_input nume' id='show_balance'></div></div>
<div class='form_input_line' id='show_hide_partner' style='display:none;'><div class='form_input_name'></div><div class='form_input_input'>".$re['partner']."</div></div>
<div class='form_input_line' id='show_hide_employee' style='display:none;'><div class='form_input_name'></div><div class='form_input_input'>".$re['employee']."</div></div>
<div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'>".$row['notes']."</textarea></div></div>
<input type='hidden' id='merchant_id' name='merchant_id' value='0' />";

if($row['merchant_id']!=0){$check_merchant="
<div class='form_input_line'><div class='form_input_name'>".langu['pay_to']."</div><div class='form_input_input'>
<input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()' checked>".langu['merchant']."
<input type='radio' name='is_customer_merchant' id='is_partner' value='2' onchange='show_hide_customer_merchant()'>".langu['partner']."    
<input type='radio' name='is_customer_merchant' id='is_employee' value='3' onchange='show_hide_customer_merchant()'>".langu['employee']."
<input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()'>".langu['normal_customer']."</div>
</div>
<div class='form_input_line' id='show_hide_customer' style='display:none;'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input'><input type='text' autocomplete='off' id='customer_name' name='customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
<div class='form_input_line' id='show_hide_merchant'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' autocomplete='off' id='merchant_name' name='merchant_name' oninput='merchant_search()' placeholder='".langu['merchant_name']."' value='".$row['mname']."'></div></div>
<div class='form_input_line' id='merchant_balance'><div class='form_input_name'>".langu['balance']."</div><div class='form_input_input nume' id='show_balance'>".$row['balance']."</div></div>
<div class='form_input_line' id='show_hide_partner' style='display:none;'><div class='form_input_name'></div><div class='form_input_input'>".$re['partner']."</div></div>
<div class='form_input_line' id='show_hide_employee' style='display:none;'><div class='form_input_name'></div><div class='form_input_input'>".$re['employee']."</div></div>
<div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'>".$row['notes']."</textarea></div></div>
<input type='hidden' id='merchant_id' name='merchant_id' value='".$row['merchant_id']."' />";}

elseif($row['partner_id']!=0){
$check_merchant="
<div class='form_input_line'><div class='form_input_name'>".langu['pay_to']."</div><div class='form_input_input'>
<input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()'>".langu['merchant']."
<input type='radio' name='is_customer_merchant' id='is_partner' value='2' onchange='show_hide_customer_merchant()' checked>".langu['partner']."    
<input type='radio' name='is_customer_merchant' id='is_employee' value='3' onchange='show_hide_customer_merchant()'>".langu['employee']."
<input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()'>".langu['normal_customer']."</div>
</div>
<div class='form_input_line' id='show_hide_customer' style='display:none;'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input'><input type='text' autocomplete='off' id='customer_name' name='customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
<div class='form_input_line' id='show_hide_merchant' style='display:none;'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' autocomplete='off' id='merchant_name' name='merchant_name' oninput='merchant_search()' placeholder='".langu['merchant_name']."' value=''></div></div>
<div class='form_input_line' id='merchant_balance' style='display:none;'><div class='form_input_name'>".langu['balance']."</div><div class='form_input_input nume' id='show_balance'></div></div>
<div class='form_input_line' id='show_hide_partner' ><div class='form_input_name'></div><div class='form_input_input'>".$re['partner']."</div></div>
<div class='form_input_line' id='show_hide_employee' style='display:none;'><div class='form_input_name'></div><div class='form_input_input'>".$re['employee']."</div></div>
<div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'>".$row['notes']."</textarea></div></div>
<input type='hidden' id='merchant_id' name='merchant_id' value='0' />";
}

elseif($row['employee_id']!=0){
$check_merchant="
<div class='form_input_line'><div class='form_input_name'>".langu['pay_to']."</div><div class='form_input_input'>
<input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()'>".langu['merchant']."
<input type='radio' name='is_customer_merchant' id='is_partner' value='2' onchange='show_hide_customer_merchant()' checked>".langu['partner']."    
<input type='radio' name='is_customer_merchant' id='is_employee' value='3' onchange='show_hide_customer_merchant()'>".langu['employee']."
<input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()'>".langu['normal_customer']."</div>
</div>
<div class='form_input_line' id='show_hide_customer' style='display:none;'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input'><input type='text' autocomplete='off' id='customer_name' name='customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
<div class='form_input_line' id='show_hide_merchant' style='display:none;'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' autocomplete='off' id='merchant_name' name='merchant_name' oninput='merchant_search()' placeholder='".langu['merchant_name']."' value=''></div></div>
<div class='form_input_line' id='merchant_balance' style='display:none;'><div class='form_input_name'>".langu['balance']."</div><div class='form_input_input nume' id='show_balance'></div></div>
<div class='form_input_line' id='show_hide_partner' style='display:none;'><div class='form_input_name'></div><div class='form_input_input'>".$re['partner']."</div></div>
<div class='form_input_line' id='show_hide_employee'><div class='form_input_name'></div><div class='form_input_input'>".$re['employee']."</div></div>
<div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'>".$row['notes']."</textarea></div></div>
<input type='hidden' id='merchant_id' name='merchant_id' value='0' />";
}

echo "
<div class='form_main'>
    <form action='return_instant_pay.php?conn=save_edit_pay' method='post' enctype='multipart/form-data'>
    <div class='form_main_name'>".langu['returned_products']."</div>
    <div class='form_main_inputs'>
            <div class='bills_date'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'><input type='text' id='bill_date' name='bill_date' autocomplete='off' placeholder='".langu['bill_date']."' value='".$row['date']."' required></div></div>
".$check_merchant."
    <input type='hidden' name='instance_id' value='".$id."' />
    </div>
    <div class='bill_product_show'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line no_print'>
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
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>0</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit_bill']."'><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
            <input type='hidden' name='bill_price' id='bill_price' value='fa_price' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='".$num."' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='".$row['total']."' />

    </form>
</div>
";
}
/**
* حفظ الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function instant_save_temp($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=$_POST['bill_date'];
$a=array();
$total=$_POST['bill_balance'];
$merchant=0;
$partner=0;
$employee=0;
$profit_all=0;
if($_POST['merchant_id']!=0){$merchant=intval($_POST['merchant_id']);}
if(isset($_POST['select_partner'])&&$_POST['select_partner']!=0){$partner=intval($_POST['select_partner']);}
if(isset($_POST['select_employee'])&&$_POST['select_employee']!=0){$employee=intval($_POST['select_employee']);}
$a['merchant_id']=$merchant;
$a['partner_id']=$partner;
$a['employee_id']=$employee;
$a['bill_price']=$_POST['bill_price'];
$a['balance']=$total;
$a['product_nums']=$num;
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
$a['pr'.$i]['price']=$_POST['product_price'.$i];
$a['pr'.$i]['bonus']=$bonus;
$a['pr'.$i]['is_offer']=$_POST['product_offer'.$i];
$a['pr'.$i]['profit']=$profit;
}
$a['profit_all']=$profit_all;
$a=serialize($a);



if($s=$mysqli->prepare("INSERT INTO return_instant_invoice (profit,products,notes,customer_name,merchant_id,total,date,partner_id,employee_id) VALUES (?,?,?,?,?,?,?,?,?)")){
@$s->bind_param("dsssidsii",$profit_all,$a,htmlentities($_POST['notes']),htmlentities($_POST['customer_name']),$merchant,$total,$date,$partner,$employee);
$s->execute();
$ma[0]=langu['add_bill_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['add_bill_fail'];$ma[1]=0;return $ma;}

}
/**
* حفظ الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function instant_save_edit($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=$_POST['bill_date'];
$a=array();
$total=$_POST['bill_balance'];
$merchant=0;
$partner=0;
$employee=0;
$profit_all=0;
if($_POST['merchant_id']!=0){$merchant=intval($_POST['merchant_id']);}
if(isset($_POST['select_partner'])&&$_POST['select_partner']!=0){$partner=intval($_POST['select_partner']);}
if(isset($_POST['select_employee'])&&$_POST['select_employee']!=0){$employee=intval($_POST['select_employee']);}
$a['merchant_id']=$merchant;
$a['partner_id']=$partner;
$a['employee_id']=$employee;
$a['bill_price']=$_POST['bill_price'];
$a['balance']=$total;
$a['product_nums']=$num;
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
$a['pr'.$i]['price']=$_POST['product_price'.$i];
$a['pr'.$i]['bonus']=$bonus;
$a['pr'.$i]['profit']=$profit;
$a['pr'.$i]['is_offer']=$_POST['product_offer'.$i];
}
$a['profit_all']=$profit_all;
$a=serialize($a);



if($s=$mysqli->prepare("update return_instant_invoice set profit=?,products=?,notes=?,customer_name=?,merchant_id=?,total=?,date=?,partner_id=?,employee_id=? where id=". intval($_POST['instance_id']))){
@$s->bind_param("dsssidsii",$profit_all,$a,htmlentities($_POST['notes']),htmlentities($_POST['customer_name']),$merchant,$total,$date,$partner,$employee);
$s->execute();
$ma[0]=langu['edit_bill_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['edit_bill_fail'];$ma[1]=0;return $ma;}

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
$q=$mysqli->query('SELECT * FROM return_instant_invoice where return_instant_invoice.is_temp=1');
if($q->num_rows>0){
$profit=0;
echo "
    <table class='main_table'>
            <tr>
                <th><input id='selectall' class='no_print' type='checkbox' onclick='select_deselect_all()' value=''/></th>
                <th>".langu['bill_num']."</th>
                <th class='no_print'></th>
                <th>".langu['customer_name']."</th>
                <th>".langu['bill_total']."</th>
                <th>".langu['profit']."</th>
                <th class='no_print'></th>
                <th class='no_print'></th>
                <th class='no_print'></th>
            </tr>";
while ($row=$q->fetch_assoc()){
$name=langu['normal_customer'];

if($row['employee_id']!=0){$n=$mysqli->query('select name from employees where id='.$row['employee_id']);$n=$n->fetch_assoc();$name=$n['name'];}
elseif($row['partner_id']!=0){$n=$mysqli->query('select name from partners where id='.$row['partner_id']);$n=$n->fetch_assoc();$name=$n['name'];}
elseif($row['merchant_id']!=0){$n=$mysqli->query('select name from merchants where id='.$row['merchant_id']);$n=$n->fetch_assoc();$name=$n['name'];}
elseif($row['customer_name']!=''){$name=$row['customer_name'];}
$i3+=1;
$total+=$row['total'];
$profit+=$row['profit'];
echo "
    <tr class='show_hide'>
        <td><span class='no_print'><input class='saveit' name='saveit' type='checkbox' value='".$row['id']."'/></span></td>
        <td class='nume'>".$row['id']."</td>
        <td class='products_list_symbol no_print' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?update_temp_bills=ret_instant&id=".$row['id']."\")'>✔</td>
        <td>".$name."</td>
        <td class='nume'>".$row['total']."</td>
        <td class='nume'>".$row['profit']."</td>
        <td class='products_list_symbol no_print'><a href='return_instant_pay.php?conn=edit_bill&id=".$row['id']."'></a></td>
        <td class='products_list_symbol no_print'><a href='printbills.php?print_bills=return_instant&id=".$row['id']."' target='_blank'>|</a></td>
        <td class='del_product no_print' onClick='remove_instant_bill(".$row['id'].")'></td>
    </tr>";
}
echo "<tr>
        <td>".langu['total']."</td>
        <td class='nume bil'>".$i3."</td>
        <td class='no_print'></td>
        <td></td>
        <td class='nume totals'>".$total."</td>
        <td class='nume totals'>".$profit."</td>
        <td class='no_print'></td>
        <td class='no_print'></td>
        <td class='no_print'></td>
    </tr>
</table>";
}

else{echo "<div class='no_bills'>".langu['no_orders']."</div>";}
echo"
        </div>
    </div>
        <div class='form_input_line' style='margin:15px auto;'><div class='hide_show nprint' style='' onclick='save_select_temp(\"saveit\",\"ajaxbills.php?update_temp_bills=ret_instant&id=\")'>".langu['save_temp']."</div><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
</div>
";
}
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
	<input type='hidden' id='product_name".$num."' name='product_name".$num."' value='".$a['pr'.$num]['name']."'/>
	<td class='del_product' id='del_pro".$num."' onclick='del_product(".$num.")'></td>
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

function search_instant_form($mysqli){
$pa_emp=$this->get_partner_employee($mysqli,9999999,999999,"onchange='search_instant_pay_partner()'","onchange='search_instant_pay_employee()'");
echo "
<div class='form_main'>
<div class='form_main_name'>".langu['search_order']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['order_num']."</div><div class='form_input_input' id='search_num'><input type='text' id='bill_num_search' oninput='search_bill_num()' autocomplete='off' placeholder='".langu['order_num']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['order_date']."</div><div class='form_input_input' id='search_date'><input type='text' id='bill_date' onchange='search_instant_date()' autocomplete='off' placeholder='".langu['order_date']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' autocomplete='off' id='merchant_name2' name='merchant_name2' oninput='merchant_search2()' placeholder='".langu['merchant_name']."' value=''></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['partner']."</div><div class='form_input_input'>".$pa_emp['partner']."</div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['employee']."</div><div class='form_input_input'>".$pa_emp['employee']."</div></div>
    </div>
    <div class='form_main_name'>".langu['bills']."</div>
    <div class='bill_list_show'>

    </div>
</div>";
}

function get_partner_employee($mysqli,$partner=null,$employee=null,$onchange_pa=null,$onchange_emp=null){
$ret=array();
if($partner!=null){
$q=$mysqli->query('select * from partners');

$ret['partner']="<select id='select_partner' name='select_partner' ".$onchange_pa." style='margin:0 5px;'>
<option value='0' disabled selected>".langu['selectpartner']."</option>";
while($row=$q->fetch_assoc()){
$ret['partner'].="<option value='".$row['id']."'>".$row['name']."</option>";
if($row['id']==$partner){$ret['partner'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
}
$ret['partner'].="</select>";
}
if($employee!=null){
$q=$mysqli->query('select * from employees');

$ret['employee']="<select id='select_employee' name='select_employee' ".$onchange_emp." style='margin:0 5px;'>
<option value='0' disabled selected>".langu['selectemployee']."</option>";
while($row=$q->fetch_assoc()){
$ret['employee'].="<option value='".$row['id']."'>".$row['name']."</option>";
if($row['id']==$employee){$ret['employee'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
}
$ret['employee'].="</select>";
}

return $ret;

}
}
