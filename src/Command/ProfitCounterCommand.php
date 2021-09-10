<?php


namespace App\Command;


use App\Models\AdditionalInformation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProfitCounterCommand extends Command
{
    protected static $defaultName = 'calculate-profit';

    //inout data: Quantity, Price, Fixed Cost, Variable Cost
    protected function configure(): void
    {
        $this
            ->setDescription('Calculates profit.')
            ->setHelp('This command allows you to calculate profit from your business...')
            ->addArgument('p', InputArgument::OPTIONAL, 'Price')
            ->addArgument('fc', InputArgument::OPTIONAL, 'Fixed Cost')
            ->addArgument('vc', InputArgument::OPTIONAL, 'Variable Cost')
        ;    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        //q = (p-fc)/(-1*vc)
        $quantity =  ($input->getArgument('fc') + $input->getArgument('vc')) / ($input->getArgument('p') - AdditionalInformation::COFFIES_PER_DAY_FOR_PERSON);

        $output->writeln("{$quantity} cups to breakeven");
        $percent = ($quantity / AdditionalInformation::COFFIES_PRE_DAY) * 100;
        if($percent<10){
            $output->writeln("Yes! its reasonable to open coffee shop because there are ". AdditionalInformation::COFFIES_PRE_DAY . "cups sold and
            the break-even point is {$quantity} cups, which is ~".(int)$percent."%
            of the market share, breaking even is achievable.
            ");
        } else {
            $output->writeln("No! its not reasonable to open coffee shop because there are ". AdditionalInformation::COFFIES_PRE_DAY . "cups sold and
            the break-even point is {$quantity} cups, which is ~".(int)$percent."%
            of the market share, breaking even is may be achievable.
            ");
        }
        return Command::SUCCESS;
    }
}