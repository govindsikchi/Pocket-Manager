<?php
    function compressFiles($rootPath){
    @$ZipFileName=end(explode("/",$rootPath));

    $zip = new ZipArchive();
    $filename = "./".$ZipFileName.".zip";
    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("Unable to Open .zip file, check the folder level permissions. ");
    }
    
    //$rootPath = "./compressFiles/zipFiles";
    $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
    
    foreach ($files as $name => $file){
        if (!$file->isDir()){
            $zip->addFile($name);
        }
    }
    
    $zip->close();
   return true;
}

if(compressFiles("./compressFiles/zipFiles")==true){
    echo "Successfully Ccomperessed";
}
else{
    echo "Problem Occured";
}
    
?>