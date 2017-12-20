<?php

namespace Service;

class FileUploader
{
  public static function upload($root)
  {
    var_dump('fileupload');
    $valid = 1;
    if ($_FILES) {
      var_dump('1');
      /* creates accordingly folders and moves image there */
      $path = $root . '/images/uploads/' . date("Y", time()) . "/". date("m", time()) . "/";
      if (!file_exists($path)) {
        var_dump('2');
        mkdir($path, 0777, true);
      }
      var_dump('3');
      $uploadfile = $path . basename($_FILES['file-upload']['name']);
      $valid = 1;
      
      if (!move_uploaded_file($_FILES['file-upload']['tmp_name'], $uploadfile)) {
        $valid = 0;
         var_dump('fileupload');
      }
    }
    var_dump($valid);
    return $valid;
  }
}