<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\UserInterface\Command;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\CommandTestCase;
use RichId\ConfigurationBundle\Domain\Entity\ConfigurationVersion;
use RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124806;
use RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124807;
use RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124808;
use RichId\ConfigurationBundle\UserInterface\Command\ConfigurationsLoadCommand;

/** @covers \RichId\ConfigurationBundle\UserInterface\Command\ConfigurationsLoadCommand */
#[TestConfig('fixtures')]
final class ConfigurationsLoadCommandTest extends CommandTestCase
{
    /** @var ConfigurationsLoadCommand */
    protected $command;

    protected function beforeTest(): void
    {
        /** @var ConfigurationsLoadCommand $command */
        $command = $this->getService(ConfigurationsLoadCommand::class);
        $this->command = $command;
    }

    public function testCommandWithoutMigrationToExecute(): void
    {
        $this->buildConfigurationVersion(Version20240109124806::class);
        $this->buildConfigurationVersion(Version20240109124807::class);
        $this->buildConfigurationVersion(Version20240109124808::class);

        self::assertSame(4, $this->countConfigurationVersion());

        $output = $this->execute();

        self::assertStringContainsString('[notice] No configuration to execute.', $output);
        self::assertSame(4, $this->countConfigurationVersion());
    }

    public function testCommand(): void
    {
        self::assertSame(1, $this->countConfigurationVersion());

        $output = $this->execute();

        self::assertStringNotContainsString('Version20240109124805', $output); // Already executed
        self::assertStringContainsString('[notice] Configuration RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124806 executed.', $output); // To execute
        self::assertStringContainsString('[notice] Configuration RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124807 is skipped.', $output); // Skipped
        self::assertStringContainsString('[notice] Configuration RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124808 executed.', $output); // To execute
        self::assertSame(3, $this->countConfigurationVersion());
    }

    public function testCommandExecuteSpecificVersionName(): void
    {
        self::assertSame(1, $this->countConfigurationVersion());

        $output = $this->execute(['--version-name' => 'Version20240109124806']);

        self::assertStringNotContainsString('Version20240109124805', $output);
        self::assertStringNotContainsString('Version20240109124807', $output);
        self::assertStringNotContainsString('Version20240109124808', $output);
        self::assertStringContainsString('[notice] Configuration RichId\ConfigurationBundle\Tests\Resources\Configurations\Version20240109124806 executed.', $output);
        self::assertSame(2, $this->countConfigurationVersion());
    }

    public function testCommandExecuteSpecificVersionNameNotFound(): void
    {
        self::assertSame(1, $this->countConfigurationVersion());

        $output = $this->execute(['--version-name' => 'Version20240109124806Bis']);

        self::assertStringNotContainsString('Version20240109124805', $output);
        self::assertStringNotContainsString('Version20240109124807', $output);
        self::assertStringNotContainsString('Version20240109124808', $output);
        self::assertStringContainsString('[ERROR] No configuration with version "Version20240109124806Bis"', $output);
        self::assertSame(1, $this->countConfigurationVersion());
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
