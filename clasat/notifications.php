<?php

class notifications {

/**
 * اظهار جميع التنبيهات مع خاصيه الاضافة والتعديل والحذف
 * @param type $mysqli mysqli operator
 */
function show_all_notifications($mysqli){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['notifications']."</div>
    <div class='add_element' onclick='mymodalbox(\"".langu['adds']." ".langu['notification']."\",\"ajax_settings.php?notifications=add-form\",1)'><span> + </span>".langu['add_new_notification']."</div>
    <table class='main_table'>
        <tr>
            <th>".langu['show']."</th>
            <th>".langu['notification']."</th>
            <th>".langu['start_date']."</th>
            <th>".langu['end_date']."</th>
            <th>".langu['edit']."</th>
            <th>".langu['delete']."</th>
        </tr>
";

$q=$mysqli->query("select * from notifications order by end_date DESC");
$day=date('Y-m-d');
while($row=$q->fetch_assoc()){
    
if($row['end_date']>=$day){
echo "<tr>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['show']." ".langu['notification']."\",\"ajax_settings.php?notifications=show&id=".$row['id']."\",1)'>[</td>
        <td>".$row['name']."</td>
        <td class='nume'>".$row['start_date']."</td>
        <td class='nume'>".$row['end_date']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit']." ".langu['notification']."\",\"ajax_settings.php?notifications=edit-form&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_notify(".$row['id'].")'></td>
      </tr>
";
}
else{
echo "<tr style='background-color:rgba(255, 35, 0, 0.15);'>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['show']." ".langu['notification']."\",\"ajax_settings.php?notifications=show&id=".$row['id']."\",1)'>[</td>
        <td>".$row['name']."</td>
        <td class='nume'>".$row['start_date']."</td>
        <td class='nume'>".$row['end_date']."</td>
        <td class='edit_symbol' onclick='mymodalbox(\"".langu['edit']." ".langu['notification']."\",\"ajax_settings.php?notifications=edit-form&id=".$row['id']."\",1)'></td>
        <td class='delete_symbol' onclick='remove_notify(".$row['id'].")'></td>
      </tr>
";
}

}

echo "</table></div>";
}

}