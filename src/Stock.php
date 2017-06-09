<?php

namespace BookStore;

use BookStore\Book;
use BookStore\BookStore;

class Stock
{
    protected $id;
    protected $book;
    protected $bookstore;

    public function getId()
    {
        return $this->id;
    }

    public function getBook()
    {
        return $this->book;
    }

    public function getBookStore()
    {
        return $this->bookstore;
    }

    public function setBook(Book $book)
    {
        $this->book = $book;
    }

    public function setBookStore(BookStore $bookstore)
    {
        $this->bookstore = $bookstore;
    }
}
