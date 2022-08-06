<?php
/*
$img1_path = 'images/merge/1.png';
$img2_path = 'images/merge/2.png';

list($img1_width, $img1_height) = getimagesize($img1_path);
list($img2_width, $img2_height) = getimagesize($img2_path);

if($img1_width<$img2_width){$new_width=$img1_width;}
elseif($img1_width==$img2_width){$new_width=$img1_width;}
else{$new_width=$img2_width;}

if($img1_height<$img2_height){$new_height=$img1_height;}
elseif($img1_height==$img2_height){$new_height=$img1_height;}
else{$new_height=$img2_height;}

$merged_width  = $new_width*2;
//get highest
//$merged_height = $img1_height < $img2_height ? $img1_height : $img2_height;
$merged_height=$new_height;

$merged_image = imagecreatetruecolor($merged_width, $merged_height);

imagealphablending($merged_image, false);
imagesavealpha($merged_image, true);

$img1 = imagecreatefrompng($img1_path);
$img2 = imagecreatefrompng($img2_path);

imagecopy($merged_image, $img1, 0, 0, 0, 0, $img1_width, $img1_height);
//place at right side of $img1
imagecopy($merged_image, $img2, $img1_width, 0, 0, 0, $img2_width, $img2_height);

//save file or output to broswer
$SAVE_AS_FILE = TRUE;
if( $SAVE_AS_FILE ){
    $save_path = "images/merge/13.png";
    imagepng($merged_image,$save_path);
}else{
    header('Content-Type: image/png');
    imagepng($merged_image);
}

//release memory
imagedestroy($merged_image);

function resize_img($img,$width,$height){
$thumb = imagecreatetruecolor(500,500);
//$source = imagecreatefromjpeg($filename);

// Resize
imagecopyresized($thumb,$img, 0, 0, 0, 0,500,500, $width, $height);

// Output
imagepng($thumb);
}*/


$img1_path = 'images/merge/1.png';
$img2_path = 'images/merge/2.png';
$img3_path = 'images/merge/3.png';
$img4_path = 'images/merge/4.png';

list($img1_width, $img1_height) = getimagesize($img1_path);
list($img2_width, $img2_height) = getimagesize($img2_path);
list($img3_width, $img3_height) = getimagesize($img3_path);
list($img4_width, $img4_height) = getimagesize($img4_path);

$merged_width=1400;

$merged_height=1400;

$merged_image = imagecreatetruecolor($merged_width, $merged_height);
imagealphablending($merged_image, false);
imagesavealpha($merged_image, true);

$img1 = resize_img(imagecreatefrompng($img1_path),$img1_width,$img1_height);
$img2 = resize_img(imagecreatefrompng($img2_path),$img2_width,$img2_height);
$img3 = resize_img(imagecreatefrompng($img3_path),$img3_width,$img3_height);
$img4 = resize_img(imagecreatefrompng($img4_path),$img4_width,$img4_height);

imagecopy($merged_image, $img1, 0, 0, 0, 0, 700, 700);
//place at right side of $img1
imagecopy($merged_image, $img2, 700, 0, 0, 0, 700, 700);
imagecopy($merged_image, $img3, 0, 700, 0, 0, 700, 700);
imagecopy($merged_image, $img4, 700, 700, 0, 0, 700, 700);

//save file or output to broswer
$SAVE_AS_FILE = TRUE;
if( $SAVE_AS_FILE ){
    $save_path = "images/merge/12.png";
    imagepng($merged_image,$save_path);
}else{
    header('Content-Type: image/png');
    imagepng($merged_image);
}

//release memory
imagedestroy($merged_image);

function resize_img($img,$width,$height){
$thumb = imagecreatetruecolor(700,700);

imagealphablending($thumb, FALSE);
//$source = imagecreatefromjpeg($filename);

// Resize
imagecopyresized($thumb,$img, 0, 0, 0, 0,700,700, $width, $height);
return $thumb;


}

?>
