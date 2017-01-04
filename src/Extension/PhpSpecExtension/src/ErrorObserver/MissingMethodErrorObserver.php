<?php

namespace RMiller\PhpSpecExtension\ErrorObserver;

use Behat\Testwork\Call\Exception\FatalThrowableError;
use RMiller\ErrorExtension\Observer\ErrorObserver;
use RMiller\PhpSpecExtension\Process\ExemplifyRunner;

class MissingMethodErrorObserver implements ErrorObserver
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
