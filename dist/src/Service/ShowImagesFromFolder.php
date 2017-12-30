<?php

namespace Service;

class ShowImagesFromFolder
{
  public function __construct()
  {
  }

  public static function showImages($root)
  {

    $location = $root . '/images/uploads/*/*/';
    $types = '{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF}';

    $images = glob($location . $types, GLOB_BRACE);
    $img = [];
    foreach ($images as $image) {
      $img[] = ['path' => str_replace($root, "", $image), 'name' => basename($image)];
    }
    return $img;
  }
}

