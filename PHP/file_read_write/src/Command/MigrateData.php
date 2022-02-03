<?php

namespace Command;

use Monolog\Logger;
use Transport\Import\Readable;
use Transport\Export\Writeable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Transport\Validator\SourceLocationValidatorResolver;

class MigrateData extends Command
{
    protected static $defaultName = 'app:migrate';
    protected static $defaultDescription = 'Migrates XML data from given source and uploads into (hard-coded source :) )';
    private Readable $consumer;
    private Writeable $producer;
    private SourceLocationValidatorResolver $locationValidatorResolver;
    private Logger $errorLogger;

    public function __construct(Readable $consumer, Writeable $producer, Logger $logger)
    {
        parent::__construct(null);
        $this->consumer = $consumer;
        $this->producer = $producer;
        // instantiated directly because we don't expect multiple location validator resolvers
        // it's already a Strategy
        $this->locationValidatorResolver = new SourceLocationValidatorResolver();
        $this->errorLogger = $logger;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('source', InputArgument::REQUIRED, 'source. Local or URL')
            ->setHelp('Migrate xml data from A to B')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $sourcePath = $input->getArgument('source');

        // Personally I don't like to pass same param into resolver and concrete strategy,
        // but passing into constructor is even worse.
        // setter doesn't solve the "readability" either
        // additionally, unit tests are cleaner
        try {
            $this->locationValidatorResolver->getValidator($sourcePath)->validate($sourcePath);
        } catch (\InvalidArgumentException $e) {
            $this->errorLogger->error(
                "Invalid data source. Details: ".$e->getMessage(),
                ['exception' => $e]
            );

            return 1;
        }

        $output->writeln("Beginning");

        try {
            $this->producer->write(
                $this->consumer->read($sourcePath)
            );
        }
        catch (\Exception $e) {
            $this->errorLogger->error($e->getMessage(), ['exception' => $e]);
            return 1;
        }

        $output->writeln("Data has been successfully migrated");
        return 0;
    }
}
