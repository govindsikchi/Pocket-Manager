<?php
    $str;
    
    function download($filename){
        echo"INside d1";
        if(file_exists($filename)) {
            echo "<br>Inside d2";

            header("Cache-Control: public");
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename="'.basename($filename).'\"');
            header('Content-Type: application/zip');
            header("Content-Transfer-Encoding:binary");
            //Define header information
            /*header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: 0");
            header('Content-Disposition: attachment; filename="'.basename($filename).'"');
            header('Content-Length: ' . filesize($filename));
            header('Pragma: public');
            
            //Clear system output buffer
            flush();
            */
            //Read the size of the file
            readfile($filename);
            //
            //Terminate from the script
            echo"Downloaded Successfully";
            die();
        }
        else{
            echo "File does not exist.";
        }
          
    }



    if(isset($_POST)){
        $operation=$_POST['upload'];
        $folderName='';
        //File Compression
        if($operation=="fcompress"){

            $folderName=$_POST['dirName'];
            $count = 0;

                    foreach ($_FILES['files']['name'] as $i => $name) {
                        if (strlen($_FILES['files']['name'][$i]) > 1) {
                            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], 'uploads/zip/'.$folderName.$name)) {
                                $count++;
                            }
                        }
                    }
            
            $pathdir = "uploads/zip/";
                    //Enter the name to creating zipped directory
            $zipcreated = $folderName.".zip";
                    //Create new zip class
            $newzip = new ZipArchive;
            $finalLocation="zippedFiles/";
            if($newzip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
                $dir = opendir($pathdir);
                while($file = readdir($dir)) {
                    if(is_file($pathdir.$file)) {
                        $newzip -> addFile($pathdir.$file, $file);
                    }
                }
                $newzip ->close();

            }        
            if( !rename($folderName.".zip", $finalLocation.$folderName.".zip") ) {  
                //echo "File can't be moved!";  
                die();
            }  
            else {  
                echo "File has been moved!";  
            } 
            $filename=$finalLocation.$zipcreated;
            download($filename);
            unlink($fileName);
            header("Location: indeX_.php?");
            
            
        }

        // Image Compression
        if($operation=="imgcompress"){

            function upload_image(){

                $uploadTo = "uploads/imageCompression/"; 
                $allowImageExt = array('jpg','png','jpeg','gif');
                $imageName = $_FILES['file']['name'];
                $tempPath=$_FILES["file"]["tmp_name"];
                $imageQuality=$_POST['cRatio'];

        
                //$imageQuality= 20;

                $basename = basename($imageName);
                $originalPath = $uploadTo.$basename; 
                $imageExt = pathinfo($originalPath, PATHINFO_EXTENSION); 

                if(empty($imageName)){ 
                    $error="Please Select files..";
                    return $error;
                
                }
                else{
            
                        if(in_array($imageExt, $allowImageExt)){ 

                            $compressedImage = compress_image($tempPath, $originalPath, $imageQuality);
                            if($compressedImage){
                                download($compressedImage);
                                unlink($compressedImage);
                                return "Image was compressed and uploaded to server";
                               
                            }
                            else{
                                return "Some error !.. check your script";
                            }
                        }
                        else{
                            return "Image Type not allowed";
                        }

                    } 
                }

                function compress_image($tempPath, $originalPath, $quality){
                
                    // Get image info 
                    $imgInfo = getimagesize($tempPath); 
                    $mime = $imgInfo['mime']; 
                    $val=70;
                    // Create a new image from file 
                    switch($mime){ 
                        case 'image/jpeg': 
                            echo"Innn";
                            if($quality=='3')
                                $val=20;
                            else if($quality=='2')
                                $val=50;
                            //echo $val;
                            $image = imagecreatefromjpeg($tempPath); 
                            imagejpeg($image, $originalPath, $val);       //for jpeg 0-100
                            break; 
                        case 'image/png':

                            if($quality=='3')
                                $val=3;
                            else if($quality=='2')
                                $val=5;
                            else 
                                $val=7; 
                             //echo $val;
                            $image = imagecreatefrompng($tempPath); 
                            imagepng($image, $originalPath, $val);         //for png from 0-9
                            break; 
                        case 'image/gif': 
                            if($quality=='3')
                                $val=20;
                            else if($quality=='2')
                                $val=50;
                            //echo $val;
                            $image = imagecreatefromgif($tempPath); 
                            imagejpeg($image, $originalPath, $val);
                            break;
                             
                        default:
                            if($quality=='3')
                                $val=20;
                            else if($quality=='2')
                                $val=50;
                            //echo $val;
                            $image = imagecreatefromjpeg($tempPath); 
                            imagejpeg($image, $originalPath, $val);
                    } 
                    //imagecreatefromstring()
                    // Save image 
                    //imagejpeg($image, $originalPath, $quality);    
                    // Return compressed image 
                   // echo"Done buddy";
                   //echo $originalPath;
                    return $originalPath; 

                }

                $msg= upload_image(); 
                
                header("Location: indeX_.php?");

        }
        
        if($operation=="encrypt"){
            $str=md5($_POST["txt"]);
            echo($str);
            //$fileName=$_FILES['file']['name'];
            $fileNameNew="uploads/encryptFiles/".uniqid('',true).".txt";
            $file1 = fopen($fileNameNew, "w");
            fwrite($file1,$str);
            download($fileNameNew);
            unlink($fileNameNew);
            header("Location: indeX_.php");
        }

    }
    //floack()


?>