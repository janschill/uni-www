<?php

namespace Model;

class PostModel extends Model
{
  public function __construct($db)
  {
    parent::__construct($db);
  }

  public function addPost($instance, $post, $id)
  {
    if ($this->getOnePost($instance, $id) != null) {
      $queryDelete = "DELETE FROM $instance WHERE id = :id";
      $sqlDelete = $this->db->prepare($queryDelete);
      $sqlDelete->bindParam(':id', $id);
      $sqlDelete->execute();
    }

    $sql = $this->db->prepare("INSERT INTO $instance (title, description, text, created, author, cover) VALUES (:title, :description, :text, :created, :author, :cover)");

    $sql->bindParam(':title', $post['title']);
    $sql->bindParam(':description', $post['description']);
    $sql->bindParam(':text', $post['text']);
    $sql->bindParam(':created', $post['created']);
    $sql->bindParam(':author', $post['author']);
    $sql->bindParam(':cover', $post['cover']);

    $sql->execute();

    $lastId = $this->db->lastInsertId();

    $this->addTagToPost($instance, $lastId, $post['tags']);
    $this->addCategoryToPost($instance, $lastId, $post['category']);
  }

  protected function addTagToPost($instance, $lastId, $tags)
  {
    $instanceId = $instance . 'id';
    $tag2Instance = 'tag2' . $instance;
    // clear all entries before adding the new set
    $query = "DELETE FROM $tag2Instance WHERE $instanceId = :postid";
    $sql = $this->db->prepare($query);
    $sql->bindParam(':postid', $lastId);
    $sql->execute();

    foreach ($tags as $tag) {
      $tagid = $this->getTagByName($tag);
      $query = "INSERT INTO $tag2Instance (tagsid, $instanceId) VALUES (:tagid, :postid)";

      $sql = $this->db->prepare($query);
      $sql->bindParam(':tagid', $tagid['id']);
      $sql->bindParam(':postid', $lastId);

      $sql->execute();
    }
  }

  protected function addCategoryToPost($instance, $lastId, $categories)
  {
    $instanceId = $instance . 'id';
    $category2Instance = 'category2' . $instance;
    // clear all entries before adding the new set
    $query = "DELETE FROM $category2Instance WHERE $instanceId = :postid";
    $sql = $this->db->prepare($query);
    $sql->bindParam(':postid', $lastId);
    $sql->execute();

    foreach ($categories as $category) {
      $categoryid = $this->getCategoryByName($category);
      $query = "INSERT INTO $category2Instance (categoriesid, $instanceId) VALUES (:categoryid, :postid)";

      $sql = $this->db->prepare($query);
      $sql->bindParam(':categoryid', $categoryid['id']);
      $sql->bindParam(':postid', $lastId);

      $sql->execute();
    }
  }

  public function getOnePost($instance, $id)
  {
    $sql = $this->db->prepare("SELECT * FROM $instance JOIN users ON author = users.id WHERE $instance.id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);
    return $row;
  }

  public function getFewPosts($instance)
  {
    return $this->getRow("SELECT * FROM $instance ORDER BY created desc LIMIT 3");
  }

  public function getAllPosts($instance)
  {
    return $this->getRow("SELECT * FROM $instance ORDER BY created desc");
  }

  public function getAllPostsByAuthor($instance, $id)
  {
    $sql = $this->db->prepare("SELECT * FROM $instance WHERE author = :id ORDER BY created desc");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetchAll();
    return $row;
  }

  public function getCategoryById($instance, $id)
  {
    $instanceId = $instance . 'id';
    $category2Instance = 'category2' . $instance;

    $query = "SELECT categories.name FROM categories 
    JOIN $category2Instance ON categories.id = $category2Instance.categoriesid
    JOIN $instance ON $instance.id = $category2Instance.$instanceId
    WHERE $instance.id = :id";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);

    return $row;
  }

  public function getTagsById($instance, $id)
  {
    $instanceId = $instance . 'id';
    $tag2Instance = 'tag2' . $instance;
    
    $query = "SELECT tags.name FROM tags
    JOIN $tag2Instance ON tags.id = $tag2Instance.tagsid
    JOIN $instance ON $instance.id = $tag2Instance.$instanceId
    WHERE $instance.id = :id";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);
    return $row;
  }

  public function deletePost($instance, $id)
  {
    $sql = $this->db->prepare("DELETE FROM $instance WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();

    return $sql;
  }

  public function addComment($formData, $id)
  {
    if (date_default_timezone_get() != 'CET') 
    {
      date_default_timezone_set('CET');
    }
    $formData['created'] = date('m/d/Y h:i:s a', time());

    $sql = $this->db->prepare("INSERT INTO comments (admin, text, created, blogid) VALUES (:admin, :text, :created, :blogid)");

    $sql->bindParam(':admin', $formData['admin']);
    $sql->bindParam(':text', $formData['text']);
    $sql->bindParam(':created', $formData['created']);
    $sql->bindParam(':blogid', $id);
        
    $sql->execute();
  }

  public function getAllCommentsForPost($id)
  {
    $query = "SELECT c.text, c.created, u.username FROM comments c JOIN blog b ON c.blogid = b.id JOIN users u ON c.admin = u.id WHERE b.id = :id";
    $sql = $this->db->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetchAll();

    return $row;
  }

}