<?php

namespace RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\CommandRunner;

use RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\CachingExecutableFinder;

class CliFunctionChecker
{
    /**
     * @var \RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\CachingExecutableFinder
     */
    private $executableFinder;

    /**
     * @param \RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\CachingExecutableFinder $executableFinder
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
