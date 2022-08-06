<?php
/*ini_set("memory_limit",-1);
echo ini_get("memory_limit");
ini_set("memory_limit",'228M'); 
while($row = $result->fetch_assoc())
{
    $rows[] = $row;
} */

include_once 'webcon/config.php';
ini_set("memory_limit",'345M');
ini_set('max_execution_time', 1000);
$co=new config();
$mysqli=$co->connect();
$q=$mysqli->query('SELECT id FROM products_test where category_id=3 GROUP by id');
$m=$q->num_rows;
$img_ar=array();
$modd=$m%4;
$m2=$m-$modd;

$rows=mysqli_fetch_all($q,MYSQLI_ASSOC);
mysqli_free_result($q);

$t1=1;$t2=1;
for($i=0;$i<$m2;$i++){
if($t1==5){$t1=1;merge_images($t2,$img1,$img2,$img3,$img4);$t2++;}
${'img'.$t1}='images/products/('.$rows[$i]['id'].').jpg';
$t1++;
}

merge_images($t2,$img1,$img2,$img3,$img4);$t2++;
$m=$m-$modd;



if($modd==3){merge_images($t2,'images/products/('.$rows[$m]['id'].').jpg','images/products/('.$rows[$m+1]['id'].').jpg','images/products/('.$rows[$m+2]['id'].').jpg');}
elseif($modd==2){merge_images($t2,'images/products/('.$rows[$m]['id'].').jpg','images/products/('.$rows[$m+1]['id'].').jpg');}
elseif($modd==1){merge_images($t2,'images/products/('.$rows[$m]['id'].').jpg');}


function merge_images($ti,$img1_path,$img2_path=null,$img3_path=null,$img4_path=null){

$merged_width=1050;$merged_height=700;
list($img1_width, $img1_height) = getimagesize($img1_path);
$img1 = resize_img(imagecreatefromjpeg($img1_path),$img1_width,$img1_height);

if($img2_path!==null){list($img2_width, $img2_height) = getimagesize($img2_path);
$img2 = resize_img(imagecreatefromjpeg($img2_path),$img2_width,$img2_height);
$merged_width=2100;$merged_height=700;
}

if($img3_path!==null){list($img3_width, $img3_height) = getimagesize($img3_path);
$img3 = resize_img(imagecreatefromjpeg($img3_path),$img3_width,$img3_height);
$merged_width=2100;$merged_height=1400;
}
if($img4_path!==null){list($img4_width, $img4_height) = getimagesize($img4_path);
$img4 = resize_img(imagecreatefromjpeg($img4_path),$img4_width,$img4_height);
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
    $save_path = "images/merge/".$ti.".jpg";
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

?>
