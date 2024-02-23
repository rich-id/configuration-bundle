<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\Configuration;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ConfigurationBundle\Domain\Configuration\ConfigurationManager;
use RichId\ConfigurationBundle\Domain\Entity\ConfigurationVersion;
use RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124805;
use RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124806;
use RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124807;
use RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124808;

/**
 * @covers \RichId\ConfigurationBundle\Domain\Configuration\AbstractConfiguration
 * @covers \RichId\ConfigurationBundle\Domain\Configuration\ConfigurationManager
 */
#[TestConfig('fixtures')]
final class ConfigurationsTest extends TestCase
{
    public ConfigurationManager $configurationManager;

    public Version20240109124805 $version20240109124805;

    public Version20240109124806 $version20240109124806;

    public function testLoadAllConfigurationsButNothingToExecute(): void
    {
        $this->buildConfigurationVersion(Version20240109124806::class);
        $this->buildConfigurationVersion(Version20240109124807::class);
        $this->buildConfigurationVersion(Version20240109124808::class);

        self::assertSame(4, $this->countConfigurationVersion());

        $this->configurationManager->loadAllConfigurations();

        self::assertSame(4, $this->countConfigurationVersion());
    }

    public function testLoadAllConfigurations(): void
    {
        self::assertSame(1, $this->countConfigurationVersion());

        $this->configurationManager->loadAllConfigurations();

        self::assertSame(3, $this->countConfigurationVersion());
    }

    public function testCommandExecuteSpecificVersionName(): void
    {
        self::assertSame(1, $this->countConfigurationVersion());

        $output = $this->configurationManager->loadConfiguration($this->version20240109124806);

        self::assertTrue($output);
        self::assertSame(2, $this->countConfigurationVersion());
    }

    public function testCommandExecuteSpecificVersionNameAlreadyExecuted(): void
    {
        self::assertSame(1, $this->countConfigurationVersion());

        $output = $this->configurationManager->loadConfiguration($this->version20240109124805);

        self::assertFalse($output);
        self::assertSame(1, $this->countConfigurationVersion());
    }

    public function testFindOneByVersionName(): void
    {
        $output = $this->configurationManager->findOneByVersionName('Version20240109124805');

        self::assertSame($this->version20240109124805, $output);
    }

    public function testFindOneByVersionNameNotFound(): void
    {
        $output = $this->configurationManager->findOneByVersionName('Version20240109124805Bis');

        self::assertNull($output);
    }

    private function countConfigurationVersion(): int
    {
        return $this->getManager()->getRepository(ConfigurationVersion::class)->count([]);
    }

    private function buildConfigurationVersion(string $version): void
    {
        $entity = new ConfigurationVersion();

        $entity->setVersion($version);
        $entity->setExecutedAt(new \DateTime('2024-01-01 00:00:00'));

        $this->getManager()->persist($entity);
        $this->getManager()->flush();
    }
}
