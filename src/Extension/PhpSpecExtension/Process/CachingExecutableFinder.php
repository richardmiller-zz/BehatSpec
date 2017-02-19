<?php

namespace RMiller\BehatSpec\Extension\PhpSpecExtension\Process;

use Symfony\Component\Process\PhpExecutableFinder;

class CachingExecutableFinder
{
    /**
     * @var PhpExecutableFinder
     */
    private $executableFinder;

    /**
     * @var null|false|string
     */
    private $executablePath;

    /**
     * @param PhpExecutableFinder $executableFinder
     */
    public function __construct(PhpExecutableFinder $executableFinder)
    {
        $this->executableFinder = $executableFinder;
    }

    /**
     * @return false|string
     */
    public function getExecutablePath()
    {
        if (null === $this->executablePath) {
            $this->executablePath = $this->executableFinder->find();
        }

        return $this->executablePath;
    }
}
