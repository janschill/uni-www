<?php

namespace Model;

class ProjectModel extends Model
{
  public function __construct($db)
  {
    parent::__construct($db);
  }

  public function addPost($post, $id)
  {
    if ($this->getOnePost($id) != null) {
      $queryDelete = "DELETE FROM projects WHERE id = :id";
      $sqlDelete = $this->db->prepare($queryDelete);
      $sqlDelete->bindParam(':id', $id);
      $sqlDelete->execute();
    }

    $sql = $this->db->prepare("INSERT INTO projects (title, text, created, author, description, cover) VALUES (:title, :text, :created, :author, :description, :cover)");

    $sql->bindParam(':title', $post['title']);
    $sql->bindParam(':text', $post['text']);
    $sql->bindParam(':created', $post['created']);
    $sql->bindParam(':author', $post['author']);
    $sql->bindParam(':description', $post['description']);
    $sql->bindParam(':cover', $post['cover']);

    $sql->execute();

    $lastId = $this->db->lastInsertId();

    $this->addTagToPost($lastId, $post['tags']);
    $this->addCategoryToPost($lastId, $post['category']);
  }

  protected function addTagToPost($lastId, $tags)
  {
    // clear all entries before adding the new set
    $query = "DELETE FROM tag2project WHERE postsid = :projectid";
    $sql = $this->db->prepare($query);
    $sql->bindParam(':projectid', $lastId);
    $sql->execute();

    foreach ($tags as $tag) {
      $tagid = $this->getTagByName($tag);
      $query = "INSERT INTO tag2project (tagsid, projectid) VALUES (:tagid, :projectid)";

      $sql = $this->db->prepare($query);
      $sql->bindParam(':tagid', $tagid['id']);
      $sql->bindParam(':projectid', $lastId);

      $sql->execute();
    }
  }

  protected function addCategoryToPost($lastId, $categories)
  {
    // clear all entries before adding the new set
    $query = "DELETE FROM category2project WHERE projectid = :projectid";
    $sql = $this->db->prepare($query);
    $sql->bindParam(':projectid', $lastId);
    $sql->execute();

    foreach ($categories as $category) {
      $categoryid = $this->getCategoryByName($category);
      $query = "INSERT INTO category2project (categoriesid, projectid) VALUES (:categoryid, :projectid)";

      $sql = $this->db->prepare($query);
      $sql->bindParam(':categoryid', $categoryid['id']);
      $sql->bindParam(':projectid', $lastId);

      $sql->execute();
    }
  }

  public function getOnePost($id)
  {
    $sql = $this->db->prepare("SELECT * FROM projects WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);
    return $row;  
  }

  public function getFewPosts()
  {
      return $this->getRow("SELECT * FROM projects ORDER BY created desc LIMIT 3");
  }

  public function getAllPosts()
  {
      return $this->getRow("SELECT * FROM projects ORDER BY created desc");
  }

  public function getCategoryById($id)
  {
    $query = "SELECT categories.name FROM categories 
    JOIN category2project ON categories.id = category2project.categoriesid
    JOIN projects ON projects.id = category2project.projectsid
    WHERE projects.id = :id";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);

    return $row;
  }

  public function getTagsById($id)
  {
    $query = "SELECT tags.name FROM tags
    JOIN tag2project ON tags.id = tag2project.tagsid
    JOIN projects ON projects.id = tag2project.projectsid
    WHERE projects.id = :id";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);

    return $row;  }
}