<?php

    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // variable "upload" to check for errors
    $upload = 1;

    // Check if image file is a actual image or fake image
    if(isset($_POST["upload"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
            $upload = 1;
        } else {
            echo "File is not an image.";
            $upload = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $upload = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $upload = 0;
    }

    // Check if $upload is set to 0 by an error
    if ($upload == 0) {
        echo "Sorry, your file was not uploaded.";
    // upload file and print "1" if everything is ok
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo $upload;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

?>