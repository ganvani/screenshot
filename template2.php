<?php
error_reporting(E_ALL & ~E_WARNING);

//header('Content-Type: image/png');

    if (file_exists('output.png')) 
    {
        unlink('output.png');
    }



    if(($_FILES["background_image"]['type'] != ""))
    {
        $validextensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["background_image"]["name"]);
        $file_extension = end($temporary);

        if ((($_FILES["background_image"]["type"] == "image/png") || ($_FILES["background_image"]["type"] == "image/jpg") || ($_FILES["background_image"]["type"] == "image/jpeg")) //Approx. 100kb files can be uploaded.
                && in_array($file_extension, $validextensions)) {
            if ($_FILES["background_image"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["background_image"]["error"] . "<br/><br/>";
            }
            else
            {
                $filepath = basename($_FILES["background_image"]["name"]);
                    if (file_exists($_FILES["background_image"]["name"])) 
                    {
                        if($_FILES["background_image"]["name"] == "template.png")
                        {
                            
                            echo $_FILES["background_image"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
                        }
                        else
                        {
                            unlink($filepath);
                        }
                    
                    }
                    $filename= uniqid().basename($_FILES["background_image"]["name"]);
                    if(move_uploaded_file($_FILES["background_image"]["tmp_name"],$filename))
                    { 
                        $template_image="output.png";
                    
                        if (file_exists($template_image)) 
                        {
                            $template=imagecreatefrompng('output.png');
                        }
                        else
                        {
                            $template=imagecreatefrompng('./template/template02.png');
                        }
                      
                        // File and new size
                        //$old_rgb=get_data('background-color');

                        $color = imagecolorallocate($template,255,90,95);
                        imagecolortransparent($template, $color);
                        
                        if (file_exists('imagecolortransparent.png')) 
                        {
                            unlink('imagecolortransparent.png');
                        }

                        imagepng($template, 'imagecolortransparent.png');
                       

                        list($width, $height) = getimagesize('imagecolortransparent.png');
                        
                        $thumb_nail = imagecreatetruecolor($width, $height);

                        if($_FILES["background_image"]["type"] == "image/png")
                        {
                            $source = imagecreatefrompng($filename);
                        }
                        else if(($_FILES["background_image"]["type"] == "image/jpg") || ($_FILES["background_image"]["type"] == "image/jpeg"))
                        {
                            $source = imagecreatefromjpeg($filename);
                        }

                        list($source_width, $source_height) = getimagesize($filename);

                        imagecopyresized($thumb_nail, $source, 0, 0, 0, 0,$width, $height, $source_width, $source_height);

                        imagecopymerge($source,$template,0,0,0,0,$width, $height,95);

                        put_data('background-image',$filename);

                        // Output
                      
                        imagepng($thumb_nail,'D:\xampp\htdocs\screenshot\output.png');     
                    } 
                    else 
                    {
                        echo "Error !!";
                    }
            }
        }
        else
        {
        echo "<span id='invalid'>***Invalid file Size or Type***<span>";
        }
    }
   
    else
    {
        if(isset($_POST['background_color']))
        {
            $new_rgb=hex2rgb($_POST['background_color']);
        
            $template_image="output.png";
                        
            if (file_exists($template_image)) 
                            {
                                $template=imagecreatefrompng('output.png');
                            }
                            else
                            {
                                $template=imagecreatefrompng('./template/template02.png');
                            }
        
            $new_color = imagecolorallocate($template,$new_rgb['r'],$new_rgb['g'],$new_rgb['b']);
            imagefill($template, 0, 0,$new_color);
            
            imagepng($template,'D:\xampp\htdocs\screenshot\output.png');
      
        }
    }

    if(($_FILES["screen_shot"]['type'] != ""))
    {

        $validextensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["screen_shot"]["name"]);
        $file_extension = end($temporary);

        if ((($_FILES["screen_shot"]["type"] == "image/png") || ($_FILES["screen_shot"]["type"] == "image/jpg") || ($_FILES["screen_shot"]["type"] == "image/jpeg")) //Approx. 100kb files can be uploaded.
                && in_array($file_extension, $validextensions)) {
            if ($_FILES["screen_shot"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["screen_shot"]["error"] . "<br/><br/>";
            }
            else
            {
                $filepath = basename($_FILES["screen_shot"]["name"]);
                    if (file_exists($_FILES["screen_shot"]["name"])) 
                    {
                        if($_FILES["screen_shot"]["name"] == "template.png")
                        {
                            
                            echo $_FILES["screen_shot"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
                        }
                        else
                        {
                            unlink($filepath);
                        }
                    
                    }
                   
                    $screen_filename= uniqid().basename($_FILES["screen_shot"]["name"]);
                    $filepath="image/".$screen_filename;
                    if(move_uploaded_file($_FILES["screen_shot"]["tmp_name"],$filepath))
                    {
                
                        $template_image="output.png";
                    
                        if (file_exists($template_image)) 
                        {
                            $template=imagecreatefrompng('output.png');
                        }
                        else
                        {
                            $template=imagecreatefrompng('/template/template02.png');
                        }
                        $resolution=get_data('screenshot');
                        // File and new size
                        $width=$resolution['width'];
                        $height=$resolution['height'];
                        list($width_orig, $height_orig) = getimagesize($filepath);
                        $ratio_orig = $width_orig/$height_orig;

                            if ($width/$height > $ratio_orig) {
                            $width = $height*$ratio_orig;
                            } else {
                            $height = $width/$ratio_orig;
                            }
                       
                        $thumb_nail = imagecreatetruecolor($width,$height);
                       
                        if($_FILES["screen_shot"]["type"] == "image/png")
                        {
                            $source = imagecreatefrompng($filepath);
                        }
                        else if(($_FILES["screen_shot"]["type"] == "image/jpg") || ($_FILES["screen_shot"]["type"] == "image/jpeg"))
                        {
                            $source = imagecreatefromjpeg($filepath);
                        }
                        
                        imagecopyresampled($thumb_nail, $source, 0, 0, 0, 0,$width,$height, $width_orig,$height_orig);
                        $black = imagecolorallocate($thumb_nail, 0, 0, 0);
                        imagecolortransparent($thumb_nail, $black);
                        
                        imagecopymerge($template, $thumb_nail,$resolution['x'],$resolution['y'], 0, 0,$resolution['width'],$resolution['height'],100);

                        // Output
                        imagepng($template,'D:\xampp\htdocs\screenshot\output.png');
                              
                    } 
                    else 
                    {
                    echo "Error !!";
                    }
              
            
            }
        }
        else
        {
        echo "<span id='invalid'>***Invalid file Size or Type***<span>";
        }
       
    }
 
   

    if(isset($_POST['text_content']))
    {
        
        $new_rgb=hex2rgb($_POST['text_color']);
      
        $template_image="output.png";
                    
        if (file_exists($template_image)) 
        {
            $template=imagecreatefrompng('output.png');
        }
        else
        {
            $template=imagecreatefrompng('/template/template02.png');
        }

            $image_width = imagesx($template);  
            $image_height = imagesy($template);
            $margin = 45;


            $text=($_POST['text_content'] != "")?$_POST['text_content']:"Text Here";
            $text_size=($_POST['text_size'] != "")?$_POST['text_size']:58;
            $font_path = 'D:\xampp\htdocs\screenshot\arial.ttf';

            //explode text by words
            $text_a = explode(' ', $text);
            $text_new = '';

            foreach($text_a as $word){
                //Create a new text, add the word, and calculate the parameters of the text
                $box = imagettfbbox($text_size, 0, $font_path, $text_new.' '.$word);
                //if the line fits to the specified width, then add the word with a space, if not then add word with new line
                if($box[2] > $image_width - $margin*2){
                    $text_new .= "\n".$word;
                } else {
                    $text_new .= " ".$word;
                }
            }

        $font_color = imagecolorallocate($template,$new_rgb['r'],$new_rgb['g'],$new_rgb['b']);
        $stroke_color = imagecolorallocate($text_size, 0, 0, 0);

        // Set Path to Font File
        $text_coordinate=get_data('text');
        
        imagettfstroketext($template, $text_size ,0,$text_coordinate['x'],$text_coordinate['y'],$font_color, $stroke_color, $font_path, $text_new, 0);

        // Write it
        // imagettftext($template,$text_size, 0,35,33, $color, $font_path, $text);
         imagepng($template,'D:\xampp\htdocs\screenshot\output.png');

    }

    $template='http://'.$_SERVER[HTTP_HOST].'/screenshot'.'/template'.'template01.png';
    $output='http://'.$_SERVER[HTTP_HOST].'/screenshot'.'/'.'output_template1.png';
    $image='http://'.$_SERVER[HTTP_HOST].'/screenshot'.'/image'.'/'.$screen_filename;
    $back_gorund_image='http://'.$_SERVER[HTTP_HOST].'/screenshot'.'/image'.'/'.$filename;
    $back_gorund_color=$_POST['background_color'];
    $text=$_POST['text_content'];
    $text_size=$_POST['text_size'];
    $text_color=$_POST['text_color'];
   
    
    
    $arr = array('template' => $template, 'output' =>$output,'image' => $image,'back_gorund_image'=>$back_gorund_color,
                'back_gorund_image'=>$back_gorund_image,'text'=>$text,'text_size'=>$text_size,'text_color'=>$text_color);

    echo json_encode($arr);

 

    function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);
        
        if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
        }
        $rgb = ["r"=>$r,"g"=>$g,"b"=>$b];
     
       return $rgb;// returns an array with the rgb values
    }

    function get_data($key)
    {
        $content=file_get_contents('template2.json');
        $data = json_decode($content, true); // decode the JSON into an associative array
        return $data[$key];

    }
    function put_data($key,$value)
    {
        $content=file_get_contents('template2.json');
        $data = json_decode($content, true); // decode the JSON into an associative array
        $data['template'][$key]=$value;
        $newcontent = json_encode($data);
        file_put_contents('template2.json', $newcontent);
    }

    function thumbnailImage($imagePath) {
        $imagick = new \Imagick(realpath($imagePath));
        $imagick->setbackgroundcolor('rgb(64, 64, 64)');
        $imagick->thumbnailImage(100, 100, true, true);
        header("Content-Type: image/jpg");
        echo $imagick->getImageBlob();
    }
   
    function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px)
    {
        for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
            for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
                $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

        return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
    }
			


?>