<?php
if(isset($_GET['image']) && isset($_GET['width']) && isset($_GET['height']))
{
    header('Content-type: image/jpeg');
    list($width, $height) = getimagesize('5c5d6893c1d4bbackgrouund.jpg');
    $image_p = imagecreatetruecolor(1242,2208);
    $image = imagecreatefromjpeg('5c5d6893c1d4bbackgrouund.jpg');
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, 1242, 2208, $width, $height);
    imagejpeg($image_p, null, 100);
    exit;
}
exit;
?>