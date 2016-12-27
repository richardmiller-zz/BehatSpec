<?php

namespace RMiller\PhpSpecExtension\Process;

interface ExemplifyRunner
{
    /**
     * @return void
     */
    public function runExemplifyCommand($className, $methodName);
}
