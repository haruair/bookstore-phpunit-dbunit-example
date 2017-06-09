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

    public function testCanFindAllBookStore()
    {
        $context = $this->getPDO();
        $repository = new BookStoreRepository($context);
        
        $bookstores = $repository->findAll();

        $this->assertEquals(count($bookstores), 2);
        $this->assertEquals($bookstores[0]->getId(), 1);
        $this->assertEquals($bookstores[0]->getName(), 'Polarbear Bookstore');
    }
    
    public function testCanSaveNewBookStore()
    {
        $context = $this->getPDO();
        $repository = new BookStoreRepository($context);

        $openedAt = date('Y-m-d H:i:s');

        $bookstore = new BookStore;
        $bookstore->setName('HelloWorld Bookstore');
        $bookstore->setAddress('Unknown');
        $bookstore->setOpenedAt($openedAt);

        $repository->save($bookstore);
        $foundBookstore = $repository->find(3);

        $this->assertEquals($foundBookstore->getId(), 3);
        $this->assertEquals($foundBookstore->getName(), 'HelloWorld Bookstore');
    }
    
    public function testCanUpdateExistingBookstore()
    {
        $context = $this->getPDO();
        $repository = new BookStoreRepository($context);

        $bookstore = $repository->find(1);
        $originalName = $bookstore->getName();

        $bookstore->setName('Koala Bookstore');
        $repository->save($bookstore);

        $updatedBookstore = $repository->find(1);
        $updatedBookstoreName = $updatedBookstore->getName();
        $updatedBookstoreAddress = $updatedBookstore->getAddress();

        $updatedBookstore->setAddress('Malvern Rd Malvern VIC AU');
        $repository->update($updatedBookstore);

        $updatedAgainBookstore = $repository->find(1);
        $updatedAgainBookstoreAddress = $updatedBookstore->getAddress();

        $this->assertEquals($originalName, 'Polarbear Bookstore');

        $this->assertEquals($updatedBookstoreName, 'Koala Bookstore');
        $this->assertEquals($updatedBookstoreAddress, '1 Polar St North Pole');

        $this->assertEquals($updatedAgainBookstoreAddress, 'Malvern Rd Malvern VIC AU');
    }

    public function testCanRemoveTheBookstore()
    {
        $context = $this->getPDO();
        $repository = new BookStoreRepository($context);

        $bookstore = $repository->find(1);
        $result = $repository->remove($bookstore);

        $destroyed = $repository->find(1);

        $this->assertNotNull($bookstore);
        $this->assertTrue($result);
        $this->assertNull($destroyed);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage BookStore id does not exist.
     */
    public function testCannotRemoveTheBookStoreIfBookStoreDoesNotHaveId()
    {
        $context = $this->getPDO();
        $repository = new BookStoreRepository($context);
        
        $bookstore = new BookStore;
        $result = $repository->remove($bookstore);
    }
}
