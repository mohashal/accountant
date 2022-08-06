<?php

class ajax_settings {

/**
*فنكشن اضافة فورم عملة
*/
function add_form_returned(){

echo "
<div class='form_main'>
    <form action='ajaxbills.php?find_check=save_returned' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:80%;margin:0 auto;font-size:15px;'>".langu['check_returned_increase']."</div></div>
            <div class='form_input_line'><div class='form_input_input' style='width:75%;margin:0 auto;'><input type='text' autocomplete='off' name='returned_value' placeholder='".langu['check_returned_increase']." ".langu['shekel']."' value='0' required /></div></div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add_check_returned']."'></div>
            <input type='hidden' name='check_id' value='".intval($_GET['id'])."'/>
        </div>
    </form>
</div>";
}

/**
*فنكشن اضافة فورم عملة
*/
function add_form_currency(){
echo "
<div class='form_main'>
    <form action='ajax_settings.php?currency=add_save_currency' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['currency_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='currency_name' placeholder='".langu['currency_name']."' value='' required /></div></div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add']." ".langu['currency']."'></div>
        </div>
    </form>
</div>";
}

/**
*فنكشن حفظ العملة الجديد في قاعدة البيانات
*/
function add_save_currency($mysqli){
$mysqli->query("INSERT INTO currency (name) VALUES ('". htmlentities($_POST['currency_name'])."')");
if($mysqli->affected_rows>0){$this->msg('success',langu['add_currency_success']);}
else{$this->msg('fail',langu['add_currency_fail']);}
}

/**
*فنكشن اضافة فورم تعديل عملة
*/
function edit_form_currency($mysqli){
$id=intval($_GET['id']);
$row=$mysqli->query('select name from currency where id='.$id);
$row=$row->fetch_assoc();
echo "
<div class='form_main'>
    <form action='ajax_settings.php?currency=edit_save_currency' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['currency_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='currency_name' placeholder='".langu['currency_name']."' value='".$row['name']."' required /></div></div>
            <input type='hidden' name='currency_id' value='".$id."'>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit']." ".langu['currency_name']."'></div>
        </div>
    </form>
</div>";
}

/**
*تعديل اسم العملة
*/
function edit_save_currency($mysqli){
$mysqli->query("update currency set name='".htmlentities($_POST['currency_name'])."' where id=".intval($_POST['currency_id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_currency_success']);}
else{$this->msg('fail',langu['edit_currency_fail']);}
}

/**
 *حذف عملة
 */
function delete_currency($mysqli){
$mysqli->query('update currency set is_delete=1 WHERE id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['delete_currency_success']);}
else{$this->msg('fail',langu['delete_currency_fail']);}
}

/*حفظ موظف جديد*/
function add_save_employee($mysqli){
if(isset($_POST['select_sale_price'])){$s=$_POST['select_sale_price'];}else{$s='';}
$mysqli->query("insert into employees (name,salary,employee_type,product_price) VALUES ('".$_POST['name']."','".$_POST['salary']."','".$_POST['select_type']."','".$s."')");
if($mysqli->affected_rows>0){$this->msg('success',langu['add_success']);}
else{$this->msg('fail',langu['add_fail']);}
}
/**
*edit employee
*/
function edit_save_employee($mysqli){
if(isset($_POST['select_sale_price'])){$s=$_POST['select_sale_price'];}else{$s='';}
$mysqli->query("update employees set name='".htmlentities($_POST['name'])."',salary='".$_POST['salary']."',employee_type='".$_POST['select_type']."',product_price='".$s."' where id=".intval($_POST['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}
else{$this->msg('fail',langu['edit_fail']);}
}

/*حفظ سيارة جديد*/
function add_save_car($mysqli){
$mysqli->query("insert into cars (name,license_plate,license_end_date,insurance_end_date,purchase_date) VALUES ('".$_POST['name']."','".$_POST['license_plate']."','".$_POST['license_end_date']."','".$_POST['insurance_end_date']."','".$_POST['purchase_date']."')");
if($mysqli->affected_rows>0){$this->msg('success',langu['add_success']);}
else{$this->msg('fail',langu['add_fail']);}
}
/*حفظ تعديل السيارة*/
function edit_save_car($mysqli){

$mysqli->query("update cars set name='".htmlentities($_POST['name'])."',license_plate='".$_POST['license_plate']."',license_end_date='".$_POST['license_end_date']."',insurance_end_date='".$_POST['insurance_end_date']."',purchase_date='".$_POST['purchase_date']."' where id=".intval($_POST['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}
else{$this->msg('fail',langu['edit_fail']);}
}
/**
*add form to edit name
*/
function edit_form_car($mysqli,$type,$table){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from '.$table.' where id='.$id);
$row=$row->fetch_assoc();
echo "<style>.form_input_name{width:35%;} .form_input_input{width:65%;}</style>
<div class='form_main'>
    <form action='ajax_settings.php?".$type."=edit_save' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu[$type.'_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='name' placeholder='".langu[$type.'_name']."' value='".$row['name']."' required /></div></div>

<div class='form_input_line'><div class='form_input_name'>".langu['license_plate']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='license_plate' placeholder='".langu['license_plate']."' value='".$row['license_plate']."' required /></div></div>
<div class='form_input_line'><div class='form_input_name'>".langu['license_end_date']."</div><div class='form_input_input'><input type='text' class='all_dates' autocomplete='off' name='license_end_date' placeholder='".langu['license_end_date']."' value='".$row['license_end_date']."' required /></div></div>
<div class='form_input_line'><div class='form_input_name'>".langu['insurance_end_date']."</div><div class='form_input_input'><input type='text' class='all_dates' autocomplete='off' name='insurance_end_date' placeholder='".langu['insurance_end_date']."' value='".$row['insurance_end_date']."' required /></div></div>
<div class='form_input_line'><div class='form_input_name'>".langu['purchase_date']."</div><div class='form_input_input'><input type='text' class='all_dates' autocomplete='off' name='purchase_date' placeholder='".langu['purchase_date']."' value='".$row['purchase_date']."' required /></div></div>

            <input type='hidden' name='id' value='".$id."'>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit']." ".langu[$type.'_name']."'></div>
        </div>
    </form>
</div>";
}

function add_save_merchant($mysqli,$table){
$mysqli->query("INSERT INTO ".$table." (name,area_name,telephone,balance) VALUES ('". htmlentities($_POST['name'])."','". htmlentities($_POST['area'])."','". htmlentities($_POST['tel'])."','". htmlentities($_POST['balance'])."')");
if($mysqli->affected_rows>0){$this->msg('success',langu['add_success']);}
else{$this->msg('fail',langu['add_fail']);}
}
function edit_form_merchant($mysqli,$type,$table){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from '.$table.' where id='.$id);
$row=$row->fetch_assoc();
echo "
<div class='form_main'>
    <form action='ajax_settings.php?".$type."=edit_save' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu[$type.'_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='name' placeholder='".langu[$type.'_name']."' value='".$row['name']."' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['area']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='area' placeholder='".langu['area_name']."' value='".$row['area_name']."' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['telephone']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='tel' placeholder='".langu['telephone']."' value='".$row['telephone']."' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['balance']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='balance' placeholder='".langu['balance']."' value='".$row['balance']."' required /></div></div>
            <input type='hidden' name='id' value='".$id."'>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit']." ".langu[$type.'_name']."'></div>
        </div>
    </form>
</div>";
}
function edit_save_merchant($mysqli,$table){
$mysqli->query("update ".$table." set name='".htmlentities($_POST['name'])."',area_name='".htmlentities($_POST['area'])."',telephone='".htmlentities($_POST['tel'])."',balance='".htmlentities($_POST['balance'])."' where id=".intval($_POST['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}
else{$this->msg('fail',langu['edit_fail']);}
}
/**
*save new element in database
*/
function add_save_telephon($mysqli,$table){
$mysqli->query("INSERT INTO ".$table." (name,tel_num) VALUES ('". htmlentities($_POST['name'])."','". htmlentities($_POST['tel'])."')");
if($mysqli->affected_rows>0){$this->msg('success',langu['add_success']);}
else{$this->msg('fail',langu['add_fail']);}
}

/**
*add form to edit name
*/
function edit_form_telephon($mysqli,$type,$table,$fields=null){
$id=intval($_GET['id']);
$row=$mysqli->query('select name,tel_num from '.$table.' where id='.$id);
$row=$row->fetch_assoc();
echo "
<div class='form_main'>
    <form action='ajax_settings.php?".$type."=edit_save' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu[$type.'_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='name' placeholder='".langu[$type.'_name']."' value='".$row['name']."' required /></div></div>
<div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['telephone']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='tel' placeholder='".langu['telephone']."' value='".$row['tel_num']."' required /></div></div>
            <input type='hidden' name='id' value='".$id."'>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit']." ".langu[$type.'_name']."'></div>
        </div>
    </form>
</div>";
}

/**
*edit name
*/
function edit_save_telephon($mysqli,$table){
$mysqli->query("update ".$table." set name='".htmlentities($_POST['name'])."',tel_num='".htmlentities($_POST['tel'])."' where id=".intval($_POST['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}
else{$this->msg('fail',langu['edit_fail']);}
}

/**
*save new element in database
*/
function add_save_user($mysqli,$table){
$mysqli->query("INSERT INTO ".$table." (name,password,permission) VALUES ('". htmlentities($_POST['name'])."','".md5(md5($_POST['passw']))."','". htmlentities($_POST['select_perm'])."')");
if($mysqli->affected_rows>0){$this->msg('success',langu['add_success']);}
else{$this->msg('fail',langu['add_fail']);}
}

/**
*add form to edit name
*/
function edit_form_user($mysqli,$type,$table,$fields=null){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from '.$table.' where id='.$id);
$row=$row->fetch_assoc();
echo "
<div class='form_main'>
    <form action='ajax_settings.php?".$type."=edit_save' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu[$type.'_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='name' placeholder='".langu[$type.'_name']."' value='".$row['name']."' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['password']."</div><div class='form_input_input' style='width:65%;'><input type='password' autocomplete='off' name='passw' value='' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['permission']."</div><div class='form_input_input' style='width:65%;'><select id='select_perm' name='select_perm'><option value='' disabled selected>".langu['select_perm']."</option><option value='1'>مدير</option><option value='2'>ادخال فواتير + الزبائن</option><option value='3'>ضريبة</option><option value='4'>البيع الفوري</option></select></div></div>
            <input type='hidden' name='id' value='".$id."'>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit']." ".langu[$type.'_name']."'></div>
        </div>
    </form>
</div>";
}

/**
*edit name
*/
function edit_save_user($mysqli,$table){
$mysqli->query("update ".$table." set name='".htmlentities($_POST['name'])."',password='".md5(md5($_POST['passw']))."',permission='". htmlentities($_POST['select_perm'])."' where id=".intval($_POST['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}
else{$this->msg('fail',langu['edit_fail']);}
}
/*------------------------------------*/
/**
*add form to add new element
*/
function add_form($type,$more_fields=null){
echo "
<div class='form_main'>
    <form action='ajax_settings.php?".$type."=add_save' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu[$type.'_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='name' placeholder='".langu[$type.'_name']."' value='' required /></div></div>
            ".$more_fields."
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add']." ".langu[$type]."'></div>
        </div>
    </form>
</div>";
}

/**
*save new element in database
*/
function add_save($mysqli,$table){
$mysqli->query("INSERT INTO ".$table." (name) VALUES ('". htmlentities($_POST['name'])."')");
if($mysqli->affected_rows>0){$this->msg('success',langu['add_success']);}
else{$this->msg('fail',langu['add_fail']);}
}

/**
*add form to edit name
*/
function edit_form($mysqli,$type,$table,$fields=null){
$id=intval($_GET['id']);
$row=$mysqli->query('select name from '.$table.' where id='.$id);
$row=$row->fetch_assoc();
echo "
<div class='form_main'>
    <form action='ajax_settings.php?".$type."=edit_save' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu[$type.'_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='name' placeholder='".langu[$type.'_name']."' value='".$row['name']."' required /></div></div>
            ".$fields."
            <input type='hidden' name='id' value='".$id."'>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit']." ".langu[$type.'_name']."'></div>
        </div>
    </form>
</div>";
}

/**
*edit name
*/
function edit_save($mysqli,$table){
$mysqli->query("update ".$table." set name='".htmlentities($_POST['name'])."' where id=".intval($_POST['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}
else{$this->msg('fail',langu['edit_fail']);}
}

/**
*delete element
 */
function delete($mysqli,$table){
$mysqli->query('update '.$table.' set is_delete=1 WHERE id='.intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['delete_success']);}
else{$this->msg('fail',langu['delete_fail']);}
}

/*------------------------------------*/
function show_notify($mysqli){
$row=$mysqli->query('SELECT * FROM notifications where id='.intval($_GET['id']));
$row=$row->fetch_assoc();
echo "
<div class='form_main'>
        <div class='form_main_inputs'>
            <div class='form_input_line' style='border-bottom: 1px dashed #c8cfd8;'><div class='form_input_name' style='width:35%;'>".langu['notification_name']."</div><div class='form_input_input' style='width:65%;'>".$row['name']."</div></div>
            <div class='form_input_line' style='border-bottom: 1px dashed #c8cfd8;'><div class='form_input_name' style='width:35%;'>".langu['start_date']."</div><div class='form_input_input nume' style='width:65%;'>".$row['start_date']."</div></div>
            <div class='form_input_line' style='border-bottom: 1px dashed #c8cfd8;'><div class='form_input_name' style='width:35%;'>".langu['end_date']."</div><div class='form_input_input nume' style='width:65%;'>".$row['end_date']."</div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['notes']."</div><div class='form_input_input nume' style='width:65%;'>".nl2br($row['notes'])."</div></div>
        </div>
</div>";
}

function add_form_notify(){
echo "
<div class='form_main'>
    <form action='ajax_settings.php?notifications=add-save' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['notification_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='name' placeholder='".langu['notification_name']."' value='' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['start_date']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' class='all_dates' name='start_date' placeholder='".langu['start_date']."' value='' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['end_date']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' class='all_dates' name='end_date' placeholder='".langu['end_date']."' value='' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['notes']."</div><div class='form_input_input' style='width:65%;'><textarea name='notes' placeholder='".langu['notes']."'></textarea></div></div>
            <div class='form_input_line' style='margin:15px auto;'><input type='submit' value='".langu['add']." ".langu['notification']."'></div>
        </div>
    </form>
</div>";
}

function add_save_notify($mysqli){
$mysqli->query("INSERT INTO notifications (name,start_date,end_date,notes) VALUES ('". htmlentities($_POST['name'])."','". htmlentities($_POST['start_date'])."','". htmlentities($_POST['end_date'])."','". htmlentities($_POST['notes'])."')");
if($mysqli->affected_rows>0){$this->msg('success',langu['add_success']);}
else{$this->msg('fail',langu['add_fail']);}
}

function delete_notify($mysqli){
$mysqli->query("delete from notifications where id=".intval($_GET['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['delete_success']);}
else{$this->msg('fail',langu['delete_fail']);}
}
function edit_form_notify($mysqli){
$id=intval($_GET['id']);
$row=$mysqli->query('select * from notifications where id='.$id);
$row=$row->fetch_assoc();
echo "
<div class='form_main'>
    <form action='ajax_settings.php?notifications=edit_save' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['notification_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' name='name' placeholder='".langu['notification_name']."' value='".$row['name']."' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['start_date']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' class='all_dates' name='start_date' placeholder='".langu['start_date']."' value='".$row['start_date']."' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['end_date']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' class='all_dates' name='end_date' placeholder='".langu['end_date']."' value='".$row['end_date']."' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['notes']."</div><div class='form_input_input' style='width:65%;'><textarea name='notes' placeholder='".langu['notes']."'>".$row['notes']."</textarea></div></div>
            <input type='hidden' name='id' value='".$id."'>
            <div class='form_input_line' style='margin:15px auto;'><input type='submit' value='".langu['edit']." ".langu['notification']."'></div>
        </div>
    </form>
</div>";
}

/**
*edit name
*/
function edit_save_notify($mysqli){
$mysqli->query("update notifications set name='". htmlentities($_POST['name'])."',start_date='". htmlentities($_POST['start_date'])."',end_date='". htmlentities($_POST['end_date'])."',notes='". htmlentities($_POST['notes'])."' where id=".intval($_POST['id']));
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_success']);}
else{$this->msg('fail',langu['edit_fail']);}
}
/**
 *تعديل بيانات البضاعة وحفظها في قاعدة البيانات
 *@param $mysqli mysqli connector
 */
function update_product_save($mysqli) {
if($s=$mysqli->prepare("update products set name=?,barcode=?,barcode2=?,barcode3=?,unit_id=?,category_id=?,our_price=?,n_price=?,fa_price=?,t_price=?,f_price=?,quantity=?,cartoon_capicity=? where id=?")){
@$s->bind_param("ssssiidddddiii",htmlentities($_POST['product_name']),htmlentities($_POST['barcode']),htmlentities($_POST['barcode2']),htmlentities($_POST['barcode3']),intval($_POST['select_unit']),intval($_POST['select_category']),floatval($_POST['product_our_price']),floatval($_POST['product_price1']),floatval($_POST['product_price2']),floatval($_POST['product_price3']),floatval($_POST['product_price4']),intval($_POST['product_quantity']),intval($_POST['cartoon_capicity']),intval($_POST['p_id']));
$s->execute();
$this->upload_image($_POST['p_id'],'product_image');
$s="parent.removebox('".$_POST['p_id']."','".$_POST['product_name']."','".$_POST['product_quantity']."','".$_POST['product_our_price']."')";
$this->msg('success',langu['update_product_success'],1,$s);
//$this->upload_image($mysqli->insert_id,'product_image');

}
else{$s="parent.removebox2()";$this->msg('fail',langu['update_product_fail'],1,$s);}
}


/**
 *اشعار 
 */
function msg($success_fail,$text,$re=null,$script=null){
$re1='';
if($re==null){$re1="<script>setTimeout(\"window.top.location.reload()\",1000);</script>";}
elseif($re==1){$re1="<script>
setTimeout(\"".$script."\",1000);
</script>";}
echo "
<style>
.msg{width:90%;margin:10px auto;font-weight:bold;font-size:16px;text-align:center;background-color:#fff;border:1px solid #c8cfd8;color:#344459;border-radius:5px;padding:7px;}
.fail{border-color:#f99ea3;color:#ff0715;}
.success{border-color:#6aa766;color:#4a901f;}
</style>
<div class='msg $success_fail'>
".$re1."
<div class='text_msg'>".$text."</div></div>";
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
$path='images/products/'.$pic;
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


}