<?php

namespace Service;

class ShowImagesFromFolder
{
  public function __construct(){}

  public static function showImages()
  {
    $location = __DIR__ . '/../../public/images/uploads/';
    $types = '{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF}';

    $images = glob($location . $types, GLOB_BRACE);
    $names = [];
    foreach ($images as $image)
    {
      $names[] = basename($image);
    }

    return $names;
  }
}

