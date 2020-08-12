<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <form name="form" id="form" method="post" action="index.php"
        enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="form-row">
            <div>
                <label>Enter Text:</label> <input type="text" class="input-field" name="txt_input" maxlength="1000" autocomplete="off">
            </div>
        </div>
        <div class="button-row">
            <input type="submit" id="submit" name="submit" value="Convert">
        </div>
    </form>
    <div id="validation-response"></div>
</body>
<script>
function validateForm() {
    var valid = true;
    document.getElementById("output").remove();
    document.getElementById("validation-response").style.display = "none";
    document.getElementById("validation-response").value = "";

    if(document.form.txt_input.value == "") {
        document.getElementById("validation-response").style.display = "block";
        document.getElementById("validation-response").innerHTML = "Text Field Should not be Empty";
        valid = false;
    }  
    
    return valid;
}
</script>
</html>
<?php
if (!empty($_POST['txt_input'])) {
    $input_text = $_POST['txt_input'];
    $width = (strlen($input_text)*9)+60;
    $height = 30;
    
    $textImage = imagecreate($width, $height);
    $color = imagecolorallocate($textImage, 0, 0, 0);
    imagecolortransparent($textImage, $color);
    imagestring($textImage, 5, 10, 5, $input_text, 0xFFFFFF);
    
    // Increase text-font size
    imageline($textImage, 30, 45, 165, 45, $color);

    //break lines
    $input_text = explode ( "\\n" , $input_text );
    $lines = count($input_text);

    
    // create background image layer
    $background = imagecreatefromjpeg('green.jpg');
    
    // Merge background image and text image layers
    imagecopymerge($background, $textImage, 15, 15, 0, 0, $width, $height, 100);
    
    
    $output = imagecreatetruecolor($width, $height);
    imagecopy($output, $background, 0, 0, 20, 13, $width, $height);
    
    
    ob_start();
    imagepng($output);
    printf('<img id="output" src="data:image/png;base64,%s" />', base64_encode(ob_get_clean()));
}
?>