<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Model\BlogModel;
use User\UserModel;
use Service\ShowImagesFromFolder;

class AdminController extends Controller
{
  protected $formData, $blogModel, $userModel;

  public function __construct($container)
  {
    parent::__construct($container);
    $this->blogModel = new BlogModel($this->container['db']);
    $this->userModel = new UserModel($this->container['db']);
  }

  /* **************************** admin **************************** */
  public function showFormAction(Request $request)
  {
    $formData = [];
    $formError = [];
    $valid = false;
    $edit = false;
    $route = $request->attributes->get('_route');
    $id = $request->attributes->get('id');
  
    /**
     * when page is loaded with GET this will trigger and fill out
     * the form defaults – like get the categories
     * 
     * when page is loaded with POST we will check all form inputs
     * and set $valid to true to save the formData to the database
     */
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
      $this->saveFormData($request, $formData, $edit, $id);

      return $this->redirect('/admin/blog', 302);
    }
    
    $user = $this->getUserFromRequest($request);
    $categories = $this->blogModel->getAllCategories();
    $tags = $this->blogModel->getAllTags();
    
    $html = $this->render('admin-blog-new.html.twig', [
      'form' => $formData,
      'error' => $formError,
      'user' => $user,
      'categories' => $categories,
      'tags' => $tags
      ]);
      
      return new Response($html);
    }
    
    protected function isFormDataValid(Request $request, $formData)
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

      if(!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE) {
      } else {
          if ($this->uploadImage() === 0) {
            $valid = false;
            $formError['image'] = 'Bad image';
            throw new \Exception('Bad image.');
        }
      }

    return [$valid, $formError];
  }

  protected function getFormDefaults($request, $edit, $id)
  {
    if ($edit)
    {
      $post = $this->blogModel->getOnePost($id);
      $category = $this->blogModel->getCategoryById($post['category']);
      // var_dump($category);
      
      $formData['title'] = $post['title'];
      $formData['text'] = $post['text'];
      $formData['created'] = $post['created'];
      $formData['author'] = $post['author'];

      // here get category and tags


    } else {
      $formData['title'] = null;
      $formData['text'] = null;

      if (date_default_timezone_get() != 'CET') {
        date_default_timezone_set('CET');
      }      
      
      $formData['created'] = date('m/d/Y h:i:s a', time());
      
      $user = $this->getUserFromRequest($request);
      $id = $this->userModel->getUser($user->getUsername());
      
      $formData['author'] = $id['id'];
      $formData['category'] = null;
    }
    
    $formData['token'] = $this->getToken();
    
    return $formData;
  }

  private function getToken()
  {
    if ($this->is_session_started() === false) {
      //session_start();
    }
    if (empty($_SESSION['token'])) {
      if (function_exists('random_bytes')) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
      } else {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
      }
    }
    $token = $_SESSION['token'];

    return $token;
  }

  private function is_session_started()
  {
    if (php_sapi_name() !== 'cli') {
      if (version_compare(phpversion(), '5.4.0', '>=')) {
        return session_status() === PHP_SESSION_ACTIVE ? true : false;
      } else {
        return session_id() === '' ? false : true;
      }
    }
    return false;
  }

  /**
   */
  protected function saveFormData(Request $request, $formData, $edit, $id)
  {
    var_dump($formData);
    $task['title'] = $formData['title'];
    $task['text'] = $formData['text'];
    $task['created'] = $formData['created'];
    $task['author'] = $formData['author'];



    // if(isset($formData['category']))
    // {
    //   foreach ($formData['category'] as $tag)
    //   {
    //     $task[] = $tag;
    //   }
    // }
    $task['category'] = $formData['category'];
    $task['tags'] = $formData['tags'];


    var_dump($task);
    if ($edit) {
      $this->blogModel->editPost($task, $id);
    } else {
      $this->blogModel->addPost($task);
    }
  }



  /* **************************** image **************************** */
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



  /* **************************** logout **************************** */
  public function logoutAction($request)
  {
    $user = $this->getUserFromRequest($request);
    $user->logout($request);
    return $this->redirect('/', 302);
  }

  
  /* **************************** admin **************************** */
  public function showAdminAction($request)
  {
    $posts = $this->blogModel->getFewPosts();  
    $user = $this->getUserFromRequest($request);
    $html = $this->render('admin.html.twig', array(
      'user' => $user,
      'posts' => $posts
    ));
      
      
    // $html = $this->container['twig']->render('admin.html.twig', [
    //   'user' => $user,
    //   'posts' => $posts
    //   ]);
      
      return new Response($html);
    }
    
  /* **************************** admin / blog **************************** */
  public function showAdminBlogAction($request)
  {
    $posts = $this->blogModel->getAllPosts();
    $posts_edited = [];
    $tags = [];
    $categories = [];

    foreach ($posts as $post) {
      // var_dump($post['category']);
      // $temp_category = $this->blogModel->getCategoryById($post['category'][]);
      // $temp_tag = $this->blogModel->getTagById($post['tag'][]);
      $temp_author = $this->userModel->getUserById($post['author']);
      
      // $post['category'] = $temp_category['name'];
      // $post['tag'] = $temp_tag['name'];
      $post['author'] = $temp_author['username'];
      $post['tags'] = $this->blogModel->getTagsById($post['id']);
      $post['category'] = $this->blogModel->getCategoryById($post['id']);
      array_push($posts_edited, $post);
    }

    $user = $this->getUserFromRequest($request);
    $html = $this->render('admin-blog.html.twig', array(
      'posts' => $posts_edited,
      'user' => $user
    ));
          
      return new Response($html);
    }
    
  /* **************************** admin / blog / delete **************************** */
  public function deleteAdminBlogAction($request)
  {
    $id = $request->attributes->get('id');

    if (isset($id))
    {
      if ($this->blogModel->deletePost($id))
      {
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


  public function showAdminProjectsAction($request)
  {
    $user = $this->getUserFromRequest($request);    
    $projects = $this->blogModel->getAllPosts();
    $html = $this->render('admin-projects.html.twig', [
      'projects' => $projects,
      'user' => $user
    ]);
    
    return new Response($html);
  }


  private function getUserFromRequest($request)
  {
    return $request->attributes->get('user');
  }

}