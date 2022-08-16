<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user.',
    hidden: false,
    aliases: ['app:add-user']
)]
class CreateUserCommand extends Command
{
    /** var UserPasswordHasherInterface */
    protected $userPasswordHasher;

    /** var EntityManagerInterface */
    protected $em;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->em = $em;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('email', null,InputOption::VALUE_REQUIRED, 'email')
            ->addOption('password',null, InputOption::VALUE_REQUIRED, 'mot de passe' )
            ->addOption('role', null, InputOption::VALUE_OPTIONAL, 'role','ROLE_USER')
            ->addOption('firstname', null, InputOption::VALUE_OPTIONAL, 'role','ROLE_USER')
            ->addOption('lastname', null, InputOption::VALUE_OPTIONAL, 'role','ROLE_USER')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $output->writeln("CreateUser - Start");

        $question = new Question('Please enter your email: ', 'email');
        $email = $helper->ask($input, $output, $question);

        $question2 = new Question('Please enter your password: ', 'password');
        $password = $helper->ask($input, $output, $question2);

        $question3 = new ChoiceQuestion('Please choose your role (defaults to ROLE_USER): ',['ROLE_USER','ROLE_ADMIN']);
        $role = $helper->ask($input, $output, $question3);

        $question4 = new Question('Please enter your first name: ', 'firstname');
        $firstname = $helper->ask($input, $output, $question4);

        $question5 = new Question('Please enter your last name: ', 'lastname');
        $lastname = $helper->ask($input, $output, $question5);

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
        $user->setRoles(array($role));
        $user->setFirstname($firstname);
        $user->setLastname($lastname);

        $this->em->persist($user);
        $this->em->flush();
        $output->writeln("CreateUser - End");
        return 0;
    }
}
