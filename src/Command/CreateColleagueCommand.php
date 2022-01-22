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
use Symfony\Component\Console\Question\Question;

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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        // Question for colleague name
        $nameQuestion = new Question('Please enter name (Required):');
        $nameQuestion->setValidator(function ($value) {
            if (trim($value) == '') {
                throw new \Exception('Name is required');
            }
            return $value;
        });
        $nameQuestion->setMaxAttempts(3);
        $name = $helper->ask($input, $output, $nameQuestion);

        // Question for colleague email
        $emailQuestion = new Question('Please enter email (Required):');
        $emailQuestion->setValidator(function ($value) {
            if (trim($value) == '') {
                throw new \Exception('Email is required');
            }

            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Please enter valid email');
            }
            return $value;
        });
        $emailQuestion->setMaxAttempts(3);
        $email = $helper->ask($input, $output, $emailQuestion);

        // Question for notes
        $noteQuestion = new Question('Write some note about colleague (Optional):');
        $note = $helper->ask($input, $output, $noteQuestion);

        $colleague = new Colleague();
        $colleague->setName($name);
        $colleague->setEmail($email);
        $colleague->setCreated(new \DateTime());
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
