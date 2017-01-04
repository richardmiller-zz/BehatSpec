<?php

namespace RMiller\ErrorExtension\Observer;

class ErrorObservers implements \IteratorAggregate
{
    private $observers;

    public function __construct(array $observers = [])
    {
        foreach ($observers as $observer) {
            if ($observer instanceof ErrorObserver) {
                continue;
            }

            $message = 'Can only be constructed with implementations of RMiller\ErrorExtension\Observer\ErrorObserver';
            throw new \InvalidArgumentException($message);
        }

        $this->observers = $observers;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->observers);
    }
}
