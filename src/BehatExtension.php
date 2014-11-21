<?php

namespace RMiller\BehatSpec;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use RMiller\ErrorExtension\ErrorExtension;
use RMiller\PhpSpecExtension\PhpSpecExtension as BehatPhpSpecExtension;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BehatExtension implements Extension
{
    private $extensions = [];

    public function __construct()
    {
        $this->extensions = [
            new BehatPhpSpecExtension(),
            new ErrorExtension(),
        ];
    }

    public function process(ContainerBuilder $container)
    {
        foreach ($this->extensions as $extension) {
            $extension->process($container);
        }
    }

    public function initialize(ExtensionManager $extensionManager)
    {
        foreach ($this->extensions as $extension) {
            $extension->initialize($extensionManager);
        }
    }

    public function load(ContainerBuilder $container, array $config)
    {
        foreach ($this->extensions as $extension) {
            $extension->load($container, $config);
        }
    }

    public function getConfigKey()
    {
        return 'behatspec';
    }

    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('path')->defaultValue('bin/phpspec')->end()
            ->end()
         ->end();
    }
}