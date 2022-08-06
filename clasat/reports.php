<?php

class reports {
/**
 *فورم الارباح حسب السنة او الشهر
 */
function profits_form(){
$year=$this->get_select_month_year('yearly');
$my=$this->get_select_month_year('monthly','monthly');
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['profits']."</div>
    <div class='form_main_inputs'>
        <div class='form_input_line' ><div class='form_input_name'>".langu['profits']."</div><div class='form_input_input'><input type='radio' name='monthly_yearly' id='is_yearly' value='0' onchange='monthly_yearly()'>".langu['yearly']." <input type='radio' name='monthly_yearly' id='is_monthly' value='1' onchange='monthly_yearly()'>".langu['monthly']."</div></div>
        <div class='form_input_line' id='yearly' style='display:none;'><div class='form_input_name'></div><div class='form_input_input' style='display:flex;'>".$year['year']."</div></div>
        <div class='form_input_line' id='monthly' style='display:none;'><div class='form_input_name'></div><div class='form_input_input' style='display:flex;'>".$my['month']." ".$my['year']."</div></div>
        <table class='main_table' id='profits'>
            <tr>
                <th>".langu['date']."</th>
                <th>".langu['revenue']."</th>
                <th>".langu['expenses']."</th>
                <th>".langu['expense_merchants_customers']."</th>
                <th>".langu['total']."</th>
            </tr>
        </table>
    </div>
</div>";
}

/**
 *سحوبات الشركاء
 */
function partners_expense($mysqli){
$year="<select id='select_year' onchange='select_year_partner()' style='margin:0 25%;'>
<option value='0' disabled selected>".langu['selectyear']."</option>";
for($i=2018;$i<=date('Y');$i++){
$year.="<option value='".$i."'>".$i."</option>";
}
$year.="</select>";
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['partners_expense']."</div>
    <div class='form_main_inputs' style='width:90%;'>".$year."</div>
    <div class='form_main_inputs' style='width:90%;' id='partners'>
    </div>
</div>";
}
/**
 *تقارير المندوبين
 */
function salesmen_orders($mysqli){

$year="<select id='select_year2' onchange='select_month_year_salesmen()' style='margin:0 5px;'>
<option value='0' disabled selected>".langu['selectyear']."</option>";
for($i=2017;$i<=date('Y');$i++){
$year.="<option value='".$i."'>".$i."</option>";
}
$year.="</select>";
$month="<select id='select_month2' onchange='select_month_year_salesmen()' style='margin:0 5px;'>
<option value='0' disabled selected>".langu['selectmonth']."</option>";
for($i=1;$i<=12;$i++){
$month.="<option value='".$i."'>".$i."</option>";
}
$month.="</select>";
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['the_salesmen']."</div>
    <div class='form_main_inputs' style='width:80%;display:flex;'>".$month." ".$year."</div>
    <div class='form_main_inputs' style='width:90%;'>
        <table class='main_table' id='saless'>
            <tr>
            <th>".langu['salesman']."</th>
            <th>".langu['bills_number']."</th>
            <th>".langu['bills_value']."</th>
            <th>".langu['profit']."</th>
            <th>".langu['revenue']."</th>
            </tr>
        </table>
    </div>
</div>";
}
/**
 * الفواتير بانواعها
 * @param type $mysqli
 */
function all_bills_form($mysqli){
$year="<select id='select_year2' onchange='select_year_bills()' style='margin:0 5px;'>
<option value='0' disabled selected>".langu['selectyear']."</option>";
for($i=2017;$i<=date('Y');$i++){
$year.="<option value='".$i."'>".$i."</option>";
}
$year.="</select>";
$bills="<select id='select_bill' onchange='select_year_bills()' style='margin:0 5px;'>
<option value='0' disabled selected>".langu['selecbilltype']."</option>
<option value='1'>".langu['bills']."</option>
<option value='2'>".langu['returned_products']."</option>
<option value='3'>".langu['instant_invoices']."</option>
<option value='4'>".langu['merchant_invoices']."</option>
</select>";
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['bills']."</div>
    <div class='form_main_inputs' style='width:80%;display:flex;'>".$bills." ".$year."</div>
    <div class='form_main_inputs' style='width:90%;'>
        <table class='main_table' id='billss'>
            <tr>
            <th>".langu['date']."</th>
            <th>".langu['bills_number']."</th>
            <th>".langu['bills_value']."</th>
            </tr>
        </table>
    </div>
</div>";
}
/**
 *فنكشن جلب الزبائن الذين لديهم ديون
 */
function customer_debt($mysqli){

echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['customer_debt']."</div>
    <div class='form_input_line' style='height:auto;'><div class='form_input_name'>".langu['debt_type']."</div><div class='form_input_input'><input type='radio' name='debt_marchant_us' id='debt_us' value='0' onchange='debt_customer()'>".langu['debt_to_us']." <br><input type='radio' name='debt_marchant_us' id='debt_marchant' value='1' onchange='debt_customer()'>".langu['debt_to_customer']."</div></div>
<div id='ap-de'></div>
</div>";
}

/**
 * فنكشن التجار
 */
function merchant_debt($mysqli){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['merchant_debt']."</div>
    <div class='form_input_line' style='height:auto;'><div class='form_input_name'>".langu['debt_type']."</div><div class='form_input_input'><input type='radio' name='debt_marchant_us' id='debt_us' value='0' onchange='debt_merchant()'>".langu['debt_to_us']." <br><input type='radio' name='debt_marchant_us' id='debt_marchant' value='1' onchange='debt_merchant()'>".langu['debt_to_merchant']."</div></div>
    <div id='ap-de'></div>
</div>";
}

/**
 * فنكشن البضائع التي شارفت على الانتهاء
 */
function few_products($mysqli){
$q=$mysqli->query('select id2,name,quantity from products where quantity<60');
if($q->num_rows>0){
$ma="<div class='form_main_inputs'>
        <table class='main_table'>
            <tr>
                <th>".langu['num']."</th>
                <th>".langu['product_name']."</th>
                <th>".langu['product_quantity']."</th>
            </tr>
";
while ($row=$q->fetch_assoc()){
$ma.="<tr>
        <td class='nume'>".$row['id2']."</td>
        <td class='nume'>".$row['name']."</td>
        <td class='nume'>".$row['quantity']."</td>
      </tr>";
}
$ma.="</table></div>";
}

else{$ma="<div class='no_resault'>".langu['no_few_products']."</div>";}

echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['few_products']."</div>
".$ma."
</div>";
}

function equity_capital($mysqli){
$q=$mysqli->query('select sum(quantity) as q,sum(quantity*our_price) as t from products');
$row2=$q->fetch_assoc();

$q=$mysqli->query('select products.id2,products.name,products.our_price,products.quantity,categories.name as cname,product_unit.name as uname from products,categories,product_unit where product_unit.id=products.unit_id and categories.id=products.category_id');

echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['equity_capital']."</div>
        <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['final_quantity']." :</div><div class='form_input_input nume'>".$row2['q']."</div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['final_total']." :</div><div class='form_input_input nume'>".$row2['t']." ".langu['shekel']."</div></div>
        <table class='main_table'>
            <tr>
                <th>".langu['num']."</th>
                <th>".langu['category']."</th>
                <th>".langu['product_name']."</th>
                <th>".langu['unit']."</th>
                <th>".langu['product_quantity']."</th>
                <th>".langu['price']."</th>
                <th>".langu['total']."</th>
            </tr>
";
while ($row=$q->fetch_assoc()){
echo "<tr>
        <td class='nume'>".$row['id2']."</td>
        <td class='nume'>".$row['cname']."</td>
        <td class='nume'>".$row['name']."</td>
        <td class='nume'>".$row['uname']."</td>
        <td class='nume'>".$row['quantity']."</td>
        <td class='nume'>".$row['our_price']."</td>
        <td class='nume'>".$row['our_price']*$row['quantity']."</td>
      </tr>";
}
echo "</table></div>
</div>";
}


/*جلب التاريخ والسنة*/
function get_select_month_year($year=null,$month=null){
if($year!=null){
$ma['year']="
<select id='select_year".$year."' name='select_year".$year."' onchange='".$year."()' required>
    <option value='' disabled selected>".langu['selectyear']."</option>";
for($i=date('Y');$i>=2017;$i--){
$ma['year'].= "    <option value='".$i."'>".$i."</option>";
}
$ma['year'].="</select>";
}

if($month!=null){
$ma['month']="
<select id='select_month".$month."' name='select_month".$month."' onchange='".$month."()' required>
    <option value='' disabled selected>".langu['selectmonth']."</option>";
for($i=1;$i<=12;$i++){
$ma['month'].="    <option value='".$i."'>".$i."</option>";
}
$ma['month'].="</select>";
}

return $ma;
}

function daily_report($mysqli){
$r=$mysqli->query('SELECT sum(cash_value) as r_cash,sum(checks_value) as r_check FROM revenue where add_date="'.date('Y-m-d').'" and is_temp=0');
$e=$mysqli->query('SELECT sum(cash_value) as e_cash,sum(check_value) as e_check,sum(our_check_value) as e_our_check FROM expense where date="'.date('Y-m-d').'" and is_temp=0');
$r=$r->fetch_assoc();
$e=$e->fetch_assoc();

$r_ch_otal=0;
$e_ch_otal=0;
$e_our_ch_otal=0;

$q2=$mysqli->query('SELECT checks_ids FROM revenue where add_date="'.date('Y-m-d').'" and is_temp=0');
while ($r_chc=$q2->fetch_assoc()){
if($r_chc['checks_ids']!=''){
$r_ch_otal+=count(unserialize($r_chc['checks_ids']));
}
}

$q3=$mysqli->query('SELECT checks_ids,our_checks_ids FROM expense where date="'.date('Y-m-d').'" and is_temp=0');
while ($e_chc=$q3->fetch_assoc()){
if($e_chc['checks_ids']!=''){
$e_ch_otal+=count(unserialize($e_chc['checks_ids']));
}
if($e_chc['our_checks_ids']!=''){
$e_our_ch_otal+=count(unserialize($e_chc['our_checks_ids']));
}
}

if($r['r_cash']==''){$r['r_cash']=0;}
if($e['e_cash']==''){$e['e_cash']=0;}
if($r['r_check']==''){$r['r_check']=0;}
if($e['e_check']==''){$e['e_check']=0;}
if($e['e_our_check']==''){$e['e_our_check']=0;}

echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['daily_report']."</div>
   <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_nae'>".langu['date']." :</div><div class='form_input_input' style='padding-right: 7px;'><input type='text' autocomplete='off' class='in_date' name='daterep' id='daterep' placeholder='".langu['date']."' value='".date('Y-m-d')."' onchange='get_daily_report()'></div></div>
    <div class='daily_rep'>
      <fieldset>
        <legend>".langu['revenue']."</legend>
        <div class='form_input_line'><div class='form_input_nae'>".langu['cash']." :</div><div class='form_input_input nume' style='padding-right: 5px;'>".$r['r_cash']." ".langu['shekel']."</div></div>
        <div class='form_input_line'><div class='form_input_nae'>".langu['check_count']." :</div><div class='form_input_input nume' style='padding-right: 5px;'>".$r_ch_otal."</div></div>
        <div class='form_input_line'><div class='form_input_nae'>".langu['payment_recipt_checks_total']." :</div><div class='form_input_input nume' style='padding-right: 5px;'>".$r['r_check']." ".langu['shekel']."</div></div>
      </fieldset>

      <fieldset>
        <legend>".langu['expenses']."</legend>
        <div class='form_input_line'><div class='form_input_nae'>".langu['cash']." :</div><div class='form_input_input nume' style='padding-right: 5px;'>".$e['e_cash']." ".langu['shekel']."</div></div>
        <div class='form_input_line'><div class='form_input_nae'>".langu['check_count']." :</div><div class='form_input_input nume' style='padding-right: 5px;'>".$e_ch_otal."</div></div>
        <div class='form_input_line'><div class='form_input_nae'>".langu['payment_recipt_checks_total']." :</div><div class='form_input_input nume' style='padding-right: 5px;'>".$e['e_check']." ".langu['shekel']."</div></div>
        <div class='form_input_line'><div class='form_input_nae'>".langu['our_check_count']." :</div><div class='form_input_input nume' style='padding-right: 5px;'>".$e_our_ch_otal." ".langu['shekel']."</div></div>
        <div class='form_input_line'><div class='form_input_nae'>".langu['our_checks_total']." :</div><div class='form_input_input nume' style='padding-right: 5px;'>".$e['e_our_check']." ".langu['shekel']."</div></div>
      </fieldset>
    </div>
   </div>
</div>";
}

function salesman_returned_check(){

$year="<select id='select_year' onchange='select_year_ret()' style='margin:0 25%;'>
<option value='0' disabled selected>".langu['selectyear']."</option>";
for($i=2018;$i<=date('Y');$i++){
$year.="<option value='".$i."'>".$i."</option>";
}
$year.="</select>";
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['ret_check_sale']."</div>
    <div class='form_main_inputs' style='width:90%;'>".$year."</div>
    <div id='table_ret' class='form_main_inputs' style='width:90%;'>
    </div>
</div>";
}

function zakah(){
$year="<select id='select_year' onchange='select_year_zak()' style='margin:0 25%;'>
<option value='0' disabled selected>".langu['selectyear']."</option>";
for($i=2018;$i<=date('Y');$i++){
$year.="<option value='".$i."'>".$i."</option>";
}
$year.="</select>";
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['zakah']."</div>
    <div class='form_main_inputs' style='width:90%;'>".$year."</div>
    <div id='table_ret' class='form_main_inputs' style='width:90%;'>
    </div>
</div>";
}

function employees_expenses(){
$year="<select id='select_year' onchange='select_year_emp()' style='margin:0 25%;'>
<option value='0' disabled selected>".langu['selectyear']."</option>";
for($i=2018;$i<=date('Y');$i++){
$year.="<option value='".$i."'>".$i."</option>";
}
$year.="</select>";
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['emp_expense']."</div>
    <div class='form_main_inputs' style='width:90%;'>".$year."</div>
    <div id='table_ret' class='form_main_inputs' style='width:90%;'>
    </div>
</div>";
}

}