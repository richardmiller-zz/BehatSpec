<?php

namespace RMiller\BehatSpec\Extension\ExemplifyExtension;

use PhpSpec\Extension;
use PhpSpec\ServiceContainer;
use RMiller\BehatSpec\Extension\ExemplifyExtension\Command\ExemplifyCommand;
use RMiller\BehatSpec\Extension\ExemplifyExtension\Generator\SpecificationMethodGenerator;

class ExemplifyExtension implements Extension
{
    /**
     * @param ServiceContainer $container
     * @param array $params
     */
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('code_generator.generators.specification_method', function (ServiceContainer $c) {
            return new SpecificationMethodGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates')
            );
        }, ['code_generator.generators']);

        $container->define('console.commands.exemplify', function () {
            return new ExemplifyCommand();
        }, ['console.commands']);
    }
}
