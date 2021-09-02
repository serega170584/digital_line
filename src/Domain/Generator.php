<?php


namespace App\Domain;


abstract class Generator
{
    /**
     * @var array
     */
    protected $records;

    public function __construct()
    {
        $this->records = [];
    }

    abstract public function generate();

    /**
     * @return array
     */
    public function getRecords(): array
    {
        return $this->records;
    }
}