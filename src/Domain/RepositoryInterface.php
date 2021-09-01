<?php


namespace App\Domain;


use Doctrine\Common\Collections\ArrayCollection;

interface RepositoryInterface
{
    public function addEntity(ArrayCollection $fields);
}