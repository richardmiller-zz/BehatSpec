<?php

namespace RMiller\BehatSpec\Extension\PhpSpecExtension\Process\DescRunner;

use RMiller\BehatSpec\Extension\PhpSpecExtension\Process\CachingExecutableFinder;
use RMiller\BehatSpec\Extension\PhpSpecExtension\Process\CommandRunner;
use RMiller\BehatSpec\Extension\PhpSpecExtension\Process\DescRunner;

class PlatformSpecificDescRunner implements DescRunner
{
    const COMMAND_NAME = 'desc';

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

    public function runDescCommand($className)
    {
        $this->commandRunner->runCommand(
            $this->executableFinder->getExecutablePath(),
            $this->getCommandArguments($className)
        );
    }

    /**
     * @param $className
     *
     * @return array
     */
    private function getCommandArguments($className)
    {
        $commandArguments = [$this->phpspecPath, self::COMMAND_NAME];
        $commandArguments = array_merge($commandArguments, $this->composeConfigOption());
        array_push($commandArguments, $className);

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
