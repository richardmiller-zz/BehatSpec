<?php

namespace RMiller\BehatSpec;

use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;
use RMiller\ExemplifyExtension\ExemplifyExtension;
use RMiller\PhpSpecRunExtension\PhpSpecRunExtension;

class PhpSpecExtension implements ExtensionInterface
{
    private $extensions = [];

    public function __construct()
    {
        $this->extensions = [
            new ExemplifyExtension(),
            new PhpSpecRunExtension()
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

        $params = $container->getParam('rerunner', []);
        $params['commands'] = isset($params['commands']) ? $params['commands'] : ['describe', 'exemplify'];
        $container->setParam('rerunner', $params);
    }
}