<?php

class PathChecker 
{
  public static function checkPath($path)
  {
    if (strpos($path, 'blog')) {
      return 'posts';
    } else if (strpos($path, 'project')) {
      return 'projects';
    } else {
      return null;
    }
  }
}