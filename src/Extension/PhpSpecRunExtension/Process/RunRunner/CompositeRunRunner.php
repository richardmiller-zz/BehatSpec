<?php

namespace RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\RunRunner;

use RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\RunRunner;

class CompositeRunRunner implements RunRunner
{
    /**
     * @var RunRunner
     */
    private $runRunner;

    /**
     * @param PlatformSpecificRunRunner[] $runRunners
     */
    public function __construct(array $runRunners)
    {
        foreach ($runRunners as $runRunner) {
            if ($runRunner->isSupported()) {
                $this->runRunner = $runRunner;
                break;
            }
        }
    }

    public function runRunCommand()
    {
        $this->runRunner->runRunCommand();
    }
}
