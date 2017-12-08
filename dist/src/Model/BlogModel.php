<?php

namespace Model;

class BlogModel extends Model
{
    public function __construct($db)
    {
        parent::__construct($db);
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