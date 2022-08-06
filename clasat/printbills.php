<?php

class printbills {
/**
*print temp bill 
*/
function print_temp($mysqli,$id){

$query='SELECT invoices.*,customers.id as c_id,customers.telephone as tel,customers.full_address as fu_adr,customers.balance,customers.name as customer_name,employees.name as sale_name,areas.name as area_name FROM invoices,customers,employees,areas where invoices.id='.intval($id).' and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id and areas.id=customers.area_id';
$title=langu['order'];

$row=$mysqli->query($query);
$row=$row->fetch_assoc();
$q=$mysqli->query('select name from employees where id='.$row['driver_id']);
$q=$q->fetch_assoc();
$a=unserialize($row['products']);
$tel=str_replace('-','',$row['tel']);
$save='';

$invoice_id="<div class='bill_title_line'>".langu['order_num']." : ".sprintf("%04s",$row['id'])."</div>";


if($row['is_temp']==1){$save="<div class='print_button' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?update_temp_bills=save&id=".$row['id']."\")'><span>|</span>".langu['save_temp']."</div>";}
echo"
<div class='main_print_button'><div class='div_print_button'>
    <div class='print_button' onclick='window.print()'><span>|</span>".langu['print']."</div>
".$save."
</div></div>

<div class='bill_main2'>

<div class='bill_title'>".$title."</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line' style='margin:0;padding:0;'></div>
    <div class='bill_title_line' style='margin:0;padding:0;'><img style='width:50px;eight:50px;float:left;' src='images/main/tr.jpg'/></div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$row['customer_name']."</div>
    <div class='bill_title_line'>".langu['date']." : ".$row['date']."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['customer_num']." : ".sprintf("%04s",$row['c_id'])."</div>
".$invoice_id."
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['telephone']." : ".$tel."</div>
    <div class='bill_title_line'>".langu['salesman2']." : ".$row['sale_name']."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['address']." : ".$row['area_name']." - ".$row['fu_adr']."</div>
    <div class='bill_title_line'>".langu['driver']." : ".$q['name']."</div>
</div>

<div class='bill_list_main'>
<table>
<thead>
<tr>
<th>".langu['num']."</th>
<th style='width:22px;'>م</th>
<th>".langu['product_num2']."</th>
<th>".langu['product_name2']."</th>
<th>".langu['product_quantity']."</th>
<th>".langu['unit']."</th>
<th>".langu['price']."</th>
<th>".langu['bonus']."</th>
<th>".langu['total']."</th>
</tr>
</thead><tbody>";


for($i=1;$i<=$a['product_nums'];$i++){
if($a['pr'.$i]['bonus']==1){$total=langu['bonus'];$bonus='✔';}
else{$total=$a['pr'.$i]['price']*$a['pr'.$i]['quantity'];$bonus='';}
echo "<tr>
<td>".$i."</td>
<td></td>
<td>".$a['pr'.$i]['ids']."</td>
<td>".$a['pr'.$i]['name']."</td>
<td>".$a['pr'.$i]['quantity']."</td>
<td>".$a['pr'.$i]['unit']."</td>
<td>".$a['pr'.$i]['price']."</td>
<td>".$bonus."</td>
<td>".$total."</td>
</tr>";
}
if($row['balance']==0){$balance=0;}
else{$balance=$row['balance'];}

/*if($row['is_temp']==0){echo "<tr><td colspan='7' style='border:0;'></td><td>".langu['bill_order']."</td><td>".$a['balance']."</td></tr>";}*/
$fin='';
if($row['is_temp']==1){
$final_total=$row['balance']+$a['balance'];
$fin="<tr><td colspan='7' style='border:0;'></td><td>".langu['balance_old']."</td><td>".$balance."</td></tr>
<tr><td colspan='7' style='border:0;'></td><td>".langu['final_total']."</td><td>".$final_total."</td></tr>";
}
echo "<tbody><tr><td colspan='7' style='border:0;'></td><td>".langu['bill_order']."</td><td>".$a['balance']."</td></tr>".$fin;


echo "</table></div>

<div class='bill_title_wrap'>
    <div class='bill_title_line' style='width:98%;margin:10px 0 20px 0;'>
    <fieldset style='padding:15px;border:1px solid black;'>
	<legend style='margin-right:15px;font-size:18px;'>".langu['notes']."</legend>".$row['notes']."
    </fieldset>
    </div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['date']." : ".$row['date']."</div>
    <div class='bill_title_line'>".langu['order_num']." : ".sprintf("%04s",$row['id'])."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['parcel_num']." : ".$row['parcel_num']."</div>
    <div class='bill_title_line'>".langu['customer_name']." : ".$row['customer_name']."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['driver']." : ".$q['name']."</div>
    <div class='bill_title_line'>".langu['recipient_sign']." :</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'></div>
    <div class='bill_title_line'></div>
</div>

</div>";
/*
<div class='bill_list_main'>
    <div class='bill_list_titles'>
        <div class='bill_list_titles_element small_bill'>".langu['num']."</div>
        <div class='bill_list_titles_element'>".langu['product_name']."</div>
        <div class='bill_list_titles_element'>".langu['product_quantity']."</div>
        <div class='bill_list_titles_element small_bill'>".langu['price']."</div>
        <div class='bill_list_titles_element'>".langu['total']."</div>
    </div>
</div>
*/
}

/**
*print temp bill 
*/
function print_with_head($mysqli,$id,$type){
if($type=='tax'){
$query='SELECT invoices.*,tax_invoice.id as t_id,customers.id as c_id,customers.full_address as fu_adr,customers.telephone as tel,customers.balance,customers.name as customer_name,employees.name as sale_name,areas.name as area_name FROM tax_invoice,invoices,customers,employees,areas where invoices.id='.intval($id).' and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id and areas.id=customers.area_id and tax_invoice.invoice_id=invoices.id';
$title=langu['tax_bill'];
}
elseif($type=='sent'){
$query='SELECT invoices.*,sent_invoice.id as s_id,customers.id as c_id,customers.full_address as fu_adr,customers.telephone as tel,customers.balance,customers.name as customer_name,employees.name as sale_name,areas.name as area_name FROM sent_invoice,invoices,customers,employees,areas where invoices.id='.intval($id).' and invoices.sales_man_id=employees.id and invoices.customer_id=customers.id and areas.id=customers.area_id and sent_invoice.invoice_id=invoices.id';
$title=langu['sent_bill'];
}

$row=$mysqli->query($query);
$row=$row->fetch_assoc();
$a=unserialize($row['products']);
$tel=str_replace('-','',$row['tel']);
$save='';
$img="<div class='header_logo'><img src='images/main/header.png'/></div>";

/*switch ($type) {
    case 'tax':$invoice_id="<div class='bill_title_line'>".langu['bill_num']." : ".sprintf("%04s",$row['t_id'])."</div>";break;
    case 'sent':$invoice_id="<div class='bill_title_line'>".langu['sent_num']." : ".sprintf("%04s",$row['s_id'])."</div>";break;
}*/

switch ($type) {
    case 'tax':$invoice_id="<span class='nume'>".sprintf("%04s",$row['t_id'])."</span>";break;
    case 'sent':$invoice_id="<span class='nume'>".sprintf("%04s",$row['s_id'])."</span>";break;
}
if($row['is_temp']==1){$save="<div class='print_button' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?update_temp_bills=save&id=".$row['id']."\")'><span>|</span>".langu['save_temp']."</div>";}
echo"
<div class='main_print_button'><div class='div_print_button'>
    <div class='print_button' onclick='window.print()'><span>|</span>".langu['print']."</div>
".$save."
</div></div>
".$img."
<div class='bill_main'>

<div class='bill_title'>".$title." - ".$invoice_id."</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$row['customer_name']."</div>
    <div class='bill_title_line'>".langu['date']." : ".$row['date']."</div>
</div>

<div class='bill_list_main'>
<table>
<tr>
<th>".langu['num']."</th>
<th>".langu['product_name2']."</th>
<th>".langu['product_quantity']."</th>
<th>".langu['unit']."</th>
<th>".langu['price']."</th>
<th>".langu['bonus']."</th>
<th>".langu['total']."</th>
</tr>";


for($i=1;$i<=$a['product_nums'];$i++){
if($a['pr'.$i]['bonus']==1){$total=langu['bonus'];$bonus='✔';}
else{$total=$a['pr'.$i]['price']*$a['pr'.$i]['quantity'];$bonus='';}

echo "<tr>
<td>".$i."</td>
<td>".$a['pr'.$i]['name']."</td>
<td>".$a['pr'.$i]['quantity']."</td>
<td>".$a['pr'.$i]['unit']."</td>
<td>".round($a['pr'.$i]['price']*0.84,2)."</td>
<td>".$bonus."</td>
<td>".round(floatval($total)*0.84,2)."</td>
</tr>";
}
if($row['balance']==0){$balance=0;}
else{$balance=$row['balance'];}

if($row['is_temp']==0){
echo "
<tr><td colspan='5' style='border:0;text-align:left;'></td><td>".langu['total']."</td><td>".round($a['balance']*0.84,2)."</td></tr>
<tr><td colspan='5' style='border:0;text-align:left;'></td><td>".langu['vat']."</td><td>".round($a['balance']*0.16,2)."</td></tr>
<tr><td colspan='5' style='border:0;text-align:left;'></td><td>".langu['final_total']."</td><td>".$a['balance']."</td></tr>";
}
else{
$final_total=$row['balance']+$a['balance'];
echo "<tr><td colspan='7' style='border:0;'></td><td>".langu['bill_order']."</td><td>".$a['balance']."</td></tr>
<tr><td colspan='7' style='border:0;'></td><td>".langu['balance_old']."</td><td>".$balance."</td></tr>
<tr><td colspan='7' style='border:0;'></td><td>".langu['final_total']."</td><td>".$final_total."</td></tr>";
}

echo "</table></div></div>";

}
/**
*print temp bill 
*/
function print_merchant_or_returned($mysqli,$id,$type){
$notes='';
if($type==1){$query='SELECT returned_products.*,customers.name as customer_name,employees.name as sale_name FROM returned_products,customers,employees where returned_products.id='.intval($id).' and returned_products.sales_man_id=employees.id and returned_products.customer_id=customers.id';
$row=$mysqli->query($query);
$row=$row->fetch_assoc();
$title=langu['returned_product'];
$num=langu['num']." ".langu['returned_order']." : ".sprintf("%04s",$row['id']);
$name=$row['customer_name'];
}

elseif($type==2){$query='SELECT merchant_invoice.*,merchants.name as customer_name FROM merchant_invoice,merchants where merchant_invoice.id='.intval($id).' and merchant_invoice.merchant_id=merchants.id';
$row=$mysqli->query($query);
$row=$row->fetch_assoc();
$title=langu['merchant_bill'];
$num=langu['bill_num']." : ".$row['bill_num'];
$name=$row['customer_name'];
}

elseif($type==3){$query='SELECT instant_invoice.*,merchants.name as merchant_name FROM instant_invoice,merchants where instant_invoice.id='.intval($id).' and instant_invoice.merchant_id=merchants.id';
$row=$mysqli->query($query);
$row=$row->fetch_assoc();
/*if($row['merchant_id']==0){$row['customer_name']=langu['normal_customer'];}*/
$name='';
if($row['merchant_id']!=0){$name=$row['merchant_name'];}
elseif($row['employee_id']!=0){$q2=$mysqli->query("select name from employees where id=".$row['employee_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
elseif($row['partner_id']!=0){$q2=$mysqli->query("select name from partners where id=".$row['partner_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
else{if($row['customer_name']!=''){$name=$row['customer_name'];}else{$name=langu['normal_customer'];}}

$title=langu['order'];
$num=langu['order_num']." : ".$row['id'];
$notes="
<div class='bill_title_wrap'>
    <div class='bill_title_line' style='width:98%;margin:10px 0 20px 0;'>
    <fieldset style='padding:15px;border:1px solid black;'>
	<legend style='margin-right:15px;font-size:18px;'>".langu['notes']."</legend>".$row['notes']."
    </fieldset>
    </div>
</div>
";
}
elseif($type==4){$query='SELECT merchant_returned.*,merchants.name as customer_name FROM merchant_returned,merchants where merchant_returned.id='.intval($id).' and merchant_returned.merchant_id=merchants.id';
$row=$mysqli->query($query);
$row=$row->fetch_assoc();
$title=langu['merchant_bill'];
$name=$row['customer_name'];
$num=langu['bill_num']." : ".$row['id'];
}

elseif($type==5){$query='SELECT return_instant_invoice.*,merchants.name as merchant_name FROM return_instant_invoice,merchants where return_instant_invoice.id='.intval($id).' and return_instant_invoice.merchant_id=merchants.id';
$row=$mysqli->query($query);
$row=$row->fetch_assoc();
/*if($row['merchant_id']==0){$row['customer_name']=langu['normal_customer'];}*/
$name='';
if($row['merchant_id']!=0){$name=$row['merchant_name'];}
elseif($row['employee_id']!=0){$q2=$mysqli->query("select name from employees where id=".$row['employee_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
elseif($row['partner_id']!=0){$q2=$mysqli->query("select name from partners where id=".$row['partner_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
else{if($row['customer_name']!=''){$name=$row['customer_name'];}else{$name=langu['normal_customer'];}}

$title=langu['returned_products'];
$num=langu['order_num']." : ".$row['id'];
$notes="
<div class='bill_title_wrap'>
    <div class='bill_title_line' style='width:98%;margin:10px 0 20px 0;'>
    <fieldset style='padding:15px;border:1px solid black;'>
	<legend style='margin-right:15px;font-size:18px;'>".langu['notes']."</legend>".$row['notes']."
    </fieldset>
    </div>
</div>
";
}

$a=unserialize($row['products']);

$invoice_id="<div class='bill_title_line'>".$num."</div>";

echo"
<div class='main_print_button'><div class='div_print_button'>
    <div class='print_button' onclick='window.print()'><span>|</span>".langu['print']."</div>
</div></div>

<div class='bill_main2'>
<div class='bill_title'>".$title."</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$name."</div>
    <div class='bill_title_line'>".langu['date']." : ".$row['date']."</div>
</div>
<div class='bill_title_wrap'>
    ".$invoice_id."
    <div class='bill_title_line'></div>
</div>

<div class='bill_list_main'>
<table>
<tr>
<th>".langu['num']."</th>
<th>".langu['product_num2']."</th>
<th>".langu['product_name2']."</th>
<th>".langu['product_quantity']."</th>
<th>".langu['unit']."</th>
<th>".langu['price']."</th>
<th>".langu['bonus']."</th>
<th>".langu['total']."</th>
</tr>";


for($i=1;$i<=$a['product_nums'];$i++){
if($a['pr'.$i]['bonus']==1){$total=langu['bonus'];$bonus='✔';}
else{$total=$a['pr'.$i]['price']*$a['pr'.$i]['quantity'];$bonus='';}
echo "<tr>
<td>".$i."</td>
<td>".$a['pr'.$i]['id']."</td>
<td>".$a['pr'.$i]['name']."</td>
<td>".$a['pr'.$i]['quantity']."</td>
<td>".$a['pr'.$i]['unit']."</td>
<td>".$a['pr'.$i]['price']."</td>
<td>".$bonus."</td>
<td>".$total."</td>
</tr>";
}

echo "<tr><td colspan='6' style='border:0;'></td><td>".langu['bill_order']."</td><td>".$a['balance']."</td></tr>";

echo "</table>".$notes. "</div>";

}
/*طباعة سند صرف*/
function print_expense($mysqli,$id,$type){
$save='';
$q=$mysqli->query("select expense.*,expense_types.name as ename from expense,expense_types where expense.id=".$id." and expense_types.id=expense.expense_type");
if($q->num_rows>0){
$row=$q->fetch_assoc();

if($row['expense_type']>5){$name=$row['ename'];}
else {
    switch ($row['expense_type']){
        case '0':$sq='select name from partners where id='.$row['partner_id'];break;
        case '1':$sq='select name from employees where id='.$row['employee_id'];break;
        case '2':$sq='select name from employees where id='.$row['employee_id'];break;
        case '3':$sq='select name from merchants where id='.$row['merchant_id'];break;
        case '4':$sq='select name from cars where id='.$row['car_id'];break;
        case '5':$sq='select name from customers where id='.$row['customer_id'];break;
    }
$q3=$mysqli->query($sq);$q3=$q3->fetch_assoc();
$name=$q3['name'];
}
$disc='';
if($row['expense_type']==3 || $row['expense_type']==5){
$disc=langu['discount']." : ".$row['discount'];
}
$total_check=$row['check_value']+$row['our_check_value'];
if($row['is_temp']==1){$save="<div class='print_button' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?expense=save_temp_exp&id=".$row['id']."&exp_type=".$row['expense_type']."\")'><span>|</span>".langu['save_temp']."</div>";}
echo"
<div class='main_print_button'><div class='div_print_button'>
    <div class='print_button' onclick='window.print()'><span>|</span>".langu['print']."</div>
".$save."
</div></div>

<div class='bill_main'>
<div class='bill_title'>".langu['expenses_payment']."</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['payment_recipt_from']." : ".$name."</div>
    <div class='bill_title_line'>".langu['date']." : ".$row['date']."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['payment_recipt_cash_total']." : ".$row['cash_value']." ".langu['shekel']."</div>
    <div class='bill_title_line'>".$disc."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['payment_recipt_checks_total']." : ".$total_check." ".langu['shekel']."</div>
    <div class='bill_title_line'>".langu['check_count']." : ".$row['check_count']."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line' style='width:90%;margin-top:20px;'>
    <fieldset style='padding:10px;border:1px solid black;'>
	<legend style='margin-right:15px;font-size:18px;'>".langu['notes']."</legend>".$row['notes']."
    </fieldset>
    </div>
</div>
";
if($row['is_check']==1){
$table1=$this->get_checks($mysqli,'SELECT checks.*,currency.name as cur_name,banks.name as bank_name FROM checks,banks,currency where checks.expense_id='.$id.' and currency.id=checks.currency_id and banks.id=checks.bank_id',1);
$table2=$this->get_checks($mysqli,'SELECT our_checks.*,currency.name as cur_name,banks.name as bank_name FROM our_checks,banks,currency where our_checks.expense_id='.$id.' and currency.id=our_checks.currency_id and banks.id=our_checks.bank_id',2);
echo "
<div class='bill_title'>".langu['checks']."</div>

<div class='bill_list_main'>
<table>
<tr>
<th></th>
<th>".langu['check_from']."</th>
<th>".langu['bank']."</th>
<th>".langu['check_num']."</th>
<th>".langu['check_date']."</th>
<th>".langu['check_value']."</th>
<th>".langu['currency']."</th>
<th>".langu['exchange_rate']."</th>
</tr>
".$table1.$table2."
</table></div>";
}
echo "</div>";

}

}

/*طباعة سند قبض*/
function print_revenue($mysqli,$id){

$q=$mysqli->query("select revenue.*,merchants.name as mname,customers.name as cname from revenue,merchants,customers where revenue.id=".$id." and customers.id=revenue.customer_id and merchants.id=revenue.merchant_id");
if($q->num_rows>0){
$row=$q->fetch_assoc();
$cash_check='';
$check_count=0;
$save='';
if($row['customer_id']==0){$name=$row['mname'];}
else{$name=$row['cname'];}
if($row['is_cash']==1){$cash_check.=langu['cash'];}
if($row['is_check']==1){$cash_check.=" ".langu['check'];$check_count=count(unserialize($row['checks_ids']));}

if($row['is_temp']==1){$save="<div class='print_button' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?find_check=save_temp_rev&id=".$row['id']."\")'><span>|</span>".langu['save_temp']."</div>";}
echo"
<div class='main_print_button'><div class='div_print_button'>
    <div class='print_button' onclick='window.print()'><span>|</span>".langu['print']."</div>
".$save."
</div></div>

<div class='bill_main'>
<div class='bill_title'>".langu['payment_receipt']."</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['payment_recipt_from']." : ".$name."</div>
    <div class='bill_title_line'>".langu['date']." : ".$row['add_date']."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['payment_recipt_cash_total']." : ".$row['cash_value']." ".langu['shekel']."</div>
    <div class='bill_title_line'>".langu['discount']." : ".$row['discount']."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line'>".langu['payment_recipt_checks_total']." : ".$row['checks_value']." ".langu['shekel']."</div>
    <div class='bill_title_line'>".langu['check_count']." : ".$check_count."</div>
</div>
<div class='bill_title_wrap'>
    <div class='bill_title_line' style='width:90%;margin-top:20px;'>
    <fieldset style='padding:10px;border:1px solid black;'>
	<legend style='margin-right:15px;font-size:18px;'>".langu['notes']."</legend>".$row['notes']."
    </fieldset>
    </div>
</div>
";
if($row['is_check']==1){
$table1=$this->get_checks($mysqli,'SELECT checks.*,currency.name as cur_name,banks.name as bank_name FROM checks,banks,currency where checks.revenue_id='.$id.' and currency.id=checks.currency_id and banks.id=checks.bank_id');

echo "
<div class='bill_title'>".langu['checks']."</div>

<div class='bill_list_main'>
<table>
<tr>
<th></th>
<th>".langu['bank']."</th>
<th>".langu['check_num']."</th>
<th>".langu['check_date']."</th>
<th>".langu['check_value']."</th>
<th>".langu['currency']."</th>
<th>".langu['exchange_rate']."</th>
</tr>
".$table1."
</table></div>";
}
echo "</div>";

}

}

/*طباعة كشف حساب شهري*/
function print_monthly_statment($mysqli,$id,$monthfrom,$monthto){

$b=$mysqli->query('SELECT id FROM `customers` where main_id='.$id);
$custom_id="customer_id=".$id;
if($b->num_rows>0){
$custom_id="customer_id IN(".$id;
while($row=$b->fetch_assoc()){
$custom_id.=",".$row['id'];
}
$custom_id.=")";
}
$customer=$mysqli->query('select * from customers where id='.$id);
$customer=$customer->fetch_assoc();
if($customer['balance']>0){$balance=langu['balance_for_comapny']." : ".abs($customer['balance'])." ".langu['shekel'];}
elseif($customer['balance']<0){$balance=langu['balance_for_customer']." : ".abs($customer['balance'])." ".langu['shekel'];}
else{$balance=langu['balance_for_comapny']." : ".abs($customer['balance']);}
echo"
<div class='main_print_button'><div class='div_print_button'>
    <div class='print_button' onclick='window.print()'><span>|</span>".langu['print']."</div>

</div></div>

<div class='bill_main'>
<div class='bill_title'>".langu['statement']." ".langu['monthly']."</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$customer['name']."</div>
    <div class='bill_title_line'>".langu['date']." : ".date('d-m-Y')."</div>
</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$balance."</div>
    <div class='bill_title_line'></div>
</div>

<div class='bill_title'><span class='nume'>".langu['from']." : ".date('d-m-Y',strtotime($monthfrom))." - ".langu['to']." : ".date('d-m-Y',strtotime($monthto))."</span></div>

<div class='bill_list_main'>
<table>
<tbody>
<tr>
<th rowspan='2'>".langu['balance']."</th>
<th colspan='2'>".langu['amount']."</th>
<th rowspan='2'>".langu['movement2']."</th>
<th rowspan='2'>".langu['notes']."</th>
<th rowspan='2'>".langu['date']."</th>
</tr>
<tr>
<th>".langu['from_person']."</th>
<th>".langu['to_person']."</th>
</tr>
</tbody>";
$q="select * from customer_merchant_statment where ".$custom_id." and (date BETWEEN '".$monthfrom."' and '".$monthto."')";

$ma=$this->customer_statment($mysqli,$q);

echo $ma."</table></div>
</div>";
}

/*طباعة كشف حساب سنوي*/
function print_yearly_statment($mysqli,$id,$year){
$b=$mysqli->query('SELECT id FROM `customers` where main_id='.$id);
$custom_id="customer_id=".$id;
if($b->num_rows>0){
$custom_id="customer_id IN(".$id;
while($row=$b->fetch_assoc()){
$custom_id.=",".$row['id'];
}
$custom_id.=")";
}
$customer=$mysqli->query('select * from customers where id='.$id);
$customer=$customer->fetch_assoc();
if($customer['balance']>0){$balance=langu['balance_for_comapny']." : ".abs($customer['balance'])." ".langu['shekel'];}
elseif($customer['balance']<0){$balance=langu['balance_for_customer']." : ".abs($customer['balance'])." ".langu['shekel'];}
else{$balance=langu['balance_for_comapny']." : ".abs($customer['balance']);}
echo"
<div class='main_print_button'><div class='div_print_button'>
    <div class='print_button' onclick='window.print()'><span>|</span>".langu['print']."</div>

</div></div>

<div class='bill_main'>
<div class='bill_title'>".langu['statement']." ".langu['yearly']."</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$customer['name']."</div>
    <div class='bill_title_line'>".langu['date']." : ".date('d-m-Y')."</div>
</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$balance."</div>
    <div class='bill_title_line'></div>
</div>

<div class='bill_title'>".langu['year']." <span class='nume'>".$year."</span></div>

<div class='bill_list_main'>
<table>
<tbody>
<tr>
<th rowspan='2'>".langu['balance']."</th>
<th colspan='2'>".langu['amount']."</th>
<th rowspan='2'>".langu['movement2']."</th>
<th rowspan='2'>".langu['notes']."</th>
<th rowspan='2'>".langu['date']."</th>
</tr>
<tr>
<th>".langu['from_person']."</th>
<th>".langu['to_person']."</th>
</tr>
</tbody>";

$q="select * from customer_merchant_statment where ".$custom_id.' and year(date)='.$year;

$ma=$this->customer_statment($mysqli,$q);

echo $ma."</table></div>
</div>";
}
/*طباعة كشف حساب شهري*/
function print_monthly_statment_merchant($mysqli,$id,$monthfrom,$monthto){
$merchant=$mysqli->query('select * from merchants where id='.$id);
$merchant=$merchant->fetch_assoc();
if($merchant['balance']<0){$balance=langu['balance_for_comapny']." : ".abs($merchant['balance'])." ".langu['shekel'];}
elseif($merchant['balance']>0){$balance=langu['balance_for_merchant']." : ".abs($merchant['balance'])." ".langu['shekel'];}
else{$balance=langu['balance_for_comapny']." : ".abs($merchant['balance']);}
echo"
<div class='main_print_button'><div class='div_print_button'>
    <div class='print_button' onclick='window.print()'><span>|</span>".langu['print']."</div>

</div></div>

<div class='bill_main'>
<div class='bill_title'>".langu['statement']." ".langu['monthly']."</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$merchant['name']."</div>
    <div class='bill_title_line'>".langu['date']." : ".date('d-m-Y')."</div>
</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$balance."</div>
    <div class='bill_title_line'></div>
</div>

<div class='bill_title'><span class='nume'>".langu['from']." : ".date('d-m-Y',strtotime($monthfrom))." - ".langu['to']." : ".date('d-m-Y',strtotime($monthto))."</span></div>

<div class='bill_list_main'>
<table>
<tbody>
<tr>
<th rowspan='2'>".langu['balance']."</th>
<th colspan='2'>".langu['amount']."</th>
<th rowspan='2'>".langu['movement2']."</th>
<th rowspan='2'>".langu['notes']."</th>
<th rowspan='2'>".langu['date']."</th>
</tr>
<tr>
<th>".langu['from_person']."</th>
<th>".langu['to_person']."</th>
</tr>
</tbody>";

$q="select * from customer_merchant_statment where merchant_id=".$id." and (date BETWEEN '".$monthfrom."' and '".$monthto."')";

$ma=$this->merchant_statment($mysqli,$q);

echo $ma."</table></div>
</div>";
}

/*طباعة كشف حساب سنوي*/
function print_yearly_statment_merchant($mysqli,$id,$year){
$merchant=$mysqli->query('select * from merchants where id='.$id);
$merchant=$merchant->fetch_assoc();
if($merchant['balance']<0){$balance=langu['balance_for_comapny']." : ".abs($merchant['balance'])." ".langu['shekel'];}
elseif($merchant['balance']>0){$balance=langu['balance_for_merchant']." : ".abs($merchant['balance'])." ".langu['shekel'];}
else{$balance=langu['balance_for_comapny']." : ".abs($merchant['balance']);}
echo"
<div class='main_print_button'><div class='div_print_button'>
    <div class='print_button' onclick='window.print()'><span>|</span>".langu['print']."</div>

</div></div>

<div class='bill_main'>
<div class='bill_title'>".langu['statement']." ".langu['yearly']."</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$merchant['name']."</div>
    <div class='bill_title_line'>".langu['date']." : ".date('d-m-Y')."</div>
</div>

<div class='bill_title_wrap'>
    <div class='bill_title_line'>".$balance."</div>
    <div class='bill_title_line'></div>
</div>

<div class='bill_title'>".langu['year']." <span class='nume'>".$year."</span></div>

<div class='bill_list_main'>
<table>
<tbody>
<tr>
<th rowspan='2'>".langu['balance']."</th>
<th colspan='2'>".langu['amount']."</th>
<th rowspan='2'>".langu['movement2']."</th>
<th rowspan='2'>".langu['notes']."</th>
<th rowspan='2'>".langu['date']."</th>
</tr>
<tr>
<th>".langu['from_person']."</th>
<th>".langu['to_person']."</th>
</tr>
</tbody>";

$q="select * from customer_merchant_statment where merchant_id=".$id.' and year(date)='.$year;
$ma=$this->merchant_statment($mysqli,$q);

echo $ma."</table></div>
</div>";
}
/*جلب الشيكات للجدول*/
function get_checks($mysqli,$sql,$nam=null){
$q=$mysqli->query($sql);
$m='';

while($row=$q->fetch_assoc()){
$name='';
if($nam==1){
$name='<td></td>';
if($row['customer_id']!=0){$row2=$mysqli->query("select name from customers where id=".$row['customer_id']);$row2=$row2->fetch_assoc();$name="<td>".$row2['name']."</td>";}
elseif($row['merchant_id']!=0){$row2=$mysqli->query("select name from merchants where id=".$row['merchant_id']);$row2=$row2->fetch_assoc();$name="<td>".$row2['name']."</td>";}
elseif($row['normal_customer']!=0){if($row['normal_customer_name']!=''){$name="<td>".$row['normal_customer_name']."</td>";} else{$name="<td>".langu['normal_customer']."</td>";}}
}
if($nam==2){$name='<td>'.langu['our_check'].'</td>';}
$r='<td></td>';
if($row['is_returned']==1){$r="<td style='color:red;'>".langu['returned']."</td>";}
$m.="<tr>
".$r.$name."
<td>".$row['bank_name']."</td>
<td class='nume'>".$row['check_num']."</td>
<td class='nume'>".$row['check_date']."</td>
<td class='nume'>".$row['check_value']."</td>
<td class='nume'>".$row['cur_name']."</td>
<td class='nume'>".$row['exchange_rate']."</td>
</tr>";
}
return $m;
}

/*---- طباعة جدول كشف الحساب -----*/
function customer_statment($mysqli,$query){
$ma='';
$q=$mysqli->query($query);
while($row=$q->fetch_assoc()){
if($row['statment_type']==1){
$ma.="<tr>
        <td>".$row['all_balance']."</td>
        <td>".$row['balance']."</td>
        <td></td>
        <td>".langu['order']." ".langu['num']." : ".$row['id_for_type']."</td>
        <td></td>
        <td>".$row['date']."</td>
    </tr>";
}

elseif($row['statment_type']==2){
        $ma.="<tr>
                <td>".$row['all_balance']."</td>
                <td></td>
                <td>".$row['balance']."</td>
                <td>".langu['returned_product']." ".langu['num']." : ".$row['id_for_type']."</td>
                <td></td>
                <td>".$row['date']."</td>
              </tr>";
}

elseif($row['statment_type']==6){
$q2=$mysqli->query('SELECT * FROM revenue where id='.$row['id_for_type']);
$q2=$q2->fetch_assoc();
$ma.="<tr>
	<td>".$row['all_balance']."</td>
	<td>".$row['balance']."</td>
	<td></td>
	<td>".langu['payment_receipt']." ".langu['num']." : ".$q2['receipt_num']."</td>
	<td>".langu['discount']." : ".$q2['discount']." - ".langu['payment_recipt_cash_total']." : ".$q2['cash_value']." - ".langu['payment_recipt_checks_total']." : ".$q2['checks_value']."</td>
	<td>".$row['date']."</td>
      </tr>";
}

elseif($row['statment_type']==7){
$q2=$mysqli->query('SELECT * FROM expense where id='.$row['id_for_type']);
$q2=$q2->fetch_assoc();
$ma.="<tr>
        <td>".$row['all_balance']."</td>
        <td></td>
        <td>".$row['balance']."</td>
        <td>".langu['expenses_payment']." ".langu['num']." : ".$row['id_for_type']."</td>
        <td>".langu['discount']." : ".$q2['discount']."</td>
        <td>".$row['date']."</td>
      </tr>";
}

elseif($row['statment_type']==8){
$q2=$mysqli->query('SELECT checks.*,currency.name as cname FROM checks,currency where checks.id='.$row['id_for_type'].' and currency.id=checks.currency_id');
$q2=$q2->fetch_assoc();
$ma.="<tr>
        <td>".$row['all_balance']."</td>
        <td>".$q2['check_value']." ".$q2['cname']."</td>
        <td></td>
        <td>".langu['check_returned_to_him']." ".langu['num']." : ".$q2['check_num']."</td>
        <td>".langu['check_returned_increase']." : ".$q2['returned_value']." ".langu['shekel']."</td>
        <td>".$row['date']."</td>
      </tr>";
}
elseif($row['statment_type']==9){
$q2=$mysqli->query("SELECT our_checks.*,currency.name as cname FROM our_checks,currency where our_checks.id=".$row['id_for_type']." and currency.id=our_checks.currency_id");
$q2=$q2->fetch_assoc();
$ma.="<tr>
	<td>".$row['all_balance']."</td>
	<td></td>
	<td>".$q2['check_value']." ".$q2['cname']."</td>
	<td>".langu['check_returned_to_us']." ".langu['num']." : ".$q2['check_num']."</td>
	<td></td>
	<td>".$row['date']."</td>
      </tr>";
}

elseif($row['statment_type']==10){
$q2=$mysqli->query("SELECT checks.*,currency.name as cname FROM checks,currency where checks.id=".$row['id_for_type']." and currency.id=checks.currency_id");
$q2=$q2->fetch_assoc();
$ma.="<tr>
	<td>".$row['all_balance']."</td>
	<td></td>
	<td>".$q2['check_value']." ".$q2['cname']."</td>
	<td>".langu['check_returned_to_us']." ".langu['num']." : ".$q2['check_num']."</td>
	<td>".langu['check_returned_increase']." : ".$q2['returned_value']." ".langu['shekel']."</td>
	<td>".$row['date']."</td>
      </tr>";
}

}
return $ma;
}

function merchant_statment($mysqli,$query){
$ma='';
$q=$mysqli->query($query);
while($row=$q->fetch_assoc()){
if($row['statment_type']==6){
$q2=$mysqli->query('SELECT * FROM revenue where id='.$row['id_for_type']);
$q2=$q2->fetch_assoc();
$ma.="<tr>
	<td>".$row['all_balance']."</td>
	<td>".$row['balance']."</td>
	<td></td>
	<td>".langu['payment_receipt']." ".langu['num']." : ".$q2['receipt_num']."</td>
	<td>".langu['discount']." : ".$q2['discount']." - ".langu['payment_recipt_cash_total']." : ".$q2['cash_value']." - ".langu['payment_recipt_checks_total']." : ".$q2['checks_value']."</td>
	<td>".$row['date']."</td>
      </tr>";
}

elseif($row['statment_type']==7){
$q2=$mysqli->query('SELECT * FROM expense where id='.$row['id_for_type']);
$q2=$q2->fetch_assoc();
$ma.="<tr>
        <td>".$row['all_balance']."</td>
        <td></td>
        <td>".$row['balance']."</td>
        <td>".langu['expenses_payment']." ".langu['num']." : ".$row['id_for_type']."</td>
        <td>".langu['discount']." : ".$q2['discount']."</td>
        <td>".$row['date']."</td>
      </tr>";
}
elseif($row['statment_type']==8){
$q2=$mysqli->query('SELECT checks.*,currency.name as cname FROM checks,currency where checks.id='.$row['id_for_type'].' and currency.id=checks.currency_id');
$q2=$q2->fetch_assoc();
$ma.="<tr>
        <td>".$row['all_balance']."</td>
        <td>".$q2['check_value']." ".$q2['cname']."</td>
        <td></td>
        <td>".langu['check_returned_to_him']." ".langu['num']." : ".$q2['check_num']."</td>
        <td>".langu['check_returned_increase']." : ".$q2['returned_value']." ".langu['shekel']."</td>
        <td>".$row['date']."</td>
      </tr>";
}
elseif($row['statment_type']==9){
$q2=$mysqli->query("SELECT our_checks.*,currency.name as cname FROM our_checks,currency where our_checks.id=".$row['id_for_type']." and currency.id=our_checks.currency_id");
$q2=$q2->fetch_assoc();
$ma.="<tr>
	<td>".$row['all_balance']."</td>
	<td></td>
	<td>".$q2['check_value']." ".$q2['cname']."</td>
	<td>".langu['check_returned_to_us']." ".langu['num']." : ".$q2['check_num']."</td>
	<td></td>
	<td>".$row['date']."</td>
      </tr>";
}

elseif($row['statment_type']==10){
$q2=$mysqli->query("SELECT checks.*,currency.name as cname FROM checks,currency where checks.id=".$row['id_for_type']." and currency.id=checks.currency_id");
$q2=$q2->fetch_assoc();
$ma.="<tr>
	<td>".$row['all_balance']."</td>
	<td></td>
	<td>".$q2['check_value']." ".$q2['cname']."</td>
	<td>".langu['check_returned_to_us']." ".langu['num']." : ".$q2['check_num']."</td>
	<td>".langu['check_returned_increase']." : ".$q2['returned_value']." ".langu['shekel']."</td>
	<td>".$row['date']."</td>
      </tr>";
}

elseif($row['statment_type']==3){
$q2=$mysqli->query('SELECT * FROM merchant_invoice where id='.$row['id_for_type']);
$q2=$q2->fetch_assoc();
$ma.="<tr>
        <td>".$row['all_balance']."</td>
        <td></td>
        <td>".$row['balance']."</td>
        <td>".langu['order']." ".langu['from']." ".langu['merchant']." ".langu['num']." : ".$q2['bill_num']."</td>
        <td></td>
        <td>".$row['date']."</td>
</tr>";
}

elseif($row['statment_type']==4){
$ma.="<tr>
        <td>".$row['all_balance']."</td>
        <td></td>
        <td>".$row['balance']."</td>
        <td>".langu['returned_to_merchant']." ".langu['num']." : ".$row['id_for_type']."</td>
        <td></td>
        <td>".$row['date']."</td>
</tr>";
}

elseif($row['statment_type']==5){
$ma.="<tr>
        <td>".$row['all_balance']."</td>
        <td>".$row['balance']."</td>
        <td></td>
        <td>".langu['order_num']." : ".$row['id_for_type']."</td>
        <td></td>
        <td>".$row['date']."</td>
</tr>";
}

elseif($row['statment_type']==11){
$ma.="<tr>
        <td>".$row['all_balance']."</td>
        <td></td>
        <td>".$row['balance']."</td>
        <td>".langu['returned_product']." : ".$row['id_for_type']."</td>
        <td></td>
        <td>".$row['date']."</td>
</tr>";
}

}
return $ma;
}

}