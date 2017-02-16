<?php

namespace spec\RMiller\BehatSpec\Extension\ErrorExtension\Observer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RMiller\BehatSpec\Extension\ErrorExtension\Observer\ErrorObserver;

class ErrorObserversSpec extends ObjectBehavior
{
    function it_can_only_be_constructed_with_observers()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('__construct', [[new \stdClass()]]);
    }

    function it_can_be_constructed_with_observers(ErrorObserver $observer)
    {
        $this->beConstructedWith([$observer]);
    }

    function it_is_traversable()
    {
        $this->shouldHaveType('\Traversable');
    }
}
