<?php

namespace BookStore;

class BookStore
{
    protected $id;
    protected $name;
    protected $address;
    protected $openedAt;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setOpenedAt($openedAt)
    {
        $this->openedAt = $openedAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getOpenedAt()
    {
        return $this->openedAt;
    }
}
