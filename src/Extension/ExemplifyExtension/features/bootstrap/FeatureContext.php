<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use PhpSpec\Console\Application;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var string|null
     */
    private $workDir = null;

    /**
     * @var ApplicationTester|null
     */
    private $applicationTester = null;

    /**
     * @BeforeScenario
     */
    public function createWorkDir()
    {

        $this->workDir = sprintf(
            '%s/%s/',
            sys_get_temp_dir(),
            uniqid('PhpSpecContext_')
        );
        $fs = new Filesystem();
        $fs->mkdir($this->workDir, 0777);
        chdir($this->workDir);
    }

    /**
     * @AfterScenario
     */
    public function removeWorkDir()
    {
        $fs = new Filesystem();
        $fs->remove($this->workDir);
    }

    /**
     * @Then the spec file :file should contain:
     */
    public function theSpecFileShouldContain($file, PyStringNode $string)
    {
        expect(file_get_contents($file))->toBe($string->getRaw());
    }

    /**
     * @Given the spec file :file contains:
     */
    public function theSpecFileContains($file, PyStringNode $string)
    {
        $this->saveFile($file, $string);
        require_once($file);
    }

    /**
     * @param $file
     * @param PyStringNode $string
     * @return void
     */
    private function saveFile($file, PyStringNode $string)
    {
        $dirname = dirname($file);
        if (!file_exists($dirname)) {
            mkdir($dirname, 0777, true);
        }

        file_put_contents($file, $string->getRaw());
    }

    /**
     * @return ApplicationTester
     */
    private function createApplicationTester()
    {
        file_put_contents('phpspec.yml','extensions: [RMiller\ExemplifyExtension\ExemplifyExtension]');
        $application = new Application('2.1-dev');
        $application->setAutoExit(false);

        return new ApplicationTester($application);
    }

    /**
     * @When I run phpspec exemplify to add the :method method to :class
     */
    public function iRunPhpspecExemplifyToAddTheMethodTo($method, $class)
    {
        $this->applicationTester = $this->createApplicationTester();
        $this->applicationTester->run(sprintf('exemplify --no-interaction %s %s', $class, $method));
    }

    /**
     * @Then /^(?:|I )should see "(?P<message>[^"]*)"$/
     */
    public function iShouldSee($message)
    {
        expect($this->applicationTester->getDisplay())->toMatch('/'.preg_quote($message, '/').'/sm');
    }

    /**
     * @When I run phpspec exemplify to add the :method method as a :type to :class
     */
    public function iRunPhpspecExemplifyToAddTheMethodAsATo($method, $type, $class)
    {
        $formattedMethodTypes = ['instance method','named constructor', 'static method'];

        $this->applicationTester = $this->createApplicationTester();
        $this->applicationTester->putToInputStream(sprintf("%s\n", array_search($type, $formattedMethodTypes)));
        $this->applicationTester->run(sprintf('exemplify %s %s', $class, $method), ['interactive' => true, 'decorated' => false]);
    }
}
