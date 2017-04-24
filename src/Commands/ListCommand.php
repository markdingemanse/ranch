<?php

namespace Liquidpineapple\Ranch\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command {

    protected function configure()
    {
        $this->setName('list')
             ->setDescription('List all configured sites')
             ->setHelp('This command shows a list of all configured sites')
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
    }

}