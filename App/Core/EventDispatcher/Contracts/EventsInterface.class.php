<?php

declare(strict_types=1);
interface EventsInterface
{
    public function getName() : string;

    public function setName($name) : self;

    public function getObject(): object;

    public function setObject(object $object) : self;

    public function setResults(object $results) : self;

    public function getResults() : object;

    public function setParams($params) : self;

    public function getParams() : array;
}
