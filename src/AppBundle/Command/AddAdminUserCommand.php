<?php

namespace AppBundle\Command;

use AppBundle\Entity\AdminUser;
use AppBundle\Utils\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class AddAdminUserCommand extends Command
{
    /** @var SymfonyStyle */
    private $io;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;
    /** @var Validator */
    private $validator;

    /**
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @param Validator $validator
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, Validator $validator)
    {
        parent::__construct();

        $this->entityManager = $em;
        $this->passwordEncoder = $encoder;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:add-admin-user')
            ->setDescription('Creates admin users and stores them in the database')
            ->setHelp($this->getCommandHelp())
            ->addArgument('username', InputArgument::OPTIONAL, 'The username of the new admin user')
            ->addArgument('password', InputArgument::OPTIONAL, 'The plain password of the new admin user')
            ->addArgument('email', InputArgument::OPTIONAL, 'The email of the new admin user')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (null !== $input->getArgument('username') && null !== $input->getArgument('password') && null !== $input->getArgument('email')) {
            return;
        }

        $this->io->title('Add AdminUser Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console app:add-admin-user username password email@example.com',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
        ]);

        // Ask for the username if it's not defined
        $username = $input->getArgument('username');
        if (null !== $username) {
            $this->io->text(' > <info>Username</info>: '.$username);
        } else {
            $username = $this->io->ask('Username', null, [$this->validator, 'validateUsername']);
            $input->setArgument('username', $username);
        }

        // Ask for the password if it's not defined
        $password = $input->getArgument('password');
        if (null !== $password) {
            $this->io->text(' > <info>Password</info>: '.str_repeat('*', mb_strlen($password)));
        } else {
            $password = $this->io->askHidden('Password (your type will be hidden)', [$this->validator, 'validatePassword']);
            $input->setArgument('password', $password);
        }

        // Ask for the email if it's not defined
        $email = $input->getArgument('email');
        if (null !== $email) {
            $this->io->text(' > <info>Email</info>: '.$email);
        } else {
            $email = $this->io->ask('Email', null, [$this->validator, 'validateEmail']);
            $input->setArgument('email', $email);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('add-admin-user-command');

        $username = $input->getArgument('username');
        $plainPassword = $input->getArgument('password');
        $email = $input->getArgument('email');

        $this->validateUserData($username, $plainPassword, $email);

        $user = new AdminUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles(['ROLE_ADMIN']);

        $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->io->success(sprintf('%s was successfully created: %s (%s)', 'Administrator user', $user->getUsername(), $user->getEmail()));

        $event = $stopwatch->stop('add-admin-user-command');
        if ($output->isVerbose()) {
            $this->io->comment(sprintf('New admin user database id: %d / Elapsed time: %.2f ms / Consumed memory: %.2f MB', $user->getId(), $event->getDuration(), $event->getMemory() / pow(1024, 2)));
        }
    }

    /**
     * @param string $username
     * @param string $plainPassword
     * @param string $email
     */
    private function validateUserData($username, $plainPassword, $email)
    {
        $userRepository = $this->entityManager->getRepository(AdminUser::class);

        $existingUser = $userRepository->findOneBy(['username' => $username]);

        if (null !== $existingUser) {
            throw new \RuntimeException(sprintf('There is already a admin user registered with the "%s" username.', $username));
        }

        $this->validator->validatePassword($plainPassword);
        $this->validator->validateEmail($email);

        $existingEmail = $userRepository->findOneBy(['email' => $email]);

        if (null !== $existingEmail) {
            throw new \RuntimeException(sprintf('There is already a admin user registered with the "%s" email.', $email));
        }
    }

    /**
     * @return string
     */
    private function getCommandHelp()
    {
        return <<<'HELP'
The <info>%command.name%</info> command creates new admin users and saves them in the database:

  <info>php %command.full_name%</info> <comment>username password email</comment>

If you omit any of the three required arguments, the command will ask you to
provide the missing values:

  # command will ask you for the email
  <info>php %command.full_name%</info> <comment>username password</comment>

  # command will ask you for the email and password
  <info>php %command.full_name%</info> <comment>username</comment>

  # command will ask you for all arguments
  <info>php %command.full_name%</info>

HELP;
    }
}
