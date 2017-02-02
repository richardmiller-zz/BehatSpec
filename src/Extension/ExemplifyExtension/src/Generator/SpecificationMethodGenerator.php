<?php

namespace RMiller\BehatSpec\Extension\ExemplifyExtension\Generator;

use PhpSpec\CodeGenerator\Generator\Generator;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\Resource;
use RMiller\Caser\Cased;

/**
 * Generates class methods from a resource
 */
class SpecificationMethodGenerator implements Generator
{
    /**
     * @var \PhpSpec\Console\IO
     */
    private $io;

    /**
     * @var \PhpSpec\CodeGenerator\TemplateRenderer
     */
    private $templates;

    /**
     * @var \PhpSpec\Util\Filesystem
     */
    private $filesystem;

    /**
     * @param ConsoleIO        $io
     * @param TemplateRenderer $templates
     * @param Filesystem       $filesystem
     */
    public function __construct(ConsoleIO $io, TemplateRenderer $templates, Filesystem $filesystem = null)
    {
        $this->io         = $io;
        $this->templates  = $templates;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    /**
     * @param Resource $resource
     * @param string            $generation
     * @param array             $data
     *
     * @return bool
     */
    public function supports(Resource $resource, $generation, array $data)
    {
        return 'specification_method' === $generation;
    }

    /**
     * @param Resource $resource
     * @param array             $data
     */
    public function generate(Resource $resource, array $data = [])
    {
        $method = Cased::fromCamelCase($data['method']);
        $spec = $this->filesystem->getFileContents($resource->getSpecFilename());

        if ($this->exampleAlreadyExists($spec, $method)) {
            $this->informExampleAlreadyExists($resource, $method);

            return;
        }

        $this->addExampleToSpec($resource, $spec, $method, $data['type']);
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return 0;
    }

    /**
     * @param $type
     * @return string
     */
    protected function getTemplate($type)
    {
        return file_get_contents(__DIR__.'/templates/'.$type.'.template');
    }

    /**
     * @param string $spec
     * @param \RMiller\Caser\Cased $method
     * @return bool
     */
    private function exampleAlreadyExists($spec, Cased $method)
    {
        $camelCaseMethod = $method->asCamelCase();

        $methodStrings = [
            '$this->' . $camelCaseMethod . '(',
            '$this::' . $camelCaseMethod . '(',
            '$this->beConstructedThrough(\'' . $camelCaseMethod . '\'',
        ];

        foreach ($methodStrings as $existingMethodString) {
            if (strpos($spec, $existingMethodString) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \RMiller\Caser\Cased $method
     * @param $type
     * @return string
     */
    private function renderContent(Cased $method, $type)
    {
        return $this->templates->renderString($this->getTemplate($type), [
            '%method%' => $method->asCamelCase(),
            '%example_name%' => 'it_should_' . $method->asSnakeCase(),
            '%constructor_example_name%' => 'it_should_be_constructed_through_' . $method->asSnakeCase(),
        ]);
    }

    /**
     * @param \PhpSpec\Locator\Resource $resource
     * @param string $spec
     * @param \RMiller\Caser\Cased $method
     * @param $type
     */
    private function addExampleToSpec(Resource $resource, $spec, Cased $method, $type)
    {
        $spec = preg_replace('/}[ \n]*$/', rtrim($this->renderContent($method, $type)) . "\n}\n", trim($spec));
        $this->filesystem->putFileContents($resource->getSpecFilename(), $spec);
        $this->informExampleAdded($resource, $method);
    }

    /**
     * @param Resource $resource
     * @param $method
     */
    private function informExampleAdded(Resource $resource, Cased $method)
    {
        $this->io->writeln(sprintf(
            "\nExample for <info>Method <value>%s::%s()</value> has been created.</info>",
            $resource->getSrcClassname(), $method->asCamelCase()
        ), 2);
    }

    /**
     * @param Resource $resource
     * @param $method
     */
    private function informExampleAlreadyExists(Resource $resource, Cased $method)
    {
        $this->io->writeln(sprintf(
            "\nExample for <info>Method <value>%s::%s()</value> already exists.</info> Try the <info>phpspec run</info> command",
            $resource->getSrcClassname(), $method->asCamelCase()
        ), 2);
    }
}
