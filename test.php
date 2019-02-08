<?php


function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
   return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}



$image = "./template/template02.png"; 
$font = "D:\\xampp\htdocs\screenshot\arial.ttf";
$font_size = "58";

$image_2 = imagecreatefrompng($image);
$black = imagecolorallocate($image_2, 255,255,255);
$black2 = imagecolorallocate($image_2, 0,0,0);

$image_width = imagesx($image_2);  
$image_height = imagesy($image_2);
$margin = 45;


$text = "Add your text here and make your screenshot awesome";

//explode text by words
$text_a = explode(' ', $text);
$text_new = '';
foreach($text_a as $word){
    //Create a new text, add the word, and calculate the parameters of the text
    $box = imagettfbbox($font_size, 0, $font, $text_new.' '.$word);
    //if the line fits to the specified width, then add the word with a space, if not then add word with new line
    if($box[2] > $image_width - $margin*2){
        $text_new .= "\n".$word;
    } else {
        $text_new .= " ".$word;
    }
}

$font_color = imagecolorallocate($image_2, 255, 255, 255);
$font_color2 = imagecolorallocate($image_2, 0, 0, 0);
$stroke_color = imagecolorallocate($image_2, 0, 0, 0);

$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$grey = imagecolorallocate($im, 175, 175, 175);


imagettfstroketext($image_2, $font_size ,0,143,164,$font_color, $stroke_color, $font, $text_new, 0);

header ("Content-type: image/png");
imagejpeg($image_2, "output_data.png");
imagedestroy($image_2);

?>