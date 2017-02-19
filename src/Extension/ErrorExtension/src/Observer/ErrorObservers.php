<?php

namespace RMiller\BehatSpec\Extension\ErrorExtension\Observer;

class ErrorObservers implements \IteratorAggregate
{
    private $observers;

    public function __construct(array $observers = [])
    {
        foreach ($observers as $observer) {
            if ($observer instanceof ErrorObserverInterface) {
                continue;
            }

            $message = 'Can only be constructed with implementations of RMiller\BehatSpec\Extension\ErrorExtension\Observer\ErrorObserverInterface';
            throw new \InvalidArgumentException($message);
        }

        $this->observers = $observers;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->observers);
    }
}
