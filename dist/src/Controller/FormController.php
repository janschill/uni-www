<?php

namespace Controller;

class FormController extends Controller
{
  public function __construct($container)
  {
    parent::__construct($container);
  }

  public function getToken()
  {
    if ($this->is_session_started() === false) {
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
}