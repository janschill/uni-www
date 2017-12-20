<?php

namespace Admin;

use Controller\Controller;
use Service\ShowImagesFromFolder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
  
  public function showAdminMediaAction($request)
  {
    $images = ShowImagesFromFolder::showImages();
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
      //hide form
    } else {
      FileUploader::upload();

      if (!$this->isAjax($request)) {
          return $this->redirect('/media/new', 201);
      } else {
          // Return correct statuscode
          return new Response($html, 201);
      }
    }

    $images = ShowImagesFromFolder::showImages();


    if ($this->isAjax($request)) {
      $html = $this->render('admin-media-form.html.twig', [

      ]);

      if ($request->getMethod() === 'POST') {
        return new Reponse($html, 422);
      } else {
        return new Response($html, 200);
      }
    } else {
      $html = $this->render('admin-media-formAndList.html.twig', [
        'images' => $images
      ]);
      return new Response($html);
    }



    $images = ShowImagesFromFolder::showImages();
    $html = $this->render('admin-media.html.twig', [
      'images' => $images
    ]);
    
    return new Response($html);
    
  }
  
  
  private function isAjax($request)
  {
      return (($request->headers->get('X-Requested-With') == 'XMLHttpRequest'));
  }

}