<?php

namespace BookStore\Test;

use PHPUnit\Framework\TestCase;
use BookStore\Stock;
use BookStore\Book;
use BookStore\BookStore;
use BookStore\Util\InternalPropertyAssignTrait;

class StockTest extends TestCase
{
    use InternalPropertyAssignTrait;

    public function testCanCreate()
    {
        $stock = new Stock;
        $this->assertInstanceOf(Stock::class, $stock);
    }

    public function testHasId()
    {
        $stock = new Stock;
        $this->assignInternalProperty($stock, 'id', 1234);
        $this->assertEquals($stock->getId(), 1234);
    }

    public function testHasBook()
    {
        $book = new Book;
        $stock = new Stock;
        $stock->setBook($book);
        $this->assertEquals($stock->getBook(), $book);
    }

    public function testHasBookStore()
    {
        $bookstore = new BookStore;
        $stock = new Stock;
        $stock->setBookStore($bookstore);
        $this->assertEquals($stock->getBookStore(), $bookstore);
    }
}
