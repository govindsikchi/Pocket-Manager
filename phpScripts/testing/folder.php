<html>
  <head>
  <title>Upload Folder using PHP </title>
  </head>
  <body>
  <form action="folderUpload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory="">
    Folder Name: <input type="text" name="dirName" id="dir">
    <input class="button" type="submit" value="upload" />
</form>
  </body>
  </html>