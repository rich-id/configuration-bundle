<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\Generator;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ConfigurationBundle\Domain\Generator\NewConfigurationGenerator;
use RichId\ConfigurationBundle\Tests\Resources\Stub\ConfigurationAdapterStub;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/** @covers \RichId\ConfigurationBundle\Domain\Generator\NewConfigurationGenerator*/
#[TestConfig('fixtures')]
final class NewConfigurationGeneratorTest extends TestCase
{
    public NewConfigurationGenerator $newConfigurationGenerator;

    public ConfigurationAdapterStub $configurationAdapterStub;

    public ParameterBagInterface $parameterBag;

    public function testGeneratorDefaultTemplate(): void
    {
        $this->configurationAdapterStub->setConfigurationPath('/app/tests/Resources/Files/tmp');

        $path = ($this->newConfigurationGenerator)();

        self::assertStringContainsString('/tests/Resources/Files/tmp/Version', $path);
    }

    public function testGeneratorCustomTemplate(): void
    {
        /** @var string $projectDir */
        $projectDir = $this->parameterBag->get('kernel.project_dir');

        $this->configurationAdapterStub->setConfigurationTemplatePath($projectDir . '/tests/Resources/configuration_template.php.txt');
        $this->configurationAdapterStub->setConfigurationPath('/app/tests/Resources/Files/tmp');

        $path = ($this->newConfigurationGenerator)();

        self::assertStringContainsString('/tests/Resources/Files/tmp/Version', $path);
    }

    public function testGeneratorCustomTemplateNotFound(): void
    {
        /** @var string $projectDir */
        $projectDir = $this->parameterBag->get('kernel.project_dir');

        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage(\sprintf('The specified template "%s/tests/Resources/configuration_template_other.php.txt" cannot be found or is not readable.', $projectDir));

        $this->configurationAdapterStub->setConfigurationTemplatePath($projectDir . '/tests/Resources/configuration_template_other.php.txt');
        $this->configurationAdapterStub->setConfigurationPath('/app/tests/Resources/Files/tmp');

        ($this->newConfigurationGenerator)();
    }

    public function testGeneratorCustomTemplateEmpty(): void
    {
        /** @var string $projectDir */
        $projectDir = $this->parameterBag->get('kernel.project_dir');

        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage(\sprintf('The specified template "%s/tests/Resources/configuration_template_empty.php.txt" could not be read or is empty.', $projectDir));

        $this->configurationAdapterStub->setConfigurationTemplatePath($projectDir . '/tests/Resources/configuration_template_empty.php.txt');
        $this->configurationAdapterStub->setConfigurationPath('/app/tests/Resources/Files/tmp');

        ($this->newConfigurationGenerator)();
    }
}
