<?php

namespace RMiller\PhpSpecRunExtension\Process;

interface CommandRunner
{
    /**
     * @param string|false $path
     * @param string[] $args
     *
     * @return void
     */
    public function runCommand($path, $args);

    /**
     * @return boolean
     */
    public function isSupported();
}
