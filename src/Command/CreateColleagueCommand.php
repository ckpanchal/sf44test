<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Colleague;
use Doctrine\ORM\EntityManagerInterface;

class CreateColleagueCommand extends Command
{
    protected static $defaultName = 'app:create-colleague';

    protected static $defaultDescription = 'This command will create a colleague for you.';

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('name', InputArgument::REQUIRED, 'Enter colleague fullname')
            ->addArgument('email', InputArgument::REQUIRED, 'Enter colleague email')
            ->addArgument('note', InputArgument::OPTIONAL, 'Enter note for colleague')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');
        $email = $input->getArgument('email');
        $note = $input->getArgument('note');

        $colleague = new Colleague();
        $colleague->setName($name);
        $colleague->setEmail($email);

        if (!empty($note)) {
            $colleague->setNote($note);
        }

        $this->em->persist($colleague);
        $this->em->flush();

        if ($colleague->getId()) {
            $io->success('Colleague id= ' .$colleague->getId(). ' successfully created.');
        } else {
            $io->error('Oops something went wrong. Colleague not created.');
        }

        return 0;
    }
}
