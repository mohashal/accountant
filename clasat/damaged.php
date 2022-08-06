<?php

class damaged {

/**
* جميع البضائع التالفة
*/
function  all_damaged($mysqli){
$total=0;
$q=$mysqli->query('select * from products where damaged <> 0');
if($q->num_rows>0){
$ma="<div class='form_main_inputs'>
        <table class='main_table'>
            <tr>
                <th>".langu['num']."</th>
                <th>".langu['product_name']."</th>
                <th>".langu['product_quantity']."</th>
                <th>".langu['product_our_price']."</th>
                <th class='no_print'>".langu['edit']."</th>
            </tr>
";
while ($row=$q->fetch_assoc()){
$total+=$row['damaged'];
$ma.="<tr>
        <td class='nume'>".$row['id2']."</td>
        <td class='nume'>".$row['name']."</td>
        <td class='nume'>".$row['damaged']."</td>
        <td class='nume'>".$row['our_price']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit_damaged']."\",\"ajax_html.php?damaged=edit-form-damaged&id=".$row['id']."&name=".$row['name']."&quan=".$row['damaged']."\",1)'></td>
      </tr>";
}
$ma.="
      <tr>
        <td>".langu['final_total']."</td>
        <td></td>
        <td class='nume'>".$total."</td>
        <td></td>
        <td class='no_print'></td>
      </tr>
</table></div>";
}

else{$ma="<div class='no_resault'>".langu['no_damaged_products']."</div>";}
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['damaged_products']."</div>
<div class='add_element no_print' onclick='mymodalbox(\"".langu['add_new_damaged']."\",\"ajax_html.php?damaged=add-damaged\",1)'><span> + </span>".langu['add_new_damaged']."</div>
    ".$ma."
</div>";
}

}