<?php

namespace Liquidpineapple\Ranch\Commands;

use Liquidpineapple\Ranch\Config;
use Liquidpineapple\Ranch\ConfigFiles\HostsConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command {

    protected function configure()
    {
        $this->setName('init')
             ->setDescription('Creates a config file in your homedir')
             ->setHelp('Touches ~/.ranchcfg check https://github.com/liquidpineapple/ranch/blob/master/README.md#configuration for configuration options');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $success = touch(getenv('HOME'). '/.ranchcfg');

        if ($success) {
            $io->text('Initiated ranch config');
            $io->text('For how to configure ranch, check https://github.com/liquidpineapple/ranch/blob/master/README.md#configuration');
        } else {
            $io->error('Something went wrong!');
        }

    }

}
