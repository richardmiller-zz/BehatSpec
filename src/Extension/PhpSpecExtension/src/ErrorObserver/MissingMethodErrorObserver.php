<?php

namespace RMiller\BehatSpec\Extension\PhpSpecExtension\ErrorObserver;

use Behat\Testwork\Call\Exception\FatalThrowableError;
use RMiller\BehatSpec\Extension\ErrorExtension\Observer\ErrorObserverInterface;
use RMiller\BehatSpec\Extension\PhpSpecExtension\Process\ExemplifyRunner;

class MissingMethodErrorObserver implements ErrorObserverInterface
{
    private $exemplifyRunner;

    public function __construct(ExemplifyRunner $exemplifyRunner)
    {
        $this->exemplifyRunner = $exemplifyRunner;
    }

    public function notify(FatalThrowableError $error)
    {
        if (strpos($error->getMessage(), 'Call to undefined method') === false) {
            return;
        }

        $missing = trim(substr($error->getMessage(), strlen('Fatal error: Call to undefined method')));
        list($class, $method) = explode('::', $missing);

        $this->exemplifyRunner->runExemplifyCommand($class, substr($method, 0, -2));
    }
}
