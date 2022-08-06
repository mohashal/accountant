<?php

class checks {
/**
*فنكشن الشيكات غير المصروفة
*/
function not_spend_check($mysqli){
$i=1;
$total=0;
$d=array();
$q=$mysqli->query("SELECT checks.*,banks.name as bank_name,currency.name as cur_name FROM checks,banks,currency where checks.is_returned=0 and banks.id=checks.bank_id and currency.id=checks.currency_id");
$q2=$mysqli->query("SELECT check_date FROM checks where is_returned=0 group by check_date");
$year="<select id='select_date' onchange='select_check_date()' style='margin:0 25%;'>
<option value='0' disabled selected>".langu['date']."</option>";
while($row3=$q2->fetch_assoc()){
$newdate = date("Y-n",strtotime($row3['check_date']));
$d[$newdate]=$newdate;
}
foreach ($d as $v) {
$year.="<option value='".$v."'>".$v."</option>";
}

$year.="</select>";
echo "
<style>.customer_auto_search_name{width: 46%;margin:0;}</style>
<div class='form_main'>

    <div class='form_main_name'>".langu['not_spend_checks']."</div>
    <div class='form_main_inputs' style='width:90%;'>".$year."</div>
    <table class='main_table' id='check_list'>
        <tr>
            <th></th>
            <th>".langu['check_from']."</th>
            <th>".langu['bank']."</th>
            <th>".langu['check_num']."</th>
            <th>".langu['check_date']."</th>
            <th>".langu['check_value']."</th>
            <th>".langu['currency']."</th>
            <th>".langu['exchange_rate']."</th>
            <th>".langu['spend']."</th>
            <th>".langu['returned']."</th>
        </tr>";
while($row=$q->fetch_assoc()){
$newdate = date("Y-n",strtotime($row['check_date']));
$name='';
if($row['customer_id']!=0){$row2=$mysqli->query("select name from customers where id=".$row['customer_id']);$row2=$row2->fetch_assoc();$name=$row2['name'];}
elseif($row['merchant_id']!=0){$row2=$mysqli->query("select name from merchants where id=".$row['merchant_id']);$row2=$row2->fetch_assoc();$name=$row2['name'];}
elseif($row['normal_customer']!=0){if($row['normal_customer_name']!=''){$name=$row['normal_customer_name'];} else{$name=langu['normal_customer'];}}
echo "
<tr class='show_hide ".$newdate."'>
    <td class='nume nu".$newdate."' style='padding: 5px;font-weight:bold;'>".$i."</td>
    <td>".$name."</td>
    <td>".$row['bank_name']."</td>
    <td class='nume'>".$row['check_num']."</td>
    <td class='nume'>".$row['check_date']."</td>
    <td class='nume va".$row['check_date']."'>".$row['check_value']."</td>
    <td class='nume'>".$row['cur_name']."</td>
    <td class='nume ex".$row['check_date']."'>".$row['exchange_rate']."</td>
    <td class='returned_symbol' onclick='login_modal(\"".langu['checks']."\",\"ajaxbills.php?find_check=spend&id=".$row['id']."\")'><span></span></td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajax_settings.php?find_check=form_returned&id=".$row['id']."\")'><span></span></td>
</tr>";
$i++;
$m=$row['check_value']*$row['exchange_rate'];
$total+=$m;
}

echo "
<tr>
    <td></td>
    <td>".langu['final_total']."</td>
    <td></td>
    <td></td>
    <td></td>
    <td class='nume' id='final_total'>".$total." ".langu['shekel']."</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
</table>
</div>
";
}
/**
*فنكشن البحث عن شيك
*/
function search_check($mysqli){
$my=$this->get_select_month_year('find_check_by_date','find_check_by_date');
echo "
<style>.customer_auto_search_name{width: 46%;margin:0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['search_check']."</div>

    <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name'>".langu['check_num']."</div><div class='form_input_input' id='search_check_num'><input type='text' autocomplete='off' id='check_num_search' name='check_num' placeholder='".langu['check_num']."' value='' oninput='find_check_by_num()' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' id='check_customer_name' name='check_cus' placeholder='".langu['customer_name']."' value='' oninput='search_customer_name()' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='search_merchant'><input type='text' autocomplete='off' id='check_merchant_name' name='check_mer' placeholder='".langu['merchant_name']."' value='' oninput='search_merchant_name()' required></div></div>
                        <div class='form_input_line' id='monthly'><div class='form_input_name'>".langu['check_date']."</div><div class='form_input_input' style='display:flex;'>".$my['month']." ".$my['year']."</div></div>
    </div>
    <div id='if_check'>
        <div class='form_main_name' style='border-top:1px #c8cfd8 solid;'>".langu['checks']."</div>
        <table class='main_table' id='check_list'>
            <tr>
                <th>".langu['check_from']."</th>
                <th>".langu['bank']."</th>
                <th>".langu['check_num']."</th>
                <th>".langu['check_date']."</th>
                <th>".langu['check_value']."</th>
                <th>".langu['currency']."</th>
                <th>".langu['exchange_rate']."</th>
                <th>".langu['spend']."</th>
                <th>".langu['returned']."</th>
            </tr>
        </table>
    </div>  
    <div class='form_input_line' style='margin:15px auto;'></div>

</div>
";
}

/**
 * شيكاتنا
 * @param type $mysqli
 */
function not_spend_our_check($mysqli){

$q=$mysqli->query("SELECT our_checks.*,banks.name as bank_name,currency.name as cur_name FROM our_checks,banks,currency where our_checks.is_returned=0 and banks.id=our_checks.bank_id and currency.id=our_checks.currency_id");
$q2=$mysqli->query("SELECT check_date FROM our_checks where is_returned=0 group by check_date");
$year="<select id='select_date' onchange='select_check_date()' style='margin:0 25%;'>
<option value='0' disabled selected>".langu['date']."</option>";
while($row3=$q2->fetch_assoc()){
$year.="<option value='".$row3['check_date']."'>".$row3['check_date']."</option>";
}
$year.="</select>";
echo "
<style>.customer_auto_search_name{width: 46%;margin:0;}</style>
<div class='form_main'>

    <div class='form_main_name'>".langu['not_spend_our_checks']."</div>
    <div class='form_main_inputs' style='width:90%;'>".$year."</div>
    <table class='main_table' id='check_list'>
        <tr>
            <th></th>
            <th>".langu['check_to']."</th>
            <th>".langu['bank']."</th>
            <th>".langu['check_num']."</th>
            <th>".langu['check_date']."</th>
            <th>".langu['check_value']."</th>
            <th>".langu['currency']."</th>
            <th>".langu['exchange_rate']."</th>
            <th>".langu['spend']."</th>
            <th>".langu['returned']."</th>
        </tr>";
$i=1;
$total=0;
while($row=$q->fetch_assoc()){
if($row['customer_id']!=0){$que="select name from customers where id=".$row['customer_id'];}
elseif($row['merchant_id']!=0){$que="select name from merchants where id=".$row['merchant_id'];}
elseif($row['employee_id']!=0){$que="select name from employees where id=".$row['employee_id'];}
elseif($row['partner_id']!=0){$que="select name from partners where id=".$row['partner_id'];}
else{$que="SELECT expense_types.name from expense_types,expense where expense.id=".$row['expense_id']." and expense.expense_type=expense_types.id";}
$row2=$mysqli->query($que);
$row2=$row2->fetch_assoc();
echo "
<tr class='show_hide ".$row['check_date']."'>
    <td class='nume nu".$row['check_date']."' style='padding: 5px;font-weight:bold;'>".$i."</td>
    <td>".$row2['name']."</td>
    <td>".$row['bank_name']."</td>
    <td class='nume'>".$row['check_num']."</td>
    <td class='nume'>".$row['check_date']."</td>
    <td class='nume va".$row['check_date']."'>".$row['check_value']."</td>
    <td class='nume'>".$row['cur_name']."</td>
    <td class='nume ex".$row['check_date']."'>".$row['exchange_rate']."</td>
    <td class='returned_symbol' onclick='login_modal(\"".langu['checks']."\",\"ajaxbills.php?find_check=our_check_spend&id=".$row['id']."\")'><span></span></td><td class='returned_symbol' onclick='login_modal(\"".langu['check_returned']."\",\"ajaxbills.php?find_check=our_check_return&id=".$row['id']."\")'><span></span></td>
</tr>";
$i++;
$m=$row['check_value']*$row['exchange_rate'];
$total+=$m;
}
echo "
<tr>
    <td></td>
    <td>".langu['final_total']."</td>
    <td></td>
    <td></td>
    <td></td>
    <td class='nume' id='final_total'>".$total." ".langu['shekel']."</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
</table>
</div>
";
}

/**
*فنكشن البحث عن شيك شخصي
*/
function search_our_check($mysqli){
$my=$this->get_select_month_year('find_our_check_by_date','find_our_check_by_date');
echo "
<style>.customer_auto_search_name{width: 46%;margin:0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['search_our_check']."</div>

    <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name'>".langu['check_num']."</div><div class='form_input_input' id='search_check_num'><input type='text' autocomplete='off' id='our_check_num_search' name='our_check_num' placeholder='".langu['check_num']."' value='' oninput='find_our_check_by_num()' required></div></div>
            <div class='form_input_line' id='monthly'><div class='form_input_name'>".langu['check_date']."</div><div class='form_input_input' style='display:flex;'>".$my['month']." ".$my['year']."</div></div>
    </div>
    <div id='if_check'>
        <div class='form_main_name' style='border-top:1px #c8cfd8 solid;'>".langu['checks']."</div>
        <table class='main_table' id='check_list'>
            <tr>
                <th>".langu['check_to']."</th>
                <th>".langu['bank']."</th>
                <th>".langu['check_num']."</th>
                <th>".langu['check_date']."</th>
                <th>".langu['check_value']."</th>
                <th>".langu['currency']."</th>
                <th>".langu['exchange_rate']."</th>
                <th>".langu['spend']."</th>
                <th>".langu['returned']."</th>
            </tr>
        </table>
    </div>  
    <div class='form_input_line' style='margin:15px auto;'></div>

</div>
";
}

/*جلب التاريخ والسنة*/
function get_select_month_year($year=null,$month=null){
if($year!=null){
$ma['year']="
<select id='select_year_check' name='select_check' onchange='".$year."()' required>
    <option value='' disabled selected>".langu['selectyear']."</option>";
for($i=date('Y');$i>=2018;$i--){
$ma['year'].= "    <option value='".$i."'>".$i."</option>";
}
$ma['year'].="</select>";
}

if($month!=null){
$ma['month']="
<select id='select_month_check' name='select_month_check' onchange='".$month."()' required>
    <option value='' disabled selected>".langu['selectmonth']."</option>";
for($i=1;$i<=12;$i++){
$ma['month'].="    <option value='".$i."'>".$i."</option>";
}
$ma['month'].="</select>";
}

return $ma;
}

}