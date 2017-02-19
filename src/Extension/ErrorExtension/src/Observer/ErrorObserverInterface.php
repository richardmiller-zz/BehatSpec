<?php

namespace RMiller\BehatSpec\Extension\ErrorExtension\Observer;

use Behat\Testwork\Call\Exception\FatalThrowableError;

interface ErrorObserverInterface
{
    public function notify(FatalThrowableError $error);
}
