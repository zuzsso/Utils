<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Utils\Collections;

use Countable;
use Iterator;
use Utils\Collections\Exception\ArrayIndexOutOfBoundsException;
use Utils\Collections\Exception\KeyAlreadyExistsException;

/**
 * Holds an associative string array, as in [$key => $value], in which $key is a string and $value is any value
 */
abstract class AbstractStringAssociativeCollection implements Iterator, Countable
{
    /**
     * @deprecated This class parameter will be made private in future releases
     * @see \Utils\Collections\AbstractStringAssociativeCollection::addStringKeyUntyped
     */
    protected array $collection = [];

    private int $it = 0;

    /**
     * @throws KeyAlreadyExistsException
     */
    final public function addStringKeyUntyped(string $key, $value): void
    {
        if (array_key_exists($key, $this->collection)) {
            throw new KeyAlreadyExistsException("Key '$key' already exists in this collection");
        }

        $this->collection[$key] = $value;
    }

    /**
     * @throws KeyAlreadyExistsException
     */
    final public function addIntKeyUntyped(?int $key, $value): void
    {
        if ($key !== null) {
            $this->addStringKeyUntyped((string)$key, $value);
        } else {
            $this->collection[] = $value;
        }
    }

    final public function next(): void
    {
        $this->it++;
    }

    final public function key(): string
    {
        $keys = array_keys($this->collection);

        return $keys[$this->it];
    }

    final public function valid(): bool
    {
        return
            ($this->it >= 0) &&
            ($this->it < count($this->collection));
    }

    final public function rewind(): void
    {
        $this->it = 0;
    }

    final public function count(): int
    {
        return count($this->collection);
    }

    /**
     * You need to implement the function 'current' of the Iterator interface in your subclass, and
     * typehint the return value to not lose custody of the type. Then you only need to call this
     * function to do the actual work
     */
    final protected function currentUntyped()
    {
        $keys = array_keys($this->collection);
        $key = $keys[$this->it];

        return $this->collection[$key];
    }

    /**
     * @throws ArrayIndexOutOfBoundsException
     */
    abstract public function getByStringKey(string $key);

    /**
     * @throws ArrayIndexOutOfBoundsException
     */
    final protected function getByStringKeyUntyped(string $key)
    {
        if (!array_key_exists($key, $this->collection)) {
            throw new ArrayIndexOutOfBoundsException("Key not found in associative array: '$key'");
        }

        return $this->collection[$key];
    }

    /**
     * @throws ArrayIndexOutOfBoundsException
     */
    abstract public function getByNumericOffset(int $offset);

    /**
     * @throws ArrayIndexOutOfBoundsException
     */
    final protected function getByNumericOffsetUntyped(int $offset)
    {
        $keys = array_keys($this->collection);
        $count = count($keys);
        if (($offset >= 0) && ($offset < $count)) {
            $key = $keys[$offset];

            return $this->collection[$key];
        }

        throw new ArrayIndexOutOfBoundsException("Ofset $offset outside of interval [0, $count)");
    }

    final protected function customAssociativeSort(callable $userFunc): void
    {
        uasort($this->collection, $userFunc);
    }
}
