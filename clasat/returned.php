<?php
include_once 'clasat/bills.php';
class returned extends bills{
/**
* قائمة الفواتير غير المرحلة
* @param type $mysqli
*/
function show_temp_bill($mysqli){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['returned_products']."</div>
    <div class='form_main_inputs' style='width:95%;'>
        <div class='bill_list_main'>";

$q=$mysqli->query('SELECT returned_products.*,customers.name as customer_name,employees.name as sale_name,areas.name as area FROM returned_products,customers,employees,areas where returned_products.is_temp=1 and returned_products.sales_man_id=employees.id and returned_products.customer_id=customers.id and customers.area_id=areas.id');
if($q->num_rows>0){
echo "
    <table class='products_list'>
            <tr class='table_head'>
                <th class='no_print'><input id='selectall' type='checkbox' onclick='select_deselect_all()' value=''/></th>
                <th>".langu['customer_name']."</th>
                <th class='no_print'></th>
                <th>".langu['salesman']."</th>
                <th>".langu['area']."</th>
                <th>".langu['bill_total']."</th>
                <th class='no_print'></th> 
                <th class='no_print'></th>
            </tr>";
while ($row=$q->fetch_assoc()){

echo "
    <tr class='show_hide'>
        <td class='no_print'><span class='no_print'><input class='saveit' name='saveit' type='checkbox' value='".$row['id']."'/></span></td>
        <td class='nume'>".$row['customer_name']."</td>
        <td class='products_list_symbol' onClick='login_modal(\"".langu['save_temp']."\",\"ajaxbills.php?update_temp_bills=ret-save&id=".$row['id']."\")'>✔</td>
        <td class='nume'>".$row['sale_name']."</td>
        <td>".$row['area']."</td>
        <td class='nume'>".$row['total']."</td>
        <td class='products_list_symbol'><a href='returned.php?conn=edit_bill&id=".$row['id']."'></a></td>
        <td class='delete_symbol' onClick='remove_returned_temp_bill(".$row['id'].")'></td>
    </tr>";
}
echo '</table>';
}

else{echo "<div class='no_bills'>".langu['no_temp_returned_products']."</div>";}
echo"
        </div>
    </div>
        <div class='form_input_line' style='margin:15px auto;'><div class='hide_show nprint' style='' onclick='save_select_temp(\"saveit\",\"ajaxbills.php?update_temp_bills=ret-save&id=\")'>".langu['save_temp']."</div><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
</div>
";
}

/**
*تعديل فورم فاتورة
*/
function edit_returned_form($mysqli){
$row=$mysqli->query('SELECT returned_products.*,customers.name as customer_name,employees.product_price FROM returned_products,customers,employees where returned_products.id='.intval($_GET['id']).' and returned_products.customer_id=customers.id and customers.sales_man_id=employees.id');
$row=$row->fetch_assoc();

$pr=unserialize($row['products']);
$num=$pr['product_nums'];
$products=$this->get_products_from_array($pr);
echo "
<div class='form_main'>
    <form action='returned.php?conn=bill-save' method='post' enctype='multipart/form-data'>
<div class='form_main_name'>".langu['add_returned_products']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['date']."</div><div class='form_input_input' id='search_date'><input type='text' id='bill_date' name='bill_date' autocomplete='off' placeholder='".langu['bill_date']."' value='".$row['date']."' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='customer_search'><input type='text' id='customer_name' name='customer_name' autocomplete='off' placeholder='".langu['customer_name']."' value='".$row['customer_name']."' required></div></div>
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
            <input type='hidden' name='customer_id' id='customer_id' value='".$row['customer_id']."' />
            <input type='hidden' name='bill_id' id='bill_id' value='".$row['id']."' />
            <input type='hidden' name='bill_price' id='bill_price' value='".$row['product_price']."' />
            <input type='hidden' name='bill_product_nums' id='bill_product_nums' value='".$num."' />
            <input type='hidden' id='bill_balance' name='bill_balance' value='".$row['total']."' />
    </form>
</div>";
}

/**
* حفظ الفاتورة المضافة في الفواتير الغير مرحلة
*@param $mysqli
*/
function save_edit_temp($mysqli){
$num=intval($_POST['bill_product_nums']);
$date=$_POST['bill_date'];
$a=array();
$total=$_POST['bill_balance'];
$profit_all=0;
$a['customer_id']=intval($_POST['customer_id']);
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
$a['pr'.$i]['sale_price']=$_POST['product_sale_price'.$i];
$a['pr'.$i]['is_offer']=$_POST['product_offer'.$i];
}
$a=serialize($a);



if($s=$mysqli->prepare("update returned_products set products=?,customer_id=?,total=?,date=? where id=?")){
@$s->bind_param("siisi",$a,intval($_POST['customer_id']),$total,$date,intval($_POST['bill_id']));
$s->execute();
$ma[0]=langu['edit_bill_success'];
$ma[1]=3;

return $ma;
}
else{$ma[0]=langu['edit_bill_fail'];$ma[1]=0;return $ma;}

}


function returned_search($mysqli){
$sales=$this->get_select_saleman($mysqli,"onchange='search_returned_sale()'");
echo "
<div class='form_main'>
<div class='form_main_name'>".langu['search_returned_products']."</div>

    <div class='form_main_inputs'>
        <div class='form_input_line'><div class='form_input_name'>".langu['num']." ".langu['returned_order']."</div><div class='form_input_input' id='search_num'><input type='text' id='bill_num_search' oninput='search_bill_num()' autocomplete='off' placeholder='".langu['num']." ".langu['returned_order']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['date']." ".langu['returned_order']."</div><div class='form_input_input' id='search_date'><input type='text' id='bill_date' onchange='search_returned_date()' autocomplete='off' placeholder='".langu['date']." ".langu['returned_order']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_name'><input type='text' id='bill_customer_search2' autocomplete='off' placeholder='".langu['customer_name']."' value='' required></div></div>
        <div class='form_input_line'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'>".$sales."</div></div>
    </div>
    <div class='form_main_name'>".langu['returned_products']."</div>
    <div class='bill_list_show'>

    </div>
</div>";
}

}