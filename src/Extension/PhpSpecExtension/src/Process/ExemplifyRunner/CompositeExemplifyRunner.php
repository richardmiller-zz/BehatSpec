<?php

namespace RMiller\PhpSpecExtension\Process\ExemplifyRunner;

use RMiller\PhpSpecExtension\Process\ExemplifyRunner;

class CompositeExemplifyRunner implements ExemplifyRunner
{
    /**
     * @var ExemplifyRunner
     */
    private $exemplifyRunner;

    /**
     * @param PlatformSpecificExemplifyRunner[] $exemplifyRunners
     */
    public function __construct(array $exemplifyRunners)
    {
        foreach ($exemplifyRunners as $exemplifyRunner) {
            if ($exemplifyRunner->isSupported()) {
                $this->exemplifyRunner = $exemplifyRunner;
                break;
            }
        }
    }

    public function runExemplifyCommand($className, $methodName)
    {
        $this->exemplifyRunner->runExemplifyCommand($className, $methodName);
    }
}
