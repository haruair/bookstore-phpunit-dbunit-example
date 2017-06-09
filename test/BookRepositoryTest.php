<?php

namespace BookStore\Test;

use BookStore\Test\Util\DatabaseTestCase as TestCase;
use BookStore\BookRepository;
use BookStore\Book;

class BookRepositoryTest extends TestCase
{
    protected $fixtureFile = '/fixture/book.xml';

    public function testCanCreate()
    {
        $context = $this->getPDO();
        $repository = new BookRepository($context);
        $this->assertInstanceOf(BookRepository::class, $repository);
    }

    public function testCanFindBookById()
    {
        $context = $this->getPDO();
        $repository = new BookRepository($context);

        $bookFirst = $repository->find(1);
        $bookSecond = $repository->find(2);

        $this->assertInstanceOf(Book::class, $bookFirst);
        $this->assertEquals($bookFirst->getTitle(), 'TDD by example');

        $this->assertInstanceOf(Book::class, $bookSecond);
        $this->assertEquals($bookSecond->getTitle(), 'Domain Driven Development');
    }

    public function testCanFindAllBooks()
    {
        $context = $this->getPDO();
        $repository = new BookRepository($context);
        
        $books = $repository->findAll();

        $this->assertEquals(count($books), 2);
        $this->assertEquals($books[0]->getId(), 1);
        $this->assertEquals($books[0]->getTitle(), 'TDD by example');
    }

    public function testCanSaveNewBook()
    {
        $context = $this->getPDO();
        $repository = new BookRepository($context);

        $book = new Book;
        $book->setTitle('Hello World With PHP');
        $book->setAuthor('Carrie M.');
        $book->setPublisher('PHP Masters');
        $book->setISBN('10293012830');

        $repository->save($book);
        $foundBook = $repository->find(3);

        $this->assertEquals($foundBook->getId(), 3);
        $this->assertEquals($foundBook->getTitle(), 'Hello World With PHP');
    }

    public function testCanUpdateExistingBook()
    {
        $context = $this->getPDO();
        $repository = new BookRepository($context);

        $book = $repository->find(1);
        $originalTitle = $book->getTitle();

        $book->setTitle('Something Fun Devlopment');
        $repository->save($book);

        $updatedBook = $repository->find(1);
        $updatedBookTitle = $updatedBook->getTitle();
        $updatedBookAuthor = $updatedBook->getAuthor();

        $updatedBook->setAuthor('Other Back');
        $repository->update($updatedBook);

        $updatedAgainBook = $repository->find(1);
        $updatedAgainBookAuthor = $updatedBook->getAuthor();

        $this->assertEquals($originalTitle, 'TDD by example');

        $this->assertEquals($updatedBookTitle, 'Something Fun Devlopment');
        $this->assertEquals($updatedBookAuthor, 'Some Back');

        $this->assertEquals($updatedAgainBookAuthor, 'Other Back');
    }

    public function testCanRemoveTheBook()
    {
        $context = $this->getPDO();
        $repository = new BookRepository($context);

        $book = $repository->find(1);
        $result = $repository->remove($book);
        
        $destroyed = $repository->find(1);

        $this->assertNotNull($book);
        $this->assertTrue($result);
        $this->assertNull($destroyed);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Book id does not exist.
     */
    public function testCannotRemoveTheBookIfBookDoesNotHaveId()
    {
        $context = $this->getPDO();
        $repository = new BookRepository($context);
        
        $book = new Book;
        $result = $repository->remove($book);
    }
}
