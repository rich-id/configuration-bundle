<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\Port;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ConfigurationBundle\Domain\Port\ConfigurationInterface;

/** @covers \RichId\ConfigurationBundle\Infrastructure\Adapter\ConfigurationAdapter */
#[TestConfig('fixtures')]
final class ConfigurationInterfaceTest extends TestCase
{
    public ConfigurationInterface $configuration;

    public function testGetConfigurationNamespace(): void
    {
        self::assertSame('RichId\ConfigurationBundle\Tests\Resources\Configurations', $this->configuration->getConfigurationNamespace());
    }

    public function testGetConfigurationPath(): void
    {
        self::assertStringContainsString('/tests/Resources/Configurations', $this->configuration->getConfigurationPath());
    }

    public function testGetConfigurationTemplatePath(): void
    {
        $conf = $this->configuration->getConfigurationTemplatePath();

        self::assertNotNull($conf);
        self::assertStringContainsString('/tests/Resources/configuration_template.php.txt', $conf);
    }
}
