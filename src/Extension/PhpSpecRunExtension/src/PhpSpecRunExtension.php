<?php

namespace RMiller\PhpSpecRunExtension;

use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;
use RMiller\PhpSpecRunExtension\Process\CachingExecutableFinder;
use RMiller\PhpSpecRunExtension\Process\CommandRunner\CliFunctionChecker;
use RMiller\PhpSpecRunExtension\Process\CommandRunner\PassthruCommandRunner;
use RMiller\PhpSpecRunExtension\Process\CommandRunner\PcntlCommandRunner;
use RMiller\PhpSpecRunExtension\Process\RunRunner\CompositeRunRunner;
use RMiller\PhpSpecRunExtension\Process\RunRunner\PlatformSpecificRunRunner;
use Symfony\Component\Process\PhpExecutableFinder;

class PhpSpecRunExtension implements ExtensionInterface
{
    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $container->setShared('rmiller.run_runner', function ($c) {
            $params = $c->getParam('rerunner', []);
            $phpspecPath = isset($params['path']) ? $params['path'] : 'bin/phpspec';
            $phpspecConfig = isset($params['config']) ? $params['config'] : null;

            return new CompositeRunRunner([
                new PlatformSpecificRunRunner(
                    new PcntlCommandRunner($c->get('rmiller.run.function_checker')),
                    $c->get('rmiller.run.caching_executable_finder'),
                    $phpspecPath,
                    $phpspecConfig
                ),
                new PlatformSpecificRunRunner(
                    new PassthruCommandRunner($c->get('rmiller.run.function_checker')),
                    $c->get('rmiller.run.caching_executable_finder'),
                    $phpspecPath,
                    $phpspecConfig
                )
            ]);
        });

        $container->setShared('rmiller.run.function_checker', function ($c) {
            return new CliFunctionChecker($c->get('rmiller.run.caching_executable_finder'));
        });

        $container->setShared('rmiller.run.caching_executable_finder', function () {
            return new CachingExecutableFinder(new PhpExecutableFinder());
        });

        $container->setShared('console_event_dispatcher.listeners.run_runner', function ($c) {
            $params = $c->getParam('rerunner', []);
            $commands = isset($params['commands']) ? $params['commands'] : ['describe'];

            return new CommandSubscriber(
                $c->get('rmiller.run_runner'),
                $c->get('console.io'),
                $commands
            );
        });
    }
}
