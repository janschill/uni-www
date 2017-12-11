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

  public function editPost($post, $id)
  {
    $sql = $this->db->prepare("UPDATE posts SET title = :title, text = :text, date = :date, author = :author, category = :category WHERE id = :id");

    $sql->bindParam(':title', $post['title']);
    $sql->bindParam(':text', $post['text']);
    $sql->bindParam(':date', $post['date']);
    $sql->bindParam(':author', $post['author']);
    $sql->bindParam(':category', $post['category']);
    $sql->bindParam(':id', $id);

    $sql->execute();
  }

  public function getOnePost($id)
  {
    $sql = $this->db->prepare("SELECT * FROM POSTS WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);
    return $row;
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

  public function getCategoryById($id)
  {
    $sql = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);
    return $row;
  }

  public function getAllTags()
  {
    return $this->getRow("SELECT * FROM tags");
  }

  public function getTagsById($id)
  {
    $query = "SELECT tags.name FROM tags
    JOIN tag2post ON tags.id = tag2post.tagid
    JOIN posts ON posts.id = tag2post.postid
    WHERE posts.id = :id";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();    
    /* to format the return array – fetches first item from every row – would otherwise return 2d array */
    $row = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);
    
    return $row;
  }
  
  public function deletePost($id)
  {
    $sql = $this->db->prepare("DELETE FROM posts WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();

    return $sql;
  }
}