<?php

namespace BookStore;

class BookStore
{
    protected $id;
    protected $name;
    protected $address;
    protected $openAt;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setOpenAt($openAt)
    {
        $this->openAt = $openAt;
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

    public function getOpenAt()
    {
        return $this->openAt;
    }
}
