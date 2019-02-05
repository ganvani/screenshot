<?php


$template = imagecreatefrompng('template.png');
$pink = imagecolorallocate($template, 255, 90,95);

// Make the background transparent
imagecolortransparent($template, $pink);
imagepng($template, 'imagecolortransparent.png');


list($width, $height) = getimagesize('imagecolortransparent.png');

$dest = imagecreatefrompng('imagecolortransparent.png');

$thumb_second = imagecreatetruecolor(872, 1568);
$source_second = imagecreatefrompng('screenshot.png');

list($screenshot_width, $screenshot_height) = getimagesize('screenshot.png');

imagecopyresized($thumb_second, $source_second, 0, 0, 0, 0,872, 1568, $screenshot_width, $screenshot_height);

imagecopymerge($dest, $thumb_second,197,338, 0, 0,872, 1568,100);


$thumb = imagecreatetruecolor($width, $height);
$source = imagecreatefromjpeg ('backgrouund.jpg');

list($source_width, $source_height) = getimagesize('backgrouund.jpg');

imagecopyresized($thumb, $source, 0, 0, 0, 0,$width, $height, $source_width, $source_height);

imagecopymerge($thumb,$dest,0,0,0,0,$width, $height,95);


imagepng($thumb,'output.png');

echo "done";


?>