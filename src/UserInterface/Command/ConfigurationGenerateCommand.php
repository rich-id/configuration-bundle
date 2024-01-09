<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\UserInterface\Command;

use RichId\ConfigurationBundle\Domain\Generator\NewConfigurationGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(name: 'rich-id:configuration:generate', description: 'Generate a blank configuration class.')]
class ConfigurationGenerateCommand extends Command
{
    #[Required]
    public NewConfigurationGenerator $newConfigurationGenerator;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $path = ($this->newConfigurationGenerator)();

        $io->text(sprintf('Generated new configuration class to "<info>%s</info>"', $path));

        return Command::SUCCESS;
    }
}
