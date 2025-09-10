<?php

if(isset($_POST['submit'])){

    $file=$_FILES['file'];

    $fileName=$_FILES['file']['name'];
    $fileTmpName=$_FILES['file']['tmp_name'];
    $fileSize=$_FILES['file']['size'];
    $fileError=$_FILES['file']['error'];
    $fileType=$_FILES['file']['type'];

    $fileExt=explode('.',$fileName);// explodes the string(into array) based on delimiter passed
    $fileActualExt=strtolower(end($fileExt));//end() gets last pience of data from an array

    $allowed=array('jpg','jpeg','png','jfif','tiff','pdf','doc');

    if(in_array($fileActualExt,$allowed)){
        if($fileError===0){
            if($fileSize<1000000){
                $fileNameNew=uniqid('',true).".".$fileActualExt;
                $fileDestination='uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName,$fileDestination);
                header("Location: uploadFile.php?uploadsuccess");
            }
            else{
                echo "Your file size is too big";
            }
        }
        else{
            echo "Error while uploading your file to server";
        }
    }
    else{
        echo "Cannot upload files of this type";
    }

}

?>