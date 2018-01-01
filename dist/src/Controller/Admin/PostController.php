<?php

namespace Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Model\PostModel;
use User\UserModel;
use Controller\Controller;
use Service\ShowImagesFromFolder;
use Service\PathChecker;

class PostController extends Controller implements FormInterface
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
    $instance = PathChecker::checkPath($route);

    /**
     * when page is loaded with GET this will trigger and fill out
     * the form defaults – like get the categories
     *
     * when page is loaded with POST we will check all form inputs
     * and set $valid to true to save the formData to the database
     */

    // check if user wants to edit
    // if (strcmp($route, 'adminblogid') === 0) {
    //   $edit = true;
    // }

    if ($request->getMethod() !== 'POST') {
      $formData = $this->getFormDefaults($request, $instance, $id);
    } else {
      $formData = $request->get('form');
      list($valid, $formError) = $this->isFormDataValid($request, $formData);
    }

    if ($request->getMethod() == 'POST' && $valid) {
      $this->saveFormData($request, $instance['instance'], $formData, $id);

      return $this->redirect('/admin/' . $instance['instance'], 302);
    }

    $user = $this->getAttributeFromRequest($request, 'user');
    $categories = $this->postModel->getAllCategories();
    $tags = $this->postModel->getAllTags();
    $images = ShowImagesFromFolder::showImages($this->root);

    $html = $this->render($instance['html'], [
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

  public function getFormDefaults($request, $instance, $id)
  {
    if ($instance['edit']) {
      $post = $this->postModel->getOnePost($instance['instance'], $id);
      $categories = $this->postModel->getCategoryById($instance['instance'], $post['id']);
      $tags = $this->postModel->getTagsById($instance['instance'], $post['id']);

      $formData['title'] = $post['title'];
      $formData['description'] = $post['description'];
      $formData['text'] = $post['text'];
      $formData['created'] = $post['created'];
      $formData['author'] = $post['author'];
      $formData['cover'] = $post['cover'];
      $formData['categories'] = $categories;
      $formData['tags'] = $tags;

    } else {
      $formData['title'] = null;
      $formData['text'] = null;
      $formData['description'] = null;

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

  public function saveFormData(Request $request, $instance, $formData, $id)
  {
    $task['title'] = $formData['title'];
    $task['description'] = $formData['description'];
    $task['text'] = $formData['text'];
    $task['created'] = $formData['created'];
    $task['author'] = $formData['author'];
    $task['category'] = $formData['category'];
    $task['tags'] = $formData['tags'];
    $task['cover'] = $formData['cover'];

    $this->postModel->addPost($instance, $task, $id);
  }


  /* **************************** admin / blog **************************** */
  public function showAdminAction($request)
  {
    $author = $this->getAttributeFromRequest($request, 'author');
    $route = $this->getAttributeFromRequest($request, '_route');
    $instance = PathChecker::checkPath($route);
    
    if ($author !== null)
    {
      $authorId = $this->userModel->getUserId($author);
      $posts = $this->postModel->getAllPostsByAuthor($instance['instance'], $authorId['id']);
    } else 
    {
      $posts = $this->postModel->getAllPosts($instance['instance']);
    }

    $posts_edited = [];
    $tags = [];
    $categories = [];

    foreach ($posts as $post) {
      $temp_author = $this->userModel->getUserById($post['author']);
      $post['author'] = $temp_author['username'];
      $post['tags'] = $this->postModel->getTagsById($instance['instance'], $post['id']);
      $post['category'] = $this->postModel->getCategoryById($instance['instance'], $post['id']);
      array_push($posts_edited, $post);
    }

    $user = $this->getAttributeFromRequest($request, 'user');
    $html = $this->render($instance['html'], array(
      'posts' => $posts_edited,
      'user' => $user,
      'instance' => $instance
    ));

    return new Response($html);
  }

  /* **************************** admin / blog / delete **************************** */
  public function deleteAdminAction($request)
  {
    $id = $this->getAttributeFromRequest($request, 'id');
    $route = $this->getAttributeFromRequest($request, '_route');
    $instance = PathChecker::checkPath($route);

    if (isset($id)) {
      if ($this->postModel->deletePost($instance['instance'], $id)) {
        $newpath = '/admin/' . $instance['instance'];
        return $this->redirect($newpath, 302);
      }
    }
  }
}