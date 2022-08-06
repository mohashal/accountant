<?php

class products {

/**
 * فورم اضافة بضاعة جديدة
 *@param $mysqli mysqli connector
 */
function add_product_form($mysqli,$ai) {
$unit_cat=$this->get_unit_cat($mysqli,1,1);
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['add_product']."</div>
    <div class='form_main_inputs'>
        <form action='products.php?conn=add-product-save' method='post' enctype='multipart/form-data'>
            <div class='form_input_line'><div class='form_input_name'>".langu['new_product_num']."</div><div class='form_input_input nume' style='line-height:33px;'>".$ai."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['product_name']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='product_name' placeholder='".langu['product_name']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['unit']."</div><div class='form_input_input'>".$unit_cat['unit']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['category']."</div><div class='form_input_input'>".$unit_cat['cat']."</div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['product_quantity']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='product_quantity' placeholder='".langu['product_quantity']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['product_our_price']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='product_our_price' placeholder='".langu['product_our_price']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['price']." n</div><div class='form_input_input'><input type='text' autocomplete='off' name='product_price1' placeholder='".langu['price']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['price']." f-a</div><div class='form_input_input'><input type='text' autocomplete='off' name='product_price2' placeholder='".langu['price']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['price']." t</div><div class='form_input_input'><input type='text' autocomplete='off' name='product_price3' placeholder='".langu['price']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['price']." f</div><div class='form_input_input'><input type='text' autocomplete='off' name='product_price4' placeholder='".langu['price']."' value='' required></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['cartoon_capicity']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='cartoon_capicity' placeholder='".langu['cartoon_capicity']."' value=''></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['barcode']."</div><div class='form_input_input'><input type='text' autocomplete='off' name='barcode' placeholder='".langu['barcode']."' value=''></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['barcode']." 2</div><div class='form_input_input'><input type='text' autocomplete='off' name='barcode2' placeholder='".langu['barcode']." 2' value=''></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['barcode']." 3</div><div class='form_input_input'><input type='text' autocomplete='off' name='barcode3' placeholder='".langu['barcode']." 3' value=''></div></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['colors']."</div><div class='form_input_input'><p class='add_color' onclick='add_color()'> + ".langu['add_color']."</p></div></div>
            <div id='colors'></div>
            <div class='form_input_line'><div class='form_input_name'>".langu['image']."</div><div class='form_input_input'><input type='file' name='product_image' id='product_image'></div></div>
            <input type='hidden' name='is_colors' id='is_colors' value='0'>
            <div class='form_input_line' style='margin:20px auto;'><input type='submit' value='".langu['add_product']."'></div>
        </form>
    </div>
</div>
";
}

/**
 *حفظ بيانات اضافة بضاعة جديد في قاعدة البيانات
 *@param $mysqli mysqli connector
 */
function add_product_save($mysqli) {
$is_color= intval($_POST['is_colors']);
$barcode=htmlentities($_POST['barcode']);
$barcode2='';
if($s=$mysqli->prepare("INSERT INTO products (name,barcode,barcode2,barcode3, unit_id, category_id,our_price,n_price,fa_price,t_price,f_price,quantity,cartoon_capicity) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)")){
@$s->bind_param("ssssiidddddii",htmlentities($_POST['product_name']),$barcode,htmlentities($_POST['barcode2']),htmlentities($_POST['barcode3']),intval($_POST['select_unit']),intval($_POST['select_category']),floatval($_POST['product_our_price']),floatval($_POST['product_price1']),floatval($_POST['product_price2']),floatval($_POST['product_price3']),floatval($_POST['product_price4']),intval($_POST['product_quantity']),intval($_POST['cartoon_capicity']));
$s->execute();
$ma[0]=langu['add_product_success'];
$ma[1]=3;
$last_id=$mysqli->insert_id;
$this->upload_image($last_id,'product_image');
$mysqli->query('update products set id2='.$last_id.' where id='.$last_id);

if($is_color>0){
$s=$mysqli->prepare("INSERT INTO products (id2,name,barcode,unit_id, category_id,our_price,n_price,fa_price,t_price,f_price,quantity,cartoon_capicity) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
for($i=1;$i<=$is_color;$i++){
if($_POST['color_barcode'.$i]!=''){$barcode2=$_POST['color_barcode'.$i];}
else{$barcode2=$barcode;}
@$s->bind_param("issiidddddii",$last_id,htmlentities($_POST['color_name'.$i]),$barcode2,intval($_POST['select_unit']),intval($_POST['select_category']),floatval($_POST['product_our_price']),floatval($_POST['product_price1']),floatval($_POST['product_price2']),floatval($_POST['product_price3']),floatval($_POST['product_price4']),intval($_POST['color_quan'.$i]),intval($_POST['cartoon_capicity']));
$s->execute();
}

}
return $ma;
}
else{$ma[0]=langu['add_product_fail'];$ma[1]=0;return $ma;}
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
$ma[0]=langu['update_product_success'];
$ma[1]=3;
//$this->upload_image($mysqli->insert_id,'product_image');
return $ma;
}
else{$ma[0]=langu['update_product_fail'];$ma[1]=0;return $ma;}
}

/**
*فنكشن البحث عن بضائع حسب التصنيف
*@param $mysqli connector
*/
function search_product_form($mysqli) {
$cat=$this->get_unit_cat($mysqli,null,1);
echo "
<div class='product_search'>
    <div class='product_search_name'>".langu['search_product']."</div>
    <div class='product_search_type'>
        <div class='product_search_title'>".langu['category']."</div><div class='product_search_select'>".$cat['cat']."</div>
    </div>
    <div class='product_search_type' id='search_num'>
        <div class='product_search_title'>".langu['product_num']."</div><div class='product_search_select'><input type='text' autocomplete='off' name='product_num_search' id='product_num_search' placeholder='".langu['product_num']."' value=''></div>
    </div>
    <div class='product_search_type' id='search_name'>
        <div class='product_search_title'>".langu['product_name']."</div><div class='product_search_select'><input type='text' autocomplete='off' name='product_name_search' id='product_name_search' placeholder='".langu['product_name']."' value=''></div>
    </div>
    <div class='product_search_type' id='search_barcode'>
        <div class='product_search_title'>".langu['barcode']."</div><div class='product_search_select'><input type='text' autocomplete='off' name='barcode_search' id='barcode_search' placeholder='".langu['barcode']."' value=''></div>
    </div>
 <div class='product_search_show'></div>
</div>";
}
/**
 *جلب الوحدة و التصنيف
 *@param $unit if 1 get unit
 *@param $category if 1 get category
 *@return array 'unit','cat'
 */
function get_unit_cat($mysqli,$unit=null,$category=null){
$ma=array();

if($unit==1){
$q=$mysqli->query('SELECT * FROM product_unit');


$ma['unit']="<select id='select_unit' name='select_unit' required>
<option value='' disabled selected>".langu['selectunit']."</option>";
while ($row=$q->fetch_assoc()) {
$ma['unit'].="<option value='".$row['id']."'>".$row['name']."</option>";
}
$ma['unit'].="</select>";
}

if($category==1){
$q=$mysqli->query('SELECT * FROM categories');
$ma['cat']="<select id='select_category' name='select_category' required>
<option value='' disabled selected>".langu['selectcategory']."</option>";
while ($row=$q->fetch_assoc()) {
$ma['cat'].="<option value='".$row['id']."'>".$row['name']."</option>";
}
$ma['cat'].="</select>";
}



return $ma;
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

//move_uploaded_file($_FILES[$name]['tmp_name'],'images/stores/'.$_SESSION['store-id'].'/albums/'.$id.'/'.$pic);

//echo "<div style='font-size:large;text-align:center;'>تم اضافة الصورة بنجاح</div>";
}}
//else { echo "<div style='font-size:large;text-align:center;'>يوجد خطا في رفع الصورة حاول مرة اخرى</div>";}}
//else {echo "<div style='font-size:large;text-align:center;'>لا يوجد ملف حاول مرة اخرى</div>";}


}

function product_our_barcode($mysqli){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['product_our_barcode']."</div>

    <table class='main_table'>
        <tr>
            <th>".langu['product_num']."</th>
            <th>".langu['product_name']."</th>
            <th>".langu['barcode']."</th>
        </tr>
";

$q=$mysqli->query("select id2,name,barcode from products where barcode like '2018100%'");
while($row=$q->fetch_assoc()){

echo "<tr>
        <td class='nume'>".$row['id2']."</td>
        <td>".$row['name']."</td>
        <td class='nume'>".$row['barcode']."</td>
</tr>";
}
echo "</table></div>";
}

function add_barcode_empty($mysqli){
ini_set('max_execution_time', 800);
$b=201810051000;
$q=$mysqli->query("SELECT id,id2,name,barcode FROM products where barcode='' and id>302");
while ($row=$q->fetch_assoc()){
$code=$this->generateEAN($b);
$mysqli->query('update products set barcode='.$code.' where id='.$row['id']);
$b++;
}
$ma[0]=langu['update_product_success'];
$ma[1]=3;
return $ma;

}
function generateEAN($number)
{
  $code =str_pad($number, 9, '0');
  //$code =str_pad($number, 9, '0', STR_PAD_LEFT);
  $weightflag = true;
  $sum = 0;
  for ($i = strlen($code) - 1; $i >= 0; $i--)
  {
    $sum += (int)$code[$i] * ($weightflag?3:1);
    $weightflag = !$weightflag;
  }
  $code .= (10 - ($sum % 10)) % 10;
  return $code;
}

}