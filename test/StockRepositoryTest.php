<?php

namespace BookStore\Test;

use BookStore\Test\Util\DatabaseTestCase as TestCase;

use BookStore\StockRepository;

class StockRepositoryTest extends TestCase
{
    protected $fixtureFile = '/fixture/stock.xml';

    public function testCanCreate()
    {
        $context = $this->getPDO();
        $repository = new StockRepository($context);
        $this->assertInstanceOf(StockRepository::class, $repository);
    }
}
