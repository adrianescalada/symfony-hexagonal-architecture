<?php

namespace App\Command;

use App\Factory\GroupFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreateGroupCommand extends Command
{
    protected static $defaultName = 'app:create-group';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Creates a new group using the GroupFactory.')
            ->setHelp('This command allows you to create a new group using the GroupFactory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $numberOfGroups = 100;

        for ($i = 0; $i < $numberOfGroups; $i++) {
            $group = GroupFactory::create();
            $this->entityManager->persist($group);
        }

        $this->entityManager->flush();

        $output->writeln('Groups created ' . $numberOfGroups . ' successfully.');


        return Command::SUCCESS;
    }
}
