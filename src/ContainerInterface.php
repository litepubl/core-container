<?php

namespace LitePubl\Core\Container;

use Psr\Container\ContainerInterface as PsrContainerInterface;
use LitePubl\Core\Container\Factories\FactoryInterface;

interface ContainerInterface extends PsrContainerInterface
{
    public function set($instance, string $name = '');
    public function createInstance(string $className);
    public function getFactory(): FactoryInterface;
    public function setFactory(FactoryInterface $factory);
    public function getEvents(): EventsInterface;
    public function setEvents(EventsInterface $events);
}
