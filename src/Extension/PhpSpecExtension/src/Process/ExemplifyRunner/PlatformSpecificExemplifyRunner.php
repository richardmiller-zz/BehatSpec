<?php

namespace RMiller\PhpSpecExtension\Process\ExemplifyRunner;

use RMiller\PhpSpecExtension\Process\CachingExecutableFinder;
use RMiller\PhpSpecExtension\Process\CommandRunner;
use RMiller\PhpSpecExtension\Process\ExemplifyRunner;

class PlatformSpecificExemplifyRunner implements ExemplifyRunner
{
    const COMMAND_NAME = 'exemplify';

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

    public function runExemplifyCommand($className, $methodName)
    {
        $this->commandRunner->runCommand(
            $this->executableFinder->getExecutablePath(),
            $this->getCommandArguments($className, $methodName)
        );
    }

    /**
     * @param $className
     * @param $methodName
     *
     * @return array
     */
    private function getCommandArguments($className, $methodName)
    {
        $commandArguments = [$this->phpspecPath, self::COMMAND_NAME];
        $commandArguments = array_merge($commandArguments, $this->composeConfigOption());
        array_push($commandArguments, $className, $methodName);

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
