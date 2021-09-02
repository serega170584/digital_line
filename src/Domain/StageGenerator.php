<?php


namespace App\Domain;


class StageGenerator extends Generator
{
    public function generate()
    {
        $this->records = ['Preliminary round', false];
    }
}