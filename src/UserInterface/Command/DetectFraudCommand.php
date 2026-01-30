<?php

namespace App\UserInterface\Command;

use App\Application\Service\DetectSuspiciousReadingsUseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:detect-fraud', description: 'Detect suspicious readings from a file')]
class DetectFraudCommand extends Command
{
    public function __construct(
        private DetectSuspiciousReadingsUseCase $useCase
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('filepath', InputArgument::REQUIRED, 'File path (CSV or XML)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filepath = $input->getArgument('filepath');

        try {
            $results = $this->useCase->execute($filepath);

            if (empty($results)) {
                $output->writeln('<info>No suspicious readings were detected.</info>');
                return Command::SUCCESS;
            }

            $table = new Table($output);
            $table->setHeaders(['Client', 'Month', 'Suspicious', 'Median']);

            foreach ($results as $row) {
                $table->addRow([$row['client'], $row['month'], $row['value'], $row['median']]);
            }

            $table->render();

        } catch (\Throwable $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
