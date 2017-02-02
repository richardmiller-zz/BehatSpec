<?php

namespace RMiller\BehatSpec\Extension\BehatSpecExtension;

use PhpSpec\ServiceContainer;
use PhpSpec\Extension;
use RMiller\BehatSpec\Extension\ExemplifyExtension\ExemplifyExtension;
use RMiller\BehatSpec\Extension\PhpSpecRunExtension\PhpSpecRunExtension;

class PhpSpecExtension implements Extension
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
    public function load(ServiceContainer $container, array $params)
    {
        foreach ($this->extensions as $extension) {
            $extension->load($container, $params);
        }

        $params = $container->getParam('rerunner', []);
        $params['commands'] = isset($params['commands']) ? $params['commands'] : ['describe', 'exemplify'];
        $container->setParam('rerunner', $params);
    }
}
