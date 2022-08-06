<?php

class ajax_html {
/**
*فنكشن اضافة فورم عملة
*/
function add_form_damaged(){
echo "
<div class='form_main'>
    <form action='ajax_html.php?damaged=add_save_damage' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;' id='search_name'>".langu['product_name']."</div><div class='form_input_input' style='width:65%;'><input type='text' oninput='product_search()' autocomplete='off' id='product_name' name='product_name' placeholder='".langu['product_name']."' value='' required /></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;' id='search_num'>".langu['product_num']."</div><div class='form_input_input' style='width:65%;'><input type='text' oninput='product_search_num()' autocomplete='off' id='product_num' name='product_num' placeholder='".langu['product_num']."' value=''/></div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['damaged_product_qantitiy']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' id='product_quantity' name='product_quantity' placeholder='".langu['damaged_product_qantitiy']."' value='' required/></div></div>
            <input type='hidden' id='product_id' name='product_id' value='' required />
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add']." ".langu['damaged_product']."'></div>
        </div>
    </form>
</div>";
}

/**
*فنكشن حفظ البضاعة التالفة الجديدة في قاعدة البيانات
*/
function add_save_damaged($mysqli){
$id= intval($_POST['product_id']);
$quan= intval($_POST['product_quantity']);
$mysqli->query('update products set quantity=quantity-'.$quan.' ,damaged=damaged+'.$quan.' where id='.$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['add_damaged_success']);}
else{$this->msg('fail',langu['add_damaged_fail']);}
}
/*------------ تعديل كمية البضاعة التالفة ------------*/
function edit_form_damaged($mysqli){
echo "
<div class='form_main'>
    <form action='ajax_html.php?damaged=edit_save_damage' method='post'>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;' id='search_name'>".langu['product_name']."</div><div class='form_input_input nume' style='width:65%;'>".$_GET['name']."</div></div>
            <div class='form_input_line'><div class='form_input_name' style='width:35%;'>".langu['damaged_product_qantitiy']."</div><div class='form_input_input' style='width:65%;'><input type='text' autocomplete='off' id='product_quantity' name='product_quantity' placeholder='".langu['damaged_product_qantitiy']."' value='".intval($_GET['quan'])."' required/></div></div>
            <input type='hidden' id='product_id' name='product_id' value='".intval($_GET['id'])."' required />
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit']." ".langu['damaged_product']."'></div>
        </div>
    </form>
</div>";
}
/**
*فنكشن حفظ تعديل كمبية البضاعة التالفة
*/
function edit_save_damaged($mysqli){
$id= intval($_POST['product_id']);
$quan= intval($_POST['product_quantity']);
$mysqli->query('update products set damaged='.$quan.' where id='.$id);
if($mysqli->affected_rows>0){$this->msg('success',langu['edit_damaged_success']);}
else{$this->msg('fail',langu['edit_damaged_fail']);}
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

}