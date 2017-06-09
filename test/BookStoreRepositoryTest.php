<?php

namespace BookStore\Test;

use BookStore\Test\Util\DatabaseTestCase as TestCase;
use BookStore\BookStoreRepository;

class BookStoreRepositoryTest extends TestCase
{
    protected $fixtureFile = '/fixture/bookstore.xml';

    public function testCanCreate()
    {
        $context = $this->getPDO();
        $repository = new BookStoreRepository($context);
        $this->assertInstanceOf(BookStoreRepository::class, $repository);
    }
}
