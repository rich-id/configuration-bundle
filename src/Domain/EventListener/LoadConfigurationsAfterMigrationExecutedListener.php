<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\EventListener;

use RichId\ConfigurationBundle\Domain\Configuration\ConfigurationManager;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Contracts\Service\Attribute\Required;

class LoadConfigurationsAfterMigrationExecutedListener
{
    public const MIGRATION_MIGRATE_COMMAND = 'doctrine:migrations:migrate';

    #[Required]
    public ConfigurationManager $configurationManager;

    public function onMigrationsMigrated(ConsoleTerminateEvent $event): void
    {
        if ($event->getCommand() === null || $event->getCommand()->getName() !== self::MIGRATION_MIGRATE_COMMAND || $event->getExitCode() !== 0) {
            return;
        }

        $this->configurationManager->loadAllConfigurations($event->getOutput());
    }
}
