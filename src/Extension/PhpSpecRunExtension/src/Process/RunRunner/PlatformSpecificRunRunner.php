<?php

namespace RMiller\PhpSpecRunExtension\Process\RunRunner;

use RMiller\PhpSpecRunExtension\Process\CachingExecutableFinder;
use RMiller\PhpSpecRunExtension\Process\CommandRunner;
use RMiller\PhpSpecRunExtension\Process\RunRunner;

class PlatformSpecificRunRunner implements RunRunner
{
    const COMMAND_NAME = 'run';

    /**
     * @var string
     */
    private $phpspecPath;

    /**
     * @var string
     */
    private $phpspecConfig;

    /**
     * @var CommandRunner
     */
    private $commandRunner;

    /**
     * @var CachingExecutableFinder
     */
    private $executableFinder;

    /**
     * @param CommandRunner $commandRunner
     * @param CachingExecutableFinder $executableFinder
     * @param string $phpspecPath
     * @param string $phpspecConfig
     */
    public function __construct(
        CommandRunner $commandRunner,
        CachingExecutableFinder $executableFinder,
        $phpspecPath,
        $phpspecConfig
    ) {
        $this->commandRunner = $commandRunner;
        $this->executableFinder = $executableFinder;
        $this->phpspecPath = $phpspecPath;
        $this->phpspecConfig = $phpspecConfig;
    }

    /**
     * @return boolean
     */
    public function isSupported()
    {
        return $this->commandRunner->isSupported();
    }

    public function runRunCommand()
    {
        $this->commandRunner->runCommand(
            $this->executableFinder->getExecutablePath(),
            $this->getCommandArguments()
        );
    }

    /**
     * @return array
     */
    private function getCommandArguments()
    {
        $commandArguments = [$this->phpspecPath, self::COMMAND_NAME];
        $commandArguments = array_merge($commandArguments, $this->composeConfigOption());

        return $commandArguments;
    }

    /**
     * @return array
     */
    private function composeConfigOption()
    {
        $configOption = [];
        if (!is_null($this->phpspecConfig)) {
            array_push($configOption, '--config', $this->phpspecConfig);
        }

        return $configOption;
    }
}
