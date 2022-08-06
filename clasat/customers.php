<?php

class customers {


/**
 * فورم اضافة زبون جديد
 *@param $mysqli mysqli connector
 */
function add_customer_form($mysqli) {
$area_sale=$this->get_areas_salesman($mysqli,1,1,1);
echo "
<style>.customer_auto_search_name{width: 46%;margin:0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['add_customer']."</div>
    <div class='form_main_inputs'>
        <form action='customers.php?conn=add-customer-save' method='post'>
            <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='customer_name' placeholder='".langu['customer_name']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['area']."</div><div class='form_input_input'>".$area_sale['area']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['full_address']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='customer_address' placeholder='".langu['full_address']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['telephone']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='customer_tel' placeholder='".langu['telephone']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['is_it']."</div><div class='form_input_input'><input type='radio' name='is_main_branch' id='is_main' value='0' onchange='show_hide_branch_search()' checked>".langu['is_main']." <input type='radio' name='is_main_branch' id='is_branch' value='' onchange='show_hide_branch_search()'>".langu['is_branch']."</div></div>
            <div class='form_input_line' id='search_main' style='display:none;'><div class='form_input_name'>".langu['main_customer']."</div><div class='form_input_input' id='name_search2'><input type='text' autocomplete='off' name='customer_name_search2' id='customer_name_search2' placeholder='".langu['customer_name']."' value='' oninput='search_customer_name2()'></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['balance']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='customer_balance' placeholder='".langu['balance']."' value='0' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['salesman']."</div><div class='form_input_input'>".$area_sale['sales']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['visit_day']."</div><div class='form_input_input'>".$area_sale['days']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['notes']."</div><div class='form_input_input'><textarea name='customer_notes'></textarea></div></div>
            <div class='form_input_line' style='margin:45px auto;'><input type='submit' value='".langu['add_customer']."'></div>
        </form>
    </div>
</div>
";
}

/**
 *حفظ بيانات اضافة زبون جديد في قاعدة البيانات
 *@param $mysqli mysqli connector
 */
function add_customer_save($mysqli) {

if($s=$mysqli->prepare("INSERT INTO customers (main_id,name, area_id, full_address, telephone, sales_man_id, balance, visit_day,notes) VALUES (?,?,?,?,?,?,?,?,?)")){
@$s->bind_param("isissidis",intval($_POST['is_main_branch']),htmlentities($_POST['customer_name']),intval($_POST['select_area']),htmlentities($_POST['customer_address']),htmlentities($_POST['customer_tel']),intval($_POST['select_salesman']), floatval($_POST['customer_balance']),intval($_POST['select_visit_day']),htmlentities($_POST['customer_notes']));
$s->execute();
$ma[0]=langu['add_customer_success'];
$ma[1]=3;
return $ma;
}
else{$ma[0]=langu['add_customer_fail'];$ma[1]=0;return $ma;}
}

/**
 *حفظ  تعديل البيانات للزبون في قاعدة البيانات
 *@param $mysqli mysqli connector
 */
function update_customer_save($mysqli) {

if($s=$mysqli->prepare("update customers set main_id=?,name=?,area_id=?,full_address=?,telephone=?,sales_man_id=?,balance=?,visit_day=?,notes=? where id=?")){
@$s->bind_param("isissidisi",intval($_POST['is_main_branch']),htmlentities($_POST['customer_name']),intval($_POST['select_area']),htmlentities($_POST['customer_address']),htmlentities($_POST['customer_tel']),intval($_POST['select_salesman']),floatval($_POST['customer_balance']),intval($_POST['select_visit_day']), htmlentities($_POST['customer_notes']),intval($_POST['c_id']));
$s->execute();
$ma[0]=langu['update_customer_success'];
$ma[1]=3;
return $ma;
}
else{$ma[0]=langu['update_customer_fail'];$ma[1]=0;return $ma;}
}

/**
 *فورم جلب الزبائن حسب اليوم والمندوب
 */
function search_customer_form($mysqli) {
$area_sale=$this->get_areas_salesman($mysqli,null,1,1);
echo "
<div class='customer_search'>
    <div class='customer_search_name'>".langu['search_customer']."</div>
    <div class='customer_search_show'>
        <p class='no_print' style='color:red;margin:0 12px;'>".langu['note']." : ".langu['customer_balance_note']." .</p>
    <div class='product_search_type no_print'>
    <div class='product_search_select no_print'><input type='text' autocomplete='off' name='customer_name_search' id='customer_name_search' placeholder='".langu['customer_name']."' value=''></div>
    </div>
        <div class='customer_search_select'>".$area_sale['sales']." ".$area_sale['days']."</div>
    </div>
    <div class='form_input_line' style='margin:15px auto;'><div class='hide_show nprint' style='' onclick='window.print()'>".langu['print']."</div></div>
</div>";
}
/**
 *فورم جلب الزبائن حسب اليوم والمندوب
 */
function statment_customer_form($mysqli) {
/*            <div class='form_input_line' id='monthly' style='display:none;'><div class='form_input_name'></div><div class='form_input_input' style='display:flex;'>".$my['month']." ".$my['year']."</div></div>*/
$year=$this->get_select_month_year('yearly');
$my=$this->get_select_month_year('monthly','monthly');
echo "<style>.customer_auto_search_name{width: 46%;margin:0;}</style>
<div class='form_main'>
    <div class='form_main_name'>".langu['statement_customers']."</div>

    <div class='form_main_inputs'>
            <div class='form_input_line'><div class='form_input_name'>".langu['customer_name']."</div><div class='form_input_input' id='search_customer'><input type='text' autocomplete='off' name='search_customer_name' id='search_customer_name' placeholder='".langu['customer_name']."' value='' oninput='check_customer_search()' /></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['statement']."</div><div class='form_input_input'><input type='radio' name='monthly_yearly' id='is_yearly' value='0' onchange='monthly_yearly()'>".langu['yearly']." <input type='radio' name='monthly_yearly' id='is_monthly' value='1' onchange='monthly_yearly()'>".langu['monthly']."</div></div>
            <div class='form_input_line' id='yearly' style='display:none;'><div class='form_input_name'></div><div class='form_input_input' style='display:flex;'>".$year['year']."</div></div>
            <div class='form_input_line monthly' style='display:none;'><div class='form_input_name'>".langu['from']."</div><div class='form_input_input' style='display:flex;'><input class='date_input' type='text' autocomplete='off' id='date1' name='date1' placeholder='".langu['date']."' value='' required></div></div>
            <div class='form_input_line monthly' style='display:none;'><div class='form_input_name'>".langu['to']."</div><div class='form_input_input' style='display:flex;'><input class='date_input' type='text' autocomplete='off' id='date2' name='date2' placeholder='".langu['date']."' value='' required></div></div>
    <div class='form_input_line' style='margin:50px auto;'><a style='margin:10px auto;' id='statment_print' href='printbills.php' target='_blank'>".langu['statement']."</a></div>
            <input type='hidden' name='customer_id' id='customer_id' value='' />
    </div>
</div>";
}

/**
 *جلب المناطق والمندوبين
 *@param $area if 1 get areas
 *@param $salesman if 1 get salesman
 *@param $days if 1 get visit days
 *@return array 'area','sales','days'
 */
function get_areas_salesman($mysqli,$area=null,$salesman=null,$days=null){
$ma=array();

if($area==1){
$q=$mysqli->query('select * from areas');


$ma['area']="<select id='select_area' name='select_area' required>
<option value='' disabled selected>".langu['selectarea']."</option>";
while ($row=$q->fetch_assoc()) {
$ma['area'].="<option value='".$row['id']."'>".$row['name']."</option>";
}
$ma['area'].="</select>";
}

if($salesman==1){
$q=$mysqli->query('select id,name from employees where employee_type=1');
$ma['sales']="<select id='select_salesman' name='select_salesman' required>
<option value='' disabled selected>".langu['selectsales']."</option>";
while ($row=$q->fetch_assoc()) {
$ma['sales'].="<option value='".$row['id']."'>".$row['name']."</option>";
}
$ma['sales'].="</select>";
}

if($days==1){
$ma['days']="
<select id='select_visit_day' name='select_visit_day' required>
    <option value='' disabled selected>".langu['selectday']."</option>
    <option value='0'>".langu['sunday']."</option>
    <option value='1'>".langu['monday']."</option>
    <option value='2'>".langu['tuesday']."</option>
    <option value='3'>".langu['wednesday']."</option>
    <option value='4'>".langu['thursday']."</option>
    <option value='5'>".langu['friday']."</option>
    <option value='6'>".langu['saturday']."</option>
    <option value='8'>".langu['all_days']."</option>
</select>";
}

return $ma;
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
