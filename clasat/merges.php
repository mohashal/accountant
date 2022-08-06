<?php

class merges {
function merge_form(){
echo "
<div class='form_main'>
    <div class='form_main_name'>".langu['merge_photos']."</div>
    <div class='form_main_inputs' style='width:95%;'>
    <div class='merge_button'><a href='merges.php?conn=merge_all'>".langu['merge_photos']."</a></div>
    </div>
</div>";
}

function merge_cats($mysqli){
$q=$mysqli->query('select id,name from categories');
while ($row=$q->fetch_assoc()){
$this->merge_all($mysqli,$row['id'],$row['name']);
}

}

function merge_all($mysqli,$cat_id,$name){
ini_set("memory_limit",'545M');
ini_set('max_execution_time', 1000);

if (!file_exists("images/merge/".$name)) {
    mkdir("images/merge/".$name, 0777, true);
}

else {
$this->delete_files("images/merge/".$name);
mkdir("images/merge/".$name, 0777, true);
}

//$q=$mysqli->query('SELECT id2 FROM products where category_id='.$cat_id.' GROUP by id');
$q=$mysqli->query('SELECT id FROM products_test where category_id='.$cat_id.' GROUP by id');
$m=$q->num_rows;
if($m>0){
$img_ar=array();
$modd=$m%4;
$m2=$m-$modd;

$rows=mysqli_fetch_all($q,MYSQLI_ASSOC);
mysqli_free_result($q);

$t1=1;$t2=1;
for($i=0;$i<$m2;$i++){
if($t1==5){$t1=1;$this->merge_images($name,$t2,$img1,$img2,$img3,$img4);$t2++;}
${'img'.$t1}='images/products/('.$rows[$i]['id'].').jpg';
$t1++;
}

$this->merge_images($name,$t2,$img1,$img2,$img3,$img4);$t2++;
$m=$m-$modd;



if($modd==3){$this->merge_images($name,$t2,'images/products/('.$rows[$m]['id'].').jpg','images/products/('.$rows[$m+1]['id'].').jpg','images/products/('.$rows[$m+2]['id'].').jpg');}
elseif($modd==2){$this->merge_images($name,$t2,'images/products/('.$rows[$m]['id'].').jpg','images/products/('.$rows[$m+1]['id'].').jpg');}
elseif($modd==1){$this->merge_images($name,$t2,'images/products/('.$rows[$m]['id'].').jpg');}

echo"تم دمج جميع صور التصنيف ".$name."</br>";
}
}

function merge_images($name,$ti,$img1_path,$img2_path=null,$img3_path=null,$img4_path=null){

$merged_width=1050;$merged_height=700;
list($img1_width, $img1_height) = getimagesize($img1_path);
$img1 = $this->resize_img(imagecreatefromjpeg($img1_path),$img1_width,$img1_height);

if($img2_path!==null){list($img2_width, $img2_height) = getimagesize($img2_path);
$img2 =$this->resize_img(imagecreatefromjpeg($img2_path),$img2_width,$img2_height);
$merged_width=2100;$merged_height=700;
}

if($img3_path!==null){list($img3_width, $img3_height) = getimagesize($img3_path);
$img3 = $this->resize_img(imagecreatefromjpeg($img3_path),$img3_width,$img3_height);
$merged_width=2100;$merged_height=1400;
}
if($img4_path!==null){list($img4_width, $img4_height) = getimagesize($img4_path);
$img4 = $this->resize_img(imagecreatefromjpeg($img4_path),$img4_width,$img4_height);
}




$merged_image = imagecreatetruecolor($merged_width, $merged_height);
imagefill($merged_image, 0, 0,imagecolorallocate($merged_image, 255, 255, 255));


imagecopy($merged_image, $img1, 0, 0, 0, 0,1050, 700);imagedestroy($img1);
if($img2_path!==null){imagecopy($merged_image, $img2, 1050, 0, 0, 0,1050, 700);imagedestroy($img2);}
if($img3_path!==null){imagecopy($merged_image, $img3, 0, 700, 0, 0,1050, 700);imagedestroy($img3);}
if($img4_path!==null){imagecopy($merged_image, $img4, 1050, 700, 0, 0,1050, 700);imagedestroy($img4);}

//save file or output to broswer
$SAVE_AS_FILE = TRUE;
if( $SAVE_AS_FILE ){
    $save_path = "images/merge/".$name."/".$ti.".jpg";
    imagejpeg($merged_image,$save_path);
}else{
    header('Content-Type: image/jpg');
    imagejpeg($merged_image);
}

//release memory
imagedestroy($merged_image);

}

function resize_img($img,$width,$height){
$mwidth=1050;
$mheight=700;
$thumb = imagecreatetruecolor($mwidth,$mheight);

imagealphablending($thumb, FALSE);
//$source = imagecreatefromjpeg($filename);

// Resize
imagecopyresized($thumb,$img, 0, 0, 0, 0,$mwidth,$mheight, $width, $height);
return $thumb;


}

function delete_files($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
        
        foreach( $files as $file )
        {
         $this->delete_files( $file );      
        }
      
        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );  
    }
}

}