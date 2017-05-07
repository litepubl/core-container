<?php

namespace litepubl\core\container\patterns;

use Psr\Container\ContainerInterface;

class Composite implements ContainerInterface
{
    protected $items;
    protected $current;

    public function __construct(ContainerInterface ...$items)
    {
        $this->items = $items;
    }

    public function get($className)
    {
        if (($this->current !== null) && isset($this->items[$this->current]) && $this->items[$this->current]->has($className)) {
                return $this->items[$this->current];
        }

        foreach ($this->items as $i => $container) {
            if ($container->has($className)) {
                $this->current = $i;
                return $container->get($className);
            }
        }

        throw new NotFound(sprintf('Class %s not found', $className));
    }

    public function has($className)
    {
        if (($this->current !== null) && isset($this->items[$this->current]) && $this->items[$this->current]->has($className)) {
                return true;
        }

        foreach ($this->items as $i => $container) {
            if ($container->has($className)) {
                $this->current = $i;
                return true;
            }
        }

        return false;
    }

    public function add(ContainerInterface $item):ContainerInterface
    {
        $this->items[] = $item;
        return $item;
    }

    public function addFirst(ContainerInterface $item): ContainerInterface
    {
        array_unshift($this->items, $item);
        $this->current = null;
        return $item;
    }

    public function remove(ContainerInterface $container): bool
    {
        foreach ($this->items as $i => $item) {
            if ($item == $container) {
                array_splice($this->items, $i, 1);
                $this->current = null;
                return true;
            }
        }

        return false;
    }
}
