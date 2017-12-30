<?php

namespace Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Model\BlogModel;
use User\UserModel;
use Controller\Controller;
use Service\ShowImagesFromFolder;

class BlogController extends Controller implements PostsInterface
{
  protected $formData;

  public function __construct($container)
  {
    parent::__construct($container);
  }

  /* **************************** admin / blog / edit or  new **************************** */
  public function showFormAction(Request $request)
  {
    $formData = [];
    $formError = [];
    $valid = false;
    $edit = false;
    $route = $this->getAttributeFromRequest($request, '_route');
    $id = $this->getAttributeFromRequest($request, 'id');

    /**
     * when page is loaded with GET this will trigger and fill out
     * the form defaults – like get the categories
     *
     * when page is loaded with POST we will check all form inputs
     * and set $valid to true to save the formData to the database
     */

    // check if user wants to edit
    if (strcmp($route, 'adminblogid') === 0) {
      $edit = true;
    }
    if ($request->getMethod() !== 'POST') {
      $formData = $this->getFormDefaults($request, $edit, $id);
    } else {
      $formData = $request->get('form');
      list($valid, $formError) = $this->isFormDataValid($request, $formData);
    }

    if ($request->getMethod() == 'POST' && $valid) {
      $this->saveFormData($request, $formData, $id);

      return $this->redirect('/admin/blog', 302);
    }

    $user = $this->getAttributeFromRequest($request, 'user');
    $categories = $this->blogModel->getAllCategories();
    $tags = $this->blogModel->getAllTags();
    $images = ShowImagesFromFolder::showImages($this->root);

    $html = $this->render('admin-blog-new.html.twig', [
      'form' => $formData,
      'error' => $formError,
      'user' => $user,
      'categories' => $categories,
      'tags' => $tags,
      'images' => $images
    ]);

    return new Response($html);
  }

  public function isFormDataValid(Request $request, $formData)
  {
    $valid = true;
    $formError = [];
    $token = $this->getToken();

    if ((!isset($formData['token'])) || (!hash_equals($token,
        $formData['token']))
    ) {
      $valid = false;
      $formError['token'] = 'Bad token';
      throw new \Exception('Bad CSRF token.');
    }

    if ((!isset($formData['title'])) || (strlen($formData['title']) < 3) || (!isset($formData['text']))) {
      $valid = false;
      $formError['title'] = "Please fill out all input fields";
    }

    if (!isset($formData['tags']) || !isset($formData['tags'])) {
      $valid = false;
      $formError['cattag'] = "Please select atleast one category and one tag";
    }


    if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE) {
    } else {
      if ($this->uploadImage() === 0) {
        $valid = false;
        $formError['image'] = 'Bad image';
        throw new \Exception('Bad image.');
      }
    }

    return [$valid, $formError];
  }

  public function getFormDefaults($request, $edit, $id)
  {
    if ($edit) {
      $post = $this->blogModel->getOnePost($id);
      $categories = $this->blogModel->getCategoryById($post['id']);
      $tags = $this->blogModel->getTagsById($post['id']);

      $formData['title'] = $post['title'];
      $formData['text'] = $post['text'];
      $formData['created'] = $post['created'];
      $formData['author'] = $post['author'];
      $formData['cover'] = $post['cover'];
      $formData['categories'] = $categories;
      $formData['tags'] = $tags;

    } else {
      $formData['title'] = null;
      $formData['text'] = null;

      if (date_default_timezone_get() != 'CET') {
        date_default_timezone_set('CET');
      }

      $formData['created'] = date('m/d/Y h:i:s a', time());

      $user = $this->getAttributeFromRequest($request, 'user');
      $id = $this->userModel->getUser($user->getUsername());

      $formData['author'] = $id['id'];
    }

    $formData['token'] = $this->getToken();

    return $formData;
  }

  public function saveFormData(Request $request, $formData, $id)
  {
    $task['title'] = $formData['title'];
    $task['text'] = $formData['text'];
    $task['created'] = $formData['created'];
    $task['author'] = $formData['author'];
    $task['category'] = $formData['category'];
    $task['tags'] = $formData['tags'];
    $task['cover'] = $formData['cover'];

    $this->blogModel->addPost($task, $id);
  }


  /* **************************** admin / blog **************************** */
  public function showAdminAction($request)
  {
    $route = $this->getAttributeFromRequest($request, '_route');

    var_dump($route);

    $instance = PathChecker::checkPath($route);
    
    if(strcmp($route, 'adminblog') == 0) {
      $instance = 'posts';
      $htmlfile = 'admin-blog.html.twig';
    } else {
      $instance = 'projects';
      $htmlfile = 'admin-projects.html.twig';
    }
    var_dump($instance);
    $posts = $this->blogModel->getAllPosts($instance);
    $posts_edited = [];
    $tags = [];
    $categories = [];

    foreach ($posts as $post) {
      $temp_author = $this->userModel->getUserById($post['author']);
      $post['author'] = $temp_author['username'];
      $post['tags'] = $this->blogModel->getTagsById($post['id']);
      $post['category'] = $this->blogModel->getCategoryById($post['id']);
      array_push($posts_edited, $post);
    }

    $user = $this->getAttributeFromRequest($request, 'user');
    $html = $this->render($htmlfile, array(
      'posts' => $posts_edited,
      'user' => $user
    ));

    return new Response($html);
  }

  /* **************************** admin / blog / delete **************************** */
  public function deleteAdminBlogAction($request)
  {
    $id = $this->getAttributeFromRequest($request, 'id');

    if (isset($id)) {
      if ($this->blogModel->deletePost($id)) {
        return $this->redirect('/admin/blog', 302);
      }
    }
  }

  /* **************************** admin / blog / edit **************************** */
  public function editAdminBlogAction($request)
  {
    // $id = $request->attributes->get('id');
    $this->showFormAction($request);

  }

}