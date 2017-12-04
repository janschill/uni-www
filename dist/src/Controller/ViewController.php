<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewController extends Controller
{
    public function __construct($container)
    {
        parent::__construct($container);
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

    /**
     * deprecated
     */
    public function showConf($request)
    {
        $html = $this->container['twig']->render('conf.html.twig');
        return new Response($html);
    }
}
