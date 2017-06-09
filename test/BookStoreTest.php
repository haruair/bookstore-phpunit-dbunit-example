<?php

namespace BookStore\Test;

use PHPUnit\Framework\TestCase;
use BookStore\BookStore;
use BookStore\Util\InternalPropertyAssignTrait;

class BookStoreTest extends TestCase
{
    use InternalPropertyAssignTrait;
    public function testCanCreate()
    {
        $bookstore = new BookStore;
        $this->assertInstanceOf(BookStore::class, $bookstore);
    }

    public function testHasId()
    {
        $bookstore = new BookStore;
        $this->assignInternalProperty($bookstore, 'id', 1020);
        $this->assertEquals($bookstore->getId(), 1020);
    }

    public function testHasName()
    {
        $bookstore = new BookStore;
        $bookstore->setName("Hello World");
        $this->assertEquals($bookstore->getName(), "Hello World");
    }
    
    public function testHasAddress()
    {
        $bookstore = new BookStore;
        $bookstore->setAddress("1 Flinders St Melbourne VIC Australia");
        $this->assertEquals($bookstore->getAddress(), "1 Flinders St Melbourne VIC Australia");
    }
    
    public function testHasOpenAt()
    {
        $date = date("Y-m-d H:i:s");
        $bookstore = new BookStore;
        $bookstore->setOpenAt($date);
        $this->assertEquals($bookstore->getOpenAt(), $date);
    }
}
