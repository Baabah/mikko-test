<?php

namespace Commands;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PayrollDatesCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('payroll:dates')
            ->setDescription('Create a .csv file containing all payment dates for the remainder of this year')
            ->addArgument(
                'output filename',
                InputArgument::REQUIRED,
                'Filename of output file'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputFile = $input->getArgument('output filename');
        $output->writeln('outputting to ' . $outputFile);
    }
}
