<?php

class settings {


function form_currency($mysqli){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['currencys']."</div>
    <div class='add_element' onclick='mymodalbox(\"".langu['add_currency']."\",\"ajax_settings.php?currency=add-form-currency\",1)'><span> + </span>".langu['add_currency']."</div>
    <table class='main_table'>
        <tr>
            <th>".langu['currency_name']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";

$q=$mysqli->query("select * from currency where is_delete=0");
while($row=$q->fetch_assoc()){
if($row['id']==1){echo "<tr><td>".$row['name']."</td><td></td><td></td></tr>";}
else{echo "<tr>
        <td>".$row['name']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit_currency']."\",\"ajax_settings.php?currency=edit-form-currency&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_currency(".$row['id'].")'></td>
</tr>";}
}
echo "</table></div>";
}

/*--------- الموظفين -----------*/
function form_employee($mysqli){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['employees']."</div>
    <div class='add_element' onclick='mymodalbox(\"".langu['adds']." ".langu['employee']."\",\"ajax_settings.php?employee=add-form\",1)'><span> + </span>".langu['add_employee']."</div>
    <table class='main_table'>
        <tr>
            <th>".langu['employee_name']."</th>
            <th>".langu['salary']."</th>
            <th>".langu['employee_type']."</th>
            <th>".langu['employee_price']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";
$type=['1'=>langu['salesman3'],'2'=>langu['driver2'],'3'=>langu['employee']];
$q=$mysqli->query("select * from employees where is_delete=0");
while($row=$q->fetch_assoc()){
echo "<tr>
        <td>".$row['name']."</td>
        <td class='nume'>".$row['salary']."</td>
        <td>".$type[$row['employee_type']]."</td>
        <td>".$row['product_price']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit']." ".langu['employee']."\",\"ajax_settings.php?employee=edit-form&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_element(".$row['id'].",\"employee\")'></td>
      </tr>
";
}

echo "</table></div>";
}

function form_expens($mysqli,$type,$table){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu[$type.'s']."</div>
    <div class='add_element' onclick='mymodalbox(\"".langu['adds']." ".langu[$type]."\",\"ajax_settings.php?".$type."=add-form\",1)'><span> + </span>".langu['add_'.$type]."</div>
    <table class='main_table'>
        <tr>
            <th>".langu[$type.'_name']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";

$q=$mysqli->query("select * from ".$table." where is_delete=0");
while($row=$q->fetch_assoc()){
if($row['id']==0 ||$row['id']==1 || $row['id']==2 || $row['id']==3 || $row['id']==4 || $row['id']==5 || $row['id']==6 || $row['id']==7){echo "<tr><td>".$row['name']."</td><td></td><td></td></tr>";}
else{echo "<tr>
        <td>".$row['name']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit']." ".langu[$type]."\",\"ajax_settings.php?".$type."=edit-form&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_element(".$row['id'].",\"".$type."\")'></td>
      </tr>";}
}
echo "</table></div>";
}

function form_cars($mysqli,$type,$table){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu[$type.'s']."</div>
    <div class='add_element' onclick='mymodalbox(\"".langu['adds']." ".langu[$type]."\",\"ajax_settings.php?".$type."=add-form\",1)'><span> + </span>".langu['add_'.$type]."</div>
    <table class='main_table'>
        <tr>
            <th>".langu[$type.'_name']."</th>
            <th>".langu['license_plate']."</th>
            <th>".langu['license_end_date']."</th>
            <th>".langu['insurance_end_date']."</th>
            <th>".langu['purchase_date']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";

$q=$mysqli->query("select * from ".$table." where is_delete=0");
while($row=$q->fetch_assoc()){

echo "<tr>
        <td>".$row['name']."</td>
        <td class='nume'>".$row['license_plate']."</td>
        <td class='nume'>".$row['license_end_date']."</td>
        <td class='nume'>".$row['insurance_end_date']."</td>
        <td class='nume'>".$row['purchase_date']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit']." ".langu[$type]."\",\"ajax_settings.php?".$type."=edit-form&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_element(".$row['id'].",\"".$type."\")'></td>
      </tr>
";
}

echo "</table></div>";
}

function form_merchants($mysqli,$type,$table){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu[$type.'s']."</div>
    <div class='add_element' onclick='mymodalbox(\"".langu['adds']." ".langu[$type]."\",\"ajax_settings.php?".$type."=add-form\",1)'><span> + </span>".langu['add_'.$type]."</div>
    <p style='color:red;margin:0 12px;'>".langu['note']." : ".langu['merchant_balance_note']." .</p>
    <table class='main_table'>
        <tr>
            <th>".langu[$type.'_name']."</th>
            <th>".langu['balance']."</th>
            <th>".langu['address']."</th>
            <th>".langu['telephone']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";

$q=$mysqli->query("select * from ".$table." where is_delete=0");
while($row=$q->fetch_assoc()){
if($row['id']==0){continue;}
else {
echo "<tr>
        <td>".$row['name']."</td>
        <td class='nume'>".$row['balance']."</td>
        <td>".$row['area_name']."</td>
        <td class='nume'>".hebrev($row['telephone'])."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit']." ".langu[$type]."\",\"ajax_settings.php?".$type."=edit-form&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_element(".$row['id'].",\"".$type."\")'></td>
      </tr>
";}
}

echo "</table></div>";
}

function form_telephone($mysqli,$type,$table){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu[$type.'s']."</div>
    <div class='add_element' onclick='mymodalbox(\"".langu['adds']." ".langu[$type]."\",\"ajax_settings.php?".$type."=add-form\",1)'><span> + </span>".langu['add_'.$type]."</div>
    <table class='main_table'>
        <tr>
            <th>".langu[$type.'_name']."</th>
            <th>".langu['telephone']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";

$q=$mysqli->query("select * from ".$table." where is_delete=0");
while($row=$q->fetch_assoc()){

echo "<tr>
        <td>".$row['name']."</td>
        <td class='nume'>".$row['tel_num']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit']." ".langu[$type]."\",\"ajax_settings.php?".$type."=edit-form&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_element(".$row['id'].",\"".$type."\")'></td>
      </tr>
";
}

echo "</table></div>";
}

function form_users($mysqli,$type,$table){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu[$type.'s']."</div>
    <div class='add_element' onclick='mymodalbox(\"".langu['adds']." ".langu[$type]."\",\"ajax_settings.php?".$type."=add-form\",1)'><span> + </span>".langu['add_'.$type]."</div>
    <table class='main_table'>
        <tr>
            <th>".langu[$type.'_name']."</th>
            <th>".langu['permission']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";

$q=$mysqli->query("select * from ".$table." where is_delete=0");
$a=['','مدير','ادخال فواتير + الزبائن','ضريبة','البيع الفوري'];
while($row=$q->fetch_assoc()){

echo "<tr>
        <td>".$row['name']."</td>
        <td>".$a[$row['permission']]."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit']." ".langu[$type]."\",\"ajax_settings.php?".$type."=edit-form&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_element(".$row['id'].",\"".$type."\")'></td>
      </tr>
";
}

echo "</table></div>";
}

function form_elements($mysqli,$type,$table){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu[$type.'s']."</div>
    <div class='add_element' onclick='mymodalbox(\"".langu['adds']." ".langu[$type]."\",\"ajax_settings.php?".$type."=add-form\",1)'><span> + </span>".langu['add_'.$type]."</div>
    <table class='main_table'>
        <tr>
            <th>".langu[$type.'_name']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";

$q=$mysqli->query("select * from ".$table." where is_delete=0");
while($row=$q->fetch_assoc()){
echo "<tr>
        <td>".$row['name']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit']." ".langu[$type]."\",\"ajax_settings.php?".$type."=edit-form&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_element(".$row['id'].",\"".$type."\")'></td>
      </tr>
";
}

echo "</table></div>";
}

}