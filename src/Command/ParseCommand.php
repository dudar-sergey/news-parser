<?php

namespace App\Command;

use App\service\NewsParserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ParseCommand extends Command
{
    protected static $defaultName = 'parse';
    protected static $defaultDescription = 'Add a short description for your command';
    protected $newsManager;

    public function __construct(NewsParserManager $newsManager, string $name = null)
    {
        parent::__construct($name);
        $this->newsManager = $newsManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->newsManager->parseNews();

        return Command::SUCCESS;
    }
}
