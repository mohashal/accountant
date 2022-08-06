<?php

class ajax_reports {

function yearly_profit($mysqli){
$year=intval($_GET['year']);
$rt=0;$et=0;$pt=0;$cht=0;$emct=0;
for($i=1;$i<13;$i++){
$r=0;$e=0;$ch=0;$emc=0;
$row=$mysqli->query('SELECT sum(cash_value+checks_value) as co FROM revenue where year(add_date)='.$year.' and MONTH(add_date)='.$i);

$row=$row->fetch_assoc();
if($row['co']!=''){$r=$row['co'];$rt+=$r;}

$row3=$mysqli->query('SELECT sum(check_value) as co FROM checks where is_returned=1 and year(returned_date)='.$year.' and MONTH(returned_date)='.$i);

$row3=$row3->fetch_assoc();
if($row3['co']!=''){$ch=$row3['co'];$cht+=$ch;}

$row2=$mysqli->query('SELECT sum(cash_value+check_value) as co FROM expense where expense_type not in(3,5) and year(date)='.$year.' and MONTH(date)='.$i);
$row2=$row2->fetch_assoc();
if($row2['co']!=''){$e=$row2['co'];$et+=$e;}

$row5=$mysqli->query('SELECT sum(cash_value+check_value) as co FROM expense where expense_type in(3,5) and year(date)='.$year.' and MONTH(date)='.$i);
$row5=$row5->fetch_assoc();
if($row5['co']!=''){$emc=$row5['co'];$emct+=$emc;}

$e2=$e+$emc;
$p=$r-$e2;$pt+=$p;
echo "
<tr class='pr_td'>
    <td class='nume'>".$i." / ".$year."</td>
    <td class='nume'>".$r."</td>
    <td class='nume'>".$e."</td>
    <td class='nume'>".$emc."</td>
    <td class='nume'>".$p."</td>
</tr>";
}
$rt=$rt-$cht;
echo "
<tr class='pr_td'>
    <td class='nume'>".langu['total']."</td>
    <td class='nume'>".$rt."</td>
    <td class='nume'>".$et."</td>
    <td class='nume'>".$emct."</td>
    <td class='nume'>".$pt."</td>
</tr>";
}

function monthly_profit($mysqli){
$year=intval($_GET['year']);
$month=intval($_GET['month']);
$r=0;$e=0;$ch=0;
$row=$mysqli->query('SELECT sum(cash_value+checks_value) as co FROM revenue where year(add_date)='.$year.' and MONTH(add_date)='.$month);

$row=$row->fetch_assoc();
if($row['co']!=''){$r=$row['co'];}

$row3=$mysqli->query('SELECT sum(check_value) as co FROM checks where is_returned=1 and year(returned_date)='.$year.' and MONTH(returned_date)='.$month);

$row3=$row3->fetch_assoc();
if($row3['co']!=''){$ch=$row3['co'];}

$row2=$mysqli->query('SELECT sum(cash_value+check_value) as co FROM expense where expense_type not in(3,5) and year(date)='.$year.' and MONTH(date)='.$month);
$row2=$row2->fetch_assoc();
if($row2['co']!=''){$e=$row2['co'];}

$row2=$mysqli->query('SELECT sum(cash_value+check_value) as co FROM expense where expense_type in(3,5) and year(date)='.$year.' and MONTH(date)='.$month);
$row2=$row2->fetch_assoc();
$es=0;
if($row2['co']!=''){$es=$row2['co'];}

$r=$r-$ch;
$p=$r-$e;
echo "
<tr class='pr_td'>
    <td class='nume'>".$month." / ".$year."</td>
    <td class='nume'>".$r."</td>
    <td class='nume'>".$e."</td>
    <td class='nume'>".$es."</td>
    <td class='nume'>".$p."</td>
</tr>";
}

function customer_debt($mysqli,$type){
if($type==1){$q2='select customers.name,customers.balance,employees.name as ename,areas.name aname from customers,employees,areas where balance<0 and customers.sales_man_id=employees.id and customers.area_id=areas.id';}
else{$q2='select customers.name,customers.balance,employees.name as ename,areas.name aname from customers,employees,areas where balance>0 and customers.sales_man_id=employees.id and customers.area_id=areas.id';}
$total=0;
$q=$mysqli->query($q2);
if($q->num_rows>0){
$ma="<div class='form_main_inputs'>
        
        <table class='main_table'>
            <tr>
                <th>".langu['customer_name']."</th>
                <th>".langu['area']."</th>
                <th>".langu['balance']."</th>
                <th>".langu['salesman2']."</th>
            </tr>";

while ($row=$q->fetch_assoc()){
$total+=$row['balance'];
$ma.="<tr>
        <td>".$row['name']."</td>
        <td>".$row['aname']."</td>
        <td class='nume'>".$row['balance']."</td>
        <td>".$row['ename']."</td>
      </tr>";
}
$ma.="
      <tr>
        <td>".langu['final_total']."</td>
        <td></td>
        <td class='nume'>".$total."</td>
        <td></td>
      </tr>
</table></div>";
}
else{$ma="<div class='no_resault'>".langu['no_debt']."</div>";}

echo $ma;
}

function merchant_debt($mysqli,$type){
if($type==1){$q2='select name,balance,area_name from merchants where balance>0';}
else{$q2='select name,balance,area_name from merchants where balance<0';}
$total=0;
$q=$mysqli->query($q2);
if($q->num_rows>0){
$ma="<div class='form_main_inputs'>
        <table class='main_table'>
            <tr>
                <th>".langu['merchant_name']."</th>
                <th>".langu['address']."</th>
                <th>".langu['balance']."</th>
            </tr>
";
while ($row=$q->fetch_assoc()){
$total+=$row['balance'];
$ma.="<tr>
        <td>".$row['name']."</td>
        <td>".$row['area_name']."</td>
        <td class='nume'>".abs($row['balance'])."</td>
      </tr>";
}
$ma.="
      <tr>
        <td>".langu['final_total']."</td>
        <td></td>
        <td class='nume'>".abs($total)."</td>
      </tr>
</table></div>";
}

else{$ma="<div class='no_resault'>".langu['no_debt']."</div>";}
echo $ma;
}

function yearly_partners($mysqli){
$year=intval($_GET['year']);
$rt=0;$et=0;$pt=0;
for($i=1;$i<13;$i++){
$r=0;$e=0;
$row=$mysqli->query('SELECT sum(cash_value+checks_value-discount) as co FROM revenue where year(add_date)='.$year.' and MONTH(add_date)='.$i);

$row=$row->fetch_assoc();
if($row['co']!=''){$r=$row['co'];$rt+=$r;}

$row2=$mysqli->query('SELECT sum(cash_value+check_value) as co FROM expense where year(date)='.$year.' and MONTH(date)='.$i);
$row2=$row2->fetch_assoc();
if($row2['co']!=''){$e=$row2['co'];$et+=$e;}

$p=$r-$e;$pt+=$p;
echo "
<tr class='pr_td'>
    <td class='nume'>".$i." / ".$year."</td>
    <td class='nume'>".$r."</td>
    <td class='nume'>".$e."</td>
    <td class='nume'>".$p."</td>
</tr>";
}
echo "
<tr class='pr_td'>
    <td class='nume'>".langu['total']."</td>
    <td class='nume'>".$rt."</td>
    <td class='nume'>".$et."</td>
    <td class='nume'>".$pt."</td>
</tr>";
}

/**
 * get product by id*/
function get_product_by_id($mysqli,$id){
$q=$mysqli->query('select * from products where id='.$id);
if($q->num_rows>0){
$q=$q->fetch_assoc();
echo json_encode($q);
}
}

function get_partners_exoense_year($mysqli){
$year= intval($_GET['year']);
$co=0;$ids=array();$q2='';$tall=0;
$name='';
$q=$mysqli->query('select name,id from partners');

while($row=$q->fetch_assoc()){
$ids['id'.$row['id']]['id']=$row['id'];
$ids['id'.$row['id']]['name']=$row['name'];
$name.="<th>".$row['name']."</th>";
}
$m="
<table class='main_table'>
    <tr>
        <th>".langu['date']."</th>
        ".$name."
        <th>".langu['total']."</th>
    </tr>";
$cid=count($ids);
for($i=1;$i<13;$i++){
/*SELECT sum(expense.cash_value+expense.check_value+expense.our_check_value) as co,partners.id FROM expense,partners where expense.partner_id=partners.id and year(date)=2018 and MONTH(date)=6 GROUP BY partners.id*/
for($i5=0;$i5<$cid;$i5++){
$a=array_values($ids);
if($i5==0){$q2='SELECT sum(cash_value+check_value+our_check_value) as co,partner_id as id FROM expense where partner_id='.$a[0]['id'].' and year(date)='.$year.' and MONTH(date)='.$i;}
else{
$q2.=' UNION ALL SELECT sum(cash_value+check_value+our_check_value) as co,partner_id as id FROM expense where partner_id='.$a[$i5]['id'].' and year(date)='.$year.' and MONTH(date)='.$i;
}
}
unset($a);

$q=$mysqli->query($q2);
$t2=0;$trr='';
while($row=$q->fetch_assoc()){
$t=0;$ids['id'.$row['id']]['m'.$i]=0;
if($row['co']!=''){$tall+=$row['co'];$t2+=$row['co'];$t=$row['co'];$ids['id'.$row['id']]['m'.$i]=$row['co'];}

$trr.="<td class='nume'>".$t."</td>";
}

$m.="<tr class='del'>
        <td class='nume'>".$i." / ".$year."</td>
        ".$trr."
        <td class='nume'>".$t2."</td>
    </tr>";
}
$trr='';
for($i5=0;$i5<$cid;$i5++){
$a=array_values($ids);
@$ta=$a[$i5]["m1"]+$a[$i5]['m2']+$a[$i5]['m3']+$a[$i5]['m4']+$a[$i5]['m5']+$a[$i5]['m6']+$a[$i5]['m7']+$a[$i5]['m8']+$a[$i5]['m9']+$a[$i5]['m10']+$a[$i5]['m11']+$a[$i5]['m12'];
$trr.="<td class='nume'>".$ta."</td>";
}
$m.="<tr class='del'>
        <td>".langu['final_total']."</td>
        ".$trr."
        <td class='nume'>".$tall."</td>
</tr>";
echo $m.'</table>';
}

function get_salesmen_orders($mysqli){
$year= intval($_GET['year']);
$month= intval($_GET['month']);
$report='';
$all_num=0;
$all_val=0;
$pro=0;
$all_rev=0;
$q=$mysqli->query('select * from employees where employee_type=1');

while($sales=$q->fetch_assoc()){
$q2=$mysqli->query('select count(id) as bill_num,sum(total) as bill_value,sum(profit) as bill_profit from invoices where MONTH(date)='.$month.' AND YEAR(date)='.$year.' and sales_man_id='.$sales['id']);
$row=$q2->fetch_assoc();

$q3=$mysqli->query('select sum(cash_value+checks_value) as rev_sum from revenue where MONTH(add_date)='.$month.' AND YEAR(add_date)='.$year.' and saleman_id='.$sales['id']);
$row3=$q3->fetch_assoc();
$report.="<tr class='hide_sales'>
            <td>".$sales['name']."</td>
            <td class='nume'>".$row['bill_num']."</td>
            <td class='nume'>".$row['bill_value']."</td>
            <td class='nume'>".$row['bill_profit']."</td>
            <td class='nume'>".$row3['rev_sum']."</td>
          </tr>";
$all_num+=$row['bill_num'];
$all_val+=$row['bill_value'];
$pro+=$row['bill_profit'];
$all_rev+=$row3['rev_sum'];
}

$q=$mysqli->query('SELECT count(id) as bill_num,sum(total) as bill_value,sum(profit) as bill_profit from instant_invoice where MONTH(date)='.$month.' and Year(date)='.$year);
$row=$q->fetch_assoc();
$all_num+=$row['bill_num'];
$all_val+=$row['bill_value'];
$pro+=$row['bill_profit'];

$report.="<tr class='hide_sales'>
            <td>".langu['instant_pay']."</td>
            <td class='nume'>".$row['bill_num']."</td>
            <td class='nume'>".$row['bill_value']."</td>
            <td class='nume'>".$row['bill_profit']."</td>
            <td class='nume'>-</td>
          </tr>
          <tr class='hide_sales'>
            <td>".langu['final_total']."</td>
            <td class='nume'>".$all_num."</td>
            <td class='nume'>".$all_val."</td>
            <td class='nume'>".$pro."</td>
            <td class='nume'>".$all_rev."</td>
          </tr>";
echo $report;

}

function get_bills_year($mysqli){
$year= intval($_GET['year']);
$bill= intval($_GET['bill']);
$report='';
$all_num=0;
$all_val=0;

for($i=1;$i<=12;$i++){
switch ($bill){
case '1':$qu='select count(id) as bill_num,sum(total) as bill_value from invoices where month(date)='.$i.' and  YEAR(date)='.$year;break;
case '2':$qu='select count(id) as bill_num,sum(total) as bill_value from returned_products where month(date)='.$i.' and  YEAR(date)='.$year;break;
case '3':$qu='select count(id) as bill_num,sum(total) as bill_value from instant_invoice where month(date)='.$i.' and  YEAR(date)='.$year;break;
case '4':$qu='select count(id) as bill_num,sum(total) as bill_value from merchant_invoice where month(date)='.$i.' and  YEAR(date)='.$year;break;
}

$q=$mysqli->query($qu);
$q=$q->fetch_assoc();

$report.="
<tr class='hide_bill'>
    <td class='nume'>".$i." / ".$year."</td>
    <td class='nume'>".$q['bill_num']."</td>
    <td class='nume'>".$q['bill_value']."</td>
</tr>
";
$all_num+=$q['bill_num'];
$all_val+=$q['bill_value'];
}

$report.="
<tr class='hide_bill'>
    <td class='nume'>".langu['final_total']."</td>
    <td class='nume'>".$all_num."</td>
    <td class='nume'>".$all_val."</td>
</tr>
";

echo $report;
}


function daily_report($mysqli){
$date=$_GET['daterep'];
$r=$mysqli->query('SELECT sum(cash_value) as r_cash,sum(checks_value) as r_check FROM revenue where add_date="'.$date.'" and is_temp=0');
$e=$mysqli->query('SELECT sum(cash_value) as e_cash,sum(check_value) as e_check,sum(our_check_value) as e_our_check FROM expense where date="'.$date.'" and is_temp=0');
$r=$r->fetch_assoc();
$e=$e->fetch_assoc();

$r_ch_otal=0;
$e_ch_otal=0;
$e_our_ch_otal=0;

$q2=$mysqli->query('SELECT checks_ids FROM revenue where add_date="'.$date.'" and is_temp=0');
while ($r_chc=$q2->fetch_assoc()){
if($r_chc['checks_ids']!=''){
$r_ch_otal+=count(unserialize($r_chc['checks_ids']));
}
}

$q3=$mysqli->query('SELECT checks_ids,our_checks_ids FROM expense where date="'.$date.'" and is_temp=0');
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

echo "<fieldset>
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
      </fieldset>";
}

function ret_check_salesman($mysqli){
$year=intval($_GET['year']);
$a=array();
$q=$mysqli->query('SELECT id,name FROM employees where employee_type=1');

while ($row=$q->fetch_assoc()){
$a['id'.$row['id']]['name']=$row['name'];
}

$e="<table class='main_table'>
<tr><th>".langu['month']."</th>";

foreach ($a as $k => $v) {
$e.="<th>".$a[$k]['name']."</th>";
for($i2=1;$i2<13;$i2++){
$a[$k][$i2]=0;
}
}

$e.="</tr>";


for($i=1;$i<13;$i++){
$ma='select checks.*,customers.sales_man_id from checks,customers where checks.is_returned=1 and checks.customer_id=customers.id and year(checks.returned_date)='.$year.' and MONTH(checks.returned_date)='.$i;
$q2=$mysqli->query($ma);

while($row=$q2->fetch_assoc()){

if($row['currency_id']==1){$total=$row['check_value'];}
else{$total=$row['check_value']*$row['exchange_rate'];}
if($row['sales_man_id']!=0){$kk='id'.$row['sales_man_id'];}
$a[$kk][$i]=$a[$kk][$i]+$total;
}

$e.="<tr><td class='nume'>".$i."</td>";
foreach ($a as $k => $v) {
$e.="<td class='nume'>".$a[$k][$i]."</td>";
}
$e.="</tr>";

}

echo $e."</table>";
}

function zakah($mysqli){
$year=intval($_GET['year']);
$q=$mysqli->query('SELECT * FROM expense where merchant_id=74 and YEAR(date)='.$year);
$cash=0;
$checks=0;
$i=1;
echo "<table class='main_table'>
<tr>
<th></th>
<th>".langu['date']."</th>
<th>".langu['cash_value']."</th>
<th>".langu['payment_recipt_checks_total']."</th>
<th>".langu['notes']."</th>
</tr>";
while($row=$q->fetch_assoc()){
$ch=$row['check_value']+$row['our_check_value'];
$cash+=$row['cash_value'];
$checks+=$ch;
echo "<tr>
<td class='nume'>".$i."</td>
<td class='nume'>".$row['date']."</td>
<td class='nume'>".$row['cash_value']."</td>
<td class='nume'>".$ch."</td>
<td>".$row['notes']."</td>
</tr>";
$i++;
}
echo "<tr>
<td class='nume'></td>
<td>".langu['final_total']."</td>
<td class='nume'>".$cash."</td>
<td class='nume'>".$checks."</td>
<td></td>
</tr>
</table>";

}
/** سحوبات الموظفين  **/
function emp_expense($mysqli){
$year=intval($_GET['year']);
$emp=array();
$all=array();
$all['all']=0;
$q=$mysqli->query('SELECT id,name FROM employees');
while ($row=$q->fetch_assoc()){
$emp['id'.$row['id']]['name']=$row['name'];
$emp['id'.$row['id']]['all']=0;
for($i=1;$i<13;$i++){
$emp['id'.$row['id']]['m'.$i]=0;
$all['m'.$i]=0;
}
}

for($i=1;$i<13;$i++){
$q=$mysqli->query('SELECT employee_id as id,sum(cash_value) as cv,sum(check_value) as chv,sum(our_check_value) as ochv FROM `expense` where expense_type=1 and month(date)='.$i.' and year(date)='.$year.' GROUP BY employee_id');
while($row=$q->fetch_assoc()){
$m=$row['cv']+$row['chv']+$row['ochv'];
$emp['id'.$row['id']]['m'.$i]=$m;
$emp['id'.$row['id']]['all']+=$m;
$all['m'.$i]+=$m;
$all['all']+=$m;
}
}

echo "<style>.main_table td {padding:7px;border: 1px solid #c8cfd8;}</style>
<table class='main_table'>
<tr>
<th>".langu['employee_name']."</th>
<th class='nume'>1</th>
<th class='nume'>2</th>
<th class='nume'>3</th>
<th class='nume'>4</th>
<th class='nume'>5</th>
<th class='nume'>6</th>
<th class='nume'>7</th>
<th class='nume'>8</th>
<th class='nume'>9</th>
<th class='nume'>10</th>
<th class='nume'>11</th>
<th class='nume'>12</th>
<th>".langu['final_total']."</th>
</tr>";
foreach ($emp as $k) {
echo "<tr>
<td>".$k['name']."</td>
<td class='nume'>".$k['m1']."</td>
<td class='nume'>".$k['m2']."</td>
<td class='nume'>".$k['m3']."</td>
<td class='nume'>".$k['m4']."</td>
<td class='nume'>".$k['m5']."</td>
<td class='nume'>".$k['m6']."</td>
<td class='nume'>".$k['m7']."</td>
<td class='nume'>".$k['m8']."</td>
<td class='nume'>".$k['m9']."</td>
<td class='nume'>".$k['m10']."</td>
<td class='nume'>".$k['m11']."</td>
<td class='nume'>".$k['m12']."</td>
<td class='nume'>".$k['all']."</td>
</tr>";

}
echo "<tr>
<td>".langu['final_total']."</td>
<td class='nume'>".$all['m1']."</td>
<td class='nume'>".$all['m2']."</td>
<td class='nume'>".$all['m3']."</td>
<td class='nume'>".$all['m4']."</td>
<td class='nume'>".$all['m5']."</td>
<td class='nume'>".$all['m6']."</td>
<td class='nume'>".$all['m7']."</td>
<td class='nume'>".$all['m8']."</td>
<td class='nume'>".$all['m9']."</td>
<td class='nume'>".$all['m10']."</td>
<td class='nume'>".$all['m11']."</td>
<td class='nume'>".$all['m12']."</td>
<td class='nume'>".$all['all']."</td>
</tr>
</table>";

}

}