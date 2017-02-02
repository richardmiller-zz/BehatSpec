<?php

namespace RMiller\BehatSpec\Extension\PhpSpecExtension\Process\CommandRunner;

use RMiller\BehatSpec\Extension\PhpSpecExtension\Process\CachingExecutableFinder;

class CliFunctionChecker
{
    /**
     * @var \Rmiller\PhpSpecExtension\Process\CachingExecutableFinder
     */
    private $executableFinder;

    /**
     * @param \Rmiller\PhpSpecExtension\Process\CachingExecutableFinder $executableFinder
     */
    public function __construct(CachingExecutableFinder $executableFinder)
    {
        $this->executableFinder = $executableFinder;
    }

    /**
     * @param string $function
     *
     * @return bool
     */
    public function functionCanBeUsed($function)
    {
        return (php_sapi_name() == 'cli')
            && $this->executableFinder->getExecutablePath()
            && function_exists($function);
    }
}
