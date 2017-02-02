<?php

namespace RMiller\BehatSpec\Extension\PhpSpecExtension\Process;

interface DescRunner
{
    /**
     * @return void
     */
    public function runDescCommand($className);
}
