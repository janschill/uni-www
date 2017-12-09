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
    return $this->getRow("SELECT * FROM posts ORDER BY date desc");
  }

  public function getFewPosts()
  {
    return $this->getRow("SELECT * FROM posts ORDER BY date desc LIMIT 3");
  }

  public function getAllCategories()
  {
    return $this->getRow("SELECT * FROM categories");
  }

  public function deletePost($id)
  {
    $sql = $this->db->prepare("DELETE FROM posts WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();

    return $sql;
  }
}