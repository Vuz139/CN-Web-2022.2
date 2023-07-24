<?php
include_once("model/Book.php");

class Model
{
    public function getBookList()
    {
        return array(
            "Jungle Book" => new Book("Jungle Book", "R Kipling", "A classic book"),
            "Moonwalke" => new Book("Moonwalke", "J> Walker", ""),
            "PHPforDummies" => new Book("PHPforDummies", "Some Smart Guy", ""),
        );
    }
    public function getBook($title)
    {

        $allBooks = $this->getBookList();
        return $allBooks[$title];
    }
}