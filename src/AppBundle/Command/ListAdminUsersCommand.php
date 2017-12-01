<?php

namespace AppBundle\Command;

use AppBundle\Entity\AdminUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListAdminUsersCommand extends Command
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var \Swift_Mailer */
    private $mailer;
    /** @var string */
    private $emailSender;

    /**
     * @param EntityManagerInterface $em
     * @param \Swift_Mailer $mailer
     * @param string $emailSender
     */
    public function __construct(EntityManagerInterface $em, \Swift_Mailer $mailer, $emailSender)
    {
        parent::__construct();

        $this->entityManager = $em;
        $this->mailer = $mailer;
        $this->emailSender = $emailSender;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:list-admin-users')
            ->setDescription('Lists all the existing admin users')
            ->setHelp(<<<'HELP'
The <info>%command.name%</info> command lists all the admin users registered in the application:

  <info>php %command.full_name%</info>

By default the command only displays the 50 most recent admin users. Set the number of
results to display with the <comment>--max-results</comment> option:

  <info>php %command.full_name%</info> <comment>--max-results=2000</comment>

In addition to displaying the admin user list, you can also send this information to
the email address specified in the <comment>--send-to</comment> option:

  <info>php %command.full_name%</info> <comment>--send-to=fabien@symfony.com</comment>

HELP
            )
            ->addOption('max-results', null, InputOption::VALUE_OPTIONAL, 'Limits the number of admin users listed', 50)
            ->addOption('send-to', null, InputOption::VALUE_OPTIONAL, 'If set, the result is sent to the given email address')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $maxResults = $input->getOption('max-results');
        $users = $this->entityManager->getRepository(AdminUser::class)->findBy([], ['id' => 'DESC'], $maxResults);

        $usersAsPlainArrays = array_map(function (AdminUser $user) {
            return [
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                implode(', ', $user->getRoles()),
            ];
        }, $users);

        $bufferedOutput = new BufferedOutput();
        $io = new SymfonyStyle($input, $bufferedOutput);
        $io->table(
            ['ID', 'Username', 'Email', 'Roles'],
            $usersAsPlainArrays
        );

        $usersAsATable = $bufferedOutput->fetch();
        $output->write($usersAsATable);

        if (null !== $email = $input->getOption('send-to')) {
            $this->sendReport($usersAsATable, $email);
        }
    }

    /**
     * @param string $contents
     * @param string $recipient
     */
    private function sendReport($contents, $recipient)
    {
        $message = $this->mailer->createMessage()
            ->setSubject(sprintf('app:list-admin-users report (%s)', date('Y-m-d H:i:s')))
            ->setFrom($this->emailSender)
            ->setTo($recipient)
            ->setBody($contents, 'text/plain')
        ;

        $this->mailer->send($message);
    }
}
