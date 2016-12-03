<?php

namespace RMiller\PhpSpecExtension\Process;

interface DescRunner
{
    /**
     * @return void
     */
    public function runDescCommand($className);
}
