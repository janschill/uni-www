<?php
namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function __construct($container)
    {
        $this->container = $container;
        $this->model = new \App\Model($this->container['db']);
    }

    public function showIndex($request)
    {
        $html = $this->container['twig']->render('index.html.twig');
        return new Response($html);
    }

    public function showAbout($request)
    {
        $html = $this->container['twig']->render('about.html.twig');
        return new Response($html);
    }

    public function showProjects($request)
    {
        $id = $request->attributes->get('id');

        if (!isset($id)) {
            $html = $this->container['twig']->render('projects.html.twig');
            return new Response($html);
        } else {
            echo "Project";
        }
    }
    public function showBlog($request)
    {
        $html = $this->container['twig']->render('blog.html.twig');
        return new Response($html);
    }
}
