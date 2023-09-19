<?php

declare(strict_types=1);

namespace App\Shared\Cli;

use App\Shared\Exception\CliException;
use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateEventStoreCommand extends Command
{
    public function __construct(
        private readonly Connection $connection,
        private readonly DBALEventStore $eventStore
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('broadway:event-store:create')
            ->setDescription('Creates the event store schema')
            ->setHelp(
                <<<'EOT'
The <info>%command.name%</info> command creates the schema in the default
connections database:

<info>php bin/console %command.name%</info>
EOT
            )
        ;
    }

    /**
     * @throws CliException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $schemaManager = $this->connection->createSchemaManager();

            if ($table = $this->eventStore->configureSchema($schemaManager->introspectSchema())) {
                $schemaManager->createTable($table);
                $output->writeln('<info>Created Broadway event store schema</info>');
            } else {
                $output->writeln('<info>Broadway event store schema already exists</info>');
            }
        } catch (Exception $exception) {
            throw CliException::FromCommandExecution($exception);
        }

        return 0;
    }
}
