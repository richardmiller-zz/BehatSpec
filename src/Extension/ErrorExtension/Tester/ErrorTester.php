<?php

namespace RMiller\BehatSpec\Extension\ErrorExtension\Tester;

use Behat\Behat\Tester\Result\ExecutedStepResult;
use Behat\Behat\Tester\Result\StepResult;
use Behat\Behat\Tester\StepTester;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\StepNode;
use Behat\Testwork\Call\Exception\FatalThrowableError;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\Teardown;
use RMiller\BehatSpec\Extension\ErrorExtension\Observer\ErrorObservers;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Output\OutputInterface;

class ErrorTester implements StepTester
{
    private $baseTester;
    private $observers;
    private $output;

    public function __construct(
        StepTester $baseTester,
        OutputInterface $output,
        array $observers = null
    ) {
        $this->baseTester = $baseTester;
        $this->output = $output;
        $this->observers = new ErrorObservers($observers);
    }

    /**
     * Sets up suite for a test.
     *
     * @param Environment $env
     * @param FeatureNode $feature
     * @param StepNode $step
     * @param bool $skip
     *
     * @return Setup
     */
    public function setUp(
        Environment $env,
        FeatureNode $feature,
        StepNode $step,
        $skip
    ) {
        return $this->baseTester->setUp($env, $feature, $step, $skip);
    }

    /**
     * Tests provided suite specifications.
     *
     * @param Environment $env
     * @param FeatureNode $feature
     * @param StepNode $step
     * @param bool $skip
     *
     * @return StepResult
     */
    public function test(
        Environment $env,
        FeatureNode $feature,
        StepNode $step,
        $skip = false
    ) {
        $result = $this->baseTester->test($env, $feature, $step, $skip);

        if ($result instanceof ExecutedStepResult && $result->hasException()) {
            $exception = $result->getException();

            if ($exception instanceof FatalThrowableError) {
                $errorMessages = [
                    sprintf('The error "%s"', $exception->getMessage()),
                    sprintf('occurred in step %s', $step->getText()),
                    sprintf('at line %s', $step->getLine()),
                ];

                $formatter = new FormatterHelper();
                $formattedBlock = $formatter->formatBlock($errorMessages,
                    'error', true);
                $this->output->writeln('');
                $this->output->writeln($formattedBlock);
                $this->output->writeln('');

                foreach ($this->observers as $observer) {
                    $observer->notify($exception);
                }
            }
        }

        return $result;
    }

    /**
     * Tears down suite after a test.
     *
     * @param Environment $env
     * @param FeatureNode $feature
     * @param StepNode $step
     * @param bool $skip
     * @param StepResult $result
     *
     * @return Teardown
     */
    public function tearDown(
        Environment $env,
        FeatureNode $feature,
        StepNode $step,
        $skip,
        StepResult $result
    ) {
        return $this->baseTester->tearDown($env, $feature, $step, $skip,
            $result);
    }
}
