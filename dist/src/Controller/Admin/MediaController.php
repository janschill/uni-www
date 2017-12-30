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

  /* **************************** image / upload **************************** */
  public function showAdminMediaFormAction($request)
  {
    $error = [];
    $images = [];

    if ($request->getMethod() !== 'POST') {
      $showForm = true;
      //hide form
    } else {
      $showForm = false;
      if (FileUploader::upload($this->root) != 1) {
        var_dump("error");
        $error['format'] = "Invalid file format";
      }
    }

    $images = ShowImagesFromFolder::showImages($this->root);
    $user = $this->getAttributeFromRequest($request, 'user');

    $html = $this->render('admin-media.html.twig', [
      'images' => $images,
      'showForm' => $showForm,
      'error' => $error,
      'user' => $user
    ]);

    return new Response($html);

  }

}