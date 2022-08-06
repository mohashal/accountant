<?php

class merchants {
/**
*اضافة فورم فاتورة
*/
function add_bill_form(){
echo "
<div class='form_main'>
    <form action='merchants.php?conn=add-bill-save' method='post' enctype='multipart/form-data'>
<div class='form_main_name'>".langu['add_bill']." ".langu['from']." ".langu['merchant']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_num']." ".langu['from']." ".langu['merchant2']."</div><div class='form_input_input'><input type='text' id='bill_num' name='bill_num' autocomplete='off' placeholder='".langu['bill_num']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_date']."</div><div class='form_input_input' id='search_date'><input type='text' id='bill_date' name='bill_date' autocomplete='off' placeholder='".langu['bill_date']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' id='merchant_name' name='merchant_name' autocomplete='off' placeholder='".langu['merchant_name']."' value='' required></div></div>
    </div>
    <div class='bill_product_show' style='display:none;'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line'>
                <div class='form_input_name' id='search_product_num'><input type='text' id='bill_product_search_num' placeholder='".langu['product_num']."' value='' autocomplete='off'></div>
                <div class='form_input_input' id='search_product_name'><input type='text' id='bill_product_search' autocomplete='off' placeholder='".langu['product_name']."' value=''></div>
                <div class='form_input_name' style='margin-right:23px;margin-top:-1px' id='search_product_barcode'><input type='text' id='bill_product_search_barcode' placeholder='".langu['barcode']."' value='' autocomplete='off'></div>
            </div>
        </div>
        <div class='bill_form_products'>
            <table class='products_list'>
                <tr class='table_head'><th></th><th>".langu['product_num']."</th><th>".langu['product_name']."</th><th>".langu['product_quantity']."</th><th>".langu['unit']."</th><th>".langu['price']."</th><th>".langu['bonus']."</th><th>".langu['total']."</th></tr>
            </table>
        </div>
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>0</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add_bill']."'></div>
            <input type='hidden' name='merchant_id' id='merchant_id' value='' />
            <input type='hidden' name='bill_price' id='bill_price' value='our_price' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='0' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='' />
    </form>
</div>";
}

/**
*تعديل فورم فاتورة
*/
function edit_bill_form($mysqli){
$row=$mysqli->query('SELECT merchant_invoice.*,merchants.name as merchant_name FROM merchant_invoice,merchants where merchant_invoice.id='.intval($_GET['id']).' and merchant_invoice.merchant_id=merchants.id');
$row=$row->fetch_assoc();

$pr=unserialize($row['products']);
$num=$pr['product_nums'];
$products=$this->get_products_from_array($pr);
echo "
<div class='form_main'>
    <form action='merchants.php?conn=edit-bill-save' method='post' enctype='multipart/form-data'>
<div class='form_main_name'>".langu['add_bill']." ".langu['from']." ".langu['merchant']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_num']." ".langu['from']." ".langu['merchant2']."</div><div class='form_input_input'><input type='text' id='bill_num' name='bill_num' autocomplete='off' placeholder='".langu['bill_num']."' value='".$row['bill_num']."' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_date']."</div><div class='form_input_input' id='search_date'><input type='text' id='bill_date' name='bill_date' autocomplete='off' placeholder='".langu['bill_date']."' value='".$row['date']."' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' id='merchant_name' name='merchant_name' autocomplete='off' placeholder='".langu['merchant_name']."' value='".$row['merchant_name']."' required></div></div>
    </div>
    <div class='bill_product_show'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' id='search_product_num'><input type='text' id='bill_product_search_num' placeholder='".langu['product_num']."' value='' autocomplete='off'></div><div class='form_input_input' id='search_product_name'><input type='text' id='bill_product_search' autocomplete='off' placeholder='".langu['product_name']."' value=''></div></div>
        </div>
        <div class='bill_form_products'>
            <table class='products_list'>
                <tr class='table_head'><th></th><th>".langu['product_num']."</th><th>".langu['product_name']."</th><th>".langu['product_quantity']."</th><th>".langu['unit']."</th><th>".langu['price']."</th><th>".langu['bonus']."</th><th>".langu['total']."</th></tr>
                ".$products."
            </table>
        </div>
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>".$row['total']."</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit_bill']."'></div>
            <input type='hidden' name='merchant_id' id='merchant_id' value='".$row['merchant_id']."' />
            <input type='hidden' name='bill_id' id='bill_id' value='".$row['id']."' />
            <input type='hidden' name='bill_price' id='bill_price' value='our_price' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='".$num."' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='".$row['total']."' />
    </form>
</div>";
}

/**
* حفظ الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function bill_save_temp($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=$_POST['bill_date'];
$a=array();
$total=$_POST['bill_balance'];
$profit_all=0;
$a['merchant_id']=intval($_POST['merchant_id']);
$a['bill_price']=$_POST['bill_price'];
$a['balance']=$total;
$a['product_nums']=$num;
for($i=1;$i<=$num;$i++){
if(isset($_POST['product_bonus'.$i])&&$_POST['product_bonus'.$i]==1){$bonus=1;}
else{$bonus=0;}


$a['pr'.$i]['id']=$_POST['product_id'.$i];
$a['pr'.$i]['ids']=$_POST['product_ids'.$i];
$a['pr'.$i]['unit']=$_POST['product_unit'.$i];
$a['pr'.$i]['name']=$_POST['product_name'.$i];
$a['pr'.$i]['quantity']=$_POST['product_quantity'.$i];
$a['pr'.$i]['our_price']=$_POST['product_our_price'.$i];
$a['pr'.$i]['price']=$_POST['product_price'.$i];
$a['pr'.$i]['bonus']=$bonus;
$a['pr'.$i]['is_offer']=$_POST['product_offer'.$i];
}
$a=serialize($a);



if($s=$mysqli->prepare("INSERT INTO merchant_invoice (products,merchant_id,total,date,bill_num) VALUES (?,?,?,?,?)")){
@$s->bind_param("sidss",$a,intval($_POST['merchant_id']),$total,$date,htmlentities($_POST['bill_num']));
$s->execute();
$ma[0]=langu['add_bill_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['add_bill_fail'];$ma[1]=0;return $ma;}

}


/**
* حفظ الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function bill_save_edit_temp($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=$_POST['bill_date'];
$a=array();
$total=$_POST['bill_balance'];
$profit_all=0;
$a['merchant_id']=intval($_POST['merchant_id']);
$a['bill_price']=$_POST['bill_price'];
$a['balance']=$total;
$a['product_nums']=$num;
for($i=1;$i<=$num;$i++){
if(isset($_POST['product_bonus'.$i])&&$_POST['product_bonus'.$i]==1){$bonus=1;}
else{$bonus=0;}


$a['pr'.$i]['id']=$_POST['product_id'.$i];
$a['pr'.$i]['ids']=$_POST['product_ids'.$i];
$a['pr'.$i]['unit']=$_POST['product_unit'.$i];
$a['pr'.$i]['name']=$_POST['product_name'.$i];
$a['pr'.$i]['quantity']=$_POST['product_quantity'.$i];
$a['pr'.$i]['our_price']=$_POST['product_our_price'.$i];
$a['pr'.$i]['price']=$_POST['product_price'.$i];
$a['pr'.$i]['bonus']=$bonus;
$a['pr'.$i]['is_offer']=$_POST['product_offer'.$i];
}
$a=serialize($a);



if($s=$mysqli->prepare("update merchant_invoice set products=?,merchant_id=?,total=?,date=?,bill_num=? where id=?")){
@$s->bind_param("sidssi",$a,intval($_POST['merchant_id']),$total,$date,htmlentities($_POST['bill_num']),intval($_POST['bill_id']));
$s->execute();
$ma[0]=langu['edit_bill_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['edit_bill_fail'];$ma[1]=0;return $ma;}

}

function add_retbill_form(){
echo "
<div class='form_main'>
    <form action='merchants.php?conn=add-retbill-save' method='post' enctype='multipart/form-data'>
<div class='form_main_name'>".langu['add_returned_to_merchant']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_date']."</div><div class='form_input_input' id='search_date'><input type='text' id='bill_date' name='bill_date' autocomplete='off' placeholder='".langu['bill_date']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' id='merchant_name' name='merchant_name' autocomplete='off' placeholder='".langu['merchant_name']."' value='' required></div></div>
    </div>
    <div class='bill_product_show' style='display:none;'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' id='search_product_num'><input type='text' id='bill_product_search_num' placeholder='".langu['product_num']."' value='' autocomplete='off'></div><div class='form_input_input' id='search_product_name'><input type='text' id='bill_product_search' autocomplete='off' placeholder='".langu['product_name']."' value=''></div></div>
        </div>
        <div class='bill_form_products'>
            <table class='products_list'>
                <tr class='table_head'><th></th><th>".langu['product_num']."</th><th>".langu['product_name']."</th><th>".langu['product_quantity']."</th><th>".langu['unit']."</th><th>".langu['price']."</th><th>".langu['bonus']."</th><th>".langu['total']."</th></tr>
            </table>
        </div>
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>0</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add_bill']."'></div>
            <input type='hidden' name='merchant_id' id='merchant_id' value='' />
            <input type='hidden' name='bill_price' id='bill_price' value='our_price' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='0' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='' />
    </form>
</div>";
}

/**
*تعديل فورم فاتورة
*/
function edit_retbill_form($mysqli){
$row=$mysqli->query('SELECT merchant_returned.*,merchants.name as merchant_name FROM merchant_returned,merchants where merchant_returned.id='.intval($_GET['id']).' and merchant_returned.merchant_id=merchants.id');
$row=$row->fetch_assoc();

$pr=unserialize($row['products']);
$num=$pr['product_nums'];
$products=$this->get_products_from_array($pr);
echo "
<div class='form_main'>
    <form action='merchants.php?conn=edit-retbill-save' method='post' enctype='multipart/form-data'>
<div class='form_main_name'>".langu['add_bill']." ".langu['from']." ".langu['merchant']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_date']."</div><div class='form_input_input' id='search_date'><input type='text' id='bill_date' name='bill_date' autocomplete='off' placeholder='".langu['bill_date']."' value='".$row['date']."' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' id='merchant_name' name='merchant_name' autocomplete='off' placeholder='".langu['merchant_name']."' value='".$row['merchant_name']."' required></div></div>
    </div>
    <div class='bill_product_show'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name' id='search_product_num'><input type='text' id='bill_product_search_num' placeholder='".langu['product_num']."' value='' autocomplete='off'></div><div class='form_input_input' id='search_product_name'><input type='text' id='bill_product_search' autocomplete='off' placeholder='".langu['product_name']."' value=''></div></div>
        </div>
        <div class='bill_form_products'>
            <table class='products_list'>
                <tr class='table_head'><th></th><th>".langu['product_num']."</th><th>".langu['product_name']."</th><th>".langu['product_quantity']."</th><th>".langu['unit']."</th><th>".langu['price']."</th><th>".langu['bonus']."</th><th>".langu['total']."</th></tr>
                ".$products."
            </table>
        </div>
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>".$row['total']."</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit_bill']."'></div>
            <input type='hidden' name='merchant_id' id='merchant_id' value='".$row['merchant_id']."' />
            <input type='hidden' name='bill_id' id='bill_id' value='".$row['id']."' />
            <input type='hidden' name='bill_price' id='bill_price' value='our_price' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='".$num."' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='".$row['total']."' />
    </form>
</div>";
}

/**
* حفظ الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function bill_save_rettemp($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=$_POST['bill_date'];
$a=array();
$total=$_POST['bill_balance'];
$profit_all=0;
$a['merchant_id']=intval($_POST['merchant_id']);
$a['bill_price']=$_POST['bill_price'];
$a['balance']=$total;
$a['product_nums']=$num;
for($i=1;$i<=$num;$i++){
if(isset($_POST['product_bonus'.$i])&&$_POST['product_bonus'.$i]==1){$bonus=1;}
else{$bonus=0;}


$a['pr'.$i]['id']=$_POST['product_id'.$i];
$a['pr'.$i]['ids']=$_POST['product_ids'.$i];
$a['pr'.$i]['unit']=$_POST['product_unit'.$i];
$a['pr'.$i]['name']=$_POST['product_name'.$i];
$a['pr'.$i]['quantity']=$_POST['product_quantity'.$i];
$a['pr'.$i]['our_price']=$_POST['product_our_price'.$i];
$a['pr'.$i]['price']=$_POST['product_price'.$i];
$a['pr'.$i]['bonus']=$bonus;
$a['pr'.$i]['is_offer']=$_POST['product_offer'.$i];
}
$a=serialize($a);



if($s=$mysqli->prepare("INSERT INTO merchant_returned (products,merchant_id,total,date) VALUES (?,?,?,?)")){
@$s->bind_param("sids",$a,intval($_POST['merchant_id']),$total,$date);
$s->execute();
$ma[0]=langu['add_bill_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['add_bill_fail'];$ma[1]=0;return $ma;}

}


/**
* حفظ الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function bill_save_retedit_temp($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=$_POST['bill_date'];
$a=array();
$total=$_POST['bill_balance'];
$profit_all=0;
$a['merchant_id']=intval($_POST['merchant_id']);
$a['bill_price']=$_POST['bill_price'];
$a['balance']=$total;
$a['product_nums']=$num;
for($i=1;$i<=$num;$i++){
if(isset($_POST['product_bonus'.$i])&&$_POST['product_bonus'.$i]==1){$bonus=1;}
else{$bonus=0;}


$a['pr'.$i]['id']=$_POST['product_id'.$i];
$a['pr'.$i]['ids']=$_POST['product_ids'.$i];
$a['pr'.$i]['unit']=$_POST['product_unit'.$i];
$a['pr'.$i]['name']=$_POST['product_name'.$i];
$a['pr'.$i]['quantity']=$_POST['product_quantity'.$i];
$a['pr'.$i]['our_price']=$_POST['product_our_price'.$i];
$a['pr'.$i]['price']=$_POST['product_price'.$i];
$a['pr'.$i]['bonus']=$bonus;
$a['pr'.$i]['is_offer']=$_POST['product_offer'.$i];
}
$a=serialize($a);



if($s=$mysqli->prepare("update merchant_returned set products=?,merchant_id=?,total=?,date=? where id=?")){
@$s->bind_param("sidsi",$a,intval($_POST['merchant_id']),$total,$date,intval($_POST['bill_id']));
$s->execute();
$ma[0]=langu['edit_bill_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['edit_bill_fail'];$ma[1]=0;return $ma;}

}


/**
* قائمة الفواتير غير المرحلة
* @param type $mysqli
*/
function show_temp_bill($mysqli){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['temp_bill']." ".langu['from']." ".langu['merchants']."</div>
    <div class='form_main_inputs' style='width:95%;'>
        <div class='bill_list_main'>";

$q=$mysqli->query('SELECT merchant_invoice.*,merchants.name as merchant_name FROM merchant_invoice,merchants where merchant_invoice.is_temp=1 and merchant_invoice.merchant_id=merchants.id');
if($q->num_rows>0){
echo "
    <table class='products_list'>
            <tr>
                <th><input id='selectall' type='checkbox' onclick='select_deselect_all()' value=''/></th>
                <th></th>
                <th>".langu['bill_num']."</th>
                <th>".langu['merchant_name']."</th>
                <th>".langu['bill_total']."</th>
                <th></th>
                <th></th> 
            </tr>";
while ($row=$q->fetch_assoc()){

echo "
    <tr class='show_hide'>
        <td><span class='no_print'><input class='saveit' name='saveit' type='checkbox' value='".$row['id']."'/></span></td>
        <td class='del_product' onClick='remove_merchant_temp_bill(".$row['id'].")'></td>
        <td class='nume'>".$row['bill_num']."</td>
        <td>".$row['merchant_name']."</td>
        <td class='nume'>".$row['total']."</td>
        <td class='products_list_symbol'><a href='merchants.php?conn=edit_bill&id=".$row['id']."'></a></td>
        <td class='products_list_symbol' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?update_temp_bills=merchant-save&id=".$row['id']."\")'>✔</td>
    </tr>";
}
echo '</table>';
}

else{echo "<div class='no_bills'>".langu['no_orders']."</div>";}
echo"
        </div>
    </div>
        <div class='form_input_line' style='margin:15px auto;'><div class='hide_show nprint' style='' onclick='save_select_temp(\"saveit\",\"ajaxbills.php?update_temp_bills=merchant-save&id=\")'>".langu['save_temp']."</div><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
</div>
";
}

function show_rettemp_bill($mysqli){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['temp_returned_to_merchant']."</div>
    <div class='form_main_inputs' style='width:95%;'>
        <div class='bill_list_main'>";

$q=$mysqli->query('SELECT merchant_returned.*,merchants.name as merchant_name FROM merchant_returned,merchants where merchant_returned.is_temp=1 and merchant_returned.merchant_id=merchants.id');
if($q->num_rows>0){
echo "
    <table class='products_list'>
            <tr>
                <th><input id='selectall' type='checkbox' onclick='select_deselect_all()' value=''/></th>
                <th></th>
                <th>".langu['merchant_name']."</th>
                <th>".langu['bill_total']."</th>
                <th></th>
                <th></th> 
            </tr>";
while ($row=$q->fetch_assoc()){

echo "
    <tr class='show_hide'>
        <td><span class='no_print'><input class='saveit' name='saveit' type='checkbox' value='".$row['id']."'/></span></td>
        <td class='del_product' onClick='remove_merchant_rettemp_bill(".$row['id'].")'></td>
        <td>".$row['merchant_name']."</td>
        <td class='nume'>".$row['total']."</td>
        <td class='products_list_symbol'><a href='merchants.php?conn=edit_retbill&id=".$row['id']."'></a></td>
        <td class='products_list_symbol' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?update_temp_bills=retmerchant-save&id=".$row['id']."\")'>✔</td>
    </tr>";
}
echo '</table>';
}

else{echo "<div class='no_bills'>".langu['no_orders']."</div>";}
echo"
        </div>
    </div>
        <div class='form_input_line' style='margin:15px auto;'><div class='hide_show nprint' style='' onclick='save_select_temp(\"saveit\",\"ajaxbills.php?update_temp_bills=retmerchant-save&id=\")'>".langu['save_temp']."</div><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
</div>
";
}

/**
*استخراج البضائع من مصفوفة قاعدة البيانات
*@param $a unserialized array from database
*/
function get_products_from_array($a){
$product='';
for($num=1;$num<=$a['product_nums'];$num++){
$total=$a['pr'.$num]['price']*$a['pr'.$num]['quantity'];
$check='';
if($a['pr'.$num]['bonus']==1){$check=' checked';$total=0;}
$product.="
<tr id='product".$num."'>
	<input type='hidden' id='product_offer".$num."' name='product_offer".$num."' value='".$a['pr'.$num]['is_offer']."'/>
	<input type='hidden' id='product_id".$num."' name='product_id".$num."' value='".$a['pr'.$num]['id']."'/>
	<input type='hidden' id='product_ids".$num."' name='product_ids".$num."' value='".$a['pr'.$num]['ids']."'/>
	<input type='hidden' id='product_unit".$num."' name='product_unit".$num."' value='".$a['pr'.$num]['unit']."'/>
	<input type='hidden' id='product_our_price".$num."' name='product_our_price".$num."' value='".$a['pr'.$num]['our_price']."'/>
	<input type='hidden' id='product_name".$num."' name='product_name".$num."' value='".$a['pr'.$num]['name']."'/>
	<td class='del_product' id='del_pro".$num."' onclick='del_product(".$num.")'></td>
        <td class='nume'>".$a['pr'.$num]['ids']."</td>
        <td class='nume'>".$a['pr'.$num]['name']."</td>
	<td><input type='text' autocomplete='off' name='product_quantity".$num."' id='product_quantity".$num."' value='".$a['pr'.$num]['quantity']."' oninput='change_total(".$num.")' placeholder='".langu['product_quantity']."'/></td>
        <td>".$a['pr'.$num]['unit']."</td>
        <td id='pru".$num."'><input type='text' autocomplete='off' name='product_price".$num."' id='product_price".$num."' value='".$a['pr'.$num]['price']."' oninput='change_total(".$num.")' placeholder='".langu['price']."'/></td>
	<td><input type='checkbox' id='product_bonus".$num."' name='product_bonus".$num."' onchange='check_bonus(".$num.")' value='1'".$check."></td>
	<td class='nume' id='product_total".$num."'>$total</td>
</tr>";
}
return $product;
}

/**
 *فورم جلب الزبائن حسب اليوم والمندوب
 */
function statment_merchant_form($mysqli) {
/*            <div class='form_input_line' id='monthly' style='display:none;'><div class='form_input_name'></div><div class='form_input_input' style='display:flex;'>".$my['month']." ".$my['year']."</div></div>*/
$year=$this->get_select_month_year('yearly');
$my=$this->get_select_month_year('monthly','monthly');
echo "<style>.customer_auto_search_name{width: 46%;margin:0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['statement_merchant']."</div>

    <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' name='search_merchant_name' id='search_merchant_name' placeholder='".langu['merchant_name']."' value='' oninput='check_merchant_search()' /></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['statement']."</div><div class='form_input_input'><input type='radio' name='monthly_yearly' id='is_yearly' value='0' onchange='monthly_yearly()'>".langu['yearly']." <input type='radio' name='monthly_yearly' id='is_monthly' value='1' onchange='monthly_yearly()'>".langu['monthly']."</div></div>
            <div class='form_input_line' id='yearly' style='display:none;'><div class='form_input_name'></div><div class='form_input_input' style='display:flex;'>".$year['year']."</div></div>
            <div class='form_input_line monthly' style='display:none;'><div class='form_input_name'>".langu['from']."</div><div class='form_input_input' style='display:flex;'><input class='date_input' type='text' autocomplete='off' id='date1' name='date1' placeholder='".langu['date']."' value='' required></div></div>
            <div class='form_input_line monthly' style='display:none;'><div class='form_input_name'>".langu['to']."</div><div class='form_input_input' style='display:flex;'><input class='date_input' type='text' autocomplete='off' id='date2' name='date2' placeholder='".langu['date']."' value='' required></div></div>
    <div class='form_input_line' style='margin:50px auto;'><a style='margin:10px auto;' id='statment_print' href='printbills.php' target='_blank'>".langu['statement']."</a></div>
            <input type='hidden' name='merchant_id' id='merchant_id' value='' />
    </div>
</div>";
}

/**
*فورم البحث عن الفواتير
*/
function search_bill_form(){

echo "
<div class='form_main'>
<div class='form_main_name'>".langu['search_merchant_bill']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_num']."</div><div class='form_input_input' id='search_num'><input type='text' oninput='search_bill_num()' id='bill_num_search' autocomplete='off' placeholder='".langu['bill_num']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_date']."</div><div class='form_input_input' id='search_date'><input type='text' onchange='search_bills_date()' id='bill_date' autocomplete='off' placeholder='".langu['bill_date']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' id='merchant_name2' name='merchant_name2' autocomplete='off' placeholder='".langu['merchant_name']."' value='' required></div></div>
    </div>
    <div class='form_main_name'>".langu['bills']."</div>
    <div class='bill_list_show'>

    </div>
</div>";
}

function search_retbill_form(){

echo "
<div class='form_main'>
<div class='form_main_name'>".langu['search_retmerchant_bill']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_num']."</div><div class='form_input_input' id='search_num'><input type='text' oninput='search_retbill_num()' id='bill_num_search' autocomplete='off' placeholder='".langu['bill_num']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['bill_date']."</div><div class='form_input_input' id='search_date'><input type='text' onchange='search_retbills_date()' id='bill_date' autocomplete='off' placeholder='".langu['bill_date']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['merchant_name']."</div><div class='form_input_input' id='merchant_search'><input type='text' id='merchant_name3' name='merchant_name3' autocomplete='off' placeholder='".langu['merchant_name']."' value='' required></div></div>
    </div>
    <div class='form_main_name'>".langu['bills']."</div>
    <div class='bill_list_show'>

    </div>
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

}