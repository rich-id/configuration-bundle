<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\UserInterface\Command;

use RichId\ConfigurationBundle\Domain\Configuration\ConfigurationManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(name: 'rich-id:configurations:load', description: 'Execute all configurations.')]
class ConfigurationsLoadCommand extends Command
{
    #[Required]
    public ConfigurationManager $configurationManager;

    protected function configure(): void
    {
        $this->addOption('version-name', null, InputOption::VALUE_OPTIONAL, 'Version name. To execute only this version.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $versionName = $input->getOption('version-name');

        if (\is_string($versionName)) {
            $version = $this->configurationManager->findOneByVersionName($versionName);

            if ($version === null) {
                $io->error(\sprintf('No configuration with version "%s"', $versionName));

                return Command::FAILURE;
            }

            $this->configurationManager->loadConfiguration($version, $output);

            return Command::SUCCESS;
        }

        $this->configurationManager->loadAllConfigurations($output);

        return Command::SUCCESS;
    }
}
