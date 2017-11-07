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

class DeleteAdminUserCommand extends Command
{
    /** @var SymfonyStyle */
    private $io;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var Validator */
    private $validator;

    /**
     * @param EntityManagerInterface $em
     * @param Validator $validator
     */
    public function __construct(EntityManagerInterface $em, Validator $validator)
    {
        parent::__construct();

        $this->entityManager = $em;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:delete-admin-user')
            ->setDescription('Deletes admin users from the database')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of an existing admin user')
            ->setHelp(<<<'HELP'
The <info>%command.name%</info> command deletes admin users from the database:

  <info>php %command.full_name%</info> <comment>username</comment>

If you omit the argument, the command will ask you to
provide the missing value:

  <info>php %command.full_name%</info>
HELP
            );
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
        if (null !== $input->getArgument('username')) {
            return;
        }

        $this->io->title('Delete Admin User Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console app:delete-admin-user username',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
            '',
        ]);

        $username = $this->io->ask('Username', null, [$this->validator, 'validateUsername']);
        $input->setArgument('username', $username);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $this->validator->validateUsername($input->getArgument('username'));

        $repository = $this->entityManager->getRepository(AdminUser::class);
        $adminUser = $repository->findOneBy(['username' => $username]);

        if (null === $adminUser) {
            throw new \RuntimeException(sprintf('AdminUser with username "%s" not found.', $username));
        }

        $adminUserId = $adminUser->getId();

        $this->entityManager->remove($adminUser);
        $this->entityManager->flush();

        $this->io->success(sprintf('User "%s" (ID: %d, email: %s) was successfully deleted.', $adminUser->getUsername(), $adminUserId, $adminUser->getEmail()));
    }
}
