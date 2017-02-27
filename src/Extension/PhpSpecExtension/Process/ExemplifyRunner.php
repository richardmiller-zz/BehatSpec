<?php

namespace RMiller\BehatSpec\Extension\PhpSpecExtension\Process;

interface ExemplifyRunner
{
    /**
     * @return void
     */
    public function runExemplifyCommand($className, $methodName);
}
