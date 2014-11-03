<?php

namespace RMiller\BehatSpec;

use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;
use RMiller\ExemplifyExtension\ExemplifyExtension;

class PhpSpecExtension implements ExtensionInterface
{
    private $extensions = [];

    public function __construct()
    {
        $this->extensions = [
            new ExemplifyExtension()
        ];
    }

    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        foreach ($this->extensions as $extension) {
            $extension->load($container);
        }
    }
}