<!DOCTYPE html>
<?php error_reporting(E_ALL & ~E_WARNING); ?>
<html lang="en">
<head>
<title>Bootstrap 4 Website Example</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="template1.js"></script>
<style>
    .fakeimg {
    height: 200px;
    background: #aaa;
    }
    *{ margin:0; }
    .loader {
        border: 5px solid #f3f3f3;
        border-radius: 50%;
        border-top: 5px solid #000;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }
  
    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }
  
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .backface-div {
            display: flex;
            height: 100vh;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            position:fixed;
        }
</style>
</head>
<body>



<div class="container-fiuld" style="margin-top:30px">
    <div class="row">
        <div class="col-sm-4">
            <div id="image_preview">
                <img  width="70%" src="<?php echo 'http://'.$_SERVER[HTTP_HOST].'/screenshot'.'/template'.'/'.'template01.png'?>" />   
            </div>
        </div>
        <div class="col-sm-4">
            <div id="image_preview">
                <?php if (file_exists('output_template1.png')) 
                { ?>
                    <img id="previewing_data" width="70%"  src="<?php echo 'http://'.$_SERVER[HTTP_HOST].'/screenshot'.'/'.'output_template1.png'?>" />
                    <a href="<?php echo 'http://'.$_SERVER[HTTP_HOST].'/screenshot'.'/'.'output_template1.png'?>" download>Download</a>

                <?php } else {?>
                    <img id="previewing_data" width="70%" src="<?php echo 'http://'.$_SERVER[HTTP_HOST].'/screenshot'.'/template'.'/'.'template01.png'?>" />
                <?php } ?>
            </div>              
        </div>     
        <div class="col-sm-4">
            <h3>Layout & Text</h3><br/>
            <hr>
            <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
            
                <div class="form-group">
                    <label for="file">Screen Shot:</label>
                    <input type="file" name="screen_shot" id="screen_shot"  />
                </div>
                <div class="form-group">
                    <label for="file">Background Color</label>
                    <input type="color" name="background_color" id="background_color" value="#FF5A5F" />
                </div>
                <div class="form-group">
                    <label for="file">Background Image:</label>
                    <input type="file" name="background_image" id="background_image"  />
                </div>
                <div class="form-group">
                    <label for="file">Text Content:</label>
                    <input type="text" name="text_content" id="text_content"  />
                </div>
                <div class="form-group">
                    <label for="file">Text Size</label>
                    <input type="number" name="text_size" id="text_size" min="1" />
                </div>
                <div class="form-group">
                    <label for="file">Text Color</label>
                    <input type="color" name="text_color" id="text_color" value="#FFFFFF" />
                </div>
                <input type="submit" value="Submit" class="submit" />
            </form>
        </div> 
    </div>
</div>

</body>
</html>