<?php

namespace RMiller\PhpSpecExtension\Tester;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Specification\SpecificationIterator;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\Setup;
use Behat\Testwork\Tester\Setup\Teardown;
use Behat\Testwork\Tester\SuiteTester;
use Rmiller\PhpSpecExtension\Process\DescRunner;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class PhpSpecTester implements SuiteTester
{
    private $baseTester;
    private $specRunner;
    private $output;
    private $input;

    public function __construct(
        SuiteTester $baseTester,
        DescRunner $specRunner,
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->baseTester = $baseTester;
        $this->specRunner = $specRunner;
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * Tests provided suite specifications.
     *
     * @param Environment $env
     * @param SpecificationIterator $iterator
     * @param Boolean $skip
     *
     * @return TestResult
     */
    public function test(Environment $env, SpecificationIterator $iterator, $skip)
    {
        return $this->baseTester->test($env, $iterator, $skip);
    }

    /**
     * Tears down suite after a test.
     *
     * @param Environment $env
     * @param SpecificationIterator $iterator
     * @param Boolean $skip
     * @param TestResult $result
     *
     * @return Teardown
     */
    public function tearDown(Environment $env, SpecificationIterator $iterator, $skip, TestResult $result)
    {
        return $this->baseTester->tearDown($env, $iterator, $skip, $result);
    }

    /**
     * Sets up suite for a test.
     *
     * @param Environment $env
     * @param SpecificationIterator $iterator
     * @param Boolean $skip
     *
     * @return Setup
     */
    public function setUp(Environment $env, SpecificationIterator $iterator, $skip)
    {
        spl_autoload_register(function($class) {

            $errorMessages = [
                $class .' was not found.'
            ];

            $formatter = new FormatterHelper();
            $formattedBlock = $formatter->formatBlock($errorMessages, 'error', true);
            $this->output->writeln('');
            $this->output->writeln($formattedBlock);
            $this->output->writeln('');

            $question = sprintf('Do you want to create a specification for %s? (Y/n)', $class);
            $questionBlock = new ConfirmationQuestion($formatter->formatBlock($question, 'question', true));

            $dialog = new QuestionHelper();

            if ($dialog->ask($this->input, $this->output, $questionBlock)) {
                $this->output->writeln('');
                $this->specRunner->runDescCommand($class);
            }

        }, true, false);

        return $this->baseTester->setUp($env, $iterator, $skip);
    }
}
