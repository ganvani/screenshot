<?php

  $requested_width = 300;
  $render_width = ($requested_width * 2) - 1; // -1 to back away from edge, removing flat spot
  $center = $render_width / 2;  
  $colordivs = 255 / $center;
  $im_scratch = @imagecreate($render_width, $render_width);

  //$back_color = imagecolorallocate($im_scratch, 20, 30, 40);  // try it with white so you can really see the edge first..
  $back_color = imagecolorallocate($im_scratch, 255, 255, 255);

  imagefill($im_scratch, 0, 0, $back_color);

  for ($i = 0; $i <= $center; $i++) {
    $diametre = $render_width - 2 * $i;
    $el_color = imagecolorallocate($im_scratch, $i * $colordivs, 0, 0);
    imageellipse($im_scratch, $center, $center, $diametre, $diametre, $el_color);
    imagefilltoborder($im_scratch, $center, $center, $el_color, $el_color);
  }

  // resample down, causes antialiasing, nice smooth curve! 
  $im = @imagecreatetruecolor($requested_width, $requested_width); 
  imagecopyresampled($im, $im_scratch, 0, 0, 0, 0, $requested_width, $requested_width, $render_width, $render_width);

  header ("Content-type: image/png");
  imagepng($im);
  ImageDestroy($im);
  ImageDestroy($im_scratch);

?>