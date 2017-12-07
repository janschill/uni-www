<?php

namespace Model;

class Model {

  protected $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function getRow($query) {
    $result = $this->db->query($query);
    $data = [];

    foreach ($result as $row) {
        $data[] = $row;
    }

    return $data;
  }
}