<?php

namespace Liquidpineapple\Ranch\Commands;

use Liquidpineapple\Ranch\Config;
use Liquidpineapple\Ranch\ConfigFiles\HostsConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command {

    protected function configure()
    {
        $this->setName('add')
             ->setDescription('Add a new site to your configuration')
             ->setHelp('Add a new site to your configuration');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
    }

}
