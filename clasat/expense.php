<?php


class expense {

/**
 *فنكشن اضافة فورم عام لسند القبض
 */
function add_expense_form($mysqli){
$s=$this->get_select_sale($mysqli,99999,99999,99999);
$m=$this->get_expense_select($mysqli,"onchange='get_expense_type()'",99899);
echo "<style>.customer_auto_search_name{width:31%; margin:1px 0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['add_expense_receipt']."</div>
    <form id='expense_form' action='expense.php?conn=save_expense_form' method='post' enctype='multipart/form-data'>

        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'><input type='text' autocomplete='off' class='check_date' name='expense_date' placeholder='".langu['date']."' value='' required></div></div>

            <div class='form_input_line'><div class='form_input_name'>".langu['expense_type']."</div><div class='form_input_input'>".$m['expense']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_expense_type']."</div><div class='form_input_input'><input type='checkbox' name='is_cash' id='is_cash' value='1' onchange='show_hide_cash_check()' checked>".langu['cash']." <input type='checkbox' name='is_check' id='is_check' value='1' onchange='show_hide_cash_check()'>".langu['check']."</div></div>
            <div class='form_append'>
            </div>
          <div id='if_cash'>
            <div class='form_input_line'><div class='form_input_name'>".langu['cash_value']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='cash_value' placeholder='".langu['cash_value']."' value=''></div></div>          
          </div>
<div class='discount_in' style='display:none'>
<div class='form_input_line'><div class='form_input_name'>".langu['discount']."</div><div class='form_input_input'><input type='text' autocomplete='off' id='discount' name='discount' placeholder='".langu['discount']."' value='0'></div></div>
</div>
                      <div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'></textarea></div></div>
        </div>
".$s['banks'].$s['cur']."

    <div id='if_check' style='display:none;'>
        <div class='form_main_name' style='border-top:1px #c8cfd8 solid;'>".langu['checks']."</div>
        <div class='add_checks_field'>
            <div class='add_check' style='width:initial;' onclick='add_check_fields()'><span> + </span>".langu['add_personal_check']."</div>
            <div class='add_old_check'><div class='old_check_name'>".langu['add_old_check']."</div><div class='old_check_input' id='search_check_num'><input type='text' autocomplete='off' name='check_num_search' id='check_num_search' oninput='find_check_by_num(\"table_check_details\")' placeholder='".langu['check_num']."'/></div></div>
        </div>
        <table class='check_list'>
            <tr>
                <th></th>
                <th>".langu['check_from']."</th>
                <th>".langu['bank']."</th>
                <th>".langu['check_num']."</th>
                <th>".langu['check_date']."</th>
                <th>".langu['check_value']."</th>
                <th>".langu['currency']."</th>
                <th>".langu['exchange_rate']."</th>
                <th>".langu['image']."</th>
            </tr>
            <tr class='final_res'>
                <td></td>
                <td>".langu['final_total']."</td>
                <td></td>
                <td></td>
                <td></td>
                <td class='nume' id='total_values'></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>


    <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add_expense_receipt']."'></div>
        <input type='hidden' id='checks_count' name='checks_count' value='0' />
    </form>
</div>
";
}


/**
 *فنكشن اضافة فورم تعديل السند
 */
function edit_expense_form($mysqli,$row,$id,$type,$fields=null){
$s=$this->get_select_sale($mysqli,99999,99999,99999);
$m=$this->get_expense_select($mysqli,"onchange='get_expense_type()'",$type);
$checks='';
$cash_check='';$cash_show='display:none;';
$check_check='';$check_show='display:none;';
if($row['is_check']==1){$check_check=' checked';$check_show='';$checks=$this->get_check_edit($mysqli,$row['checks_ids'],$row['our_checks_ids']);}
if($row['is_cash']==1){$cash_check=' checked';$cash_show='';}

$disc="style='display:none'";
if($type==3 || $type==5){$disc=0;}

echo "<style>.customer_auto_search_name{width:31%; margin:1px 0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['add_expense_receipt']."</div>
    <form id='expense_form' action='expense.php?conn=save_expense_form' method='post' enctype='multipart/form-data'>

        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'><input type='text' autocomplete='off' class='check_date' name='expense_date' placeholder='".langu['date']."' value='".$row['date']."' required></div></div>

            <div class='form_input_line'><div class='form_input_name'>".langu['expense_type']."</div><div class='form_input_input'>".$m['expense']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['payment_expense_type']."</div><div class='form_input_input'><input type='checkbox' name='is_cash' id='is_cash' value='1' onchange='show_hide_cash_check()'".$cash_check.">".langu['cash']." <input type='checkbox' name='is_check' id='is_check' value='1' onchange='show_hide_cash_check()'".$check_check.">".langu['check']."</div></div>
            <div class='form_append'>
            ".$fields."
            </div>
          <div id='if_cash' style='".$cash_show."'>
            <div class='form_input_line'><div class='form_input_name'>".langu['cash_value']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='cash_value' placeholder='".langu['cash_value']."' value='".$row['cash_value']."'></div></div>          
          </div>
<div class='discount_in' ".$disc.">
<div class='form_input_line'><div class='form_input_name'>".langu['discount']."</div><div class='form_input_input'><input type='text' autocomplete='off' id='discount' name='discount' placeholder='".langu['discount']."' value='".$row['discount']."'></div></div>
</div>
                      <div class='form_input_line form_textarea'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='notes' placeholder='".langu['notes']."'>".$row['notes']."</textarea></div></div>
        </div>
".$s['banks'].$s['cur']."

    <div id='if_check' style='".$check_show."'>
        <div class='form_main_name' style='border-top:1px #c8cfd8 solid;'>".langu['checks']."</div>
        <div class='add_checks_field'>
            <div class='add_check' style='width:initial;' onclick='add_check_fields()'><span> + </span>".langu['add_personal_check']."</div>
            <div class='add_old_check'><div class='old_check_name'>".langu['add_old_check']."</div><div class='old_check_input' id='search_check_num'><input type='text' autocomplete='off' name='check_num_search' id='check_num_search' oninput='find_check_by_num(\"table_check_details\")' placeholder='".langu['check_num']."'/></div></div>
        </div>
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
            ".$checks."
        </table>
        <script>$('.check_date').datepicker();</script>
    </div>


    <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit_expense_receipt']."'></div>
        <input type='hidden' id='checks_count' name='checks_count' value='".$row['check_count']."' />
        <input type='hidden' id='edit_expenses' name='edit_expenses' value='".$id."' />
    </form>
</div>
";
}

/**
 * جلب الشيكات للتعديل
 * @param type $mysqli
 * @param type $checks
 * @param type $our_checks
 */
function get_check_edit($mysqli,$checks,$our_checks){
$checks=unserialize($checks);
$our_checks=unserialize($our_checks);
$tr_content='';
        
$count1=count($checks);
$count2=count($our_checks);

$i=1;

for($i2=0;$i2<$count1;$i2++){
$row=$mysqli->query('SELECT checks.*,currency.name as cur_name,banks.name as bank_name FROM checks,banks,currency where checks.id='.$checks[$i2].' and currency.id=checks.currency_id and banks.id=checks.bank_id');
$row=$row->fetch_assoc();
$tr_content.="<tr id='check".$i."'>
<td><span class='delete_check' id='delete_el".$i."' onclick='delete_check(".$i.")'></span>".$row['bank_name']."</td>
<td class='nume'>".$row['check_num']."</td>
<td class='nume'>".$row['check_date']."</td>
<td class='nume'>".$row['check_value']."</td>
<td class='nume'>".$row['cur_name']."</td>
<td class='nume'>".$row['exchange_rate']."</td>
<td></td>
<input type='hidden' name='check_id".$i."' id='check_id".$i."' value='".$row['id']."'>
<input type='hidden' name='check_value".$i."' id='check_value".$i."' value='".$row['check_value']."'>
<input type='hidden' name='check_exr".$i."' id='check_exr".$i."' value='".$row['exchange_rate']."'>
</tr>";$i=$i+1;
}

for($i3=0;$i3<$count2;$i3++){
$row3=$mysqli->query("select * from our_checks where id=".$our_checks[$i3]);
$row3=$row3->fetch_assoc();
$s2=$this->edit_select_bank_cur($mysqli,$row3['bank_id'],$row3['currency_id'],$i);

$tr_content.="
<tr id='check".$i."'>
    <td><span class='delete_check delinp' id='delete_el".$i."' onclick='delete_check(".$i.")'></span>".$s2['banks']."</td>
    <td><input type='text' autocomplete='off' id='check_num".$i."' name='check_num".$i."' placeholder='رقم الشيك' value='".$row3['check_num']."' required></td>
    <td><input type='text' autocomplete='off' class='check_date' id='check_date".$i."' name='check_date".$i."' placeholder='تاريخ الشيك' value='".$row3['check_date']."' required></td>
    <td><input type='text' autocomplete='off' id='check_value".$i."' name='check_value".$i."' placeholder='قيمة الشيك' value='".$row3['check_value']."' required></td>
    <td>".$s2['cur']."</td>
    <td><input type='text' autocomplete='off' id='exchange_rate".$i."' name='exchange_rate".$i."' placeholder='سعر الصرف' value='".$row3['exchange_rate']."'></td>
    <td><input type='file' name='check_image".$i."' id='check_image".$i."'></td>
    <input type='hidden' name='check_id".$i."' id='check_id".$i."' value='0'>
</tr>";
$i=$i+1;
}

return $tr_content;
}

/**
 * فنكشن اضافة جدول السندات الغير مرحلة
 * @param type $mysqli
 */
function temp_expense_form($mysqli){
$no='';
echo "
<style>.check_list{margin-top:30px;}.form_main{width:95%;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['temp_expense_payment']."</div>
    <table class='check_list'>
        <tr>
            <th class='no_print'><input id='selectall' type='checkbox' onclick='select_deselect_all()' value=''/></th>
            <th>".langu['payment_recipt_from']."</th>
            <th class='edit_symbol'></th>
            <th>".langu['payment_recipt_type']."</th>
            <th>".langu['payment_recipt_cash_total']."</th>
            <th>".langu['check_count']."</th>
            <th>".langu['payment_recipt_checks_total']."</th>
            <th>".langu['our_checks_total']."</th>
            <th class='edit_symbol'></th>
            <th class='delete_symbol'></th>
        </tr>
";
$q=$mysqli->query("select expense.*,expense_types.name as ename from expense,expense_types where is_temp=1 and expense_types.id=expense.expense_type");
if($q->num_rows>0){
while ($row=$q->fetch_assoc()){

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

echo "  <tr>
            <td class='no_print'><span class='no_print'><input class='saveit' name='saveit' type='checkbox' value='".$row['id']."'/></span></td>
            <td>".$name."</td>
            <td class='edit_symbol' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?expense=save_temp_exp&id=".$row['id']."&exp_type=".$row['expense_type']."\")'>✔</td>
            <td>".$row['ename']."</td>
            <td class='nume'>".$row['cash_value']."</td>
            <td class='nume'>".$row['check_count']."</td>
            <td class='nume'>".$row['check_value']."</td>
            <td class='nume'>".$row['our_check_value']."</td>
            <td class='edit_symbol'><a href='expense.php?conn=edit-temp-expense&id=".$row['id']."&type=".$row['expense_type']."'></a></td>
            <td class='delete_symbol' onClick='remove_temp_exp(".$row['id'].")'></td>
        </tr>";
}}
else{$no="<div class='no_resault'>".langu['no_temp_receipt']."</div>";}
echo "</table>
".$no."
<div class='form_input_line' style='margin:15px auto;'><div class='hide_show nprint' style='' onclick='save_select_temp(\"saveit\",\"ajaxbills.php?expense=save_temp_exp&id=\")'>".langu['save_temp']."</div><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
</div>";
}

/**
 * حفظ الفورم المرسل حسب النوع
 * @param type $mysqli
 * @param type $type
 */
function save_expense_form($mysqli,$type){
if(isset($_POST['edit_expenses'])){
$id=$_POST['edit_expenses'];
$mysqli->query('update checks set expense_id=0,is_returned=0 where expense_id='.$id);
$mysqli->query('DELETE FROM our_checks WHERE expense_id='.$id);
$mysqli->query('DELETE FROM expense WHERE id='.$id);
}

$m='';

    switch ($type){
        case '0':$m=$this->save_expense_form_partner($mysqli);break;
        case '1':$m=$this->save_expense_form_salary($mysqli);break;
        case '2':$m=$this->save_expense_form_salary($mysqli);break;
        case '3':$m=$this->save_expense_form_merchant($mysqli);break;
        case '4':$m=$this->save_expense_form_car($mysqli);break;
        case '5':$m=$this->save_expense_form_customer($mysqli);break;
default :$m=$this->save_expense_form_other($mysqli);break;
    }

if($m!=''){return $m;}
}

/*حفظ سند صرف راتب موظف*/
function save_expense_form_salary($mysqli){
$date=$_POST['expense_date'];
$expense_type=$_POST['expense_type'];
$is_cash=0;$is_check=0;
$cash_value=0;$check_value=0;
$count_checks=$_POST['checks_count'];
if($count_checks!=0){$check=1;}

if(isset($_POST['is_cash'])){if($_POST['is_cash']==1){$is_cash=1;$cash_value=floatval($_POST['cash_value']);}}
if(isset($_POST['is_check'])){if($_POST['is_check']==1){$is_check=1;}}

if($s=$mysqli->prepare("INSERT INTO expense (expense_type,is_cash,is_check,cash_value,date,employee_id,notes,check_count) VALUES (?,?,?,?,?,?,?,?)")){
@$s->bind_param("iiidsisi",$expense_type,$is_cash,$is_check,$cash_value,$date,$_POST['employee_id'],$_POST['notes'],$count_checks);
$s->execute();
$exp_id=$mysqli->insert_id;

if(isset($_POST['is_check'])){if($_POST['is_check']==1&&$count_checks!=0){
$this->save_checks_to_database($mysqli,$count_checks,$exp_id,$_POST['employee_id']);
}}
$ma[0]=langu['add_expense_success'];
$ma[1]=3;
return $ma;
}

else{$ma[0]=langu['add_expense_fail'];$ma[1]=0;return $ma;}

}

/*حفظ سند صرف شركاء*/
function save_expense_form_partner($mysqli){
$date=$_POST['expense_date'];
$expense_type=$_POST['expense_type'];
$is_cash=0;$is_check=0;
$cash_value=0;$check_value=0;
$count_checks=$_POST['checks_count'];
if($count_checks!=0){$check=1;}

if(isset($_POST['is_cash'])){if($_POST['is_cash']==1){$is_cash=1;$cash_value=floatval($_POST['cash_value']);}}
if(isset($_POST['is_check'])){if($_POST['is_check']==1){$is_check=1;}}

if($s=$mysqli->prepare("INSERT INTO expense (expense_type,is_cash,is_check,cash_value,date,partner_id,notes,check_count) VALUES (?,?,?,?,?,?,?,?)")){
@$s->bind_param("iiidsisi",$expense_type,$is_cash,$is_check,$cash_value,$date,$_POST['partner_id'],$_POST['notes'],$count_checks);
$s->execute();
$exp_id=$mysqli->insert_id;

if(isset($_POST['is_check'])){if($_POST['is_check']==1&&$count_checks!=0){
$this->save_checks_to_database($mysqli, $count_checks, $exp_id,null,null,null,$_POST['partner_id']);
}}
$ma[0]=langu['add_expense_success'];
$ma[1]=3;
return $ma;
}

else{$ma[0]=langu['add_expense_fail'];$ma[1]=0;return $ma;}

}
/*حفظ سند صرف راتب موظف*/
function save_expense_form_car($mysqli){
$date=$_POST['expense_date'];
$expense_type=$_POST['expense_type'];
$is_cash=0;$is_check=0;
$cash_value=0;$check_value=0;
$count_checks=$_POST['checks_count'];
if($count_checks!=0){$check=1;}

if(isset($_POST['is_cash'])){if($_POST['is_cash']==1){$is_cash=1;$cash_value=floatval($_POST['cash_value']);}}
if(isset($_POST['is_check'])){if($_POST['is_check']==1){$is_check=1;}}

if($s=$mysqli->prepare("INSERT INTO expense (expense_type,is_cash,is_check,cash_value,date,car_id,notes,check_count) VALUES (?,?,?,?,?,?,?,?)")){
@$s->bind_param("iiidsisi",$expense_type,$is_cash,$is_check,$cash_value,$date,$_POST['car_id'],$_POST['notes'],$count_checks);
$s->execute();
$exp_id=$mysqli->insert_id;

if(isset($_POST['is_check'])){if($_POST['is_check']==1&&$count_checks!=0){
$this->save_checks_to_database($mysqli,$count_checks,$exp_id);
}}
$ma[0]=langu['add_expense_success'];
$ma[1]=3;
return $ma;
}

else{$ma[0]=langu['add_expense_fail'];$ma[1]=0;return $ma;}

}
/*حفظ سند صرف لتاجر*/
function save_expense_form_merchant($mysqli){
$date=$_POST['expense_date'];
$expense_type=$_POST['expense_type'];
$is_cash=0;$is_check=0;
$cash_value=0;$check_value=0;
$count_checks=$_POST['checks_count'];
if($count_checks!=0){$check=1;}

if(isset($_POST['is_cash'])){if($_POST['is_cash']==1){$is_cash=1;$cash_value=floatval($_POST['cash_value']);}}
if(isset($_POST['is_check'])){if($_POST['is_check']==1){$is_check=1;}}

if($s=$mysqli->prepare("INSERT INTO expense (expense_type,is_cash,is_check,cash_value,date,merchant_id,notes,check_count,discount) VALUES (?,?,?,?,?,?,?,?,?)")){
@$s->bind_param("iiidsisid",$expense_type,$is_cash,$is_check,$cash_value,$date,$_POST['merchant_id'],$_POST['notes'],$count_checks,$_POST['discount']);
$s->execute();
$exp_id=$mysqli->insert_id;

if(isset($_POST['is_check'])){if($_POST['is_check']==1&&$count_checks!=0){
$this->save_checks_to_database($mysqli,$count_checks,$exp_id,null,$_POST['merchant_id']);
}}
$ma[0]=langu['add_expense_success'];
$ma[1]=3;
return $ma;
}

else{$ma[0]=langu['add_expense_fail'];$ma[1]=0;return $ma;}

}
/*حفظ سند صرف لتاجر*/
function save_expense_form_customer($mysqli){
$date=$_POST['expense_date'];
$expense_type=$_POST['expense_type'];
$is_cash=0;$is_check=0;
$cash_value=0;$check_value=0;
$count_checks=$_POST['checks_count'];
if($count_checks!=0){$check=1;}

if(isset($_POST['is_cash'])){if($_POST['is_cash']==1){$is_cash=1;$cash_value=floatval($_POST['cash_value']);}}
if(isset($_POST['is_check'])){if($_POST['is_check']==1){$is_check=1;}}

if($s=$mysqli->prepare("INSERT INTO expense (expense_type,is_cash,is_check,cash_value,date,customer_id,notes,check_count,discount) VALUES (?,?,?,?,?,?,?,?,?)")){
@$s->bind_param("iiidsisid",$expense_type,$is_cash,$is_check,$cash_value,$date,$_POST['customer_id'],$_POST['notes'],$count_checks,$_POST['discount']);
$s->execute();
$exp_id=$mysqli->insert_id;

if(isset($_POST['is_check'])){if($_POST['is_check']==1&&$count_checks!=0){
$this->save_checks_to_database($mysqli,$count_checks,$exp_id,null,null,$_POST['customer_id']);
}}
$ma[0]=langu['add_expense_success'];
$ma[1]=3;
return $ma;
}

else{$ma[0]=langu['add_expense_fail'];$ma[1]=0;return $ma;}

}
/*حفظ سند صرف مصاريف اخرى*/
function save_expense_form_other($mysqli){
$date=$_POST['expense_date'];
$expense_type=$_POST['expense_type'];
$is_cash=0;$is_check=0;
$cash_value=0;$check_value=0;
$count_checks=$_POST['checks_count'];
if($count_checks!=0){$check=1;}

if(isset($_POST['is_cash'])){if($_POST['is_cash']==1){$is_cash=1;$cash_value=floatval($_POST['cash_value']);}}
if(isset($_POST['is_check'])){if($_POST['is_check']==1){$is_check=1;}}

if($s=$mysqli->prepare("INSERT INTO expense (expense_type,is_cash,is_check,cash_value,date,notes,check_count) VALUES (?,?,?,?,?,?,?)")){
@$s->bind_param("iiidssi",$expense_type,$is_cash,$is_check,$cash_value,$date,$_POST['notes'],$count_checks);
$s->execute();
$exp_id=$mysqli->insert_id;

if(isset($_POST['is_check'])){if($_POST['is_check']==1&&$count_checks!=0){
$this->save_checks_to_database($mysqli,$count_checks,$exp_id);
}}
$ma[0]=langu['add_expense_success'];
$ma[1]=3;
return $ma;
}

else{$ma[0]=langu['add_expense_fail'];$ma[1]=0;return $ma;}

}
/**
 *جلب الشيكات وارقامها وحفظها
 */
function save_checks_to_database($mysqli,$count_checks,$exp_id,$employee_id=null,$merchant_id=null,$customer_id=null,$partner_id=null){
$ex_rate=1;
$check_total=0;
$our_check_total=0;
$ch_ids=array();
$our_ch_ids=array();
$ou=0;

if($employee_id==null){$employee_id=0;}
if($merchant_id==null){$merchant_id=0;}
if($customer_id==null){$customer_id=0;}
if($partner_id==null){$partner_id=0;}


$s=$mysqli->prepare("INSERT INTO our_checks (check_num,check_value,check_date,bank_id,currency_id,exchange_rate,expense_id,merchant_id,employee_id,customer_id,partner_id) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

for($i=1;$i<=$count_checks;$i++){
$ex_rate=1;
if($_POST['check_id'.$i]==0){$ou=1;
$valu=floatval($_POST['check_value'.$i]);
if($_POST['select_cur'.$i]!=1){$ex_rate=floatval($_POST['exchange_rate'.$i]);$our_check_total+=($ex_rate*$valu);}
else{$our_check_total+=$valu;}
@$s->bind_param("sdsiidiiiii",htmlentities($_POST['check_num'.$i]),$valu,htmlentities($_POST['check_date'.$i]),intval($_POST['select_bank'.$i]),intval($_POST['select_cur'.$i]),$ex_rate,$exp_id,$merchant_id,$employee_id,$customer_id,$partner_id);
$s->execute();
$check_id=$mysqli->insert_id;
$our_ch_ids[]=$check_id;
$this->upload_image($check_id,'check_image'.$i);
}

else{
$check_id=$_POST["check_id".$i];
$ch_ids[]=$check_id;
$check_total+=($_POST["check_exr".$i]*$_POST["check_value".$i]);
$mysqli->query('UPDATE checks set expense_id='.$exp_id.',is_returned=2 where id='.$check_id);
}

}

$mysqli->query("UPDATE expense SET check_value=".$check_total.",our_check_value=".$our_check_total.",checks_ids='".serialize($ch_ids)."',our_checks_ids='".serialize($our_ch_ids)."',is_our_checks=".$ou." WHERE id=".$exp_id);


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
$path='images/our_checks/'.$pic;
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
function search_expense($mysqli,$type=1){
$month="<select id='search_expense_month' name='search_expense_month' onchange='get_records_by_monthyear(".$type.")'>
<option value='0' disabled selected>".langu['select_month']."</option>";
for($i=1;$i<13;$i++){$month.="<option value='$i'>".$i."</option>";}
$month.="</select>";

$year="<select id='search_expense_year' name='search_expense_year' onchange='get_records_by_monthyear(".$type.")'>
<option value='0' disabled selected>".langu['select_year']."</option>";
for($i=2017;$i<=date('Y');$i++){$year.="<option value='$i'>".$i."</option>";}
$year.="</select>";

if($type==2){$types=$this->get_expense_select2($mysqli,"onchange='show_hide_tr()'");$title=langu['search_expense2'];}
else{$types=$this->get_expense_select2($mysqli,"onchange='show_hide_tr()'",99899);$title=langu['search_expense'];}

echo "<style>.customer_auto_search_name{width:31%; margin:1px 0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".$title."</div>
<div class='form_main_inputs'>
    <div class='form_input_line'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input'>".$month.$year."</div></div>
</div>

<div class='form_main_name'>".langu['expenses_payments']."</div>
    <div id='show_tr' style='display:none;'><div class='form_input_line'><div class='form_input_name'>".langu['payment_recipt_type']."</div><div class='form_input_input' style='display:flex;'>".$types['expense']." ".$types['partners']." ".$types['employees']."</div></div></div>
<div id='expenses_append'></div>
</div>
";
}

/**
 * جلب قائمة انواع المصاريف
 * @param type $mysqli
 * @param type $ex_func
 * @return string
 */
function get_expense_select($mysqli,$ex_func,$type=null){
$ma=array();

$q=$mysqli->query('select id,name from expense_types where is_delete=0');
$ma['expense']="<select id='expense_type' name='expense_type' ".$ex_func." required>";


if($type==99899){
$ma['expense'].="<option value='-1' disabled selected>".langu['select_expense_type']."</option>";
while ($row=$q->fetch_assoc()) {
$ma['expense'].="<option value='".$row['id']."'>".$row['name']."</option>";
}
}

else{
$ma['expense'].="<option value='-1' disabled>".langu['select_expense_type']."</option>";
while ($row=$q->fetch_assoc()) {

if($type==$row['id']){$ma['expense'].="<option value='".$row['id']."' selected>".$row['name']."</option>";}
else {$ma['expense'].="<option value='".$row['id']."'>".$row['name']."</option>";}
}
}


$ma['expense'].="</select>";

$q=$mysqli->query('select * from partners where is_delete=0');
$ma['partners']="
<select id='partners' name='partners' onchange='select_partner()' style='display:none'>
<option value='-1' disabled selected>".langu['select_partner']."</option>";
while($row=$q->fetch_assoc()){
$ma['partners'].="<option value='".$row['id']."'>".$row['name']."</option>";
}
$ma['partners'].="</select>";


$q=$mysqli->query('select * from employees where is_delete=0');
$ma['employees']="
<select id='employees' name='employees' onchange='select_employee()' style='display:none'>
<option value='-1' disabled selected>".langu['selectemployee']."</option>";
while($row=$q->fetch_assoc()){
$ma['employees'].="<option value='".$row['id']."'>".$row['name']."</option>";
}
$ma['employees'].="</select>";

return $ma;
}
function get_expense_select2($mysqli,$ex_func,$type=null){
$ma=array();


$ma['expense']="<select id='expense_type' name='expense_type' ".$ex_func." required>";


if($type==99899){
$q=$mysqli->query('select id,name from expense_types where is_delete=0 and id not IN(3,5)');
}
else{
$q=$mysqli->query('select id,name from expense_types where is_delete=0 and id IN(3,5)');
}
$ma['expense'].="<option value='-1' disabled selected>".langu['select_expense_type']."</option>";
while ($row=$q->fetch_assoc()) {
$ma['expense'].="<option value='".$row['id']."'>".$row['name']."</option>";
}

$ma['expense'].="</select>";

$q=$mysqli->query('select * from partners where is_delete=0');
$ma['partners']="
<select id='partners' name='partners' onchange='select_partner()' style='display:none'>
<option value='-1' disabled selected>".langu['select_partner']."</option>";
while($row=$q->fetch_assoc()){
$ma['partners'].="<option value='".$row['id']."'>".$row['name']."</option>";
}
$ma['partners'].="</select>";


$q=$mysqli->query('select * from employees where is_delete=0');
$ma['employees']="
<select id='employees' name='employees' onchange='select_employee()' style='display:none'>
<option value='-1' disabled selected>".langu['selectemployee']."</option>";
while($row=$q->fetch_assoc()){
$ma['employees'].="<option value='".$row['id']."'>".$row['name']."</option>";
}
$ma['employees'].="</select>";

return $ma;
}
/**
*جلب المندوبين
*@return $ma array contains $ma['sale']
*/
function get_select_sale($mysqli,$saleman=null,$banks=null,$currency=null,$i=null){
$ma=array();
if($saleman!=null){
$q=$mysqli->query('select id,name from employees where employee_type=1');
$ma['sales']="<select id='select_salesman".$i."' name='select_salesman".$i."' required>
<option value='0' disabled selected>".langu['selectsales']."</option>";
if($saleman==99998){$ma['sales'].="<option value='0'>".langu['merchant']."</option>";}
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
$ma['banks']=$ba."<select name='select_bank".$i."' id='select_bank".$i."' required>
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
$ma['cur']=$ta."<select name='select_cur".$i."' id='select_cur".$i."' required>
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

}