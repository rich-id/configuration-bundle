<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\Port;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ConfigurationBundle\Domain\Port\ConfigurationInterface;
use RichId\ConfigurationBundle\Tests\Resources\Stub\ConfigurationAdapterStub;

/** @covers \RichId\ConfigurationBundle\Infrastructure\Adapter\ConfigurationAdapter */
#[TestConfig('fixtures')]
final class ConfigurationInterfaceTest extends TestCase
{
    public ConfigurationInterface $configuration;

    public ConfigurationAdapterStub $configurationAdapterStub;

    public function testGetConfigurationNamespace(): void
    {
        self::assertSame('RichId\ConfigurationBundle\Tests\Resources\Configurations', $this->configuration->getConfigurationNamespace());
    }

    public function testGetConfigurationPath(): void
    {
        self::assertStringContainsString('/tests/Resources/Configurations', $this->configuration->getConfigurationPath());
    }

    public function testGetConfigurationTemplatePathDefaultValue(): void
    {
        $conf = $this->configuration->getConfigurationTemplatePath();

        self::assertNull($conf);
    }


    public function testGetConfigurationTemplatePathCustomValue(): void
    {
        $this->configurationAdapterStub->setConfigurationTemplatePath('/tests/Resources/configuration_template.php.txt');
        $conf = $this->configuration->getConfigurationTemplatePath();

        self::assertNotNull($conf);
        self::assertSame('/tests/Resources/configuration_template.php.txt', $conf);
    }
}
