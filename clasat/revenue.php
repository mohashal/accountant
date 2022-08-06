<?php

class revenue {
/**
*فورم اضافة شيك جديد لزبون
*/
function form_add_revenue($mysqli){
$s=$this->get_select_sale($mysqli,99999,99999,99999);
$ep=$this->get_partner_employee($mysqli,99999,99999);
echo "
<style>.customer_auto_search_name{width: 46%;margin:0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['add_payment_receipt']."</div>
<form action='revenue.php?conn=add-revenue-save' method='post' enctype='multipart/form-data'>
    <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'><input type='text' autocomplete='off' class='check_date' name='revenue_date' placeholder='".langu['date']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_receipt_to']."</div><div class='form_input_input'><input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()'>".langu['merchant']." <input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()' checked>".langu['customer']."
           <input type='radio' name='is_customer_merchant' id='is_partner' value='3' onchange='show_hide_customer_merchant()'>".langu['partner']." <input type='radio' name='is_customer_merchant' id='is_employee' value='4' onchange='show_hide_customer_merchant()'>".langu['employee']."<input type='radio' name='is_customer_merchant' id='is_normal' value='5' onchange='show_hide_customer_merchant()'>".langu['normal_customer']."</div></div>
            <div class='form_input_line' id='show_hide_customer'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' id='check_customer_name' name='check_customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_merchant' style='display:none;'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='search_merchant'><input type='text' autocomplete='off' id='check_merchant_name' name='check_merchant_name' placeholder='".langu['merchant_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_sale'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'><span id='set_sale'></span><input type='hidden' id='select_salesman' name='select_salesman' value='' /></div></div>
            <div class='form_input_line show_hide_baln' id='show_hide_sale'><div class='form_input_name'>".langu['balance']."</div><div class='form_input_input nume' id='set_balance'></div></div>
            <div class='form_input_line' id='show_hide_partner' style='display:none;'><div class='form_input_name'>".langu['partner']."</div><div class='form_input_input'>".$ep['partner']."</div></div>
            <div class='form_input_line' id='show_hide_emp' style='display:none;'><div class='form_input_name'>".langu['employee']."</div><div class='form_input_input'>".$ep['employee']."</div></div>
            <div class='form_input_line' id='show_hide_ncustomer' style='display:none;'><div class='form_input_name'>".langu['normal_customer']."</div><div class='form_input_input'><input type='text' id='customername' name='customername' placeholder='".langu['normal_customer']."' value=''/></div></div>
          <div id='if_cash'>
            <div class='form_input_line'><div class='form_input_name'>".langu['receipt_num']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='receipt_num' placeholder='".langu['receipt_num']."' value=''></div></div> 
          </div>
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_receipt_type']."</div><div class='form_input_input'><input type='checkbox' name='is_cash' id='is_cash' value='1' onchange='show_hide_cash_check()' checked>".langu['cash']." <span id='is_check_hs'><input type='checkbox' name='is_check' id='is_check' value='1' onchange='show_hide_cash_check()'>".langu['check']."</span></div></div>
          <div id='if_cash2'>  
            <div class='form_input_line'><div class='form_input_name'>".langu['cash_value']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='cash_value' placeholder='".langu['cash_value']."' value=''></div></div>          
          </div>
            <div class='form_input_line'><div class='form_input_name'>".langu['discount']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='discount' placeholder='".langu['discount']."' value='0'></div></div>
            <div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'></textarea></div></div>
            <input type='hidden' id='customer_id' name='customer_id' value=''/>
            <input type='hidden' id='main_customer_id' name='main_customer_id' value=''/>
            <input type='hidden' id='merchant_id' name='merchant_id' value='' />
            <input type='hidden' id='checks_count' name='checks_count' value='0' />
    </div>
".$s['banks'].$s['cur']."
    <div id='if_check' style='display:none;'>
        <div class='form_main_name' style='border-top:1px #c8cfd8 solid;'>".langu['checks']."</div>
        <div class='add_check' onclick='add_check_fields()'><span> + </span>".langu['add_check']."</div>
        <table class='check_list'>
            <tr>
                <th>".langu['bank']."</th>
                <th>".langu['check_num']."</th>
                <th>".langu['check_date']."</th>
                <th>".langu['check_value']."</th>
                <th>".langu['currency']."</th>
                <th>".langu['exchange_rate']."</th>
                <th>".langu['image']."</th>
            </tr>
        </table>
    </div>  
    <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add_payment_receipt']."'></div>
</form>
</div>
";
}

/**
*فورم  تعديل سند قبض
*/
function form_edit_revenue($mysqli,$not_temp=null){
$id=intval($_GET['id']);$checks_count=0;
$is_cash=">".langu['cash'];$is_check=">".langu['check'];
$check_hide=" style='display:none;'";
$row=$mysqli->query('select * from revenue where id='.$id);
$row=$row->fetch_assoc();
$cash1="<div id='if_cash' style='display:none;'><div class='form_input_line'><div class='form_input_name'>".langu['receipt_num']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='receipt_num' placeholder='".langu['receipt_num']."' value=''></div></div> </div>";
$cash2="<div id='if_cash2' style='display:none;'> <div class='form_input_line'><div class='form_input_name'>".langu['cash_value']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='cash_value' placeholder='".langu['cash_value']."' value=''></div></div> </div>";
$act='edit-revenue-save';
if($not_temp!=null){$act='edit-revenue-nottemp-save';}


$s=$this->get_select_sale($mysqli,$row['saleman_id'],99999,99999);
$ep=$this->get_partner_employee($mysqli,$row['partner_id'],$row['employee_id']);

if($row['checks_ids']!=null){$checks=unserialize($row['checks_ids']);$checks_count=count($checks);}

if($row['merchant_id']!=0){$row2=$mysqli->query('select name from merchants where id='.$row['merchant_id']);$row2=$row2->fetch_assoc();
$customer_merchent="           
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_receipt_to']."</div><div class='form_input_input'><input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()' checked>".langu['merchant']." <input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()'>".langu['customer']."
           <input type='radio' name='is_customer_merchant' id='is_partner' value='3' onchange='show_hide_customer_merchant()'>".langu['partner']." <input type='radio' name='is_customer_merchant' id='is_employee' value='4' onchange='show_hide_customer_merchant()'>".langu['employee']."<input type='radio' name='is_customer_merchant' id='is_normal' value='5' onchange='show_hide_customer_merchant()'>".langu['normal_customer']."</div></div>
            <div class='form_input_line' id='show_hide_customer' style='display:none;'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' id='check_customer_name' name='check_customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_merchant'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='search_merchant'><input type='text' autocomplete='off' id='check_merchant_name' name='check_merchant_name' placeholder='".langu['merchant_name']."' value='".$row2['name']."'></div></div>
            <div class='form_input_line' id='show_hide_sale' style='display:none;'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'>".$s['sales']."</div></div>
            <div class='form_input_line' id='show_hide_partner' style='display:none;'><div class='form_input_name'>".langu['partner']."</div><div class='form_input_input'>".$ep['partner']."</div></div>
            <div class='form_input_line' id='show_hide_emp' style='display:none;'><div class='form_input_name'>".langu['employee']."</div><div class='form_input_input'>".$ep['employee']."</div></div>
            <div class='form_input_line' id='show_hide_ncustomer' style='display:none;'><div class='form_input_name'>".langu['normal_customer']."</div><div class='form_input_input'><input type='text' id='customername' name='customername' placeholder='".langu['normal_customer']."' value=''/></div></div>
";}
/*            <div class='form_input_line' id='show_hide_sale'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'>".$s['sales']."</div></div>*/
elseif($row['customer_id']!=0){$row2=$mysqli->query('select customers.name as cname,employees.name as ename from customers,employees where customers.sales_man_id=employees.id and customers.id='.$row['customer_id']);$row2=$row2->fetch_assoc();
$customer_merchent="           
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_receipt_to']."</div><div class='form_input_input'><input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()'>".langu['merchant']." <input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()' checked>".langu['customer']."
           <input type='radio' name='is_customer_merchant' id='is_partner' value='3' onchange='show_hide_customer_merchant()'>".langu['partner']." <input type='radio' name='is_customer_merchant' id='is_employee' value='4' onchange='show_hide_customer_merchant()'>".langu['employee']."<input type='radio' name='is_customer_merchant' id='is_normal' value='5' onchange='show_hide_customer_merchant()'>".langu['normal_customer']."</div></div>
            <div class='form_input_line' id='show_hide_customer'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' id='check_customer_name' name='check_customer_name' placeholder='".langu['customer_name']."' value='".$row2['cname']."'></div></div>
            <div class='form_input_line' id='show_hide_merchant' style='display:none;'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='search_merchant'><input type='text' autocomplete='off' id='check_merchant_name' name='check_merchant_name' placeholder='".langu['merchant_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_sale'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'><span id='set_sale'>".$row2['ename']."</span><input type='hidden' id='select_salesman' name='select_salesman' value='".$row['saleman_id']."' /></div></div>
            <div class='form_input_line' id='show_hide_partner' style='display:none;'><div class='form_input_name'>".langu['partner']."</div><div class='form_input_input'>".$ep['partner']."</div></div>
            <div class='form_input_line' id='show_hide_emp' style='display:none;'><div class='form_input_name'>".langu['employee']."</div><div class='form_input_input'>".$ep['employee']."</div></div>
            <div class='form_input_line' id='show_hide_ncustomer' style='display:none;'><div class='form_input_name'>".langu['normal_customer']."</div><div class='form_input_input'><input type='text' id='customername' name='customername' placeholder='".langu['normal_customer']."' value=''/></div></div>
";}

elseif($row['partner_id']!=0){
$customer_merchent="           
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_receipt_to']."</div><div class='form_input_input'><input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()'>".langu['merchant']." <input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()'>".langu['customer']."
           <input type='radio' name='is_customer_merchant' id='is_partner' value='3' onchange='show_hide_customer_merchant()' checked>".langu['partner']." <input type='radio' name='is_customer_merchant' id='is_employee' value='4' onchange='show_hide_customer_merchant()'>".langu['employee']."<input type='radio' name='is_customer_merchant' id='is_normal' value='5' onchange='show_hide_customer_merchant()'>".langu['normal_customer']."</div></div>
            <div class='form_input_line' id='show_hide_customer' style='display:none;'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' id='check_customer_name' name='check_customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_merchant' style='display:none;'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='search_merchant'><input type='text' autocomplete='off' id='check_merchant_name' name='check_merchant_name' placeholder='".langu['merchant_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_sale' style='display:none;'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'>".$s['sales']."</div></div>
            <div class='form_input_line' id='show_hide_partner'><div class='form_input_name'>".langu['partner']."</div><div class='form_input_input'>".$ep['partner']."</div></div>
            <div class='form_input_line' id='show_hide_emp' style='display:none;'><div class='form_input_name'>".langu['employee']."</div><div class='form_input_input'>".$ep['employee']."</div></div>
            <div class='form_input_line' id='show_hide_ncustomer' style='display:none;'><div class='form_input_name'>".langu['normal_customer']."</div><div class='form_input_input'><input type='text' id='customername' name='customername' placeholder='".langu['normal_customer']."' value=''/></div></div>
";}
elseif($row['employee_id']!=0){
$customer_merchent="           
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_receipt_to']."</div><div class='form_input_input'><input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()'>".langu['merchant']." <input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()'>".langu['customer']."
           <input type='radio' name='is_customer_merchant' id='is_partner' value='3' onchange='show_hide_customer_merchant()'>".langu['partner']." <input type='radio' name='is_customer_merchant' id='is_employee' value='4' onchange='show_hide_customer_merchant()' checked>".langu['employee']."<input type='radio' name='is_customer_merchant' id='is_normal' value='5' onchange='show_hide_customer_merchant()'>".langu['normal_customer']."</div></div>
            <div class='form_input_line' id='show_hide_customer' style='display:none;'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' id='check_customer_name' name='check_customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_merchant' style='display:none;'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='search_merchant'><input type='text' autocomplete='off' id='check_merchant_name' name='check_merchant_name' placeholder='".langu['merchant_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_sale' style='display:none;'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'>".$s['sales']."</div></div>
            <div class='form_input_line' id='show_hide_partner' style='display:none;'><div class='form_input_name'>".langu['partner']."</div><div class='form_input_input'>".$ep['partner']."</div></div>
            <div class='form_input_line' id='show_hide_emp'><div class='form_input_name'>".langu['employee']."</div><div class='form_input_input'>".$ep['employee']."</div></div>
            <div class='form_input_line' id='show_hide_ncustomer' style='display:none;'><div class='form_input_name'>".langu['normal_customer']."</div><div class='form_input_input'><input type='text' id='customername' name='customername' placeholder='".langu['normal_customer']."' value=''/></div></div>
";}
elseif($row['normal_customer']!=0){
$customer_merchent="           
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_receipt_to']."</div><div class='form_input_input'><input type='radio' name='is_customer_merchant' id='is_merchant' value='0' onchange='show_hide_customer_merchant()'>".langu['merchant']." <input type='radio' name='is_customer_merchant' id='is_customer' value='1' onchange='show_hide_customer_merchant()'>".langu['customer']."
           <input type='radio' name='is_customer_merchant' id='is_partner' value='3' onchange='show_hide_customer_merchant()'>".langu['partner']." <input type='radio' name='is_customer_merchant' id='is_employee' value='4' onchange='show_hide_customer_merchant()'>".langu['employee']."<input type='radio' name='is_customer_merchant' id='is_normal' value='5' onchange='show_hide_customer_merchant()' checked>".langu['normal_customer']."</div></div>
            <div class='form_input_line' id='show_hide_customer' style='display:none;'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' id='check_customer_name' name='check_customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_merchant' style='display:none;'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='search_merchant'><input type='text' autocomplete='off' id='check_merchant_name' name='check_merchant_name' placeholder='".langu['merchant_name']."' value=''></div></div>
            <div class='form_input_line' id='show_hide_sale' style='display:none;'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'>".$s['sales']."</div></div>
            <div class='form_input_line' id='show_hide_partner' style='display:none;'><div class='form_input_name'>".langu['partner']."</div><div class='form_input_input'>".$ep['partner']."</div></div>
            <div class='form_input_line' id='show_hide_emp' style='display:none;'><div class='form_input_name'>".langu['employee']."</div><div class='form_input_input'>".$ep['employee']."</div></div>
            <div class='form_input_line' id='show_hide_ncustomer'><div class='form_input_name'>".langu['normal_customer']."</div><div class='form_input_input'><input type='text' id='customername' name='customername' placeholder='".langu['normal_customer']."' value='".$row['normal_customer_name']."'/></div></div>
";}

if($row['is_cash']==1){$is_cash=" checked >".langu['cash'];
$cash1="<div id='if_cash'><div class='form_input_line'><div class='form_input_name'>".langu['receipt_num']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='receipt_num' placeholder='".langu['receipt_num']."' value='".$row['receipt_num']."'></div></div> </div>";
$cash2="<div id='if_cash2'> <div class='form_input_line'><div class='form_input_name'>".langu['cash_value']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='cash_value' placeholder='".langu['cash_value']."' value='".$row['cash_value']."'></div></div> </div>";
}

if($row['is_check']==1){$is_check=" checked >".langu['check'];$check_hide="";}

echo "
<style>.customer_auto_search_name{width: 46%;margin:0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['edit_payment_receipt']."</div>
<form action='revenue.php?conn=".$act."' method='post' enctype='multipart/form-data'>
    <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'><input type='text' autocomplete='off' class='check_date' name='revenue_date' placeholder='".langu['date']."' value='".$row['add_date']."' required></div></div>
".$customer_merchent.$cash1."
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_receipt_type']."</div><div class='form_input_input'><input type='checkbox' name='is_cash' id='is_cash' value='1' onchange='show_hide_cash_check()'".$is_cash." <input type='checkbox' name='is_check' id='is_check' value='1' onchange='show_hide_cash_check()'".$is_check."</div></div>
".$cash2."
            <div class='form_input_line'><div class='form_input_name'>".langu['discount']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='discount' placeholder='".langu['discount']."' value='".$row['discount']."'></div></div>
            <div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'>".$row['notes']."</textarea></div></div>
            <input type='hidden' id='customer_id' name='customer_id' value='".$row['customer_id']."'/>
            <input type='hidden' id='main_customer_id' name='main_customer_id' value='".$row['main_customer_id']."'/>
            <input type='hidden' id='merchant_id' name='merchant_id' value='".$row['merchant_id']."' />
            <input type='hidden' id='checks_count' name='checks_count' value='".$checks_count."' />
            <input type='hidden' id='rev_id' name='rev_id' value='".$id."' />
    </div>
".$s['banks'].$s['cur']."
    <div id='if_check'".$check_hide.">
        <div class='form_main_name' style='border-top:1px #c8cfd8 solid;'>".langu['checks']."</div>
        <div class='add_check' onclick='add_check_fields()'><span> + </span>".langu['add_check']."</div>
        <table class='check_list'>
            <tr>
                <th>".langu['bank']."</th>
                <th>".langu['check_num']."</th>
                <th>".langu['check_date']."</th>
                <th>".langu['check_value']."</th>
                <th>".langu['currency']."</th>
                <th>".langu['exchange_rate']."</th>
                <th>".langu['image']."</th>
            </tr>";
for($i=0;$i<$checks_count;$i++){
$row3=$mysqli->query("select * from checks where id=".$checks[$i]);
$row3=$row3->fetch_assoc();
$s2=$this->edit_select_bank_cur($mysqli,$row3['bank_id'],$row3['currency_id'],($i+1));
echo "
<tr id='check".($i+1)."'>
    <td><span class='delete_check' id='delete_el".($i+1)."' onclick='delete_check(".($i+1).",".$row3['id'].")'></span>".$s2['banks']."</td>
    <td><input type='text' autocomplete='off' name='check_num".($i+1)."' placeholder='رقم الشيك' value='".$row3['check_num']."' required></td>
    <td><input type='text' autocomplete='off' class='check_date' name='check_date".($i+1)."' placeholder='تاريخ الشيك' value='".$row3['check_date']."' required></td>
    <td><input type='text' autocomplete='off' name='check_value".($i+1)."' placeholder='قيمة الشيك' value='".$row3['check_value']."' required></td>
    <td>".$s2['cur']."</td>
    <td><input type='text' autocomplete='off' name='exchange_rate".($i+1)."' placeholder='سعر الصرف' value='".$row3['exchange_rate']."'></td>
    <td><input type='file' name='check_image".($i+1)."' id='check_image'></td>
    <input type='hidden' id='this_check_id".($i+1)."' name='this_check_id".($i+1)."' value='".$row3['id']."' />
</tr>";
}
/*<span class='delete_check' id='delete_el".($i+1)."' onclick='delete_check(".($i+1).",".$row3['id'].")'></span>*/
echo "<script>$('.check_date').datepicker();</script>
        </table>
    </div>  
    <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit_payment_receipt']."'></div>
</form>
</div>
";
}


/**
*فنكشن حفظ اضافة السند غير المرحل
*/
function form_save_revenue($mysqli){
if(isset($_POST['is_customer_merchant'])){$is=intval($_POST['is_customer_merchant']);
$costumer_id=0;$main_customer_id=0;$merchant_id=0;$sale_id=0;$partner=0;$employee=0;$normal_customer=0;$ncname='';$no_check=0;
if($is==1){$main_customer_id=intval($_POST['main_customer_id']);$costumer_id=intval($_POST['customer_id']);$sale_id=intval($_POST['select_salesman']);}
elseif($is==0){$merchant_id=intval($_POST['merchant_id']);}
elseif($is==3){$partner=intval($_POST['select_partner']);$no_check=1;}
elseif($is==4){$employee=intval($_POST['select_employee']);$no_check=1;}
elseif($is==5){$normal_customer=1;$ncname=htmlentities($_POST['customername']);}
}
$cash=0;
$cash_value=0;
$check=0;$is_temp=1;
$check_total=0;
$count_checks=$_POST['checks_count'];
if($count_checks!=0 && $no_check==0){$check=1;}
$discount=floatval($_POST['discount']);
if(isset($_POST['is_cash'])){if($_POST['is_cash']==1){$cash=1;$cash_value=floatval($_POST['cash_value']);}}

/*اضافة سند قبض جديد*/
if($s=$mysqli->prepare("INSERT INTO revenue (is_cash,is_check,discount,cash_value,merchant_id,customer_id,main_customer_id,notes,saleman_id,add_date,receipt_num,is_temp,employee_id,partner_id,normal_customer,normal_customer_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")){
@$s->bind_param("iiddiiisissiiiis",$cash,$check,$discount,$cash_value,$merchant_id,$costumer_id,$main_customer_id,htmlentities($_POST['notes']),$sale_id,htmlentities($_POST['revenue_date']),htmlentities($_POST['receipt_num']),$is_temp,$employee,$partner,$normal_customer,$ncname);
$s->execute();

$rev_id=$mysqli->insert_id;
/*اضافة الشيكات اذا وجدت*/
if(isset($_POST['is_check'])){if($_POST['is_check']==1&&$count_checks!=0&&$no_check==0){
$ex_rate=1;
$ch_ids=array();
$s=$mysqli->prepare("INSERT INTO checks (merchant_id,customer_id,check_num,check_value,check_date,bank_id,currency_id,exchange_rate,revenue_id,normal_customer_name,normal_customer) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

for($i=1;$i<=$count_checks;$i++){
$ex_rate=1;
$valu=floatval($_POST['check_value'.$i]);
if($_POST['select_cur'.$i]!=1){$ex_rate=floatval($_POST['exchange_rate'.$i]);$check_total+=($ex_rate*$valu);}
else{$check_total+=$valu;}

@$s->bind_param("iisdsiidisi",$merchant_id,$costumer_id,htmlentities($_POST['check_num'.$i]),$valu,htmlentities($_POST['check_date'.$i]),intval($_POST['select_bank'.$i]),intval($_POST['select_cur'.$i]),$ex_rate,$rev_id,$ncname,$normal_customer);
$s->execute();
$check_id=$mysqli->insert_id;
$ch_ids[]=$check_id;
$this->upload_image($check_id,'check_image'.$i);
}

$mysqli->query("UPDATE revenue SET checks_value=".$check_total.",checks_ids='".serialize($ch_ids)."' WHERE id=".$rev_id);


}}

$ma[0]=langu['add_payment_success'];
$ma[1]=3;
return $ma;
}

else{$ma[0]=langu['add_payment_fail'];$ma[1]=0;return $ma;}
}

/**
*فنكشن حفظ تعديل السند غير المرحل
*/
function save_edit_revenue($mysqli){
/*if(isset($_POST['is_customer_merchant'])){$is=intval($_POST['is_customer_merchant']);
if($is==1){$main_customer_id=intval($_POST['main_customer_id']);$costumer_id=intval($_POST['customer_id']);$merchant_id=0;$sale_id=intval($_POST['select_salesman']);}
if($is==0){$costumer_id=0;$main_customer_id=0;$merchant_id=intval($_POST['merchant_id']);$sale_id=0;}
}*/
if(isset($_POST['is_customer_merchant'])){$is=intval($_POST['is_customer_merchant']);
$costumer_id=0;$main_customer_id=0;$merchant_id=0;$sale_id=0;$partner=0;$employee=0;$normal_customer=0;$ncname='';$no_check=0;
if($is==1){$main_customer_id=intval($_POST['main_customer_id']);$costumer_id=intval($_POST['customer_id']);$sale_id=intval($_POST['select_salesman']);}
elseif($is==0){$merchant_id=intval($_POST['merchant_id']);}
elseif($is==3){$partner=intval($_POST['select_partner']);$no_check=1;}
elseif($is==4){$employee=intval($_POST['select_employee']);$no_check=1;}
elseif($is==5){$normal_customer=1;$ncname=htmlentities($_POST['customername']);}
}
$rev_id=intval($_POST['rev_id']);
$cash=0;
$cash_value=0;
$check=0;$is_temp=1;
$check_total=0;
$count_checks=$_POST['checks_count'];
if($count_checks!=0 && $no_check==0){$check=1;}
$discount=floatval($_POST['discount']);
if(isset($_POST['is_cash'])){if($_POST['is_cash']==1){$cash=1;$cash_value=floatval($_POST['cash_value']);}}

/*تعديل سند قبض*/
if($s=$mysqli->prepare("update revenue set is_cash=?,is_check=?,discount=?,cash_value=?,merchant_id=?,customer_id=?,main_customer_id=?,notes=?,saleman_id=?,add_date=?,receipt_num=?,is_temp=?,employee_id=?,partner_id=?,normal_customer=?,normal_customer_name=? where id=?")){
@$s->bind_param("iiddiiisissiiiisi",$cash,$check,$discount,$cash_value,$merchant_id,$costumer_id,$main_customer_id,htmlentities($_POST['notes']),$sale_id,htmlentities($_POST['revenue_date']),htmlentities($_POST['receipt_num']),$is_temp,$employee,$partner,$normal_customer,$ncname,$rev_id);
$s->execute();

/*اضافة الشيكات اذا وجدت*/
if(isset($_POST['is_check'])){if($_POST['is_check']==1&&$count_checks!=0&&$no_check==0){
$ex_rate=1;
$ch_ids=array();
$s=$mysqli->prepare("INSERT INTO checks (merchant_id,customer_id,check_num,check_value,check_date,bank_id,currency_id,exchange_rate,revenue_id) VALUES (?,?,?,?,?,?,?,?,?)");
$s10=$mysqli->prepare("update checks set merchant_id=?,customer_id=?,check_num=?,check_value=?,check_date=?,bank_id=?,currency_id=?,exchange_rate=?,revenue_id=? where id=?");

for($i=1;$i<=$count_checks;$i++){
$ex_rate=1;
$valu=floatval($_POST['check_value'.$i]);
if($_POST['select_cur'.$i]!=1){$ex_rate=floatval($_POST['exchange_rate'.$i]);$check_total+=($ex_rate*$valu);}
else{$check_total+=$valu;}


if(isset($_POST['this_check_id'.$i])){
$check_id=intval($_POST['this_check_id'.$i]);
@$s10->bind_param("iisdsiidii",$merchant_id,$costumer_id,htmlentities($_POST['check_num'.$i]),$valu,htmlentities($_POST['check_date'.$i]),intval($_POST['select_bank'.$i]),intval($_POST['select_cur'.$i]),$ex_rate,$rev_id,$check_id);
$s10->execute();
$ch_ids[]=$check_id;
$this->upload_image($check_id,'check_image'.$i);
}

else{
@$s->bind_param("iisdsiidi",$merchant_id,$costumer_id,htmlentities($_POST['check_num'.$i]),$valu,htmlentities($_POST['check_date'.$i]),intval($_POST['select_bank'.$i]),intval($_POST['select_cur'.$i]),$ex_rate,$rev_id);
$s->execute();
$check_id=$mysqli->insert_id;
$ch_ids[]=$check_id;
$this->upload_image($check_id,'check_image'.$i);
}

}

$mysqli->query("UPDATE revenue SET checks_value=".$check_total.",checks_ids='".serialize($ch_ids)."' WHERE id=".$rev_id);


}}

$ma[0]=langu['edit_payment_success'];
$ma[1]=3;
return $ma;
}

else{$ma[0]=langu['edit_payment_fail'];$ma[1]=0;return $ma;}
}

/**
*فنكشن اضافة فورم السندات غير المرحلة
*/
function form_temp_revenue($mysqli){
$no='';
$sales=$this->get_select_sale($mysqli,99998,null,null,'temp');
echo "
<style>.check_list{margin-top:30px;}.form_main{width:95%;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['temp_payment_receipt']."</div>
<div class='select_sale_temp'>".$sales['sales']."</div>
    <table class='check_list'>
        <tr>
            <th class='no_print'><input id='selectall' type='checkbox' onclick='select_deselect_all()' value=''/></th>
            <th>".langu['payment_recipt_num']."</th>
            <th class='edit_symbol'></th>
            <th>".langu['payment_recipt_from']."</th>
            <th>".langu['payment_recipt_type']."</th>
            <th>".langu['payment_recipt_cash_total']."</th>
            <th>".langu['check_count']."</th>
            <th>".langu['payment_recipt_checks_total']."</th>
            <th>".langu['discount']."</th>
            <th class='edit_symbol'></th>
            <th class='delete_symbol'></th>
        </tr>";

$q=$mysqli->query("select * from revenue where is_temp=1");
if($q->num_rows>0){
while($row=$q->fetch_assoc()){
$checks=0;$type='';
if($row['checks_ids']!=null){$checks=unserialize($row['checks_ids']);$checks=count($checks);}
if($row['is_cash']==1){$type.=langu['cash'].' ';}
if($row['is_check']==1){$type.=langu['check'];}

$name='';$class=0;
if($row['customer_id']!=0){$q2=$mysqli->query("select name from customers where id=".$row['customer_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];$class=$row['saleman_id'];}
elseif($row['merchant_id']!=0){$q2=$mysqli->query("select name from merchants where id=".$row['merchant_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];$class='m';}
elseif($row['employee_id']!=0){$q2=$mysqli->query("select name from employees where id=".$row['employee_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
elseif($row['partner_id']!=0){$q2=$mysqli->query("select name from partners where id=".$row['partner_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
elseif($row['normal_customer']!=0){if($row['normal_customer_name']!=''){$name=$row['normal_customer_name'];}else{$name=langu['normal_customer'];}}

echo "  <tr class='show_hide ".$class."' data-cash='".$row['cash_value']."' data-check='".$row['checks_value']."' data-discount='".$row['discount']."'>
            <td class='no_print'><span class='no_print'><input class='saveit ss".$class."' name='saveit' type='checkbox' value='".$row['id']."'/></span></td>
            <td class='nume'>".$row['id']."</td>
            <td class='edit_symbol' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?find_check=save_temp_rev&id=".$row['id']."\")'>✔</td>
            <td >".$name."</td>
            <td>".$type."</td>
            <td class='nume'>".$row['cash_value']."</td>
            <td class='nume'>".$checks."</td>
            <td class='nume'>".$row['checks_value']."</td>
            <td class='nume'>".$row['discount']."</td>
            <td class='edit_symbol'><a href='revenue.php?conn=edit-temp-revenue&id=".$row['id']."'></a></td>
            <td class='delete_symbol' onClick='remove_temp_rev(".$row['id'].")'></td>
        </tr>";
}}

else{$no="<div class='no_resault'>".langu['no_temp_receipt']."</div>";}
echo "<tr class='show_hide' id='temp_total' style='display:none'><td class='no_print'></td><td>".langu['total']."</td><td></td><td></td>
<td class='nume' id='temp_total_cash'></td><td></td>
<td class='nume' id='temp_total_discount'></td>
<td class='nume' id='temp_total_check'></td>
<td></td><td></td><td></td>
</tr>
</table>
".$no."
    <div class='form_input_line' style='margin:15px auto;'><div class='hide_show nprint' style='' onclick='save_select_temp(\"saveit\",\"ajaxbills.php?find_check=save_temp_rev&id=\")'>".langu['save_temp']."</div><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>

</div>
";
}

/**
 *فنكشن رفع الصور الى السيرفر 
 *@param type $id
 */
function upload_image($id,$name){
$id=intval($id);

if($_FILES[$name]["name"]!='' && $id!=0){
$ext=explode(".",$_FILES[$name]["name"]);
$ext=strtolower($ext[1]);
$pic=$id.'.jpg';
$path='images/checks/'.$pic;
if ((($_FILES[$name]["type"] == "image/gif")
|| ($_FILES[$name]["type"] == "image/jpeg")
|| ($_FILES[$name]["type"] == "image/jpg")
|| ($_FILES[$name]["type"] == "image/pjpeg")
|| ($_FILES[$name]["type"] == "image/x-png")
|| ($_FILES[$name]["type"] == "image/png"))
&& ($_FILES[$name]["size"] < 5900000)
&& in_array($ext,array("gif","jpeg","jpg","png"))){

$is_jpg=0;
switch ($ext){
case 'jpg':imagejpeg(imagecreatefromjpeg($_FILES[$name]['tmp_name']),$path,75);break;
case 'jpeg':imagejpeg(imagecreatefromjpeg($_FILES[$name]['tmp_name']),$path,75);break;
case 'png':$image=imagecreatefrompng($_FILES[$name]['tmp_name']);$is_jpg=1;break;
default:$image=imagecreatefromgif($_FILES[$name]['tmp_name']);$is_jpg=1;break;
}
if($is_jpg==1){
$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
imagealphablending($bg, TRUE);
imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
imagedestroy($image);
imagejpeg($bg,$path,75);
imagedestroy($bg);
}

}}

}

/**
 *البحث عن سندات الصرف
 */
function search_revenue($mysqli){
$sales=$this->get_select_sale($mysqli,99998,null,null,'search');
$month="<select id='search_expense_month' name='search_expense_month' onchange='get_records_by_monthyear()'>
<option value='0' disabled selected>".langu['select_month']."</option>";
for($i=1;$i<13;$i++){$month.="<option value='$i'>".$i."</option>";}
$month.="</select>";

$year="<select id='search_expense_year' name='search_expense_year' onchange='get_records_by_monthyear()'>
<option value='0' disabled selected>".langu['select_year']."</option>";
for($i=2017;$i<=date('Y');$i++){$year.="<option value='$i'>".$i."</option>";}
$year.="</select>";


echo "<style>.customer_auto_search_name{width:31%; margin:1px 0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['search_revenue']."</div>
<div class='form_main_inputs'>
    <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' id='s_customer_name' name='s_customer_name' placeholder='".langu['customer_name']."' value=''></div></div>
    <div class='form_input_line'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'>".$month.$year."</div></div>
    <div class='form_input_line' id='salesmans' style='display:none;'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'><div class='select_sale_temp' style='margin:0;'>".$sales['sales']."</div></div></div>
</div>

<div class='form_main_name'>".langu['revenue_payments']."</div>

<div id='revenues_append'></div>
</div>
";
}

/**
*جلب المندوبين
*@return $ma array contains $ma['sale']
*/
function get_select_sale($mysqli,$saleman=null,$banks=null,$currency=null,$i=null){
$ma=array();
if($saleman!=null){
$ins=" ( ".langu['partners']." , ".langu['employees']." , ".langu['normal_customer']." )";
$q=$mysqli->query('select id,name from employees where employee_type=1');
$ma['sales']="<select id='select_salesman".$i."' name='select_salesman".$i."' required>
<option value='n' disabled selected>".langu['selectsales']."</option>";
if($saleman==99998){$ma['sales'].="<option value='0'>".langu['instant_pay'].$ins."</option><option value='m'>".langu['merchant']."</option>";}
while ($row=$q->fetch_assoc()) {
if($saleman==$row['id']){$ma['sales'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$ma['sales'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$ma['sales'].="</select>";
}

if($banks!=null){$ba='';$ba2='';
if($banks==99999){$ba="<textarea id='select_banks'>";$ba2="</textarea>";}
$q=$mysqli->query('select * from banks where is_delete=0');
$ma['banks']=$ba."<select name='select_bank0' id='select_bank0' required>
<option value='' disabled selected>".langu['selectbank']."</option>";
while ($row=$q->fetch_assoc()) {
if($banks==$row['id']){$ma['banks'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$ma['banks'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$ma['banks'].="</select>".$ba2;
}

if($currency!=null){$ta='';$ta2='';
if($currency==99999){$ta="<textarea id='select_curs'>";$ta2="</textarea>";}
$q=$mysqli->query('select * from currency where id>1 and is_delete=0');
$ma['cur']=$ta."<select name='select_cur0' id='select_cur0' required>
<option value='' disabled>".langu['selectcur']."</option>
<option value='1' selected>".langu['shekel']."</option>";
while ($row=$q->fetch_assoc()) {
if($currency==$row['id']){$ma['cur'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$ma['cur'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$ma['cur'].="</select>".$ta2;
}

return $ma;
}

/**
 *جلب البنوك والعملات لتعديل السند
 */
function edit_select_bank_cur($mysqli,$banks=null,$currency=null,$i=null){
$ma=array();

if($banks!=null){$ba='';$ba2='';
if($banks==99999){$ba="<textarea id='select_banks'>";$ba2="</textarea>";}
$q=$mysqli->query('select * from banks where is_delete=0');
$ma['banks']=$ba."<select name='select_bank".$i."' id='select_bank".$i."' required >
<option value='0' disabled selected>".langu['selectbank']."</option>";
while ($row=$q->fetch_assoc()) {
if($banks==$row['id']){$ma['banks'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$ma['banks'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$ma['banks'].="</select>".$ba2;
}

if($currency!=null){$ta='';$ta2='';
if($currency==99999){$ta="<textarea id='select_curs'>";$ta2="</textarea>";}
$q=$mysqli->query('select * from currency where id>1 and is_delete=0');
$ma['cur']=$ta."<select name='select_cur".$i."' id='select_cur".$i."' required >
<option value='0' disabled>".langu['selectcur']."</option>
<option value='1' selected>".langu['shekel']."</option>";
while ($row=$q->fetch_assoc()) {
if($currency==$row['id']){$ma['cur'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else{$ma['cur'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
$ma['cur'].="</select>".$ta2;
}

return $ma;
}

function get_partner_employee($mysqli,$partner=null,$employee=null){
$ret=array();
if($partner!=null){
$q=$mysqli->query('select * from partners');

$ret['partner']="<select id='select_partner' name='select_partner' style='margin:0 5px;'>
<option value='0' disabled selected>".langu['selectpartner']."</option>";
while($row=$q->fetch_assoc()){
$ret['partner'].="<option value='".$row['id']."'>".$row['name']."</option>";
if($row['id']==$partner){$ret['partner'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
}
$ret['partner'].="</select>";
}
if($employee!=null){
$q=$mysqli->query('select * from employees');

$ret['employee']="<select id='select_employee' name='select_employee' style='margin:0 5px;'>
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