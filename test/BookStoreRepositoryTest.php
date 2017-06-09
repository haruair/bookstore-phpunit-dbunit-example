<?php

namespace BookStore\Test;

use BookStore\Test\Util\DatabaseTestCase as TestCase;

use BookStore\BookStoreRepository;
use BookStore\BookStore;

class BookStoreRepositoryTest extends TestCase
{
    protected $fixtureFile = '/fixture/bookstore.xml';

    public function testCanCreate()
    {
        $context = $this->getPDO();
        $repository = new BookStoreRepository($context);
        $this->assertInstanceOf(BookStoreRepository::class, $repository);
    }

    public function testCanFindBookStoreById()
    {
        $context = $this->getPDO();
        $repository = new BookStoreRepository($context);

        $bookStoreFirst = $repository->find(1);
        $bookStoreSecond = $repository->find(2);

        $this->assertInstanceOf(BookStore::class, $bookStoreFirst);
        $this->assertEquals($bookStoreFirst->getName(), 'Polarbear Bookstore');

        $this->assertInstanceOf(BookStore::class, $bookStoreSecond);
        $this->assertEquals($bookStoreSecond->getName(), 'PHP Bookstore');
    }
}
