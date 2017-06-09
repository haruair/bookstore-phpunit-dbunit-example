<?php
namespace BookStore\Test;

use PHPUnit\Framework\TestCase;
use BookStore\Book;

use BookStore\Util\InternalPropertyAssignTrait;

class BookTest extends TestCase
{
    use InternalPropertyAssignTrait;

    public function testCanCreate() {
        $book = new Book;
        $this->assertInstanceOf(Book::class, $book);
    }

    public function testHasId() {
        $book = new Book;
        $this->assignInternalProperty($book, 'id', 1234);

        $id = $book->getId();
        $this->assertEquals($id, 1234);
    }

    public function testHasTitle() {
        $book = new Book;
        $book->setTitle('Hello World');
        $title = $book->getTitle();
        $this->assertEquals($title, 'Hello World');
    }

    public function testHasAuthor() {
        $book = new Book;
        $book->setAuthor('Murakami Haruki');
        $author = $book->getAuthor();
        $this->assertEquals($author, 'Murakami Haruki');
    }

    public function testHasPublisher() {
        $book = new Book;
        $book->setPublisher('Many Trees');
        $publisher = $book->getPublisher();
        $this->assertEquals($publisher, 'Many Trees');
    }

    public function testHasISBN() {
        $book = new Book;
        $book->setISBN('012346789123');
        $isbn = $book->getISBN();
        $this->assertEquals($isbn, '012346789123');
    }
}
