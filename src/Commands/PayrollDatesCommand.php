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
        // Read specified filename
        $outputFile = $input->getArgument('output filename');

        // Get app and project dir
        $app = $this->getSilexApplication();
        $root = $this->getProjectDirectory();

        // Retrieve payments
        $payments = $app['yearPayments'];

        // Export csv to payments
        $csvExporter = $app['csvExporter']($outputFile, $root);
        $success = $csvExporter->export($payments);

        // Show output message
        if ($success == true) {
            $output->writeln('Successfully calculated salary and bonus dates for this year.');
            return true;
        }
        $output->writeln('Something went wrong, please check error messages for more details.');
        return false;
    }
}
