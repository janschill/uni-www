<?php

namespace Model;

class BlogModel extends \Model\Model {

  public function __construct($db) {
    parent::__construct($db);
  }

  public function getAllPosts($request) {
    return $this->getRow("SELECT * FROM posts");
  }

}