<?php

namespace Model;

class BlogModel extends Model
{
  public function __construct($db)
  {
    parent::__construct($db);
  }


  public function addPost($post)
  {
    $sql = $this->db->prepare("INSERT INTO posts (title, text, date, author, category) VALUES (:title, :text, :date, :author, :category)");

    $sql->bindParam(':title', $post['title']);
    $sql->bindParam(':text', $post['text']);
    $sql->bindParam(':date', $post['date']);
    $sql->bindParam(':author', $post['author']);
    $sql->bindParam(':category', $post['category']);

    $sql->execute();
  }

  public function getAllPosts()
  {
    return $this->getRow("SELECT * FROM posts");
  }

  public function getAllCategories()
  {
    return $this->getRow("SELECT * FROM categories");
  }
}