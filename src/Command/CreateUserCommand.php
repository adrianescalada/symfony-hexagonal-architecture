<?php

namespace App\Command;

use App\Factory\UserFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Creates a new user using the UserFactory.')
            ->setHelp('This command allows you to create a new user using the UserFactory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $numberOfUsers = 1000;

        for ($i = 0; $i < $numberOfUsers; $i++) {
            $group = UserFactory::create();
            $this->entityManager->persist($group);
        }

        $this->entityManager->flush();

        $output->writeln('Users created ' . $numberOfUsers . ' successfully.');


        return Command::SUCCESS;
    }
}