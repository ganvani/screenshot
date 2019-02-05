<?php


$im = imagecreatefrompng('data.png');
// sets background to red
$red = imagecolorallocate($im,255,255,255);
imagefill($im, 0, 0, $red);

header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
?>