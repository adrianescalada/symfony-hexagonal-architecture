<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class CreateEntitiesCommand extends Command
{
    protected static $defaultName = 'app:create-entities';

    protected function configure()
    {
        $this->setDescription('Creates both groups and users using the respective commands.')
            ->setHelp('This command allows you to create both groups and users using the respective commands.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $groupCommand = $this->getApplication()->find('app:create-group');
        $userCommand = $this->getApplication()->find('app:create-user');

        $groupInput = new ArrayInput([]);
        $userInput = new ArrayInput([]);

        $groupCommand->run($groupInput, $output);
        $userCommand->run($userInput, $output);

        return Command::SUCCESS;
    }
}