<?php

namespace RMiller\PhpSpecExtension\Process;

interface CommandRunner
{
    /**
     * @param string|false $path
     *
     * @return void
     */
    public function runCommand($path, $args);

    /**
     * @return boolean
     */
    public function isSupported();
}
