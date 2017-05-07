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
        $this->setName('list')
             ->setDescription('List all configured sites')
             ->setHelp('This command shows a list of all configured sites');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $hostsFileHosts = HostsConfig::get()
            ->filter(function($host) {
                return $host['ip_address'] === '192.168.10.10';
            })
            ->map(function($host) {
                return $host['hostname'];
            })
            ->toArray();
        $io->title('Configured sites');
        $io->listing($hostsFileHosts);
    }

}
