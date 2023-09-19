<?php

declare(strict_types=1);

namespace App\Shared\Cli;

use App\Shared\Exception\CliException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Table;
use Security\Infrastructure\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Creates the read model table.
 */
class CreateReadModelCommand extends Command
{
    private const RM_USER = 'rm_user';

    public function __construct(
        private readonly Connection $connection,
        private readonly UserRepository $userRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('broadway:read-model:create')
            ->setDescription('Creates the read model table')
            ->addArgument('tableName', InputArgument::REQUIRED, 'The table name you need to create for the related read model')
        ;
    }

    /**
     * @throws CliException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $schemaManager = $this->connection->createSchemaManager();

            if ($table = $this->getTableFromTableName($schemaManager, $input->getArgument('tableName'))) {
                $schemaManager->createTable($table);
                $output->writeln('<info>Created Broadway read model schema</info>');
            } else {
                $output->writeln('<info>Broadway read model schema already exists</info>');
            }
        } catch (Exception $exception) {
            throw CliException::FromCommandExecution($exception);
        }

        return 0;
    }

    private function getTableFromTableName(AbstractSchemaManager $schemaManager, string $tableName): Table
    {
        return match($tableName) {
            self::RM_USER => $this->userRepository->getInstance()->configureSchema($schemaManager->introspectSchema()),
        };
    }
}
