  <?php
  $template_image="output.png";
                    
        if (file_exists($template_image)) 
                        {
                            $template=imagecreatefrompng('output.png');
                        }
                        else
                        {
                            $template=imagecreatefrompng('./template.png');
                        }
       
        $new_color = imagecolorallocate($template,0,0,255);
        imagefill($template, 0, 0,$new_color);
        
        imagepng($template,'D:\xampp\htdocs\screenshot\output.png');
        exit;

        ?>