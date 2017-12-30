<?php

namespace Model;

abstract class Model
{

  protected $db;

  // abstract public function addPost($post, $id);
  // abstract protected function addTagToPost($lastId, $tags);
  // abstract protected function addCategoryToPost($lastId, $categories);
  // abstract public function getOnePost($id);
  // abstract public function getFewPosts();
  // abstract public function getAllPosts();
  // abstract public function getCategoryById($id);
  // abstract public function getTagsById($id);

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getRow($query)
  {
    $result = $this->db->query($query);
    $data = [];

    foreach ($result as $row) {
      $data[] = $row;
    }

    return $data;
  }

  public function getAllCategories()
  {
    return $this->getRow("SELECT * FROM categories");
  }

  protected function getCategoryByName($name)
  {
    $query = "SELECT categories.id FROM categories WHERE categories.name = :name";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':name', $name);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);

    return $row;
  }

  public function getAllTags()
  {
    return $this->getRow("SELECT * FROM tags");
  }

  public function getTagByName($name)
  {
    $query = "SELECT tags.id FROM tags WHERE tags.name = :name";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':name', $name);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);

    return $row;
  }

  public function addTag($table, $data)
  {
    $query = "INSERT INTO $table ('name') VALUES (:data)";
    $sql = $this->db->prepare($query);
    $sql->bindParam(':data', $data);

    $sql->execute();
  }

  public function deleteTag($id)
  {
    $sql = $this->db->prepare("DELETE FROM tags WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();

    return $sql;
  }

  public function getTableByName($table, $name)
  {
    $query = "SELECT * FROM $table WHERE :tableName = :name";

    $sql = $this->db->prepare($query);
    $tablename = $table . '.name';
    $sql->bindParam(':tableName', $tablename);
    $sql->bindParam(':name', $name);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);

    return $row;
  }
}