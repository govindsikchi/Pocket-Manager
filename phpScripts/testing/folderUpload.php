<?php
  $count = 0;
  $folderName="";
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      $folderName=$_POST["dirName"];
      foreach ($_FILES['files']['name'] as $i => $name) {
          if (strlen($_FILES['files']['name'][$i]) > 1) {
              if (move_uploaded_file($_FILES['files']['tmp_name'][$i], 'uploads/zip/'.$name)) {
                  $count++;
              }
          }
      }
      echo "Count: ".$count;
  }

  //Enter the name of directory
    $pathdir = "uploads/zip/";
    //Enter the name to creating zipped directory
    $zipcreated = $folderName.".zip";
    //Create new zip class
    $newzip = new ZipArchive;
    if($newzip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
        $dir = opendir($pathdir);
        while($file = readdir($dir)) {
            if(is_file($pathdir.$file)) {
                $newzip -> addFile($pathdir.$file, $file);
            }
        }
        $newzip ->close();
    }
  /*
    function compressFiles($rootPath){
        echo("RootPath: ".$rootPath);
        @$ZipFileName=end(explode("/",$rootPath));
       // $zipName=explode("/",$rootPath);
      //  echo("This:<br>");
     //  print_r($ZipFileName);
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
            print_r($file);
            if (!$file->isDir()){
                $zip->addFile($name);
            }
        }
        
        $zip->close();
        return true;

    if(compressFiles('uploads/zip')==true){
        echo "Successfully Ccompressed";
       // header("Location: folder.php?uploadsuccess");
    }
    else{
        echo "Problem Occured";
    }
    */
  
  ?>