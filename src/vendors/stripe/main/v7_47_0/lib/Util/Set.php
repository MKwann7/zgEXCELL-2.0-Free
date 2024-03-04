<?php

namespace Stripe\Util;

use ArrayIterator;
use IteratorAggregate;

class Set implements IteratorAggregate
{
    private array $_elts;

    /**
     * @param array $members
     */
    public function __construct(array $members = [])
    {
        $this->_elts = [];
        foreach ($members as $item) {
            $this->_elts[$item] = true;
        }
    }

    /**
     * @param $elt
     * @return bool
     */
    public function includes($elt): bool
    {
        return isset($this->_elts[$elt]);
    }

    /**
     * @param $elt
     * @return void
     */
    public function add($elt): void
    {
        $this->_elts[$elt] = true;
    }

    /**
     * @param $elt
     * @return void
     */
    public function discard($elt): void
    {
        unset($this->_elts[$elt]);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return \array_keys($this->_elts);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }
}
