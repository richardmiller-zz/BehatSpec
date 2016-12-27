<?php

namespace RMiller\PhpSpecExtension\Process\DescRunner;

use RMiller\PhpSpecExtension\Process\DescRunner;

class CompositeDescRunner implements DescRunner
{
    /**
     * @var DescRunner
     */
    private $descRunner;

    /**
     * @param PlatformSpecificDescRunner[] $descRunners
     */
    public function __construct(array $descRunners)
    {
        foreach ($descRunners as $descRunner) {
            if ($descRunner->isSupported()) {
                $this->descRunner = $descRunner;
                break;
            }
        }
    }

    public function runDescCommand($className)
    {
        $this->descRunner->runDescCommand($className);
    }
}
