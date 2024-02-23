<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Domain\EventListener;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\CommandTestCase;
use RichId\ConfigurationBundle\Domain\Entity\ConfigurationVersion;
use RichId\ConfigurationBundle\Domain\EventListener\LoadConfigurationsAfterMigrationExecutedListener;
use RichId\ConfigurationBundle\Tests\Resources\Command\MigrateCommand;
use RichId\ConfigurationBundle\UserInterface\Command\ConfigurationGenerateCommand;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/** @covers \RichId\ConfigurationBundle\Domain\EventListener\LoadConfigurationsAfterMigrationExecutedListener */
#[TestConfig('fixtures')]
final class LoadConfigurationsAfterMigrationExecutedListenerTest extends CommandTestCase
{
    public LoadConfigurationsAfterMigrationExecutedListener $loadConfigurationsAfterMigrationExecutedListener;

    public function testListenerWithoutMigrationCommand(): void
    {
        /** @var ConfigurationGenerateCommand $command */
        $command = $this->getService(ConfigurationGenerateCommand::class);

        self::assertSame(1, $this->countConfigurationVersion());

        $event = new ConsoleTerminateEvent($command, new ArrayInput([]), new NullOutput(), 0);
        $this->loadConfigurationsAfterMigrationExecutedListener->onMigrationsMigrated($event);

        self::assertSame(1, $this->countConfigurationVersion());
    }

    public function testListenerWithMigrateCommand(): void
    {
        /** @var ConfigurationGenerateCommand $command */
        $command = $this->getService(MigrateCommand::class);
        self::assertSame(1, $this->countConfigurationVersion());

        $event = new ConsoleTerminateEvent($command, new ArrayInput([]), new NullOutput(), 0);
        $this->loadConfigurationsAfterMigrationExecutedListener->onMigrationsMigrated($event);

        self::assertSame(3, $this->countConfigurationVersion());
    }

    public function testListenerWithMigrateCommandButNotExitCodeZero(): void
    {
        /** @var MigrateCommand $command */
        $command = $this->getService(MigrateCommand::class);
        self::assertSame(1, $this->countConfigurationVersion());

        $event = new ConsoleTerminateEvent($command, new ArrayInput([]), new NullOutput(), 1);
        $this->loadConfigurationsAfterMigrationExecutedListener->onMigrationsMigrated($event);

        self::assertSame(1, $this->countConfigurationVersion());
    }

    private function countConfigurationVersion(): int
    {
        return $this->getManager()->getRepository(ConfigurationVersion::class)->count([]);
    }
}
