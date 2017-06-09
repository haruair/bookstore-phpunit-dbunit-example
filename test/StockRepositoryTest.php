<?php

namespace BookStore\Test;

use BookStore\Test\Util\DatabaseTestCase as TestCase;

use BookStore\StockRepository;
use BookStore\BookRepository;
use BookStore\BookStoreRepository;
use BookStore\Book;
use BookStore\BookStore;

class StockRepositoryTest extends TestCase
{
    protected $fixtureFile = '/fixture/stock.xml';

    private $book1;
    private $book2;
    private $bookstore1;
    private $bookstore2;

    public function setUp()
    {
        parent::setUp();

        $context = $this->getPDO();
        
        $bookRepository = new BookRepository($context);
        $bookstoreRepository = new BookStoreRepository($context);

        $this->book1 = $bookRepository->find(1);
        $this->book2 = $bookRepository->find(2);
        $this->bookstore1 = $bookstoreRepository->find(1);
        $this->bookstore2 = $bookstoreRepository->find(2);
    }

    public function testCanCreate()
    {
        $context = $this->getPDO();
        $repository = new StockRepository($context);
        $this->assertInstanceOf(StockRepository::class, $repository);
    }

    public function testFindStockCount()
    {
        $context = $this->getPDO();
        $repository = new StockRepository($context);

        $count1 = $repository->stockCount($this->book1, $this->bookstore1);
        $count2 = $repository->stockCount($this->book2, $this->bookstore1);
        $count3 = $repository->stockCount($this->book1);
        
        $this->assertEquals($count1, 2);
        $this->assertEquals($count2, 3);
        $this->assertEquals($count3, 3);
    }

    public function testCreateNewStock()
    {
        $context = $this->getPDO();
        $repository = new StockRepository($context);

        $countBefore = $repository->stockCount($this->book1, $this->bookstore1);
        $repository->newStockTo($this->book1, $this->bookstore1);
        $countAfter = $repository->stockCount($this->book1, $this->bookstore1);

        $this->assertEquals($countBefore, 2);
        $this->assertEquals($countAfter, 3);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid Book
     */
    public function testSaveAnInvalidBook()
    {
        $context = $this->getPDO();
        $repository = new StockRepository($context);
        $invalidBook = new Book;

        $repository->newStockTo($invalidBook, $this->bookstore1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid BookStore
     */
    public function testSaveAnInvalidBookStore()
    {
        $context = $this->getPDO();
        $repository = new StockRepository($context);
        $invalidBookstore = new BookStore;

        $repository->newStockTo($this->book1, $invalidBookstore);
    }
}
