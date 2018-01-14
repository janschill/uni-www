<?php 

namespace Controller;

class DocumentationController extends Controller 
{
  public function __construct($container)
  {
    parent::__construct($container);
  }

  public function showAction($request)
  {
    $user = $request->attributes->get('user');
    $html = $this->container['twig']->render('doc.html.twig', [
      'user' => $user
      ]);
    return new Response($html);
  }

}