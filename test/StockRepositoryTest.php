<?php

namespace BookStore\Test;

use BookStore\Test\Util\DatabaseTestCase as TestCase;

use BookStore\StockRepository;
use BookStore\BookRepository;
use BookStore\BookStoreRepository;

class StockRepositoryTest extends TestCase
{
    protected $fixtureFile = '/fixture/stock.xml';
    
    private $book1;
    private $book2;
    private $bookstore1;
    private $bookstore2;

    public function setUp()
    {
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
}
