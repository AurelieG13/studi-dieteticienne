<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-administrator',
    description: 'Create an administrator',
)]
class CreateAdministratorCommand extends Command
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct('app:create-administrator');
        $this->em = $em;
    }
    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Name')
            ->addArgument('firstname', InputArgument::OPTIONAL, 'Firstname')
            ->addArgument('email', InputArgument::OPTIONAL, 'Email')
            ->addArgument('password', InputArgument::OPTIONAL, 'Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);

        $firstname = $input->getArgument('firstname');
        if(!$firstname) {
            $question = new Question('Quel est le prénom de l\'administrateur :');
            $firstname = $helper->ask($input, $output, $question);
        }
        
        $name = $input->getArgument('name');
        if(!$name) {
            $question = new Question('Quel est le nom de l\'administrateur :');
            $name = $helper->ask($input, $output, $question);
        }

        $email = $input->getArgument('email');
        if(!$email) {
            $question = new Question('Quel est l\'email de '. $firstname . $name.' :');
            $email = $helper->ask($input, $output, $question);
        }
        $plainPassword = $input->getArgument('password');
        if(!$plainPassword) {
            $question = new Question('Quel est le mot de passe de '. $firstname . $name.' :');
            $plainPassword = $helper->ask($input, $output, $question);
        }

        $user =(new User())->setFirstname($firstname)
            ->setName($name)
            ->setEmail($email)
            ->setPlainPassword($plainPassword)
            ->setPassword($plainPassword)
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setIsVerified(1)
            ;

        $this->em->persist($user);
        $this->em->flush();

        $io->success('Le nouvel administrateur a été créé !');

        return Command::SUCCESS;
    }
}
