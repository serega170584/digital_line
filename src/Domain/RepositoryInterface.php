<?php


namespace App\Domain;


use Doctrine\Common\Collections\ArrayCollection;

interface RepositoryInterface
{
    public function addEntity(array $fields);

    public function addGeneratedRecords();
}