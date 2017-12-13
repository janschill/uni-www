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
    $sql = $this->db->prepare("INSERT INTO posts (title, text, created, author) VALUES (:title, :text, :created, :author)");

    $sql->bindParam(':title', $post['title']);
    $sql->bindParam(':text', $post['text']);
    $sql->bindParam(':created', $post['created']);
    $sql->bindParam(':author', $post['author']);
    
    $sql->execute();
    
    $lastId = $this->db->lastInsertId();

    $this->addTagToPost($lastId, $post['tags']);
    $this->addCategoryToPost($lastId, $post['category']);
    
  }

  private function addTagToPost($lastId, $tags)
  {
    var_dump($tags);
    foreach ($tags as $tag)
    {
      var_dump($tag);
      $tagid = $this->getTagByName($tag);
      var_dump($tagid);
      $query = "INSERT INTO tag2post (tagsid, postsid) VALUES (:tagid, :postid)";
  
      $sql = $this->db->prepare($query);
      $sql->bindParam(':tagid', $tagid['id']);
      $sql->bindParam(':postid', $lastId);
      
      $sql->execute();
    }
  }

  private function addCategoryToPost($lastId, $categories)
  {
    var_dump($categories);
    foreach ($categories as $category)
    {
      var_dump($category);
      $categoryid = $this->getCategoryByName($category);
      var_dump($categoryid);
      $query = "INSERT INTO category2post (categoriesid, postsid) VALUES (:categoryid, :postid)";
  
      $sql = $this->db->prepare($query);
      $sql->bindParam(':categoryid', $categoryid['id']);
      $sql->bindParam(':postid', $lastId);
      
      $sql->execute();
    }
  }

  public function editPost($post, $id)
  {
    $sql = $this->db->prepare("UPDATE posts SET title = :title, text = :text, created = :created, author = :author WHERE id = :id");

    $sql->bindParam(':title', $post['title']);
    $sql->bindParam(':text', $post['text']);
    $sql->bindParam(':created', $post['created']);
    $sql->bindParam(':author', $post['author']);
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
  
  public function getPostIdFromCreated($created)
  {
    $sql = $this->db->prepare("SELECT id FROM POSTS WHERE created = :created");
    $sql->bindParam(':created', $$created);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);
    return $row;
  }

  public function getFewPosts()
  {
    return $this->getRow("SELECT * FROM posts ORDER BY created desc LIMIT 3");
  }

  public function getAllPosts()
  {
    return $this->getRow("SELECT * FROM posts ORDER BY created desc");
  }


  public function getAllCategories()
  {
    return $this->getRow("SELECT * FROM categories");
  }

  private function getCategoryByName($name)
  {
    $query = "SELECT categories.id FROM categories WHERE categories.name = :name";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':name', $name);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);

    return $row;
  }

  public function getCategoryById($id)
  {
    $query = "SELECT categories.name FROM categories 
    JOIN category2post ON categories.id = category2post.categoriesid
    JOIN posts ON posts.id = category2post.postsid
    WHERE posts.id = :id";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);

    return $row;
  }

  public function getAllTags()
  {
    return $this->getRow("SELECT * FROM tags");
  }

  private function getTagByName($name)
  {
    $query = "SELECT tags.id FROM tags WHERE tags.name = :name";

    $sql = $this->db->prepare($query);
    $sql->bindParam(':name', $name);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);

    return $row;
  }

  public function getTagsById($id)
  {
    $query = "SELECT tags.name FROM tags
    JOIN tag2post ON tags.id = tag2post.tagsid
    JOIN posts ON posts.id = tag2post.postsid
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