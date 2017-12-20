<?php

namespace User;

class UserModel
{
  protected $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  /**
   * add new user to the database
   */
  public function addUser($user)
  {
    if ($this->getUser($user['username']) == null) {
      $query = "INSERT INTO users
      ('username', 'password') VALUES (:username, :password)";

      $sql = $this->db->prepare($query);

      $sql->bindParam(':username', $user['username']);
      $sql->bindParam(':password', password_hash($user['password'], PASSWORD_DEFAULT));

      $sql->execute();
    } else {
      throw new \Exception('User exists.');
    }
  }

  /**
   * retrieve user from database
   */
  public function getUser($username)
  {
    $query = "SELECT * FROM users WHERE username = :username";
    $sql = $this->db->prepare($query);
    $sql->bindParam(':username', $username);

    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);

    return $row;
  }

  public function getAllUsers()
  {
    return $this->getRow("SELECT username FROM users");
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

  public function getUserById($id)
  {
    $sql = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $row = $sql->fetch(\PDO::FETCH_ASSOC);
    return $row;
  }

  /**
   * check if user and password matches
   */
  public function isValidUser($username, $password)
  {
    $user = $this->getUser($username);

    if (isset($user['username'])) {
      return password_verify($password, $user['password']);
    }

    return false;
  }

  /**
   * fetch permission from database table
   */

  public function getAllPermissions()
  {
    return $this->getRow("SELECT * FROM permissions");
  }

  public function getAllUsersPermissions()
  {
    $query = "SELECT users.username, permissions.permission FROM permissions 
    JOIN user2permission ON permissions.id = user2permission.permissionid
    JOIN users ON users.id = user2permission.userid";

    $sql = $this->db->prepare($query);
    $sql->execute();    
    
    $row = $sql->fetchAll();
    var_dump($row);
    return $row;
  }

  public function getPermissions($username)
  {
    $query = "SELECT permissions.permission FROM permissions 
    JOIN user2permission ON permissions.id = user2permission.permissionid
    JOIN users ON users.id = user2permission.userid
    WHERE users.username = :username";
    
    $sql = $this->db->prepare($query);
    $sql->bindParam(':username', $username);
    $sql->execute();    
    /* to format the return array – fetches first item from every row – would otherwise return 2d array */
    $row = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);
    return $row;
  }
}