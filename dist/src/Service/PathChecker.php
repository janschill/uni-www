<?php

namespace Service;

class PathChecker 
{
  public static function checkPath($path)
  {
    $instance = ['instance' => null, 'html' => null, 'edit' => false];

    if (strpos($path, 'project') !== false)
    {
      $instance['instance'] = 'projects';
    }
    if (strpos($path, 'blog') !== false)
    {
      $instance['instance'] = 'blog';
    }

    switch(true) 
    {
      case strcmp($path, 'adminproject') === 0:
        $instance['html'] = 'admin-posts.html.twig';
        break;
      case strcmp($path, 'adminblog') === 0:
        $instance['html'] = 'admin-posts.html.twig';
        break;
      case strcmp($path, 'adminblogid') === 0:
        $instance['html'] = 'admin-blog-new.html.twig';
        $instance['edit'] = true;
        break;
      case strcmp($path, 'adminprojectid') === 0:
        $instance['html'] = 'admin-project-new.html.twig';
        $instance['edit'] = true;
        break;
      case strcmp($path, 'adminblognew') === 0:
        $instance['html'] = 'admin-blog-new.html.twig';
        break;
      case strcmp($path, 'adminprojectnew') === 0:
        $instance['html'] = 'admin-project-new.html.twig';
        break;        
      case strcmp($path, 'blog') === 0:
        $instance['html'] = 'posts.html.twig';
        break;        
      case strcmp($path, 'projects') === 0:
        $instance['html'] = 'posts.html.twig';
        break;  
      case strcmp($path, 'blogID') === 0:
        $instance['html'] = 'post-single.html.twig';
        break;  
      case strcmp($path, 'projectsID') === 0:
        $instance['html'] = 'post-single.html.twig';
        break;    
      case strcmp($path, 'adminblogauthor') === 0:
        $instance['html'] = 'admin-posts.html.twig';
        break;      
      case strcmp($path, 'adminprojectsauthor') === 0:
        $instance['html'] = 'admin-posts.html.twig';
        break;                           
      default:
        $instance['error'] = 'Not able to parse path.';
        break;
    }

    //var_dump($instance);

    return $instance;
  }
}

