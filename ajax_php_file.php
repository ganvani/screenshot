<?php
error_reporting(E_ALL & ~E_WARNING);

header('Content-Type: image/png');
    if (file_exists('output.png')) 
    {
        unlink('output.png');
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
                    $filename= uniqid().basename($_FILES["screen_shot"]["name"]);
                    if(move_uploaded_file($_FILES["screen_shot"]["tmp_name"],$filename))
                    {
                
                        $template_image="output.png";
                    
                        if (file_exists($template_image)) 
                        {
                            $template=imagecreatefrompng('output.png');
                        }
                        else
                        {
                            $template=imagecreatefrompng('template.png');
                        }
                        
                        // File and new size
                    
                       

                        list($width, $height) = getimagesize($filename);
                    

                        $thumb_nail = imagecreatetruecolor(872, 1568);

                        if($_FILES["screen_shot"]["type"] == "image/png")
                        {
                            $source = imagecreatefrompng($filename);
                        }
                        else if(($_FILES["screen_shot"]["type"] == "image/jpg") || ($_FILES["screen_shot"]["type"] == "image/jpeg"))
                        {
                            $source = imagecreatefromjpeg($filename);
                        }
                        
                        imagecopyresized($thumb_nail, $source, 0, 0, 0, 0,872, 1568, $width, $height);

                        imagecopymerge($template, $thumb_nail,196,339, 0, 0,872, 1568,100);

                        // Output
                                imagepng($template,'D:\xampp\htdocs\Qbix-screenshot\output.png');
                              
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
    if(isset($_POST['background_color']))
    {
        $new_rgb=hex2rgb($_POST['background_color']);
      
        $old_rgb=get_data('background-color');
      
        $template_image="output.png";
                    
        if (file_exists($template_image)) 
        {
            $template=imagecreatefrompng('output.png');
        }
        else
        {
            $template=imagecreatefrompng('template.png');
        }
       
        $new_color = imagecolorallocate($template,$new_rgb['r'],$new_rgb['g'],$new_rgb['b']);
        imagefill($template, 0, 0, $new_color);
        put_data('background-color',$new_rgb);
        imagepng($template,'D:\xampp\htdocs\Qbix-screenshot\output.png');
      
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
                            $template=imagecreatefrompng('template.png');
                        }
                      
                        // File and new size
                        $old_rgb=get_data('background-color');

                        $color = imagecolorallocate($template,$old_rgb['r'],$old_rgb['g'],$old_rgb['b']);
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

                        imagecopymerge($thumb_nail,$template,0,0,0,0,$width, $height,95);

                        put_data('background-image',$filename);

                        // Output
                      
                               imagepng($thumb_nail,'D:\xampp\htdocs\Qbix-screenshot\output.png');
                             
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
        if (file_exists($template_image)) 
        {
            $template=imagecreatefrompng('output.png');
        }
        else
        {
            $template=imagecreatefrompng('template.png');
        }
        $color = imagecolorallocate($template,$new_rgb['r'],$new_rgb['g'],$new_rgb['b']);
        // Set Path to Font File
         $font_path = 'D:\xampp\htdocs\Qbix-screenshot\arial.ttf';
         $text=($_POST['text_content'] != "")?$_POST['text_content']:"Text Here";
         $text_size=($_POST['text_size'] != "")?$_POST['text_size']:50;
         imagettftext($template,$text_size, 0,249,147, $color, $font_path, $text);
         imagepng($template,'D:\xampp\htdocs\Qbix-screenshot\output.png');

    }
    $image='http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'/'.'output.png';
    
    $arr = array('image' => $image, 'msg' =>"true");

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
        $content=file_get_contents('config.json');
        $data = json_decode($content, true); // decode the JSON into an associative array
        return $data['template'][$key];

    }
    function put_data($key,$value)
    {
        $content=file_get_contents('config.json');
        $data = json_decode($content, true); // decode the JSON into an associative array
        $data['template'][$key]=$value;
        $newcontent = json_encode($data);
        file_put_contents('config.json', $newcontent);
    }

?>