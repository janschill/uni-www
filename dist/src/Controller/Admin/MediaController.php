<?php

namespace Admin;

use Controller\Controller;
use Service\ShowImagesFromFolder;
use Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
  public function __construct($container)
  {
    parent::__construct($container);
  }

  public function showAdminMediaAction($request)
  {
    $images = ShowImagesFromFolder::showImages($this->root);
    $html = $this->render('admin-media.html.twig', [
      'images' => $images
    ]);
    
    return new Response($html);
  }

  
  /* **************************** image / upload **************************** */
  public function showAdminMediaFormAction($request)
  {
    // call by add new media

    if ($request->getMethod() !== 'POST') {
     $showForm = true;
      //hide form
    } else {
     $showForm = false;
      if (!FileUploader::upload($this->root)) {
        throw new \Exception;
      }
    }

    $images = ShowImagesFromFolder::showImages($this->root);

    $html = $this->render('admin-media.html.twig', [
      'images' => $images,
      'showForm' => $showForm
    ]);
    
    return new Response($html);
    
  }

}