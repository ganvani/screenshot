$(document).ready(function (e) {
    $("#loader").hide();
$("#uploadimage").on('submit',(function(e) {
    e.preventDefault();
    $("#message").empty();
   
    $.ajax({
    url: "template1.php", // Url to which the request is send
    type: "POST",             // Type of request to be send, called as method
    data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false,       // The content type used when sending data to the server.
    cache: false,             // To unable request pages to be cached
    processData:false,  
    beforeSend: function() {
        $("#loader").show();
     },      // To send DOMDocument or non processed data file it is set to false
    success: function(data)   // A function to be called if request succeeds
    {
        console.log("ok");
        console.log(data);
        var obj=JSON.parse(data);
        setTimeout(function(){
            $('#previewing_data').attr('src','');
            $('#previewing_data').attr('src',obj.output);
            $('#loader').hide();
        },2000);

        //window.location.reload(true);

    },
    error:function(data)
    {
        console.log("ok");
        console.log(data);
        var obj=JSON.parse(data);
        setTimeout(function(){
            $('#previewing_data').attr('src','');
            $('#previewing_data').attr('src',obj.output);
            $('#loader').hide();
        },2000);
    }
    });
}));

    /*$("#screen_shot").change(function() {
    
        $("#message").empty(); // To remove the previous error message
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
        {
            $('#previewing').attr('src','noimage.png');
            $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        }
        else
        { 
            var file_data = $("#screen_shot").prop("files")[0];
        
            var form_data = new FormData();
            form_data.append("screen_shot", file_data);
          
            $.ajax({
                url: "ajax_php_file.php", // Url to which the request is send
                type: "POST",   
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#loader").show();
                },      // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {    $("#message").html(data);
                
                    window.location.reload(true);
            
                },
                complete:function(data){
                    // Hide image container
                    $('#loader').hide();
                }
            
            });
        }
    });

    $("#background_color").change(function(){
        var form_data = new FormData();
            form_data.append("background_color",$(this).val());
          
            $.ajax({
                url: "ajax_php_file.php", // Url to which the request is send
                type: "POST",   
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#loader").show();
                },      // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {    $("#message").html(data);
                     
                    //window.location.reload(true);
            
                },
                complete:function(data){
                    // Hide image container
                    $('#loader').hide();
                }
            
            });
       
    });

    $("#background_image").change(function() {
    
        $("#message").empty(); // To remove the previous error message
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
        {
            $('#previewing').attr('src','noimage.png');
            $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        }
        else
        { 
            var file_data = $("#background_image").prop("files")[0];
        
            var form_data = new FormData();
            form_data.append("background_image", file_data);
          
            $.ajax({
                url: "ajax_php_file.php", // Url to which the request is send
                type: "POST",   
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#loader").show();
                },      // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {    $("#message").html(data);
                
                    //window.location.reload(true);
            
                },
                complete:function(data){
                    // Hide image container
                    $('#loader').hide();
                }
            
            });
        }
    });*/

});
