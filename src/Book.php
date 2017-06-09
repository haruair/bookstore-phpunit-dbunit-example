<?php

namespace BookStore;

class Book
{
    protected $id;
    protected $title;
    protected $author;
    protected $publisher;
    protected $ISBN;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    public function setISBN($ISBN)
    {
        $this->ISBN = $ISBN;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function getISBN()
    {
        return $this->ISBN;
    }
}
