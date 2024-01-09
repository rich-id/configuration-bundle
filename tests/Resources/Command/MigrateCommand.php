<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Resources\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'doctrine:migrations:migrate')]
class MigrateCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('status-code');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $input->getArgument('status-code') ?? Command::SUCCESS;
    }
}
