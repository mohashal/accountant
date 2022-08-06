<?php

class offers {
/**
 *اضافة عرض جديد
 */
function add_offer_form(){

echo "
<div class='form_main'>
    <form action='offers.php?conn=save_new_offer' method='post' enctype='multipart/form-data'>
    <div class='form_main_name'>".langu['add_offer']."</div>
    <div class='form_main_inputs'>
            <div class='bills_date'><div class='form_input_name'>".langu['offer_name']."</div><div class='form_input_input'><input type='text' id='offer_name' name='offer_name' autocomplete='off' placeholder='".langu['offer_name']."' value='' required></div></div>
    </div>
    <div class='bill_product_show'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line no_print'>
                <div class='form_input_name' id='search_product_num'><input type='text' id='bill_product_search_num' placeholder='".langu['product_num']."' value='' autocomplete='off'></div>
                <div class='form_input_input' id='search_product_name'><input type='text' id='bill_product_search' autocomplete='off' placeholder='".langu['product_name']."' value=''></div>
                <div class='form_input_name' style='margin-right:23px;margin-top:-1px' id='search_product_barcode'><input type='text' id='bill_product_search_barcode' placeholder='".langu['barcode']."' value='' autocomplete='off'></div>
            </div>
        </div>
        <div class='bill_form_products'>
            <table class='products_list'>
                <tr class='table_head'><th class='no_print'></th><th>".langu['product_num']."</th><th>".langu['product_name']."</th><th>".langu['product_quantity']."</th><th>".langu['unit']."</th><th>".langu['price']."</th><th>".langu['bonus']."</th><th>".langu['total']."</th></tr>
            </table>
        </div>
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>0</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add_offer']."'></div>
            <input type='hidden' name='bill_price' id='bill_price' value='our_price' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='0' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='' />

    </form>
</div>
";
}

function edit_offer_form($mysqli){
$id=intval($_GET['id']);
$q=$mysqli->query('select * from offers where id='.$id);
$row=$q->fetch_assoc();

$pr=unserialize($row['products']);
$num=$pr['product_nums'];
$products=$this->get_products_from_array($pr);
echo "
<div class='form_main'>
    <form action='offers.php?conn=save_edit_offer' method='post' enctype='multipart/form-data'>
    <div class='form_main_name'>".langu['edit_offer']."</div>
    <div class='form_main_inputs'>
            <div class='bills_date'><div class='form_input_name'>".langu['offer_name']."</div><div class='form_input_input'><input type='text' id='offer_name' name='offer_name' autocomplete='off' placeholder='".langu['offer_name']."' value='".$row['name']."' required></div></div>
    </div>
    <div class='bill_product_show'>
        <div class='form_main_name'>".langu['products']."</div>
        <div class='form_main_inputs'>
            <div class='form_input_line no_print'>
                <div class='form_input_name' id='search_product_num'><input type='text' id='bill_product_search_num' placeholder='".langu['product_num']."' value='' autocomplete='off'></div>
                <div class='form_input_input' id='search_product_name'><input type='text' id='bill_product_search' autocomplete='off' placeholder='".langu['product_name']."' value=''></div>
                <div class='form_input_name' style='margin-right:23px;margin-top:-1px' id='search_product_barcode'><input type='text' id='bill_product_search_barcode' placeholder='".langu['barcode']."' value='' autocomplete='off'></div>
            </div>
        </div>
        <div class='bill_form_products'>
            <table class='products_list'>
                <tr><th class='no_print'></th><th>".langu['product_num']."</th><th>".langu['product_name']."</th><th>".langu['product_quantity']."</th><th>".langu['unit']."</th><th>".langu['price']."</th><th>".langu['bonus']."</th><th>".langu['total']."</th></tr>
            ".$products."
            </table>
        </div>
        <div class='form_input_line' style='width:100%;border-top:1px solid #c8cfd8;'><div class='form_input_name'>".langu['final_total']."</div><div class='form_input_input nume' id='show_final_total'>".$pr['balance']."</div></div>
    </div>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['edit_offer']."'></div>
            <input type='hidden' name='bill_price' id='bill_price' value='our_price' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='".$num."' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='".$pr['balance']."' />
            <input type='hidden' id='bill_balance' name='offer_id' value='".$id."' />

    </form>
</div>
";
}

/**
*حفظ العرض الجديد
 */
function save_new_offer($mysqli){
$num=intval($_POST['bill_product_nums']);
$a=array();
$a['product_nums']=$num;
$a['balance']=$_POST['bill_balance'];
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
$a['pr'.$i]['is_offer']=1;
}
$a=serialize($a);



if($s=$mysqli->prepare("INSERT INTO offers (products,name) VALUES (?,?)")){
@$s->bind_param("ss",$a,htmlentities($_POST['offer_name']));
$s->execute();
$ma[0]=langu['add_offer_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['add_offer_fail'];$ma[1]=0;return $ma;}

}

function save_edit_offer($mysqli){
$num=intval($_POST['bill_product_nums']);
$a=array();
$a['product_nums']=$num;
$a['balance']=$_POST['bill_balance'];
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
$a['pr'.$i]['is_offer']=1;
}
$a=serialize($a);



if($s=$mysqli->prepare("update offers set products=?,name=? where id=".intval($_POST['offer_id']))){
@$s->bind_param("ss",$a,htmlentities($_POST['offer_name']));
$s->execute();
$ma[0]=langu['edit_offer_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['edit_offer_fail'];$ma[1]=0;return $ma;}

}

/**
 *جلب البضائع من المصفوفة
 */
function get_products_from_array($a){
$product='';
for($num=1;$num<=$a['product_nums'];$num++){
$total=$a['pr'.$num]['price']*$a['pr'.$num]['quantity'];
$check='';
if($a['pr'.$num]['bonus']==1){$check=' checked';$total=0;}
$product.="
<tr id='product".$num."'>
	<input type='hidden' id='product_offer".$num."' name='product_offer".$num."' value='1'/>
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
 * جلب جميع العروض
 */
function show_offers($mysqli){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['employees']."</div>
    <div class='add_element'><a href='offers.php?conn=add_offer'><span> + </span>".langu['add_offer']."</a></div>
    <table class='main_table'>
        <tr>
            <th>".langu['offer_name']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";
$type=['1'=>langu['salesman3'],'2'=>langu['driver2'],'3'=>langu['employee']];
$q=$mysqli->query("select * from offers");
while($row=$q->fetch_assoc()){
echo "<tr>
        <td>".$row['name']."</td>
        <td class='edit_symbol'><a href='offers.php?conn=edit_offer&id=".$row['id']."'></a></td>
        <td class='delete_symbol' onclick='remove_offer(".$row['id'].")'></td>
      </tr>
";
}

echo "</table></div>";
}

}
