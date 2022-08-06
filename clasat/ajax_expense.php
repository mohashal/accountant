<?php

class ajax_expense {
/**
 *get salary form
 */
function get_salary_form($mysqli,$emp_id=null,$type=null){
$q2="select id,name,salary from employees where is_delete=0";
if($type==1){$q2="select id,name,salary from employees where employee_type=1 and is_delete=0";}
$q=$mysqli->query($q2);

$e="<select id='employee_id' name='employee_id' required>";

if($emp_id==null){
$e.="<option value='' disabled selected>".langu['select_employee']."</option>";
while ($row=$q->fetch_assoc()){
$e.="<option value='".$row['id']."' data-name='".$row['name']."' data-salary='".$row['salary']."'>".$row['name']."</option>";
}}

else{
$e.="<option value='' disabled>".langu['select_employee']."</option>";
while ($row=$q->fetch_assoc()){
if($emp_id==$row['id']){$e.="<option value='".$row['id']."' data-name='".$row['name']."' data-salary='".$row['salary']."' selected>".$row['name']."</option>";}
else{$e.="<option value='".$row['id']."' data-name='".$row['name']."' data-salary='".$row['salary']."'>".$row['name']."</option>";}
}}

$e.="</select>";

$m="
<div class='form_input_line'><div class='form_input_name'>".langu['employee_name']."</div>".$e."</div>
";
return $m;
}
/**
 *get salary form
 */
function get_car_form($mysqli,$car_id=null){
$q=$mysqli->query("select id,name from cars where is_delete=0");
$ss=' selected';
if($car_id==null){$ss='';}
$e="<select id='car_id' name='car_id' required>
<option value='' disabled".$ss.">".langu['select_car']."</option>";
while ($row=$q->fetch_assoc()){
if($car_id==$row['id']){$e.="<option value='".$row['id']."' data-name='".$row['name']."' selected>".$row['name']."</option>";}
else{$e.="<option value='".$row['id']."' data-name='".$row['name']."'>".$row['name']."</option>";}
}
$e.="</select>";

$m="<div class='form_input_line'><div class='form_input_name'>".langu['car_name']."</div>".$e."</div>";
return $m;
}
/**
 * جلب فورم الشركاء
 * @param type $mysqli
 * @param type $partner_id
 * @return string
 */
function get_partner_form($mysqli,$partner_id=null){
$q=$mysqli->query("select id,name from partners where is_delete=0");
$ss=' selected';
if($partner_id!=null){$ss='';}
$e="<select id='partner_id' name='partner_id' required>
<option value='' disabled".$ss.">".langu['select_partner']."</option>";
while ($row=$q->fetch_assoc()){
if($partner_id==$row['id']){$e.="<option value='".$row['id']."' data-name='".$row['name']."' selected>".$row['name']."</option>";}
else{$e.="<option value='".$row['id']."' data-name='".$row['name']."'>".$row['name']."</option>";}
}
$e.="</select>";

$m="<div class='form_input_line'><div class='form_input_name'>".langu['partner_name']."</div>".$e."</div>";
return $m;
}
/**
 *get merchant form
 */
function get_merchant_form($mysqli=null,$id=null){
$name='';
if($id!=null){
$row=$mysqli->query('select name from merchants where id='.$id);
$row=$row->fetch_assoc();
$name=$row['name'];}
$m="
<div class='form_input_line'>
    <div class='form_input_name'>".langu['merchant']."</div>
    <div class='form_input_input' id='search_merchant'>
        <input type='text' autocomplete='off' id='check_merchant_name' name='check_merchant_name' oninput='merchant_search()' placeholder='".langu['merchant_name']."' value='".$name."' required />
        <input type='hidden' id='merchant_id' name='merchant_id' value='".$id."' required />
    </div>
</div>
<div class='form_input_line'>
    <div class='form_input_name'>".langu['balance']."</div>
    <div class='form_input_input nume' id='merchant_balance'></div>
</div>";
return $m;
}
/**
 *get customer form
 */
function get_customer_form($mysqli=null,$id=null){
$name='';
if($id!=null){
$row=$mysqli->query('select name from customers where id='.$id);
$row=$row->fetch_assoc();
$name=$row['name'];}
$m="
<div class='form_input_line'>
    <div class='form_input_name'>".langu['customer']."</div>
    <div class='form_input_input' id='search_customer'>
        <input type='text' autocomplete='off' id='check_customer_name' name='check_customer_name' oninput='customer_search()' placeholder='".langu['customer_name']."' value='".$name."' required />
        <input type='hidden' id='merchant_id' name='customer_id' value='".$id."' required />
    </div>
</div>";
return $m;
}
/**
 *جلب معلومات الشيك لاضفاتها لجدول القبض
 */
function table_checks_details($mysqli){
$i=intval($_GET['i']);
$row=$mysqli->query('SELECT checks.*,currency.name as cur_name,banks.name as bank_name FROM checks,banks,currency where checks.id='.intval($_GET['id']).' and currency.id=checks.currency_id and banks.id=checks.bank_id');
$row=$row->fetch_assoc();

if($row['customer_id']!=0){$row2=$mysqli->query('select name from customers where id='.$row['customer_id']);$row2=$row2->fetch_assoc();$name=$row2['name'];}
elseif($row['merchant_id']!=0){$row2=$mysqli->query('select name from merchants where id='.$row['merchant_id']);$row2=$row2->fetch_assoc();$name=$row2['name'];}
else {$name=$row['normal_customer_name'];}

echo "<tr id='check".$i."'>
<td class='nume'><span class='delete_check' id='delete_el".$i."' onclick='delete_check(".$i.")'></span><p id='nu".$i."'>".$i."<p></td>
<td>".$name."</td>
<td>".$row['bank_name']."</td>
<td class='nume'>".$row['check_num']."</td>
<td class='nume'>".$row['check_date']."</td>
<td class='nume'>".$row['check_value']."</td>
<td class='nume'>".$row['cur_name']."</td>
<td class='nume'>".$row['exchange_rate']."</td>
<td></td>
<input type='hidden' name='check_id".$i."' id='check_id".$i."' value='".$row['id']."'>
<input type='hidden' name='check_value".$i."' id='check_value".$i."' value='".$row['check_value']."'>
<input type='hidden' name='check_exr".$i."' id='check_exr".$i."' value='".$row['exchange_rate']."'>
</tr>";
}

/*جلب النتائج حسب التاريخ والسنة*/
function get_by_monthyear($mysqli,$type=null){
$cash=0;
$check=0;
$our_check=0;
if($type==2){
$q=$mysqli->query("select expense.*,expense_types.name as ename from expense,expense_types where expense.expense_type in(3,5) and MONTH(expense.date)=".$_GET['month']." AND YEAR(expense.date)=".$_GET['year']." and expense_types.id=expense.expense_type");
}
else {$q=$mysqli->query("select expense.*,expense_types.name as ename from expense,expense_types where expense.expense_type not in(3,5) and MONTH(expense.date)=".$_GET['month']." AND YEAR(expense.date)=".$_GET['year']." and expense_types.id=expense.expense_type");}
if($q->num_rows>0){
echo "
<table class='check_list'>
    <tr>
        <th>".langu['date']."</th>
        <th>".langu['payment_recipt_from']."</th>
        <th>".langu['payment_recipt_type']."</th>
        <th>".langu['payment_recipt_cash_total']."</th>
        <th>".langu['notes']."</th>
        <th>".langu['payment_recipt_checks_total']."</th>
        <th>".langu['our_checks_total']."</th>
        <th class='edit_symbol'></th>
    </tr>
";
while ($row=$q->fetch_assoc()){
$pa='';
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
if($row['partner_id']!=0){$pa='pa'.$row['partner_id'];}
elseif($row['employee_id']!=0){$pa='em'.$row['employee_id'];}

echo "  <tr class='show_hide_tr ".$row['expense_type']." ".$pa."' data-cash='".$row['cash_value']."' data-check='".$row['check_value']."' data-ourcheck='".$row['our_check_value']."'>
            <td class='nume'>".$row['date']."</td>
            <td class='nume'>".$name."</td>
            <td class='nume'>".$row['ename']."</td>
            <td class='nume'>".$row['cash_value']."</td>
            <td class='nume'>".$row['notes']."</td>
            <td class='nume'>".$row['check_value']."</td>
            <td class='nume'>".$row['our_check_value']."</td>
            <td class='edit_symbol'><a href='printbills.php?print_payment=expense&id=".$row['id']."&type=".$row['expense_type']."' target='_blank'>|</a></td>
        </tr>";
$cash+=$row['cash_value'];
$check+=$row['check_value'];
$our_check+=$row['our_check_value'];
}
/*$final=$cash+$check+$our_check;*/
echo "  <tr>
            <td class='nume'>".langu['final_total']."</td>
            <td  class='nume'></td>
            <td></td>
            <td class='nume' id='total_cash'>".$cash."</td>
            <td></td>
            <td class='nume' id='total_check'>".$check."</td>
            <td class='nume' id='total_our_check'>".$our_check."</td>
            <td></td>
   </tr>

</table>";
}
else{echo "<div class='no_resault'>".langu['no_receipt_month']."</div>";}

}

/**
*جلب نتائج القبض حسب التاريخ والسنة
*/
function get_by_monthyear_rev($mysqli){

$q=$mysqli->query("select revenue.*,merchants.name as mname,customers.name as cname from revenue,merchants,customers where MONTH(revenue.add_date)=".$_GET['month']." AND YEAR(revenue.add_date)=".$_GET['year']." and customers.id=revenue.customer_id and merchants.id=revenue.merchant_id");
if($q->num_rows>0){
echo "
<table class='check_list'>
    <tr>
        <th>".langu['date']."</th>
        <th>".langu['payment_recipt_from']."</th>
        <th>".langu['payment_recipt_type']."</th>
        <th>".langu['payment_recipt_cash_total']."</th>
        <th>".langu['discount']."</th>
        <th>".langu['check_count']."</th>
        <th>".langu['payment_recipt_checks_total']."</th>
        <th class='edit_symbol'></th>
    </tr>
";
$cash_total=0;
$check_total=0;
$discount_total=0;
$check_count_all=0;

while ($row=$q->fetch_assoc()){
$cash_check='';
$check_count=0;
$name='';$class=0;

/*if($row['merchant_id']=!0){$name=$row['mname'];}
elseif($row['customer_id']!=0){$name=$row['cname'];}*/
if($row['customer_id']!=0){$q2=$mysqli->query("select name from customers where id=".$row['customer_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];$class=$row['saleman_id'];}
elseif($row['merchant_id']!=0){$q2=$mysqli->query("select name from merchants where id=".$row['merchant_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];$class='m';}
elseif($row['employee_id']!=0){$q2=$mysqli->query("select name from employees where id=".$row['employee_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
elseif($row['partner_id']!=0){$q2=$mysqli->query("select name from partners where id=".$row['partner_id']);$q2=$q2->fetch_assoc();$name=$q2['name'];}
elseif($row['normal_customer']!=0){if($row['normal_customer_name']!=''){$name=$row['normal_customer_name'];}else{$name=langu['normal_customer'];}}

if($row['is_cash']==1){$cash_check.=langu['cash'];}
if($row['is_check']==1){$cash_check.=" ".langu['check'];$check_count=count(unserialize($row['checks_ids']));}

echo "  <tr class='show_hide ".$class."' data-cash='".$row['cash_value']."' data-check='".$row['checks_value']."' data-chcount='".$check_count."' data-discount='".$row['discount']."'>
            <td class='nume'>".$row['add_date']."</td>
            <td>".$name."</td>
            <td>".$cash_check."</td>
            <td class='nume'>".$row['cash_value']."</td>
            <td class='nume'>".$row['discount']."</td> 
            <td class='nume'>".$check_count."</td>
            <td class='nume'>".$row['checks_value']."</td>
            <td class='edit_symbol'><a href='printbills.php?print_payment=revenue&id=".$row['id']."' target='_blank'>|</a></td>
        </tr>";

$cash_total+=$row['cash_value'];
$check_total+=$row['checks_value'];
$discount_total+=$row['discount'];
$check_count_all+=$check_count;
}
echo "
<tr>
            <td class='nume'></td>
            <td>".langu['final_total']."</td>
            <td></td>
            <td class='nume' id='temp_total_cash'>".$cash_total."</td>
            <td class='nume' id='temp_total_discount'>".$discount_total."</td> 
            <td class='nume' id='check_count_all'>".$check_count_all."</td>
            <td class='nume' id='temp_total_check'>".$check_total."</td>
            <td></td>
        </tr>
</table>";
}
else{echo "<div class='no_resault'>".langu['no_receipt_month']."</div>";}

}

function get_by_customer_rev($mysqli){
$c_id=intval($_GET['id']);
$q=$mysqli->query("select revenue.*,customers.name as cname from revenue,customers where (customer_id=".$c_id." or main_customer_id=".$c_id.") and customers.id=revenue.customer_id");
if($q->num_rows>0){
echo "
<table class='check_list'>
    <tr>
        <th>".langu['date']."</th>
        <th>".langu['payment_recipt_from']."</th>
        <th>".langu['payment_recipt_type']."</th>
        <th>".langu['payment_recipt_cash_total']."</th>
        <th>".langu['discount']."</th>
        <th>".langu['check_count']."</th>
        <th>".langu['payment_recipt_checks_total']."</th>
        <th class='edit_symbol'></th>
    </tr>
";
$cash_total=0;
$check_total=0;
$discount_total=0;
$check_count_all=0;

while ($row=$q->fetch_assoc()){
$cash_check='';
$check_count=0;
$name='';$class=0;

if($row['is_cash']==1){$cash_check.=langu['cash'];}
if($row['is_check']==1){$cash_check.=" ".langu['check'];$check_count=count(unserialize($row['checks_ids']));}

echo "  <tr class='show_hide ".$class."' data-cash='".$row['cash_value']."' data-check='".$row['checks_value']."' data-chcount='".$check_count."' data-discount='".$row['discount']."'>
            <td class='nume'>".$row['add_date']."</td>
            <td>".$row['cname']."</td>
            <td>".$cash_check."</td>
            <td class='nume'>".$row['cash_value']."</td>
            <td class='nume'>".$row['discount']."</td> 
            <td class='nume'>".$check_count."</td>
            <td class='nume'>".$row['checks_value']."</td>
            <td class='edit_symbol'><a href='printbills.php?print_payment=revenue&id=".$row['id']."' target='_blank'>|</a></td>
        </tr>";

$cash_total+=$row['cash_value'];
$check_total+=$row['checks_value'];
$discount_total+=$row['discount'];
$check_count_all+=$check_count;
}
echo "
<tr>
            <td class='nume'></td>
            <td>".langu['final_total']."</td>
            <td></td>
            <td class='nume' id='temp_total_cash'>".$cash_total."</td>
            <td class='nume' id='temp_total_discount'>".$discount_total."</td> 
            <td class='nume' id='check_count_all'>".$check_count_all."</td>
            <td class='nume' id='temp_total_check'>".$check_total."</td>
            <td></td>
        </tr>
</table>";
}
else{echo "<div class='no_resault'>".langu['no_receipt_customer']."</div>";}
}

function debt_customer_note($mysqli){
$id=intval($_GET['id']);
$row=$mysqli->query('select balance from customers where id='.$id);
$row=$row->fetch_assoc();

if($row['balance']>0){
$row=$mysqli->query('select max(date) as ma FROM expense where customer_id='.$id);
if($row->num_rows>0){
$row=$row->fetch_assoc();
$date1=date_create($row['ma']);
$date2=date_create(date('Y-m-d'));
$diff=date_diff($date1,$date2);

if($diff->format("%R%a")>15){
echo "<div class='msg fail nume'><div class='text_msg'>".langu['debt_customer_no_bill']."</div></div>";
}
}
}

}

}