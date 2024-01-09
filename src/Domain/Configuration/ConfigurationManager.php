<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Domain\Configuration;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RichId\ConfigurationBundle\Domain\Factory\ConfigurationVersionFactory;
use RichId\ConfigurationBundle\Domain\Port\ConfigurationVersionRepositoryInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Service\Attribute\Required;

final class ConfigurationManager
{
    #[Required]
    public ConfigurationVersionFactory $configurationVersionFactory;

    #[Required]
    public ConfigurationVersionRepositoryInterface $configurationVersionRepository;

    #[Required]
    public LoggerInterface $logger;

    #[Required]
    public EntityManagerInterface $entityManager;

    /** @var ConfigurationInterface[] */
    private array $configurations = [];

    /** @var string[]|null  */
    private ?array $executedConfigurations = null;

    public function addService(ConfigurationInterface $configuration): void
    {
        $this->configurations[] = $configuration;
    }

    public function findOneByVersionName(string $versionName): ?ConfigurationInterface
    {
        foreach ($this->configurations as $configuration) {
            if (\str_ends_with($configuration::class, \sprintf('\%s', $versionName))) {
                return $configuration;
            }
        }

        return null;
    }

    public function loadAllConfigurations(?OutputInterface $output = null): void
    {
        $hasExecustedConfiguration = false;

        foreach ($this->configurations as $configuration) {
            if ($this->isMigrationExecuted($configuration)) {
                continue;
            }

            $this->loadConfiguration($configuration, $output);
            $hasExecustedConfiguration = true;
        }

        if (!$hasExecustedConfiguration) {
            $output?->writeln('<info>[notice] No configuration to execute.</info>');
        }
    }

    public function loadConfiguration(ConfigurationInterface $configuration, ?OutputInterface $output = null): bool
    {
        if ($this->isMigrationExecuted($configuration)) {
            $output?->writeln(\sprintf('<info>[notice] Configuration <comment>%s</comment> already executed.</info>', $configuration::class));

            return false;
        }

        $isExecuted = $configuration->loadConfiguration();

        if (!$isExecuted) {
            $output?->writeln(\sprintf('<info>[notice] Configuration <comment>%s</comment> is skipped.</info>', $configuration::class));

            return false;
        }

        $output?->writeln(\sprintf('<info>[notice] Configuration <comment>%s</comment> executed.</info>', $configuration::class));

        ($this->configurationVersionFactory)($configuration::class);
        $this->entityManager->flush();

        $this->executedConfigurations[] = $configuration::class;

        return true;
    }

    private function isMigrationExecuted(ConfigurationInterface $configuration): bool
    {
        return \in_array($configuration::class, $this->getExecutedConfigurations(), true);
    }

    /** @return string[] */
    private function getExecutedConfigurations(): array
    {
        if ($this->executedConfigurations === null) {
            $this->executedConfigurations = $this->configurationVersionRepository->findAllVersions();
        }

        return $this->executedConfigurations;
    }
}
