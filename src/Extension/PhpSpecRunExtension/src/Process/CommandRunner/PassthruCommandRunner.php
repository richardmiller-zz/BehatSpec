<?php

namespace RMiller\PhpSpecRunExtension\Process\CommandRunner;

use RMiller\PhpSpecRunExtension\Process\CommandRunner;

class PassthruCommandRunner implements CommandRunner
{
    /**
     * @var CliFunctionChecker
     */
    private $functionChecker;

    /**
     * @param CliFunctionChecker $functionChecker
     */
    public function __construct(CliFunctionChecker $functionChecker)
    {
        $this->functionChecker = $functionChecker;
    }

    /**
     * @param $path
     * @param $args
     */
    public function runCommand($path, $args)
    {
        $command = escapeshellcmd($path) . ' ' . join(' ', array_map('escapeshellarg', $args));
        passthru($command, $exitCode);
        exit($exitCode);
    }

    public function isSupported()
    {
        return $this->functionChecker->functionCanBeUsed('passthru');
    }
}
