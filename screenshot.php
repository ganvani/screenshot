<?php 
    require __DIR__.'/vendor/autoload.php';
    
    use GDText\Box;
    use GDText\Color;
    error_reporting(E_ALL & ~E_WARNING);

    $options = ['-t'=>'template image','-i'=>'background image','-s'=>'screen-shot image','-f'=>'fornt content',
            '-c'=>'background color','-a'=>'fornt color','-z' => 'fornt size',
            '-x'=>'template config file','-r'=>'Output image formate','-o'=>'Output image size'];

    $parameter = getopt("t:s:i:f:c:a:z:x:r:o:");
  
    if (count($parameter) <= 0 ) { 
        // For Help command

        print "\n php screenshot.php -t TemplateFilename -x TemplateConfigFilename -i [BackgroundimageFilename] -s [ScreenshotFilename] -f [Forntcontent] -a [Forntcolor] -z [ForntSize] -c [BackgroundColor] -o [OutputImageResolution] -r [OutputFileExtension] \n\n";
        print "\n  The list of command line options provided by the Screen-Shot PHP Script.";
        print "\n  Option : \n";

        foreach($options as $key => $value)
        {
            print "\n".$key .": \t\t\t".$value."\n";
        }
        exit(1); 
    } 
   else
    {
        // font file

        $font_path = dirname(__FILE__) .'/'.'arial.ttf';
    
        if(isset($parameter['t']) && isset($parameter['x']))
        {
            
            $template_ext = pathinfo($parameter['t'], PATHINFO_EXTENSION);

            if($template_ext == "png")
            {
                // template file path
                $template_filepath = $parameter['t'];
              
                if(!file_exists($template_filepath))
                {
                    print "\n\n Please enter a valid template file name.\n\n";
                    exit;
                }

                // template config file path
                $template_config = $parameter['x'];

                if(!file_exists($template_config))
                {
                    print "\n\n Please enter a valid template config name.\n\n";
                    exit;
                }
          
                if(isset($parameter['r']))
                {
                    if($parameter['r'] == "png"||$parameter['r'] == "jpg"||$parameter['r'] == "jpeg")
                    {
                        // Output file path
                        $output_filepath=dirname(__FILE__)."/output"."/"."output.".$parameter['r'];

                        if(file_exists($output_filepath))
                        {
                            unlink($output_filepath);
                        }

                        // Get template image
                        $template=get_template($template_filepath,$output_filepath);

                        // Create a output image
                        output_image($template,$output_filepath);

                    }
                    else
                    {
                        print "\n\n Please enter a valid output file extension like png or jpg.\n\n";
                        exit;
                    }
                }
                else
                {
                    $output_filepath=dirname(__FILE__)."/output"."/" ."output.png";
                  
                    if(file_exists($output_filepath))
                    {
                        unlink($output_filepath);
                    }
                    // Get template image
                    $template=get_template($template_filepath,$output_filepath);

                    // Create a output image
                    output_image($template,$output_filepath);
                }
            }
            else
            {
                print "\n\n Please enter a valid template file extension.\n\n";
                 exit;
            }
        }
        else
        {
            print "\n\n Please enter a Valid argrument.Template name and Template config file are required.\n\n";
            exit;
        }
        if(isset($parameter['c']))
        {
           
            list($width, $height) = getimagesize($template_filepath);
            $new_template = imagecreatetruecolor($width,$height);
          
            //Covert hexacode to rgb code
            $new_rgb=hex2rgb($parameter['c']); 
        
            $new_color = imagecolorallocate($new_template,$new_rgb['r'],$new_rgb['g'],$new_rgb['b']);
            
            //Fill Backgroud color 
            imagefill($new_template, 0, 0,$new_color);

            if(!isset($parameter['s']))
            {
                $template=get_template($template_filepath,$output_filepath);

                $template=imagecreatefrompng($template_filepath);
                $color = imagecolorallocate($template,255,90,95);

                $color_transparent='imagecolortransparent.png';

                if (file_exists($color_transparent)) 
                {
                    unlink($color_transparent);
                }
        
                imagepng($template, $color_transparent);

                // Create Transparent image 
                imagecolortransparent($template, $color);
                imagecopymerge($new_template,$template,0,0,0,0,$width, $height,100);
            }
          
            // Create a output image
            output_image($new_template,$output_filepath);
            print "\n Backgroud-color set successfully \n";
           
        }

        if(isset($parameter['i']))
        {
            $background_ext = pathinfo($parameter['i'], PATHINFO_EXTENSION);

            if($background_ext == "png" || $background_ext == "PNG" || $background_ext == "jpg" || $background_ext == "JPG"
                || $background_ext == "jpge" || $background_ext == "JPGE")
            {
                // Background image path
                $background_filepath=$parameter['i'];
              
                if(!file_exists($background_filepath))
                {
                    print "\n\n Please enter a valid backgorund file name.\n\n";
                    exit;
                }

                $template=get_template($template_filepath,$output_filepath);

                $template=imagecreatefrompng($template_filepath);
                $color = imagecolorallocate($template,255,90,95);

                // Create Transparent image 
                imagecolortransparent($template, $color);
                
                $color_transparent='imagecolortransparent.png';
        
                if (file_exists($color_transparent)) 
                {
                    unlink($color_transparent);
                }
        
                imagepng($template, $color_transparent);
        
                list($width, $height) = getimagesize($color_transparent);
                
                $thumb_nail = imagecreatetruecolor($width, $height);
        
                if($background_ext == "png" || $background_ext == "PNG")
                {
                    $source = imagecreatefrompng($background_filepath);
                }
                else if($background_ext == "jpg" || $background_ext == "jpeg" || $background_ext == "JPEG" || $background_ext == "JPG")
                {
                    $source = imagecreatefromjpeg($background_filepath);
                }
                
                list($source_width, $source_height) = getimagesize($background_filepath);
                
                // Resize Background image 
                imagecopyresized($thumb_nail, $source, 0, 0, 0, 0,$width, $height, $source_width, $source_height);

                 // Copy and merge Background image and template image
                imagecopymerge($thumb_nail,$template,0,0,0,0,$width, $height,95);
                
                // Create a output image
                output_image($thumb_nail,$output_filepath);
            
                print "\n Backgroud-Image set successfully. \n";

            }
            else
            {
                print "\n\n Please enter a valid backgorund file extension.\n\n";
                 exit;
            }
        }

        if(isset($parameter['s']))
        {
            $screen_ext = pathinfo($parameter['s'], PATHINFO_EXTENSION);

            if($screen_ext == "png" || $screen_ext == "PNG" || $screen_ext == "jpg" || $screen_ext == "JPG"
                || $screen_ext == "jpeg" || $screen_ext == "JPEG")
            {
                // Screen shot image path
                $screen_filepath=$parameter['s'];
              
                if(!file_exists($screen_filepath))
                {
                    print "\n\n Please enter a valid screen-shot file name.\n\n";
                    print_r($parameter); exit;
                }
                    
                $template=get_template($template_filepath,$output_filepath);

                //Get Resolution data form config file
                $resolution=get_data('screenshot',$template_config);
                if($resolution == null)
                {
                    print "\n\n Please put validate configrution for screen-shot \n\n";
                    exit;
                }
                $width=$resolution['width'];
                $height=$resolution['height'];

                list($width_orig, $height_orig) = getimagesize($screen_filepath);
                $ratio_orig = $width_orig/$height_orig;

                if ($width/$height > $ratio_orig)
                {
                    $width = $height*$ratio_orig;
                } 
                else 
                {
                    $height = $width/$ratio_orig;
                }

                $thumb_nail = imagecreatetruecolor($width,$height);
                 //Fix Screenshot into template
                //imagecopymergegray($template, $thumb_nail,$resolution['x'],$resolution['y'], 0, 0,$resolution['width'],$resolution['height'],0);
                

                 // Create output image
                
                       
                if($screen_ext == "png" || $screen_ext == "PNG")
                {
                    $source = imagecreatefrompng($screen_filepath);
                }
                else if($screen_ext == "jpeg" || $screen_ext == "jpg" || $screen_ext == "JPEG"|| $screen_ext == "JPG")
                {
                    $source = imagecreatefromjpeg($screen_filepath);
                }
                
                imagecopyresampled($thumb_nail, $source, 0, 0, 0, 0,$width,$height, $width_orig,$height_orig);
            
                if(isset($resolution['degrees']))
                {
                 
                    $thumb_nail = imagerotate($thumb_nail,$resolution['degrees'],0);
                  
                }
                if($resolution['width'] >= $width)
                {
                    $resolution['width']=$width;
                }
                if($resolution['height'] >= $height)
                {
                    $resolution['height']=$height;
                }

              
               
                //Fix Screenshot into template
                imagecopymergegray($template, $thumb_nail,$resolution['x'],$resolution['y'], 0, 0, $resolution['width'],$resolution['height'],100);
             
                // Create output image
                output_image($template,$output_filepath);
              
                print "\n Screen-shot set successfully. \n";

            }
            else
            {
                print "\n\n Please enter a valid screen-shot file extension.\n\n";
                print_r($parameter); exit;
            }
        }

        if(isset($parameter['f']))
        {
            //Get Text Content from Config file

            $text_coordinate=get_data('text',$template_config);
         
            if($text_coordinate == null)
            {
                print "\n\n Please put validate configrution for text \n\n";
                exit;
            }
            // Get Fort color by default it is white color.
            $fornt_color=(isset($parameter['a']))?$parameter['a']:"#ffffff";
            $new_rgb=hex2rgb($fornt_color);
          
            $template=get_template($template_filepath,$output_filepath);
      
            $image_width = imagesx($template);  
            $image_height = imagesy($template);
            $margin = 45;
          
            $text=$parameter['f'];
            if(isset($parameter['z']))
            {
                $text_size=$parameter['z'];
            }
            else
            {
                $length=strlen($text);
            
                $data=(100 * 50)/$length;
                $text_size=ceil($data);
            
                if($text_size >= 100)
                {
                    $text_size=$text_size % 100;
                   
                }
                $text_size = ($text_size == 0)?55:$text_size;
              
            }
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
           
            $box = new Box($template);
            $box->setFontFace(__DIR__.'/arial.ttf'); // http://www.dafont.com/minecraftia.font
            $box->setFontColor(new Color($new_rgb['r'],$new_rgb['g'],$new_rgb['b']));
            //$box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
            $box->setFontSize($text_size);
            $box->setLineHeight(1.5);
            //$box->enableDebug();
            $box->setBox($text_coordinate['x'],$text_coordinate['y'],$text_coordinate['width'],$text_coordinate['height']);
            $box->setTextAlign($text_coordinate['alignment'],$text_coordinate['alignment']);
            $box->draw($text_new);
           
            //Create a Output file
          
            output_image($template,$output_filepath);

            print "\n Front set successfully. \n";

        } 

        if(isset($parameter['o']))
        {
           
            //Get Output file Resolution.

           $resolution= explode("x",$parameter['o']);

           if(count($resolution) == 2)
           {
                $dest_width=(int)$resolution[0];
                $dest_height=(int)$resolution[1];

                if($dest_width == 0 || $dest_height == 0)
                { 
                    print "\n\n Please enter a Valid argrument for output image size.\n\n";
                    exit;
                }
                if (file_exists($output_filepath)) 
                {
                    list($width, $height) = getimagesize($output_filepath);
                }
                else
                {
                    list($width, $height) = getimagesize($template_filepath);
                }
              
                $image_p = imagecreatetruecolor($dest_width, $dest_width);

                $template=get_template($template_filepath,$output_filepath);

                //Resize Image Dynamically
                imagecopyresampled($image_p, $template, 0, 0, 0, 0, $dest_width, $dest_width, $width, $height);

                //Create Output image
                output_image($image_p,$output_filepath);

                print "\n Image resize successfully. \n";

           }
           else
           {
               print "please enter a valid argrument for output image size";
               exit;
           }
        }
    }

    print "\n Output image created successfully. \n";
    
    function output_image($template,$output_filepath) // For Create Output file
    {
        $output_ext = pathinfo($output_filepath, PATHINFO_EXTENSION);
        if($output_ext == "png")
        {
            imagepng($template,$output_filepath);
        }
        elseif($output_ext == "jpg" || $output_ext == "jpeg")
        {
            imagejpeg($template,$output_filepath);
        }
        else
        {
            imagepng($template,$output_filepath);
        }
    
    }
    function get_template($template_filepath,$output_filepath) // For Create Template file object
    {
        if (file_exists($output_filepath)) 
        {
            $output_ext = pathinfo($output_filepath, PATHINFO_EXTENSION);
            if($output_ext == "png")
            {
                $template=imagecreatefrompng($output_filepath);
            }
            elseif($output_ext == "jpg" || $output_ext == "jpeg")
            {
                $template=imagecreatefromjpeg ($output_filepath);
            } 
        }
        else
        {
            $template=imagecreatefrompng($template_filepath);
        }

        return $template;

    }
    function hex2rgb($hex) // Convert Hexacode to rgbCode
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

    function get_data($key,$template_config) // Get Data form Config file
    {
        $content=file_get_contents($template_config);
        $data = json_decode($content, true); // decode the JSON into an associative array
        if(isset($data[$key]))
        {
            return $data[$key];
        }
        return null;
       
    }

   /* function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) // Add Multiple line text into image
    {
        for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
            for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
                $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

        return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
    }*/
    function newText($im, $size, $angle= 0, $x, $y, $color, $font, $text,$align = "left",$border=false,$width=0,$height=0){
       
        if($align == "center")
        {
        
            if ($border == true ){
               imagerectangle($im, $x, $y, $x +$width, $y + $height, $color);
            }
            $bbox = imageftbbox($size, 0, $font, $text);
    
            // Marcamos el ancho y alto
            $s_width  = $bbox[4];
            $s_height = $bbox[5];  
            
            $y = $y + ($height-$s_height)/2;
            $x = $x + ($width-$s_width)/2;
    
        }
         
        imagettftext($im, $size, $angle, $x, $y, $color, $font, $text);
    }

?> 