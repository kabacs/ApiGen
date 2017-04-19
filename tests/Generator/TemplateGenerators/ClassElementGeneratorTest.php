<?php declare(strict_types=1);

namespace ApiGen\Tests\ApiGen\Generator\TemplateGenerators;

use ApiGen\Contracts\Configuration\ConfigurationInterface;
use ApiGen\Contracts\Parser\ParserInterface;
use ApiGen\Generator\TemplateGenerators\ClassElementGenerator;
use ApiGen\Tests\AbstractContainerAwareTestCase;

final class ClassElementGeneratorTest extends AbstractContainerAwareTestCase
{
    /**
     * @var ClassElementGenerator
     */
    private $classElementGenerator;

    protected function setUp(): void
    {
        /** @var ConfigurationInterface $configuration */
        $configuration = $this->container->getByType(ConfigurationInterface::class);
        $configuration->resolveOptions([
            'source' => [__DIR__],
            'destination' => TEMP_DIR
        ]);

        /** @var ParserInterface $parser */
        $parser = $this->container->getByType(ParserInterface::class);
        $parser->parseDirectories([__DIR__ . '/Source']);

        $this->classElementGenerator = $this->container->getByType(ClassElementGenerator::class);
    }

    public function testGenerate(): void
    {
        $this->classElementGenerator->generate();
        $this->assertFileExists(TEMP_DIR . '/class-ApiGen.Tests.ApiGen.Generator.TemplateGenerators.Source.SomeClass.html');
        $this->assertFileExists(TEMP_DIR . '/interface-ApiGen.Tests.ApiGen.Generator.TemplateGenerators.Source.SomeInterface.html');
        $this->assertFileExists(TEMP_DIR . '/trait-ApiGen.Tests.ApiGen.Generator.TemplateGenerators.Source.SomeTrait.html');
    }
}
