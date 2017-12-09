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

      $stmt = $this->db->prepare($query);

      $stmt->bindParam(':username', $user['username']);
      $stmt->bindParam(':password', password_hash($user['password'], PASSWORD_DEFAULT));

      $stmt->execute();
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
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':username', $username);

    $stmt->execute();
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);

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
   * temporarily like this – later with db permission table
   */
  public function getPermissions($username)
  {
    $query = "SELECT permissions.permission FROM permissions 
    JOIN user2permission ON permissions.id = user2permission.permissionid
    JOIN users ON users.id = user2permission.userid
    WHERE users.username = :username";
    
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();    
    $row = $stmt->fetchAll(\PDO::FETCH_COLUMN, 0);

    return $row;
  }

}