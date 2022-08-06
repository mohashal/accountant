<?php
error_reporting(E_ALL);
/**
* generates a image with chars instead of pixels
*
* @param string $url Filepath or url
* @param string $chars The chars which should replace the pixels
* @param int $shrpns Sharpness (2 = every second pixel, 1 = every pixel ... )
* @param int $size 
* @param int $weight font-weight/size
* @return sesource
* @author Nicolas 'KeksNicoh' Heimann <www.salamipla.net>
* @date 02nov08
*/
function pixelfuck($url, $chars='ewk34543§G§$§$Tg34g4g', $shrpns=1, $size=4,$weight=2)
{
    list($w, $h, $type) = getimagesize($url);
    $resource = imagecreatefromstring(file_get_contents($url));
    $img = imagecreatetruecolor($w*$size,$h*$size);

    $cc = strlen($chars);
    for($y=0;$y <$h;$y+=$shrpns) 
        for($x=0;$x <$w;$x+=$shrpns)
            imagestring($img,$weight,$x*$size,$y*$size, $chars{@++$p%$cc}, imagecolorat($resource, $x, $y));
    return $img;
}

$url = 'http://upload.wikimedia.org/wikipedia/commons/b/be/Manga_Icon.png';
$url='https://seeklogo.com/images/P/php-logo-ADE513E748-seeklogo.com.png';
$text = 'I-dont-like-manga-...-Why-do-they-have-such-big-eyes? Strange-...-WHAT-WANT-YOU-DO?';

$text ='1233232132132132132132';


Header('Content-Type: image/png');
imagepng(pixelfuck($url, $text, 1,6));
/*imagepng(pixelfuck($url, $text, 1, 6));*/
?>