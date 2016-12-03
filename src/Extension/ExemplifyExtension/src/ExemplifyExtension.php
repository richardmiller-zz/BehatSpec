<?php

namespace RMiller\ExemplifyExtension;

use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;
use RMiller\ExemplifyExtension\Command\ExemplifyCommand;
use RMiller\ExemplifyExtension\Generator\SpecificationMethodGenerator;

class ExemplifyExtension implements ExtensionInterface
{
    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $container->set('code_generator.generators.specification_method', function (ServiceContainer $c) {
            return new SpecificationMethodGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates')
            );
        });

        $container->setShared('console.commands.exemplify', function () {
            return new ExemplifyCommand();
        });
    }
}
