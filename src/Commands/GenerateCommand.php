<?php

declare(strict_types=1);

namespace App\Commands;

use App\Model\Elastic\Indices\SalesIndex;
use App\Model\Fixtures\BillsGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateCommand extends Command
{
    protected static $defaultName = 'app:generate';

    public function __construct(public SalesIndex $salesIndex)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('count', InputArgument::OPTIONAL, 'count of generated bills', 1000);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $count = (int) $input->getArgument('count');
        $io->progressStart($count);
        foreach (BillsGenerator::create()->generate($count) as $bill) {
            $this->salesIndex->put($bill);
            $io->progressAdvance();
        }
        $io->progressFinish();

        $io->success('done');

        return 0;
    }
}
