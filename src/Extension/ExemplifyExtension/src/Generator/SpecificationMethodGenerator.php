<?php

namespace RMiller\ExemplifyExtension\Generator;

use PhpSpec\CodeGenerator\Generator\GeneratorInterface;
use PhpSpec\Console\IO;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Util\Filesystem;
use PhpSpec\Locator\ResourceInterface;
use RMiller\Caser\Cased;

/**
 * Generates class methods from a resource
 */
class SpecificationMethodGenerator implements GeneratorInterface
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
     * @param IO               $io
     * @param TemplateRenderer $templates
     * @param Filesystem       $filesystem
     */
    public function __construct(IO $io, TemplateRenderer $templates, Filesystem $filesystem = null)
    {
        $this->io         = $io;
        $this->templates  = $templates;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    /**
     * @param ResourceInterface $resource
     * @param string            $generation
     * @param array             $data
     *
     * @return bool
     */
    public function supports(ResourceInterface $resource, $generation, array $data)
    {
        return 'specification_method' === $generation;
    }

    /**
     * @param ResourceInterface $resource
     * @param array             $data
     */
    public function generate(ResourceInterface $resource, array $data = [])
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
     * @param \PhpSpec\Locator\ResourceInterface $resource
     * @param string $spec
     * @param \RMiller\Caser\Cased $method
     * @param $type
     */
    private function addExampleToSpec(ResourceInterface $resource, $spec, Cased $method, $type)
    {
        $spec = preg_replace('/}[ \n]*$/', rtrim($this->renderContent($method, $type)) . "\n}\n", trim($spec));
        $this->filesystem->putFileContents($resource->getSpecFilename(), $spec);
        $this->informExampleAdded($resource, $method);
    }

    /**
     * @param ResourceInterface $resource
     * @param $method
     */
    private function informExampleAdded(ResourceInterface $resource, Cased $method)
    {
        $this->io->writeln(sprintf(
            "\nExample for <info>Method <value>%s::%s()</value> has been created.</info>",
            $resource->getSrcClassname(), $method->asCamelCase()
        ), 2);
    }

    /**
     * @param ResourceInterface $resource
     * @param $method
     */
    private function informExampleAlreadyExists(ResourceInterface $resource, Cased $method)
    {
        $this->io->writeln(sprintf(
            "\nExample for <info>Method <value>%s::%s()</value> already exists.</info> Try the <info>phpspec run</info> command",
            $resource->getSrcClassname(), $method->asCamelCase()
        ), 2);
    }
}
