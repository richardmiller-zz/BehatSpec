<?php

namespace RMiller\BehatSpec\Extension\PhpSpecRunExtension;

use PhpSpec\Extension;
use PhpSpec\ServiceContainer;
use RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\CachingExecutableFinder;
use RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\CommandRunner\CliFunctionChecker;
use RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\CommandRunner\PassthruCommandRunner;
use RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\CommandRunner\PcntlCommandRunner;
use RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\RunRunner\CompositeRunRunner;
use RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process\RunRunner\PlatformSpecificRunRunner;
use Symfony\Component\Process\PhpExecutableFinder;

class PhpSpecRunExtension implements Extension
{
    /**
     * @param ServiceContainer $container
     * @param array $params
     */
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('rmiller.run_runner', function ($c) use ($params) {

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

        $container->define('rmiller.run.function_checker', function ($c) {
            return new CliFunctionChecker($c->get('rmiller.run.caching_executable_finder'));
        });

        $container->define('rmiller.run.caching_executable_finder', function () {
            return new CachingExecutableFinder(new PhpExecutableFinder());
        });

        $container->define('console_event_dispatcher.listeners.run_runner', function ($c) {
            $params = $c->getParam('rerunner', []);
            $commands = isset($params['commands']) ? $params['commands'] : ['describe'];

            return new CommandSubscriber(
                $c->get('rmiller.run_runner'),
                $c->get('console.io'),
                $commands
            );
        }, ['console_event_dispatcher.listeners']);
    }
}
